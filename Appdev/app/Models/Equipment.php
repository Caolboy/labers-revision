<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Equipment extends Model
{
    protected $fillable = [
        'category_id', 
        'name', 
        'description', 
        'image', 
        'quantity', 
        'status'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function bookings()
    {
        return $this->hasMany(EquipmentBooking::class);
    }
}
