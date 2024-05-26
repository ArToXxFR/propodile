<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'username' => 'admin',
            'firstname' => 'Admin',
            'lastname' => 'Admin',
            'grade_id' => 6,
            'role' => "admin",
            'description' => 'Testing administrator account',
            'email' => 'admin@test.test',
            'password' => Hash::make('7MrOcjlCkzAM62z'),
            'profile_photo_path' => 'profile-photos/default.png',
        ]);
    }
}
