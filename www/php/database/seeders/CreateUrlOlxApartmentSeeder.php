<?php

namespace Database\Seeders;

use App\Models\Research;
use Illuminate\Database\Seeder;

class CreateUrlOlxApartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Research::add(['title' => 'olx_apartment', 'url' => 'null']);
    }
}
