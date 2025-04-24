<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate([
            'email' => 'admin@rt.local',
        ], [
            'name' => 'Admin RT',
            'password' => Hash::make('password123'), // Ganti kalau mau lebih aman
        ]);
    }
}
