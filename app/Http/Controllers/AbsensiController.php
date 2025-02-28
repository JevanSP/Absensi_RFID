<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\Siswa;
use App\Models\PengaturanAbsensi;
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

        $tanggal = Carbon::today()->format('Y-m-d'); // Format yang sesuai dengan database
        $jamSekarang = Carbon::now()->format('H:i:s');
        $pengaturan = PengaturanAbsensi::first();
        $kehadiran = Absensi::where('siswa_id', $siswa->id)->where('tanggal', $tanggal)->first();

        if (!$kehadiran) {
            // Cek apakah siswa datang terlambat
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
        } else {
            // Jika sudah absen masuk, tambahkan jam pulang
            if (is_null($kehadiran->jam_pulang)) {
                $kehadiran->update(['jam_pulang' => $jamSekarang]);

                return response()->json([
                    'message' => 'Absen pulang berhasil',
                    'data' => $siswa,
                ]);
            }

            return response()->json(['message' => 'Anda sudah absen pulang hari ini']);
        }
    }

}
