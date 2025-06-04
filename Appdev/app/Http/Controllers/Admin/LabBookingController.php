<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LabBooking;

class LabBookingController extends Controller
{
    public function index(Request $request)
    {
        $start = $request->query('start');
        $end = $request->query('end');

        $bookings = LabBooking::with(['room.lab', 'timeSlot', 'user'])
            ->whereBetween('booking_date', [$start, $end])
            ->where('status', 'approved')
            ->get();

        $events = $bookings->map(function ($booking) {
            return [
                'id'    => $booking->id,
                'title' => "{$booking->user->name} booked Room {$booking->room->room_number}",
                'start' => $booking->booking_date,
                'allDay' => true,
                'user'  => $booking->user->name,
                'room'  => $booking->room->room_number,
                'slot'  => $booking->timeSlot->slot,
            ];
        });

        return response()->json($events);
    }
}
