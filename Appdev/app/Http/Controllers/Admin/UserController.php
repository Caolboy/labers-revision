<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash; 

class UserController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');

        $query = User::select('id', 'name', 'email', 'is_admin');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('id', 'like', "%{$search}%");
                  if (strtolower($search) === 'admin') {
                      $q->orWhere('is_admin', 1);
                  } elseif (strtolower($search) === 'user') {
                      $q->orWhere('is_admin', 0);
                  }
            });
        }

        return response()->json($query->get());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'is_admin' => 'required|in:0,1',
        ]); 

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'is_admin' => (bool) $validated['is_admin'],
        ]);

        return response()->json($user, 201);
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => "required|email|unique:users,email,{$user->id}",
            'is_admin' => 'required|boolean', 
        ]);

        $validated['is_admin'] = (bool) $validated['is_admin'];
        
        $user->update($validated);

        return response()->json($user->fresh());
    }

    public function destroy(User $user)
    {
        $user->delete();
        return response()->json(['message' => 'User deleted']);
    }

    public function bookings(User $user)
    {
        $labBookings = $user->labBookings()
            ->with(['room', 'timeSlot'])
            ->orderBy('booking_date', 'desc')
            ->get()
            ->map(function ($booking) {
                return [
                    'room' => $booking->room->room_number,
                    'slot' => $booking->timeSlot->slot ?? '—',
                    'date' => $booking->booking_date,
                    'status' => $booking->status,
                ];
            });
            
        $equipmentBookings = $user->equipmentBookings()
            ->with('equipment')
            ->orderBy('booking_date', 'desc')
            ->get()
            ->map(function ($booking) {
                return [
                    'equipment' => $booking->equipment->name,
                    'date' => $booking->booking_date,
                    'status' => $booking->status,
                ];
            });    

        return response()->json([
            'lab_bookings' => $labBookings,
            'equipment_bookings' => $equipmentBookings,
        ]);
    }
}