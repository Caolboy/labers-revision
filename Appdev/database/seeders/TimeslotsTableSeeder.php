<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TimeslotsTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('time_slots')->insert([
            [
                'room_id' => 1, 
                'slot' => '08:00-10:00'
            ],
            [
                'room_id' => 1, 
                'slot' => '10:00-12:00'
            ],
            [
                'room_id' => 1, 
                'slot' => '13:00-15:00'
            ],
            [
                'room_id' => 2, 
                'slot' => '08:00-10:00'
            ],
            [
                'room_id' => 2, 
                'slot' => '10:00-12:00'
            ],
            [
                'room_id' => 2, 
                'slot' => '13:00-15:00'
            ],
            [
                'room_id' => 3, 
                'slot' => '08:00-10:00'
            ],
            [
                'room_id' => 3, 
                'slot' => '10:00-12:00'
            ],
            [
                'room_id' => 3, 
                'slot' => '13:00-15:00'
            ],
            [
                'room_id' => 4, 
                'slot' => '08:00-10:00'
            ],
            [
                'room_id' => 4, 
                'slot' => '10:00-12:00'
            ],
            [
                'room_id' => 4, 
                'slot' => '13:00-15:00'
            ],
        ]);
    }
}
