<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\PengaturanAbsensi;
use Illuminate\Http\Request;
use App\Models\Siswa;
use App\Models\PoinSiswa;
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
        $siswa_tidak_hadir_hari_ini = Siswa::whereHas('absensi', function ($query) use ($today) {
            $query->whereDate('created_at', $today)
                ->whereNotIn('status', ['hadir', 'terlambat']);
        })->count();

        return view('dashboard.list', compact('user', 'total_siswa', 'siswa_hadir_hari_ini', 'siswa_tidak_hadir_hari_ini'));
    }

    public function siswa()
    {
        $user = Auth::user();
        $siswa = Siswa::where('id', $user->siswa_id)->first();
        $jam_masuk = PengaturanAbsensi::first()->jam_masuk;
        $jam_pulang = PengaturanAbsensi::first()->jam_pulang;
        $status = Absensi::where('siswa_id', $user->siswa_id)->first();
        if ($status) {
            $status = $status->status;
        } else {
            $status = null;
        }
        // $total_poin = PoinSiswa::where('siswa_id', $user->siswa_id)->sum('poin');
        return view('dashboard.siswa', compact('user', 'siswa', 'jam_masuk', 'jam_pulang', 'status', ));
    }

}
