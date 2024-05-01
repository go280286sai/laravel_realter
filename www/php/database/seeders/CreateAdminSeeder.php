<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CreateAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::insert('insert into users (id, name, email, password, profile_photo_path, is_admin, created_at) values (?, ?, ?, ?, ?, ?, ?)',
         [1, 'admin', 'admin@admin.ua', bcrypt('12345678'), '/img/profile/no-user-image.png', 1, now()]);

    }
}
