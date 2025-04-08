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

        // Cari siswa berdasarkan RFID yang diberikan
        $siswa = Siswa::where('rfid_tag', $request->rfid_tag)->first();
        if (!$siswa) {
            // Jika siswa tidak ditemukan, kembalikan respons error 404
            return response()->json(['message' => 'RFID tidak ditemukan'], 404);
        }

        // Ambil tanggal hari ini dalam format 'Y-m-d'
        $tanggal = Carbon::today()->format('Y-m-d');

        // Ambil waktu sekarang dalam format 'H:i:s'
        $jamSekarang = Carbon::now()->format('H:i:s');

        // Ambil pengaturan absensi (pengaturan jam masuk dan jam pulang)
        $pengaturan = PengaturanAbsensi::first();

        if (!$pengaturan) {
            // Jika pengaturan absensi belum dikonfigurasi, kembalikan respons error 500
            return response()->json(['message' => 'Pengaturan absensi belum dikonfigurasi'], 500);
        }

        // Periksa apakah siswa sudah memiliki absensi untuk hari ini
        $kehadiran = Absensi::where('siswa_id', $siswa->id)->where('tanggal', $tanggal)->first();

        if (!$kehadiran) {
            // Jika belum ada absensi, tentukan status berdasarkan jam masuk
            $status = ($jamSekarang > $pengaturan->jam_masuk) ? 'terlambat' : 'hadir';

            // Buat catatan absensi baru untuk siswa
            Absensi::create([
                'siswa_id' => $siswa->id, 
                'tanggal' => $tanggal, 
                'status' => $status, 
                'jam_masuk' => $jamSekarang, 
                'jam_pulang' => null, 
                'keterangan' => null, 
            ]);
        } else {
            // Jika absensi sudah ada, kembalikan respons bahwa siswa sudah absen
            return response()->json(['message' => 'Siswa sudah absen hari ini'], 200);
        }

        // Kembalikan respons sukses
        return response()->json(['message' => 'Absensi berhasil dicatat'], 200);
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
        // Query siswa beserta relasi kelas dan absensi
        $query = Siswa::with(['kelas', 'absensi' => function ($query) {
            $query->latest(); // Mengurutkan absensi terbaru per siswa
        }]);

        if ($request->filled('kelas')) {
            $query->where('kelas_id', $request->kelas); 
        }

        if ($request->filled('nis')) {
            $query->where('nis', $request->nis);
        }

        // Filter berdasarkan tanggal absensi
        if ($request->filled('tanggal')) {
            $query->whereHas('absensi', function ($q) use ($request) {
                $q->whereDate('tanggal', $request->tanggal); // Gunakan whereDate untuk membandingkan tanggal
            });
        }
        $absensi = $query->get();

        // Ambil semua kelas untuk dropdown
        $kelas = Kelas::all();

        return view('absen.list', compact('absensi', 'kelas'));
    }

    public function index()
    {
        $absensi = Siswa::with(['kelas', 'absensi' => function ($query) {
            $query->latest();
        }])->get();

        $kelas = Kelas::all();
        return view('absen.list', compact('absensi', 'kelas'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'jam_masuk' => 'nullable|date_format:H:i',
            'jam_pulang' => 'nullable|date_format:H:i',
            'status' => 'required|in:hadir,izin,sakit,alpa',
            'keterangan' => 'nullable|string',
        ]);

        $absensi = Absensi::findOrFail($id);
        $absensi->update([
            'jam_masuk' => $request->jam_masuk,
            'jam_pulang' => $request->jam_pulang,
            'status' => $request->status,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->back()->with('success', 'Data absensi berhasil diperbarui');
    }
}
