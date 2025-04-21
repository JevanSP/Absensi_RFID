<!DOCTYPE html>
<html>
<head>
    <title>Laporan Absensi Bulanan</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 11px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; text-align: center; padding: 5px; }
        th { background-color: #f0f0f0; }
        .info { margin-bottom: 10px; }
    </style>
</head>
<body>
    <h3 style="text-align: center;">Laporan Absensi Bulanan</h3>

    <div class="info">
        <p><strong>Kelas:</strong> {{ $kelas->nama }}</p>
        <p><strong>Bulan:</strong> {{ $bulan->translatedFormat('F Y') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Nama</th>
                @foreach ($tanggalRange as $tanggal)
                    <th>{{ \Carbon\Carbon::parse($tanggal)->format('d') }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach ($siswa as $item)
                <tr>
                    <td style="text-align: left;">{{ $item->nama_siswa }}</td>
                    @foreach ($tanggalRange as $tanggal)
                        @php
                            $absen = $item->absensi->firstWhere('tanggal', $tanggal);
                            $simbol = '-';
                            if ($absen) {
                                switch (strtolower($absen->status)) {
                                    case 'terlambat': $simbol = 'T'; break;
                                    case 'izin': $simbol = 'I'; break;
                                    case 'sakit': $simbol = 'S'; break;
                                    case 'alpa': $simbol = 'A'; break;
                                }
                            }
                        @endphp
                        <td>{{ $simbol }}</td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
