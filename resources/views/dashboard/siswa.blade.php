{{-- @extends('layout.siswa')
@section('content')
<div class="container-fluid px-4">
    <div class="row ">
        <div class="col-xl-4 col-md-6">
            <div class="card bg-success text-white mb-4">
                <div class="card-body">
                    <h5>Absensi</h5>
                    <h2>{{ $absensi }}</h2> 
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-md-6">
            <div class="card bg-danger text-white mb-4">
                <div class="card-body">
                    <h5>Poin</h5>
                    <h2>{{ $total_poin }}</h2> 
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-md-6">
            <div class="card bg-primary text-white mb-4">
                <div class="card-body">
                    <h5>Total Barang</h5>
                    <h2>{{ $total_barang }}</h2> 
                </div>
            </div>
        </div>
    </div>
</div>

@endsection --}}

@extends('layout.siswa')
@section('siswa')
{{-- @foreach ( user as siswa )
<p>Selamat Datang, {{ siswa->nama }}</p>
@endforeach --}}

<div class="d-flex flex-wrap justify-content-center">
    <a href="#" class="btn btn-success m-2" style="width: 45%; height: 100px;">
        <div class="d-flex flex-column justify-content-center align-items-center h-100">
            <h5>Absensi</h5>
        </div>
    </a>
    <a href="#" class="btn btn-primary m-2" style="width: 45%; height: 100px;">
        <div class="d-flex flex-column justify-content-center align-items-center h-100">
            <h5>Poin</h5>
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