<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PoinSiswa;
use App\Models\Absensi;

class TampilanSiswaController extends Controller
{
    public function poin()
    {
        $poin = PoinSiswa::where('siswa_id')->get();
        return view('siswa_tampilan.poin', compact('poin'));
    }

    public function absensi()
    {
        $absensi = Absensi::where('siswa_id')->get();
        return view('siswa_tampilan.absensi', compact('absensi'));
    }

    public function berita()
    {
        return view('siswa_tampilan.berita');
    }
}
