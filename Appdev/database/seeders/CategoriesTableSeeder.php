<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('categories')->insert([
            [
                'name' => 'Laboratory', 
                'description' => 'Various academic labs'
            ],
            [
                'name' => 'Equipment', 
                'description' => 'Lab equipment and tools'
            ],
        ]);
    }
}
