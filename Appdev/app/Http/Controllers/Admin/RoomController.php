<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Room;
use App\Models\TimeSlot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class RoomController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');

        $query = Room::with(['lab', 'timeSlots']);

        if ($search) {
            $query->where('room_number', 'like', "%{$search}%")
                  ->orWhereHas('lab', function ($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%");
                  });
        }

        return response()->json($query->get());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'room_number' => 'required|string|max:255',
            'lab_id' => 'required|exists:labs,id',
            'status' => 'required|in:available,unavailable',
            'time_slots' => 'required|array|min:1',
            'time_slots.*' => 'required|string|regex:/^\d{2}:\d{2}-\d{2}:\d{2}$/',
        ]);

        DB::beginTransaction();
        
        try {
            $room = Room::create([
                'room_number' => $validated['room_number'],
                'lab_id' => $validated['lab_id'],
                'status' => $validated['status'],
            ]);

            foreach ($validated['time_slots'] as $slot) {
                TimeSlot::create([
                    'room_id' => $room->id,
                    'slot' => $slot,
                ]);
            }

            DB::commit();

            return response()->json($room->load(['lab', 'timeSlots']), 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Failed to create room with time slots',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, Room $room)
    {
        $validated = $request->validate([
            'room_number' => 'required|string|max:255',
            'lab_id' => 'required|exists:labs,id',
            'status' => 'required|in:available,unavailable',
            'time_slots' => 'sometimes|array',
            'time_slots.*' => 'required|string|regex:/^\d{2}:\d{2}-\d{2}:\d{2}$/',
        ]);

        DB::beginTransaction();

        try {
            $room->update([
                'room_number' => $validated['room_number'],
                'lab_id' => $validated['lab_id'],
                'status' => $validated['status'],
            ]);

            if (isset($validated['time_slots'])) {
                $room->timeSlots()->delete();

                foreach ($validated['time_slots'] as $slot) {
                    TimeSlot::create([
                        'room_id' => $room->id,
                        'slot' => $slot,
                    ]);
                }
            }

            if ($request->hasFile('image')) {
                $lab = $room->lab;

                if ($lab->image) {
                    $oldPath = str_replace('storage/', '', $lab->image);
                    if (Storage::disk('public')->exists($oldPath)) {
                        Storage::disk('public')->delete($oldPath);
                    }
                }

                $path = $request->file('image')->store('images', 'public');
                $lab->image = 'storage/' . $path;
                $lab->save();
            }

            DB::commit();

            return response()->json($room->load(['lab', 'timeSlots']));

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Failed to update room',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show(Room $room)
    {
        return response()->json($room->load(['lab', 'timeSlots']));
    }

    public function destroy(Room $room)
    {
        DB::beginTransaction();
        
        try {
            $room->delete();
            
            DB::commit();
            
            return response()->json(['message' => 'Room and associated time slots deleted']);
            
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Failed to delete room',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}