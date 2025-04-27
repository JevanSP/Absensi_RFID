<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PoinSiswa;
use App\Models\Absensi;
use App\Models\Berita;
use Illuminate\Support\Str;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

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

    public function absensi(Request $request)
    {
        $siswa = Auth::user()->siswa;
        $selectedMonth = $request->bulan ?? now()->format('Y-m');

        $absen = $siswa->absensi()
            ->whereMonth('tanggal', date('m', strtotime($selectedMonth)))
            ->whereYear('tanggal', date('Y', strtotime($selectedMonth)))
            ->orderBy('tanggal', 'desc')
            ->get();

        // Convert status jadi lowercase
        $rekap = $absen->groupBy(function ($item) {
            return strtolower(trim($item->status));
        })->map->count();

        return view('siswa_tampilan.absensi', compact('absen', 'rekap', 'selectedMonth'));
    }

    public function berita()
    {

        $today = Carbon::now()->toDateString();
        $lastUpdate = Cache::get('last_berita_update');

        $berita = Berita::first();

        if ($berita) {
            if ($today > $lastUpdate) {
                $berita->update([
                    'acara' => '-',
                    'pakaian' => 'tidak ada',
                ]);
                Cache::put('last_berita_update', $today, now()->addDay());
            }
        }
        // Kirim juga tanggal sekarang
        $tanggalDibuat = Carbon::now();

        return view('siswa_tampilan.berita', compact('berita', 'tanggalDibuat'));
    }

    public function sekolah()
    {
        $total_siswa = Siswa::count();
        $total_guru = User::where('role', 'guru')->count();
        return view('siswa_tampilan.sekolah', compact('total_siswa', 'total_guru'));
    }
}
