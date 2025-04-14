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
    public function absen_masuk_RFID(Request $request)
    {
        $pengaturan = PengaturanAbsensi::first(); // asumsinya hanya ada satu pengaturan
        $now = Carbon::now();
    
        if ($now->gt(Carbon::createFromFormat('H:i:s', $pengaturan->jam_masuk))) {
            return response()->json(['message' => 'Waktu absen masuk sudah lewat!'], 500);
        }
        
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
                'pengaturan_absensi_id' => $pengaturan->id,
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


        // Tampilkan alert dengan deskripsi siswa
        return response()->json([
            'message' => 'Absensi berhasil dicatat',
            'siswa' => [
                'nama_siswa' => $siswa->nama_siswa,
                'nis' => $siswa->nis,
                'kelas' => $siswa->kelas->nama ?? 'Tidak ada kelas',
                'jam_masuk' => $jamSekarang,
                'status' => ($jamSekarang > $pengaturan->jam_masuk) ? 'terlambat' : 'hadir',
                'foto' => $siswa->foto,
            ]
        ], 200);
    }

    public function absen_pulang_RFID(Request $request)
    {

        $pengaturan = PengaturanAbsensi::first();
        $now = Carbon::now();
    
        if ($now->lt(Carbon::createFromFormat('H:i:s', $pengaturan->jam_pulang))) {
            return response()->json(['message' => 'Belum waktunya absen pulang!'], 500);
        }

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
        if ($kehadiran && $jamSekarang < $pengaturan->jam_pulang) {
            // Jika jam sekarang belum mencapai jam pulang, kembalikan respons error
            return response()->json(['message' => 'Belum waktunya untuk absen pulang'], 400);
        }

        if ($kehadiran) {
            $kehadiran->update([
                'jam_pulang' => $jamSekarang,
            ]);

            return response()->json([
                'message' => 'Absensi pulang berhasil dicatat',
                'siswa' => [
                    'nama_siswa' => $siswa->nama_siswa,
                    'nis' => $siswa->nis,
                    'kelas' => $siswa->kelas->nama ?? 'Tidak ada kelas',
                    'jam_pulang' => $jamSekarang,
                    'foto' => $siswa->foto,
                ]
            ], 200);
        } else {
            return response()->json([
                'message' => 'Siswa belum absen masuk hari ini',
                'siswa' => [
                    'nama' => $siswa->nama_siswa,
                    'nis' => $siswa->nis,
                    'kelas' => $siswa->kelas,
                    'foto' => $siswa->foto,
                ]
            ], 200);
        }
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

        // Ambil data absensi terbaru yang sesuai dengan filter
        $absensi = $query->get()->map(function ($siswa) use ($request) {
            $siswa->absensi = $siswa->absensi->filter(function ($absen) use ($request) {
                return $absen->tanggal == $request->tanggal; // Pastikan hanya absensi pada tanggal yang difilter
            });
            return $siswa;
        });

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

    public function absensi_masuk()
    {
        return view('absen.absensi_masuk');
    }

    public function absensi_pulang()
    {
        return view('absen.absensi_pulang');
    }

    public function absen_manual(Request $request)
    {
        $request->validate([
            'siswa_id' => 'required|exists:siswa,id',
            'tanggal' => 'required|date',
            'jam_masuk' => 'nullable|date_format:H:i',
            'jam_pulang' => 'nullable|date_format:H:i',
            'status' => 'required|in:hadir,terlambat,izin,sakit,alpa',
            'keterangan' => 'nullable|string',
        ]);

        $siswaId = $request->siswa_id;
        $tanggal = $request->tanggal;

        // Ambil atau buat data absensi
        $absen = Absensi::firstOrNew([
            'siswa_id' => $siswaId,
            'tanggal' => $tanggal,
        ]);

        $absen->jam_masuk = $request->jam_masuk ?? $absen->jam_masuk;
        $absen->jam_pulang = $request->jam_pulang ?? $absen->jam_pulang;
        $absen->status = $request->status;
        $absen->keterangan = $request->keterangan;
        $absen->save();

        return redirect()->back()->with('success', 'Absensi berhasil disimpan atau diperbarui.');
    }
}
