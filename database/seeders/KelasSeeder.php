<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KelasSeeder extends Seeder
{
    public function run()
    {
        DB::table('kelas')->insert([
            ['tingkatan' => 'X', 'nama' => 'X IPA 1'],
            ['tingkatan' => 'XI', 'nama' => 'XI IPA 1'],
            ['tingkatan' => 'XII', 'nama' => 'XII IPA 1'],
        ]);
    }
}
