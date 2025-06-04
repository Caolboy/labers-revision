<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $fillable = [
        'room_number', 
        'lab_id',     
        'status',      
    ];

    public function lab()
    {
        return $this->belongsTo(Lab::class);
    }

    public function timeSlots()
    {
        return $this->hasMany(TimeSlot::class);
    }

    public function bookings()
    {
        return $this->hasMany(LabBooking::class);
    }
}
