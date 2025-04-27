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
use Illuminate\Support\Facades\Storage;

class AbsensiController extends Controller
{
    public function absen_masuk_RFID(Request $request)
    {
        $request->validate(['rfid_tag' => 'required|string']);

        $siswa = Siswa::where('rfid_tag', $request->rfid_tag)->first();
        if (!$siswa) {
            return response()->json(['message' => 'RFID tidak ditemukan', 'type' => 'error'], 404);
        }

        $tanggal = Carbon::today()->format('Y-m-d');
        $jamSekarang = Carbon::now()->format('H:i:s');
        $pengaturan = PengaturanAbsensi::first();

        if (!$pengaturan) {
            return response()->json(['message' => 'Pengaturan absensi belum dikonfigurasi', 'type' => 'error'], 500);
        }

        // Cek apakah siswa sudah absen hari ini
        $kehadiran = Absensi::where('siswa_id', $siswa->id)
            ->whereDate('tanggal', $tanggal)
            ->first();

        if ($kehadiran) { // Modifikasi di sini
            // Update jika sudah ada record
            $kehadiran->update([
                'jam_masuk' => $jamSekarang,
                'status' => ($jamSekarang > $pengaturan->jam_masuk) ? 'terlambat' : 'hadir',
            ]);

            if ($kehadiran->status === 'terlambat') {
                $this->tambahPelanggaran($siswa->id, 'Terlambat', $tanggal);
            }

            return response()->json([
                'message' => 'Absensi masuk berhasil dicatat',
                'type' => 'success',
                'siswa' => [
                    'nama_siswa' => $siswa->nama_siswa,
                    'nis' => $siswa->nis,
                    'kelas' => $siswa->kelas->nama ?? 'Tidak ada kelas',
                    'jam_masuk' => $jamSekarang,
                    'jam_pulang' => $kehadiran->jam_pulang ?? '-',
                    'status' => ($jamSekarang > $pengaturan->jam_masuk) ? 'terlambat' : 'hadir',
                    'foto' => $siswa->foto,
                ]
            ], 200);
        } else {
            // Jika belum absen, catat absensi
            $status = ($jamSekarang > $pengaturan->jam_masuk) ? 'terlambat' : 'hadir';

            Absensi::create([
                'siswa_id' => $siswa->id,
                'pengaturan_absensi_id' => $pengaturan->id,
                'tanggal' => $tanggal,
                'status' => $status,
                'jam_masuk' => $jamSekarang,
                'jam_pulang' => null,
                'keterangan' => null,
            ]);

            if ($status === 'terlambat') {
                $this->tambahPelanggaran($siswa->id, 'Terlambat', $tanggal);
            }

            return response()->json([
                'message' => 'Absensi masuk berhasil dicatat',
                'type' => 'success',
                'siswa' => [
                    'nama_siswa' => $siswa->nama_siswa,
                    'nis' => $siswa->nis,
                    'kelas' => $siswa->kelas->nama ?? 'Tidak ada kelas',
                    'jam_masuk' => $jamSekarang,
                    'jam_pulang' => '-',
                    'status' => $status,
                    'foto' => $siswa->foto,
                ]
            ], 200);
        }
    }

    public function checkAbsensiHariIni(Request $request)
    {
        $request->validate(['rfid_tag' => 'required|string']);

        $siswa = Siswa::where('rfid_tag', $request->rfid_tag)->first();
        if (!$siswa) {
            return response()->json(['message' => 'RFID tidak ditemukan', 'type' => 'error'], 404);
        }

        $tanggal = Carbon::today()->format('Y-m-d');

        $kehadiran = Absensi::where('siswa_id', $siswa->id)
            ->whereDate('tanggal', $tanggal)
            ->first();

        if ($kehadiran) {
            return response()->json([
                'message' => 'Siswa sudah absen hari ini',
                'type' => 'warning',
                'siswa' => [
                    'nama_siswa' => $siswa->nama_siswa,
                    'nis' => $siswa->nis,
                    'kelas' => $siswa->kelas->nama ?? 'Tidak ada kelas',
                    'jam_masuk' => $kehadiran->jam_masuk ?? '-',
                    'jam_pulang' => $kehadiran->jam_pulang ?? '-',
                    'status' => $kehadiran->status ?? '-',
                    'foto' => $siswa->foto,
                ]
            ]);
        } else {
            return response()->json([
                'message' => 'Siswa belum absen hari ini',
                'type' => 'success', // Or perhaps 'info', depending on how you want to style it
                'siswa' => [
                    'nama_siswa' => $siswa->nama_siswa,
                    'nis' => $siswa->nis,
                    'kelas' => $siswa->kelas->nama ?? 'Tidak ada kelas',
                    'foto' => $siswa->foto,
                ]
            ]);
        }
    }

