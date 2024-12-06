<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin Lay',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('admin123'),
            'user_type' => 'admin',
            'phone' => '09123456789',
            'user_photo' => 'default_admin_photo.jpg',
        ]);

        User::factory(5)->create([
            'user_type' => 'instructor',
        ]);

        User::factory(15)->create([
            'user_type' => 'student',
        ]);
    }
}
