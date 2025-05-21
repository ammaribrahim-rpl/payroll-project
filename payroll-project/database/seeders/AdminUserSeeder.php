<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'), // Ganti dengan password aman
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Karyawan',
            'email' => 'karyawan@example.com',
            'password' => Hash::make('password'), // Ganti dengan password aman
            'role' => 'karyawan',
        ]);
    }
}