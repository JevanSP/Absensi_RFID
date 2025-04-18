<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SiswaSeeder extends Seeder
{
    public function run()
    {
        $kelasIds = DB::table('kelas')->pluck('id')->toArray();
        $data = [
            [
                'nis' => '1234567890',
                'nama_siswa' => 'Ahmad Fauzi',
                'jenis_kelamin' => 'L',
                'kelas_id' => 1, // Pastikan kelas_id ini ada di tabel kelas
                'rfid_tag' => 'RFID123456A',
                'foto' => 'default.jpg',
            ],
            [
                'nis' => '1234567891',
                'nama_siswa' => 'Putri Aisyah',
                'jenis_kelamin' => 'P',
                'kelas_id' => 2,
                'rfid_tag' => 'RFID123456B',
                'foto' => 'default.jpg',
            ],
            [
                'nis' => '1234567892',
                'nama_siswa' => 'Dewi Lestari',
                'jenis_kelamin' => 'P',
                'kelas_id' => 3,
                'rfid_tag' => 'RFID123456C',
                'foto' => 'default.jpg',
            ],
        ];

        DB::table('siswa')->insert($data);
    }
}
