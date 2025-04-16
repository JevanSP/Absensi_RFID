<?php

namespace App\Exports;

use App\Models\Absensi;
use App\Models\Siswa;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Carbon\Carbon;

class LaporanAbsensiExport implements FromView
{
    protected $kelasId;
    protected $bulan;

    public function __construct($kelasId, $bulan)
    {
        $this->kelasId = $kelasId;
        $this->bulan = $bulan;
    }

    public function view(): View
    {
        $tanggalMulai = Carbon::parse($this->bulan . '-01');
        $tanggalAkhir = $tanggalMulai->copy()->endOfMonth();

        $tanggalRange = [];
        for ($date = $tanggalMulai->copy(); $date->lte($tanggalAkhir); $date->addDay()) {
            $tanggalRange[] = $date->format('Y-m-d');
        }

        $siswa = Siswa::where('kelas_id', $this->kelasId)
            ->with(['absensi' => function ($query) use ($tanggalMulai, $tanggalAkhir) {
                $query->whereBetween('tanggal', [$tanggalMulai->toDateString(), $tanggalAkhir->toDateString()]);
            }])->get();

        return view('absen.excel_laporan_bulanan', [
            'siswa' => $siswa,
            'tanggalRange' => $tanggalRange,
        ]);
    }
}
