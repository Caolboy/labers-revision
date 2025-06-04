<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoomsTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('rooms')->insert([
            [
                'lab_id' => 1, // Electronic Lab
                'room_number' => '510',
            ],
            [
                'lab_id' => 1, // Electronic Lab
                'room_number' => '511',
            ],
            [
                'lab_id' => 2, // Computer Lab
                'room_number' => '519',
            ],
            [
                'lab_id' => 2, // Computer Lab
                'room_number' => '520',
            ],
        ]);
    }
}
