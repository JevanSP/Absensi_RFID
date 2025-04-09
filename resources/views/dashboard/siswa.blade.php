@extends('layout.siswa')
@section('siswa')
{{-- @foreach ( user as siswa )
<p>Selamat Datang, {{ $siswa->nama }} {{ $siswa->kelas }}</p>
@endforeach --}}

<div class="container-fluid px-4">
    <div class="row ">
        <div class="col-xl-4 col-md-6">
            <div class="card bg-primary text-white mb-4">
                <div class="card-body">
                    <h5>Jam Masuk Dan Jam Pulang</h5>
                    <h2>{{ $j->jam_masuk }} - {{ $j->jam_pulang }}</h2> 
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-md-6">
            <div class="card bg-info text-white mb-4">
                <div class="card-body">
                    <h5>Status Hari Ini</h5>
                    <h2>@if ($a->status == 'Hadir')
                        <span class="badge bg-success">Hadir</span>
                    @elseif ($a->status == 'Sakit')
                        <span class="badge bg-warning">Sakit</span>
                    @elseif ($a->status == 'Izin')
                        <span class="badge bg-info">Izin</span>
                    @else
                        <span class="badge bg-danger">Alfa</span>
                    @endif
                    </h2> 
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-md-6">
            <div class="card bg-info text-white mb-4">
                <div class="card-body">
                    <h5>Total Poin</h5>
                    <h2>{{ $total_poin }}</h2>
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
            <h5>Pengaturan</h5>
        </div>
    </a>
</div>
@endsection