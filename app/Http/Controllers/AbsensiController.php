<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\Siswa;
use App\Models\PengaturanAbsensi;
use App\Models\Kelas;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AbsensiController extends Controller
{
    public function absenRFID(Request $request)
    {
        $request->validate(['rfid_tag' => 'required|string']);

        $siswa = Siswa::where('rfid_tag', $request->rfid_tag)->first();
        if (!$siswa) {
            return response()->json(['message' => 'RFID tidak ditemukan'], 404);
        }

        $tanggal = Carbon::today()->format('Y-m-d');
        $jamSekarang = Carbon::now()->format('H:i:s');
        $pengaturan = PengaturanAbsensi::first();

        if (!$pengaturan) {
            return response()->json(['message' => 'Pengaturan absensi belum dikonfigurasi'], 500);
        }

        $kehadiran = Absensi::where('siswa_id', $siswa->id)->where('tanggal', $tanggal)->first();

        if (!$kehadiran) {
            $status = ($jamSekarang > $pengaturan->jam_masuk) ? 'terlambat' : 'hadir';

            Absensi::create([
                'siswa_id' => $siswa->id,
                'tanggal' => $tanggal,
                'jam_masuk' => $jamSekarang,
                'status' => $status,
                'pengaturan_absensi_id' => $pengaturan->id,
            ]);

            return response()->json([
                'message' => 'Absen masuk berhasil',
                'data' => $siswa,
                'status' => $status,
            ]);
        }

        if (is_null($kehadiran->jam_pulang)) {
            $kehadiran->update(['jam_pulang' => $jamSekarang]);

            return response()->json([
                'message' => 'Absen pulang berhasil',
                'data' => $siswa,
            ]);
        }

        return response()->json(['message' => 'Anda sudah absen pulang hari ini']);
    }

    public function absenManual(Request $request)
    {
        $request->validate([
            'siswa_id' => 'required|exists:siswa,id',
            'tanggal' => 'required|date_format:Y-m-d',
            'jam_masuk' => 'required|date_format:H:i:s',
            'jam_pulang' => 'nullable|date_format:H:i:s',
            'status' => 'required|in:hadir,izin,sakit,alpa',
        ]);

        $pengaturan = PengaturanAbsensi::first();
        if (!$pengaturan) {
            return response()->json(['message' => 'Pengaturan absensi belum dikonfigurasi'], 500);
        }

        $kehadiran = Absensi::where('siswa_id', $request->siswa_id)->where('tanggal', $request->tanggal)->first();
        if ($kehadiran) {
            return response()->json(['message' => 'Siswa sudah absen hari ini']);
        }

        Absensi::create([
            'siswa_id' => $request->siswa_id,
            'tanggal' => $request->tanggal,
            'jam_masuk' => $request->jam_masuk,
            'jam_pulang' => $request->jam_pulang,
            'status' => $request->status,
            'pengaturan_absensi_id' => $pengaturan->id,
        ]);

        return response()->json(['message' => 'Absen berhasil']);
    }

    public function filter(Request $request)
    {
        $query = Absensi::with('siswa');

        if ($request->filled('kelas')) {
            $query->whereHas('siswa', fn($q) => $q->where('kelas', $request->kelas));
        }

        if ($request->filled('kelas')) {
            $query->whereHas('siswa', fn($q) => $q->where('kelas_id', $request->kelas));
        }

        if ($request->filled('tanggal')) {
            $query->where('tanggal', $request->tanggal);
        }

        $absensi = $query->latest()->get();
        $kelas = Kelas::all();

        return view('absen.list', compact('absensi', 'kelas'));
    }

    public function index()
    {
        $absensi = Absensi::with('siswa')->get();
        $kelas = Kelas::all();
        return view('absen.list', compact('absensi', 'kelas'));
    }
}
