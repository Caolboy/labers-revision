<?php

namespace App\Http\Controllers\UserPanel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\Lab;
use App\Models\TimeSlot;
use App\Models\LabBooking;

class UserCalendarController extends Controller
{
    public function availability(Request $request)
    {
        $date = $request->query('date');
        $labs = Lab::with(['rooms.timeSlots'])->get();

        $response = [];

        foreach ($labs as $lab) {
            $available = [];
            $booked = [];

            foreach ($lab->rooms as $room) {
                $timeSlots = $room->timeSlots;
                foreach ($timeSlots as $slot) {
                    $isBooked = LabBooking::where('room_id', $room->id)
                        ->where('booking_date', $date)
                        ->where('time_slot_id', $slot->id)
                        ->where('status', '!=', 'cancelled')
                        ->exists();

                    $entry = [
                        'room_number' => $room->room_number,
                        'slot' => $slot->slot,
                    ];

                    if ($isBooked) {
                        $booked[] = $entry;
                    } else {
                        $available[] = $entry;
                    }
                }
            }

            $response[] = [
                'lab_name' => $lab->name,
                'available' => $available,
                'booked' => $booked,
            ];
        }

        return response()->json($response);
    }
}