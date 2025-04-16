<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PoinSiswa;
use App\Models\Absensi;
use Illuminate\Support\Facades\Auth;

class TampilanSiswaController extends Controller
{
    public function poin()
    {
        $user = Auth::user();
        $siswa = $user->siswa; // Asumsinya: user punya relasi siswa()

        if (!$siswa) {
            abort(403, 'Data siswa tidak ditemukan.');
        }

        $poin = PoinSiswa::with('poinKategori')
            ->where('siswa_id', $siswa->id)
            ->orderBy('tanggal', 'desc')
            ->get();

        return view('siswa_tampilan.poin', compact('poin'));
    }

    public function absensi()
    {
        $bulan = request('bulan');
        if ($bulan) {
            $absensi = Absensi::where('siswa_id', Auth::id())
                ->whereMonth('tanggal', $bulan)
                ->get();
        } else {
            $absensi = Absensi::where('siswa_id', Auth::id())->get();
        }
        $absensi = Absensi::where('siswa_id')->get();
        return view('siswa_tampilan.absensi', compact('absensi'));
    }

    public function berita()
    {
        return view('siswa_tampilan.berita');
    }

    public function sekolah()
    {
        return view('siswa_tampilan.sekolah');
    }
}
