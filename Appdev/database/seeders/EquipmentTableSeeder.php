<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EquipmentTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('equipment')->insert([
            [
                'category_id' => 2,
                'name' => 'Screwdriver',
                'description' => 'Flathead screwdriver for lab use',
                'quantity' => 10,
            ],
            [
                'category_id' => 2,
                'name' => 'Multimeter',
                'description' => 'Digital multimeter for measuring voltage, current, and resistance',
                'quantity' => 5,
            ],
            [
                'category_id' => 2,
                'name' => 'Soldering Iron',
                'description' => 'Used for soldering components in electronic circuits',
                'quantity' => 7,
            ],
            [
                'category_id' => 2,
                'name' => 'Oscilloscope',
                'description' => 'Used to visualize electronic signals',
                'quantity' => 3,
            ],
            [
                'category_id' => 2,
                'name' => 'Crimping Tool',
                'description' => 'Used to attach connectors to the ends of cables or wires',
                'quantity' => 4,
            ],
            [
                'category_id' => 2,
                'name' => 'Breadboard',
                'description' => 'For building and testing circuits without soldering',
                'quantity' => 20,
            ],
            [
                'category_id' => 2,
                'name' => 'Wire Stripper',
                'description' => 'Used to strip insulation from electrical wires',
                'quantity' => 10,
            ],
            [
                'category_id' => 2,
                'name' => 'ESD Wrist Strap',
                'description' => 'Prevents electrostatic discharge damage to components',
                'quantity' => 15,
            ],
        ]);
    }
}