    public function absen_pulang_RFID(Request $request)
    {
        $request->validate(['rfid_tag' => 'required|string']);

        // Cari siswa berdasarkan RFID
        $siswa = Siswa::where('rfid_tag', $request->rfid_tag)->first();
        if (!$siswa) {
            return response()->json(['message' => 'RFID tidak ditemukan'], 404);
        }

        $tanggalHariIni = Carbon::today()->format('Y-m-d');
        $jamSekarang = Carbon::now()->format('H:i:s');
        $pengaturan = PengaturanAbsensi::first();

        if (!$pengaturan) {
            return response()->json(['message' => 'Pengaturan absensi belum dikonfigurasi'], 500);
        }

        // ======================
        // CEK absensi KEMARIN
        // ======================
        $absensiKemarin = Absensi::where('siswa_id', $siswa->id)
            ->whereDate('tanggal', Carbon::yesterday()->format('Y-m-d'))
            ->first();

        if ($absensiKemarin) {
            if ($absensiKemarin->jam_masuk && !$absensiKemarin->jam_pulang) {
                // Kalau ada jam_masuk kemarin tapi tidak absen pulang, tambah pelanggaran
                $this->tambahPelanggaran($siswa->id, 'Bolos Sekolah', Carbon::yesterday()->format('Y-m-d'));
            }
        }

        // ======================
        // UPDATE absensi HARI INI
        // ======================
        $kehadiranHariIni = Absensi::where('siswa_id', $siswa->id)
            ->whereDate('tanggal', $tanggalHariIni)
            ->first();

        if ($kehadiranHariIni) {
            // Update jam pulang
            $kehadiranHariIni->update(['jam_pulang' => $jamSekarang]);

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
                    'nama_siswa' => $siswa->nama_siswa,
                    'nis' => $siswa->nis,
                    'kelas' => $siswa->kelas->nama ?? 'Tidak ada kelas',
                    'foto' => $siswa->foto,
                ]
            ], 200);
        }
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
        $pengaturan = PengaturanAbsensi::first();
        return view('absen.absensi_masuk', compact('pengaturan'));
    }

    public function absensi_pulang()
    {
        $pengaturan = PengaturanAbsensi::first();
        return view('absen.absensi_pulang', compact('pengaturan'));
    }

    public function absensi_manual(Request $request)
    {
        $request->validate([
            'siswa_id' => 'required|exists:siswa,id',
            'tanggal' => 'required|date',
            'jam_masuk' => 'nullable|date_format:H:i',
            'jam_pulang' => 'nullable|date_format:H:i',
            'status' => 'required|in:hadir,terlambat,izin,sakit,alpa,none',
            'keterangan' => 'nullable|string',
            'bukti_file' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $siswa = Siswa::findOrFail($request->siswa_id);
        $tanggal = $request->tanggal;

        // Cari data absensi hari itu
        $absen = Absensi::where('siswa_id', $siswa->id)
            ->whereDate('tanggal', $tanggal)
            ->first();

        if ($request->status === 'none') {
            if ($absen) {
                $absen->delete();
            }
            return back()->with('success', 'Data absensi berhasil dihapus.');
        }

        if (!$absen) {
            // Kalau belum ada, buat baru
            $absen = new Absensi();
            $absen->siswa_id = $siswa->id;
            $absen->tanggal = $tanggal;
        }

        $absen->jam_masuk = $request->filled('jam_masuk') ? $request->jam_masuk : $absen->jam_masuk;
        $absen->jam_pulang = $request->filled('jam_pulang') ? $request->jam_pulang : $absen->jam_pulang;
        $absen->status = $request->status;
        $absen->pengaturan_absensi_id = PengaturanAbsensi::first()->id ?? null;

        if (in_array($request->status, ['izin', 'sakit']) && $request->hasFile('bukti_file')) {
            $file = $request->file('bukti_file');
            $namaFile = 'bukti_' . $siswa->id . '_' . now()->format('YmdHis') . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('bukti_absensi', $namaFile, 'public');
            $absen->keterangan = "Bukti: " . $path;
        } else {
            $absen->keterangan = $request->keterangan;
        }

        if ($absen->jam_masuk && $absen->jam_pulang && $absen->jam_masuk > $absen->jam_pulang) {
            return back()->with('error', 'Jam masuk tidak boleh lebih besar dari jam pulang.');
        }

        $absen->save();

        // Tambahkan pelanggaran jika statusnya 'terlambat'
        if ($request->status === 'terlambat') {
            $this->tambahPelanggaran($siswa->id, 'Terlambat', $tanggal);
        }

        return back()->with('success', 'Absensi berhasil diperbarui.');
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
        // Cek apakah kategori pelanggaran ada pada database
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
