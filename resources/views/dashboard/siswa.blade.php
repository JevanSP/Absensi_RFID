@extends('layout.siswa')
@section('siswa')
    <h3 class="mb-2"><b>Selamat Datang, {{ $user->nama }} </b></h3>
    <div class="container-fluid px-4">
        <div class="row mt-3">
            <div class="col-xl-4 col-md-6">
                <div class="card bg-success text-white mb-4">
                    <div class="card-body mt-3">
                        <h5>Jam Masuk Dan Jam Pulang</h5>
                        <h2>{{ $jam_masuk }} - {{ $jam_pulang }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-md-6">
                <div class="card bg-success border-collapse border-success text-white mb-4">
                    <div class="card-body mt-3">
                        <h5 class="text-white">Status Hari Ini</h5>
                        <h2>
                            @if ($status == 'Hadir')
                                <span class="badge bg-success">Hadir</span>
                            @elseif ($status == 'sakit')
                                <span class="badge bg-secondary">Sakit</span>
                            @elseif ($status == 'alfa')
                                <span class="badge bg-danger">Alfa</span>
                            @elseif ($status == 'terlambat')
                                <span class="badge bg-warning">Terlambat</span>
                            @elseif ($status == 'izin')
                                <span class="badge bg-info">Izin</span>
                            @elseif ($status == null)
                                <span class="badge bg-black">-</span>
                            @endif 
                        </h2>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-md-6">
                <div class="card bg-success text-white mb-4">
                    <div class="card-body mt-3">
                        <h5>Total Poin</h5>
                        <h2 id="totalPoin" data-target="{{ $total_poin }}">0</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="d-flex flex-wrap justify-content-center">
        <a href="{{ route('siswa.absensi') }}"
            class="btn btn-light border-success m-2 d-flex flex-column justify-content-center align-items-center text-white"
            style="width: 45%; height: 100px;">
            <img src="{{ asset('assets/img/absensi.svg') }}" alt="Absen"
                style="width: 60px; height: 60px; object-fit: contain;">
            <h5 class="mb-2 text-success">Rekap Absensi</h5>
        </a>
        <a href="{{ route('siswa.poin') }}"
            class="btn btn-light border-success m-2 d-flex flex-column justify-content-center align-items-center text-white"
            style="width: 45%; height: 100px;">
            <img src="{{ asset('assets/img/poin.svg') }}" alt="Absen"
                style="width: 60px; height: 60px; object-fit: contain;">
            <h5 class="mb-2 text-success">PoinKU</h5>
        </a>
        <a href="{{ route('siswa.berita') }}"
            class="btn btn-light border-success m-2 d-flex flex-column justify-content-center align-items-center text-white"
            style="width: 45%; height: 100px;">
            <img src="{{ asset('assets/img/berita.svg') }}" alt="Absen"
                style="width: 60px; height: 60px; object-fit: contain;">
            <h5 class="mb-2 text-success">Berita/Acara</h5>
        </a>
        <a href="{{ route('siswa.sekolah') }}"
            class="btn btn-light border-success m-2 d-flex flex-column justify-content-center align-items-center text-white"
            style="width: 45%; height: 100px;">
            <img src="{{ asset('assets/img/sekolah.svg') }}" alt="Absen"
                style="width: 60px; height: 60px; object-fit: contain;">
            <h5 class="mb-2 text-success">Tentang Sekolah</h5>
        </a>
    </div>
@endsection
