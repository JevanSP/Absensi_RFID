<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laporan Absensi</title>
</head>
<body>
    <h3>Laporan Absensi Bulanan</h3>
    <table border="1" cellspacing="0" cellpadding="4">
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
                    <td>{{ $item->nama_siswa }}</td>
                    @php
                        $absensiMap = $item->absensi->keyBy('tanggal');
                    @endphp
                    @foreach ($tanggalRange as $tanggal)
                        @php
                            $absen = $absensiMap->get($tanggal);
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
