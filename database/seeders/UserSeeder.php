<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User; // <-- Import model User
use Illuminate\Support\Facades\Hash; // <-- Import Hash facade

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Data Dosen
        User::create([
            'name' => 'Andhik',
            'email' => 'andhik123.com',
            'password' => Hash::make('123456'), // Ganti dengan password yang aman
            'role' => 'dosen',
            'email_verified_at' => now(), // Agar bisa langsung login
        ]);

        User::create([
            'name' => 'Prof. Citra Lestari',
            'email' => 'citra.dosen@example.com',
            'password' => Hash::make('password123'),
            'role' => 'dosen',
            'email_verified_at' => now(),
        ]);

        // Data Mahasiswa
        User::create([
            'name' => 'Achmad Alfitri Mulyawan',
            'email' => 'alfit.ahmad12@gmail.com',
            'password' => Hash::make('123456'),
            'role' => 'mahasiswa', // Defaultnya sudah mahasiswa, tapi lebih baik eksplisit
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'Siti Aminah',
            'email' => 'siti.mahasiswa@example.com',
            'password' => Hash::make('password123'),
            'role' => 'mahasiswa',
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'Rian Hidayat',
            'email' => 'rian.mahasiswa@example.com',
            'password' => Hash::make('password123'),
            'role' => 'mahasiswa',
            'email_verified_at' => now(),
        ]);

        // Tambahkan lebih banyak user jika diperlukan
        // User::factory(10)->create(); // Jika Anda ingin menggunakan factory untuk data dummy massal
    }
}