<?php
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use App\Models\Absensi;
use App\Models\Siswa;
use App\Models\Kelas;
use Illuminate\Support\Carbon;

class AbsensiBulananExport implements FromArray, WithTitle, WithHeadings, ShouldAutoSize
{
    protected $kelasId;
    protected $bulan;
    protected $tanggalRange;
    protected $kelasNama;

    public function __construct($kelasId, $bulan)
    {
        $this->kelasId = $kelasId;
        $this->bulan = $bulan;

        $start = Carbon::parse($bulan)->startOfMonth();
        $end = Carbon::parse($bulan)->endOfMonth();
        $this->tanggalRange = collect();
        while ($start <= $end) {
            $this->tanggalRange->push($start->format('Y-m-d'));
            $start->addDay();
        }

        $this->kelasNama = Kelas::find($kelasId)->nama;
    }

    public function array(): array
    {
        $data = [];

        // Baris info kelas dan bulan
        $data[] = ['Kelas:', $this->kelasNama];
        $data[] = ['Bulan:', Carbon::parse($this->bulan)->translatedFormat('F Y')];
        $data[] = []; // Baris kosong

        // Header tanggal
        $header = ['Nama'];
        foreach ($this->tanggalRange as $tanggal) {
            $header[] = Carbon::parse($tanggal)->format('d');
        }
        $data[] = $header;

        // Isi data absen
        $siswa = Siswa::where('kelas_id', $this->kelasId)->with(['absensi' => function ($query) {
            $query->whereMonth('tanggal', Carbon::parse($this->bulan)->month)
                ->whereYear('tanggal', Carbon::parse($this->bulan)->year);
        }])->get();

        foreach ($siswa as $item) {
            $row = [$item->nama_siswa];
            foreach ($this->tanggalRange as $tanggal) {
                $absen = $item->absensi->firstWhere('tanggal', $tanggal);
                $simbol = '-';
                if ($absen) {
                    switch (strtolower($absen->status)) {
                        case 'terlambat':
                            $simbol = 'T';
                            break;
                        case 'izin':
                            $simbol = 'I';
                            break;
                        case 'sakit':
                            $simbol = 'S';
                            break;
                        case 'alpa':
                            $simbol = 'A';
                            break;
                    }
                }
                $row[] = $simbol;
            }
            $data[] = $row;
        }

        return $data;
    }

    public function headings(): array
    {
        return []; // Heading sudah kita buat manual di array()
    }

    public function title(): string
    {
        return 'Laporan Absensi';
    }
}
