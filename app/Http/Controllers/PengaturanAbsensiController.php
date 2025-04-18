<?php

namespace App\Http\Controllers;

use App\Models\PengaturanAbsensi;
use Illuminate\Http\Request;

class PengaturanAbsensiController extends Controller
{
    public function index()
    {
        $pengaturanAbsensi = PengaturanAbsensi::first();
        return view('pengaturan.list', compact('pengaturanAbsensi'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'jam_masuk' => 'required|date_format:H:i',
            'jam_pulang' => 'required|date_format:H:i',
        ]);
        PengaturanAbsensi::updateOrCreate([
        ], [
            'jam_masuk' => $request->jam_masuk,
            'jam_pulang' => $request->jam_pulang,
        ]);
        return redirect()->back()->with('success', 'Pengaturan absensi berhasil diubah');
    }
}
