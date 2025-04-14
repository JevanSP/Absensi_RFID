@extends('layout.siswa')
@section('siswa')
    <h3 class="mb-2"><b>Selamat Datang, {{ $user->nama }} </b></h3>
    <div class="container-fluid px-4">
        <div class="row ">
            <div class="col-xl-4 col-md-6">
                <div class="card bg-primary text-white mb-4">
                    <div class="card-body">
                        <h5>Jam Masuk Dan Jam Pulang</h5>
                        <h2>{{ $jam_masuk }} - {{ $jam_pulang }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-md-6">
                <div class="card bg-white border-collapse border-success text-white mb-4">
                    <div class="card-body">
                        <h5 class="text-black">Status Hari Ini</h5>
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
                            @endif
                        </h2>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-md-6">
                <div class="card bg-info text-white mb-4">
                    <div class="card-body">
                        <h5>Total Poin</h5>
                        {{-- <h2>{{ $total_poin }}</h2> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="d-flex flex-wrap justify-content-center">
        <a href="#" class="btn btn-success m-2" style="width: 45%; height: 100px;">
            <div class="d-flex flex-column justify-content-center align-items-center h-100">
                <h5>Rekap Absensi</h5>
            </div>
        </a>
        <a href="#" class="btn btn-primary m-2" style="width: 45%; height: 100px;">
            <div class="d-flex flex-column justify-content-center align-items-center h-100">
                <h5>PoinKU</h5>
            </div>
        </a>
        <a href="#" class="btn btn-info m-2" style="width: 45%; height: 100px;">
            <div class="d-flex flex-column justify-content-center align-items-center h-100">
                <h5>Berita/Acara</h5>
            </div>
        </a>
        <a href="#" class="btn btn-warning m-2" style="width: 45%; height: 100px;">
            <div class="d-flex flex-column justify-content-center align-items-center h-100">
                <h5>Tentang Sekolah</h5>
            </div>
        </a>
    </div>
@endsection
