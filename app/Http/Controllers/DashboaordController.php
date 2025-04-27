<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\PengaturanAbsensi;
use Illuminate\Http\Request;
use App\Models\Siswa;
use App\Models\PoinSiswa;
use App\Models\Berita;
use Illuminate\Support\Facades\Auth;

class DashboaordController extends Controller
{
    public function admin_guru()
    {
        $user = Auth::user();
        $total_siswa = Siswa::count();
        $today = now()->toDateString();
        $siswa_hadir_hari_ini = Siswa::whereHas('absensi', function ($query) use ($today) {
            $query->whereDate('created_at', $today)
                ->whereIn('status', ['hadir', 'terlambat']);
        })->count();
        $siswa_tidak_hadir_hari_ini = Siswa::whereDoesntHave('absensi', function ($query) use ($today) {
            $query->whereDate('created_at', $today)
                ->whereIn('status', ['hadir', 'terlambat']);
        })->count();
        $jam_masuk = PengaturanAbsensi::first()->jam_masuk;
        $jam_pulang = PengaturanAbsensi::first()->jam_pulang;
        $peringkat_poin = \App\Models\PoinSiswa::selectRaw('siswa_id, SUM(CASE WHEN poin_kategori.kategori = "pelanggaran" THEN -poin_kategori.poin ELSE poin_kategori.poin END) as total_poin')
            ->join('poin_kategori', 'poin_siswa.poin_kategori_id', '=', 'poin_kategori.id')
            ->groupBy('siswa_id')
            ->orderByDesc('total_poin')
            ->take(5)
            ->get();

        $peringkat_poin->transform(function ($item) {
            $item->siswa = \App\Models\Siswa::with('kelas')->find($item->siswa_id);
            return $item;
        });
        $berita = Berita::first();
        $acara = $berita ? $berita->acara : '-';
        $pakaian = $berita ? $berita->pakaian : '-';
        $tanggalDibuat = $berita ? $berita->updated_at->format('d M Y') : '-';

        return view('dashboard.list', compact('user', 'total_siswa', 'siswa_hadir_hari_ini', 'siswa_tidak_hadir_hari_ini', 'jam_masuk', 'jam_pulang', 'peringkat_poin', 'acara', 'pakaian', 'tanggalDibuat'));
    }

    public function siswa()
    {
        $user = Auth::user();
        $siswa = Siswa::where('id', $user->siswa_id)->first();
        $jam_masuk = PengaturanAbsensi::first()->jam_masuk;
        $jam_pulang = PengaturanAbsensi::first()->jam_pulang;
        $status = Absensi::where('siswa_id', $user->siswa_id)
            ->whereDate('tanggal', today())
            ->first();
        if ($status) {
            $status = $status->status;
        } else {
            $status = null;
        }
        $total_poin = PoinSiswa::with('PoinKategori')
            ->where('siswa_id', $user->siswa_id)
            ->get()
            ->sum(function ($item) {
                $poin = $item->kategori->poin ?? 0;
                return $item->kategori->kategori === 'pelanggaran' ? -$poin : $poin;
            });
        // Ambil berita terbaru
        $beritaTerbaru = Berita::latest()->first();
        $adaUpdateBeritaBaru = false;

        if ($beritaTerbaru && $beritaTerbaru->updated_at->isToday()) {
            $adaUpdateBeritaBaru = true;
        }
        return view('dashboard.siswa', compact('user', 'siswa', 'jam_masuk', 'jam_pulang', 'status', 'total_poin','adaUpdateBeritaBaru'));
    }
}
