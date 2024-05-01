<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GenderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('genders')->insert([
            ['id' => 1, 'name' => 'not known'],
            ['id' => 2, 'name' => 'male'],
            ['id' => 3, 'name' => 'female'],
        ]);
    }
}
