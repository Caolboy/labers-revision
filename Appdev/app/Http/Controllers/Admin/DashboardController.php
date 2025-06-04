<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\LabBooking;
use App\Models\EquipmentBooking;

class DashboardController extends Controller
{
    public function data()
    {
        $totalRoomBookings = LabBooking::count();
        $totalEquipmentBookings = EquipmentBooking::count();
        $pendingApprovals = LabBooking::where('status', 'pending')->count();

        $recentLabBookings = LabBooking::with(['user', 'room.lab'])
            ->latest()
            ->take(10)
            ->get()
            ->map(function ($booking) {
                return [
                    'type' => 'lab',
                    'description' => "Room {$booking->room->room_number} ({$booking->room->lab->name}) booked by {$booking->user->name}",
                    'status' => $booking->status,
                    'timestamp' => $booking->created_at->format('Y-m-d h:i A'),
                    'created_at' => $booking->created_at,
                ];
            });

        $recentEquipmentBookings = EquipmentBooking::with(['user', 'equipment'])
            ->latest()
            ->take(10)
            ->get()
            ->map(function ($booking) {
                return [
                    'type' => 'equipment',
                    'description' => "{$booking->equipment->name} booked by {$booking->user->name}",
                    'status' => $booking->status,
                    'timestamp' => $booking->created_at->format('Y-m-d h:i A'),
                    'created_at' => $booking->created_at,
                ];
            });

        $recentActivities = $recentLabBookings
            ->concat($recentEquipmentBookings)
            ->sortByDesc('created_at')
            ->take(5)
            ->values();

        $roomBookingChart = LabBooking::select('room_id', DB::raw('count(*) as total'))
            ->groupBy('room_id')
            ->with('room.lab')
            ->get()
            ->map(function ($item) {
                return [
                    'room' => "{$item->room->room_number} {$item->room->lab->name}",
                    'total' => $item->total,
                ];
            });

        $equipmentBookingChart = EquipmentBooking::select('equipment_id', DB::raw('count(*) as total'))
            ->groupBy('equipment_id')
            ->with('equipment')
            ->get()
            ->map(function ($item) {
                return [
                    'equipment' => $item->equipment->name,
                    'total' => $item->total,
                ];
            });

        return response()->json([
            'totalRoomBookings' => $totalRoomBookings,
            'totalEquipmentBookings' => $totalEquipmentBookings,
            'pendingApprovals' => $pendingApprovals,
            'recentActivities' => $recentActivities,
            'roomBookingChart' => $roomBookingChart,
            'equipmentBookingChart' => $equipmentBookingChart,
        ]);
    }
}