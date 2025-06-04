<?php

namespace App\Http\Controllers\UserPanel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Category;
use App\Models\Lab;
use App\Models\Room;
use App\Models\Equipment;
use App\Models\TimeSlot;
use App\Models\LabBooking;
use App\Models\EquipmentBooking;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\BookingMadeMail;

class BookingController extends Controller
{

    public function getCategories()
    {
        return response()->json(Category::all());
    }

    public function getItems(Request $request)
    {
        $labIds = Lab::where('category_id', $request->category_id)
                     ->pluck('id')->toArray();

        $rooms = Room::with('lab')
                     ->whereIn('lab_id', $labIds)
                     ->get();

        $equipment = Equipment::where('category_id', $request->category_id)
                              ->get();

        $roomItems = $rooms->map(fn($r) => [
            'id'              => $r->id,
            'name'            => $r->room_number,
            'type'            => 'room',
            'lab_name'        => $r->lab->name,
            'lab_description' => $r->lab->description,
            'description'     => null,
        ]);

        $equipItems = $equipment->map(fn($e) => [
            'id'              => $e->id,
            'name'            => $e->name,
            'type'            => 'equipment',
            'lab_name'        => null,
            'lab_description' => null,
            'description'     => $e->description,
        ]);

        return response()->json($roomItems->concat($equipItems)->values());
    }

    public function getAvailableSlots(Request $request)
    {
        try {
            $room   = Room::findOrFail($request->query('item_id'));
            $date   = $request->query('date'); 

            $slots  = TimeSlot::where('room_id', $room->id)->get();

            $booked = LabBooking::where('room_id', $room->id)
                                ->where('booking_date', $date)
                                ->where('status', '!=', 'cancelled')
                                ->pluck('time_slot_id')
                                ->toArray();

            $now = now();

            $available = $slots->map(function($slot) use ($booked, $date, $now) {
                [$start, $end] = explode('-', $slot->slot);

                $slotEndDateTime = \Carbon\Carbon::createFromFormat('Y-m-d H:i', $date . ' ' . $end);

                $isBooked = in_array($slot->id, $booked);

                $isPast = false;
                if ($slotEndDateTime->lessThanOrEqualTo($now)) {
                    $isPast = true;
                }

                return [
                    'id'        => $slot->id,
                    'slot'      => $slot->slot,
                    'available' => (! $isBooked) && (! $isPast),
                ];
            });

            return response()->json($available);

        } catch (\Throwable $e) {
            Log::error("getAvailableSlots error: {$e->getMessage()}");
            return response()->json([
                'error'   => 'Could not load slots',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function makeBooking(Request $request)
    {
        $userId = auth()->id();

        if ($request->item_type === 'room') {
            $booking = LabBooking::create([
                'user_id'       => $userId,
                'room_id'       => $request->item_id,
                'time_slot_id'  => $request->time_slot_id,
                'booking_date'  => $request->date,
                'status'        => 'pending',
            ]);
            
            $booking->load(['user', 'room.lab', 'timeSlot']);
            
            Mail::to($booking->user->email)->send(new BookingMadeMail($booking, 'room'));
            
        } else {
            $equipment = Equipment::findOrFail($request->item_id);
            if ($equipment->quantity <= 0) {
                return response()->json(['error' => 'Equipment not available'], 400);
            }
            $equipment->decrement('quantity');

            $booking = EquipmentBooking::create([
                'user_id'       => $userId,
                'equipment_id'  => $request->item_id,
                'booking_date'  => $request->date,
                'status'        => 'pending',
            ]);
            
            $booking->load(['user', 'equipment']);
            
            Mail::to($booking->user->email)->send(new BookingMadeMail($booking, 'equipment'));
        }

        return response()->json([
            'success' => true,
            'booking' => $booking,
        ], 201);
    }

    public function getUserBookings(Request $request)
    {
        $userId = $request->user()->id;

        $labBookings = LabBooking::where('user_id', $userId)
            ->with(['room.lab', 'timeSlot'])
            ->orderBy('booking_date', 'desc')
            ->get()
            ->map(fn($b) => [
                'id'          => $b->id,
                'type'        => 'room',
                'lab_name'    => $b->room->lab->name,
                'room_number' => $b->room->room_number,
                'date'        => $b->booking_date,  
                'time'        => $b->timeSlot->slot,
                'status'      => $b->status,
                'created_at'  => $b->created_at->toDateTimeString(),
            ]);

        $eqBookings = EquipmentBooking::where('user_id', $userId)
            ->with('equipment')
            ->orderBy('booking_date', 'desc')
            ->get()
            ->map(fn($b) => [
                'id'          => $b->id,
                'type'        => 'equipment',
                'equipment'   => $b->equipment->name,
                'date'        => $b->booking_date,    
                'time'        => null,
                'status'      => $b->status,
                'created_at'  => $b->created_at->toDateTimeString(),
            ]);

        $all = $labBookings->concat($eqBookings)
            ->sortByDesc('date')
            ->values();

        return response()->json($all);
    }

    public function getDashboardData(Request $request)
    {
        $user = $request->user();
        
        $pendingRoomBookings = LabBooking::where('user_id', $user->id)
            ->where('status', 'pending')
            ->count();
            
        $pendingEquipmentBookings = EquipmentBooking::where('user_id', $user->id)
            ->where('status', 'pending')
            ->count();
            
        $totalPendingBookings = $pendingRoomBookings + $pendingEquipmentBookings;

        return response()->json([
            'user_name' => $user->name,
            'pending_bookings_count' => $totalPendingBookings
        ]);
    }

    public function cancelBooking(Request $request, $id)
    {
        $userId = $request->user()->id;
        $type = $request->input('type');

        if ($type === 'room') {
            $lab = LabBooking::where('id', $id)->where('user_id', $userId)->first();
            if ($lab) {
                $lab->status = 'cancelled';
                $lab->save();
                return response()->json(['success' => true]);
            }
        } elseif ($type === 'equipment') {
            $eq = EquipmentBooking::where('id', $id)->where('user_id', $userId)->first();
            if ($eq) {
                Equipment::where('id', $eq->equipment_id)->increment('quantity');
                $eq->status = 'cancelled';
                $eq->save();
                return response()->json(['success' => true]);
            }
        }

        return response()->json(['error' => 'Booking not found'], 404);
    }
}