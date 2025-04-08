@extends('layout.siswa')
@section('siswa')
    <div class="pagetitle">
        <h1>AbsensiKu</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/dashboard/siswa">Beranda</a></li>
                <li class="breadcrumb-item active">Absen</li>
            </ol>
        </nav>
    </div>

    <table class="">
        <thead class="table-light">
            ...
        </thead>
        <tbody>
            @php $no = 1; @endphp
            @foreach ($absen as $a)
                <tr>
                    <td class="text-center">{{ $a->tanggal }}</td>
                    {{-- <td class="text-capitalize">{{ $a->auth }}</td> --}}
                    <td class="text-center">
                        @if ($a->status == 'Hadir')
                            <span class="badge bg-success">Hadir</span>
                        @elseif ($a->status == 'Sakit')
                            <span class="badge bg-warning">Sakit</span>
                        @elseif ($a->status == 'Izin')
                            <span class="badge bg-info">Izin</span>
                        @else
                            <span class="badge bg-danger">Alfa</span>
                        @endif
                    </td>
                    <td class="text-center">{{ $a->keterangan }}</td>
                </tr>
                <!-- Repeat for other rows -->
        </tbody>
    </table>
@endsection
