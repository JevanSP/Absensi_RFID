@extends('layout.layout')

@section('content')
    <div class="pagetitle">
        <h1>Absensi Siswa</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="home">Beranda</a></li>
                <li class="breadcrumb-item active">Absensi Siswa</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <form method="GET" action="{{ route('absen.filter') }}">
        <div class="row mb-3">
            <div class="col-md-3">
                <label>NIS</label>
                <input type="text" name="nis" class="form-control" placeholder="NIS">
            </div>
            <div class="col-md-3">
                <label>Kelas</label>
                <select name="kelas" class="form-control">
                    <option value="">Semua Kelas</option>
                    <option value="X">X</option>
                    <option value="XI">XI</option>
                    <option value="XII">XII</option>
                </select>
            </div>

            <div class="col-md-3">
                <label>Jurusan</label>
                <select name="jurusan" class="form-control">
                    <option value="">Semua Jurusan</option>
                    @foreach ($jurusan as $j)
                        <option value="{{ $j->id }}">{{ $j->nama }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-3">
                <label>Tanggal</label>
                <input type="date" name="tanggal" class="form-control">
            </div>

            <div class="col-md-3 d-flex align-items-end">
                <button type="submit" class="btn btn-primary w-100">Filter</button>
            </div>
        </div>
    </form>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>NIS</th>
                <th>Nama Siswa</th>
                <th>Kelas</th>
                <th>Tanggal</th>
                <th>Jam Masuk</th>
                <th>Jam Pulang</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @if($absensi->isEmpty())
                <tr>
                    <td colspan="7" class="text-center">Tidak ada data absensi</td>
                </tr>
            @else
                @foreach ($absensi as $absen)
                    <tr>
                        <td>{{ $absen->siswa->nis }}</td>
                        <td>{{ $absen->siswa->nama_siswa }}</td>
                        <td>{{ $absen->siswa->jurusan->singkatan }} {{ $absen->siswa->kelas }}</td>
                        <td>{{ $absen->tanggal }}</td>
                        <td>{{ $absen->jam_masuk }}</td>
                        <td>{{ $absen->jam_pulang ?? '-' }}</td>
                        <td>{{ ucfirst($absen->status) }}</td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
@endsection
