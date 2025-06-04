<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LabsTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('labs')->insert([
            [
                'category_id' => 1,
                'name' => 'Electronics Lab',
                'description' => 'This is the electronic lab equipped with various tools for electronics experiments.',
            ],
            [   
                'category_id' => 1,
                'name' => 'Computer Lab',
                'description' => 'This is the computer lab with desktop computers and software for programming tasks.',
            ],
        ]);
    }
}
