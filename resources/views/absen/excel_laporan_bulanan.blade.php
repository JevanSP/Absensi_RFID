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
                <td>{{ $item->nama_siswa }}</td>
                @foreach ($tanggalRange as $tanggal)
                    @php
                        $absen = $item->absensi->firstWhere('tanggal', $tanggal);
                        $simbol = '.';
                        if ($absen) {
                            switch ($absen->status) {
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
                        } else {
                            $simbol = '-'; // jika tidak ada catatan sama sekali
                        }
                    @endphp
                    <td>{{ $simbol }}</td>
                @endforeach
            </tr>
        @endforeach
    </tbody>
</table>
