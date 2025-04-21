<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\Siswa;
use App\Models\PengaturanAbsensi;
use App\Models\Kelas;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Exports\LaporanAbsensiExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class AbsensiController extends Controller
{
    public function absen_masuk_RFID(Request $request)
    {
        $request->validate(['rfid_tag' => 'required|string']);

        // Cari siswa berdasarkan RFID yang diberikan
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

        // Periksa apakah siswa sudah memiliki absensi untuk hari ini
        $kehadiran = Absensi::where('siswa_id', $siswa->id)
            ->where('tanggal', $tanggal)
            ->whereNull('jam_pulang') // Pastikan absensi belum pulang
            ->first();

        if (!$kehadiran) {
            // Tentukan status berdasarkan jam masuk
            $status = ($jamSekarang > $pengaturan->jam_masuk) ? 'terlambat' : 'hadir';

            // Buat catatan absensi baru untuk siswa
            $absensi = Absensi::create([
                'siswa_id' => $siswa->id,
                'pengaturan_absensi_id' => $pengaturan->id,
                'tanggal' => $tanggal,
                'status' => $status,
                'jam_masuk' => $jamSekarang,
                'jam_pulang' => null,
                'keterangan' => null,
            ]);

            // Tambah poin pelanggaran jika terlambat
            if ($status === 'terlambat') {
                $this->tambahPelanggaran($siswa->id, 'Terlambat', $tanggal);
            }

            return response()->json([
                'message' => 'Absensi masuk berhasil dicatat',
                'siswa' => [
                    'nama_siswa' => $siswa->nama_siswa,
                    'nis' => $siswa->nis,
                    'kelas' => $siswa->kelas->nama ?? 'Tidak ada kelas',
                    'jam_masuk' => $jamSekarang,
                    'status' => $status,
                    'foto' => $siswa->foto,
                ]
            ], 200);
        }
    }


    public function absen_pulang_RFID(Request $request)
    {
        $request->validate(['rfid_tag' => 'required|string']);

        // Cari siswa berdasarkan RFID yang diberikan
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

        // Periksa apakah siswa sudah memiliki absensi untuk hari ini dan sudah absen masuk
        $kehadiran = Absensi::where('siswa_id', $siswa->id)
            ->where('tanggal', $tanggal)
            ->whereNotNull('jam_masuk') // Pastikan sudah absen masuk
            ->first();

        if ($kehadiran) {
            // Periksa jika absensi sudah ada dan jam pulang belum dicatat
            if ($kehadiran->jam_pulang) {
                return response()->json([
                    'message' => 'Siswa sudah absen pulang',
                    'siswa' => [
                        'nama_siswa' => $siswa->nama_siswa,
                        'nis' => $siswa->nis,
                        'kelas' => $siswa->kelas->nama ?? 'Tidak ada kelas',
                        'jam_pulang' => $kehadiran->jam_pulang,
                        'foto' => $siswa->foto,
                    ]
                ], 200);
            }

            // Update jam pulang
            $kehadiran->update(['jam_pulang' => $jamSekarang]);

            // Tambah pelanggaran jika bolos (jam pulang lebih dari jam yang ditentukan)
            if ($jamSekarang > $pengaturan->jam_pulang) {
                $this->tambahPelanggaran($siswa->id, 'Bolos Sekolah', $tanggal);
            }

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
        }

        // Jika absensi masuk belum tercatat
        return response()->json([
            'message' => 'Siswa belum absen masuk hari ini',
            'siswa' => [
                'nama_siswa' => $siswa->nama_siswa,
                'nis' => $siswa->nis,
                'kelas' => $siswa->kelas->nama ?? 'Tidak ada kelas',
                'foto' => $siswa->foto,
            ]
        ], 200);
    }

    public function filter(Request $request)
    {
        // Query siswa dengan relasi kelas dan semua absensi
        $query = Siswa::with(['kelas', 'absensi']);

        if ($request->filled('kelas')) {
            $query->where('kelas_id', $request->kelas);
        }

        if ($request->filled('nis')) {
            $query->where('nis', $request->nis);
        }

        $siswaList = $query->get();

        // Filter absensi per siswa berdasarkan tanggal (kalau diisi)
        $siswaList->map(function ($siswa) use ($request) {
            $siswa->absensi = $siswa->absensi->filter(function ($absen) use ($request) {
                return !$request->filled('tanggal') || $absen->tanggal === $request->tanggal;
            });
            return $siswa;
        });

        $kelas = Kelas::all();

        return view('absen.list', [
            'semuaSiswa' => $siswaList,
            'kelas' => $kelas,
        ]);
    }


    public function index()
    {
        $semuaSiswa = Siswa::with(['kelas', 'absensi' => function ($query) {
            $query->whereDate('tanggal', Carbon::today());
        }])->get();

        $kelas = Kelas::all();

        return view('absen.list', compact('semuaSiswa', 'kelas'));
    }

    public function absensi_masuk()
    {
        return view('absen.absensi_masuk');
    }

    public function absensi_pulang()
    {
        return view('absen.absensi_pulang');
    }

    public function absensi_manual(Request $request, $id = null)
    {
        $request->validate([
            'siswa_id' => 'required|exists:siswa,id',
            'tanggal' => 'required|date',
            'jam_masuk' => 'nullable|date_format:H:i',
            'jam_pulang' => 'nullable|date_format:H:i',
            'status' => 'required|in:hadir,terlambat,izin,sakit,alpa,none',
            'keterangan' => 'nullable|string',
        ]);

        $siswaId = $request->siswa_id;
        $tanggal = $request->tanggal;

        // Tambah atau edit absensi
        $absen = Absensi::firstOrNew([
            'siswa_id' => $siswaId,
            'tanggal' => $tanggal,
        ]);

        $absen->jam_masuk = $request->jam_masuk;
        $absen->jam_pulang = $request->jam_pulang;
        $absen->status = $request->status;
        $absen->keterangan = $request->keterangan;
        $absen->pengaturan_absensi_id = PengaturanAbsensi::first()->id ?? null; // optional, jika ada
        $absen->save();


        return redirect()->back()->with('success', 'Absensi berhasil disimpan.');
    }

    public function cetak_laporan_bulanan(Request $request)
    {
        $request->validate([
            'kelas_id' => 'required|exists:kelas,id',
            'bulan' => 'required|date_format:Y-m',
        ]);

        $kelas = \App\Models\Kelas::findOrFail($request->kelas_id);
        $bulan = $request->bulan;
        $bulanFormat = \Carbon\Carbon::parse($bulan)->translatedFormat('F_Y'); // contoh: April_2025

        $fileName = 'Laporan_Absensi_' . $kelas->nama . '_' . $bulanFormat . '.xlsx';

        return Excel::download(new LaporanAbsensiExport($kelas->id, $bulan), $fileName);
    }


    private function tambahPelanggaran($siswaId, $kategoriNama, $tanggal, $userId = null)
    {
        $kategori = \App\Models\PoinKategori::where('nama', $kategoriNama)->where('kategori', 'pelanggaran')->first();

        if ($kategori) {
            \App\Models\PoinSiswa::create([
                'siswa_id' => $siswaId,
                'poin_kategori_id' => $kategori->id,
                'user_id' => $userId ?? Auth::id(), // bisa dari guru yang login atau null
                'keterangan' => "Pelanggaran otomatis: " . $kategoriNama,
                'tanggal' => $tanggal,
            ]);
        }
    }

    public function cetak_laporan_bulanan_pdf(Request $request)
    {
        $request->validate([
            'kelas_id' => 'required|exists:kelas,id',
            'bulan' => 'required|date_format:Y-m',
        ]);

        $kelas = Kelas::findOrFail($request->kelas_id);
        $bulan = Carbon::parse($request->bulan);
        $tanggalRange = collect();
        $start = $bulan->copy()->startOfMonth();
        $end = $bulan->copy()->endOfMonth();
        while ($start <= $end) {
            $tanggalRange->push($start->format('Y-m-d'));
            $start->addDay();
        }

        $siswa = Siswa::where('kelas_id', $kelas->id)->with(['absensi' => function ($query) use ($bulan) {
            $query->whereMonth('tanggal', $bulan->month)->whereYear('tanggal', $bulan->year);
        }])->get();

        $pdf = Pdf::loadView('absen.pdf_laporan_bulanan', [
            'kelas' => $kelas,
            'bulan' => $bulan,
            'tanggalRange' => $tanggalRange,
            'siswa' => $siswa,
        ])->setPaper('a4', 'landscape');

        $fileName = 'Laporan_Absensi_' . $kelas->nama . '_' . $bulan->translatedFormat('F_Y') . '.pdf';

        return $pdf->stream($fileName);
    }
}
