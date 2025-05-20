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
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'), // Ganti dengan password aman
            'role' => 'admin',
            'gaji_pokok' => 10000000, // Contoh gaji admin
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'Karyawan Biasa',
            'email' => 'karyawan@example.com',
            'password' => Hash::make('password'), // Ganti dengan password aman
            'role' => 'karyawan',
            'gaji_pokok' => 5000000, // Contoh gaji karyawan
            'email_verified_at' => now(),
        ]);
    }
}