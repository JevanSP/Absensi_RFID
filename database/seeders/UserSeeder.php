<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Admin
        User::create([
            'siswa_id' => null,
            'nama' => 'Admin Utama',
            'username' => 'admin',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'remember_token' => Str::random(10),
        ]);

        // Guru
        User::create([
            'siswa_id' => null,
            'nama' => 'Guru Satu',
            'username' => 'guru1',
            'password' => Hash::make('password'),
            'role' => 'guru',
            'remember_token' => Str::random(10),
        ]);

        // Siswa (pastikan ID siswa yang dimasukkan sudah ada di tabel `siswa`)
        User::create([
            'siswa_id' => 1, // Ganti dengan ID siswa yang valid
            'nama' => 'Siswa Satu',
            'username' => 'siswa1',
            'password' => Hash::make('password'),
            'role' => 'siswa',
            'remember_token' => Str::random(10),
        ]);
    }
}
