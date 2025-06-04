<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'name', 
        'image', 
        'description'
    ];

    public function labs()
    {
        return $this->hasMany(Lab::class);
    }

    public function equipment()
    {
        return $this->hasMany(Equipment::class);
    }
}
