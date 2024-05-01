<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('services')->insert([
            ['service' => 'Buy'],
            ['service' => 'Sell'],
            ['service' => 'Rent'],
        ]);
    }
}
