<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LabBooking extends Model
{
    protected $fillable = [
        'room_id', 
        'user_id', 
        'booking_date', 
        'time_slot_id', 
        'status'
    ];

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function timeSlot()
    {
        return $this->belongsTo(TimeSlot::class, 'time_slot_id');
    }
}
