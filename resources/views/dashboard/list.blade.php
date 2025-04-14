{{-- @extends('layout.layout')
@section('content')
    <div id="layoutSidenav_content">
        <div class="container-fluid px-4">
            <div class="row ">
                <div class="col-xl-4 col-md-6">
                    <div class="card bg-success text-white mb-4">
                        <div class="card-body">
                            <h5>Total Pendapatan</h5>
                            <h2>Rp. {{ number_format($total_pendapatan) }}</h2>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-md-6">
                    <div class="card bg-danger text-white mb-4">
                        <div class="card-body">
                            <h5>Total Jenis Barang</h5>
                            <h2>{{ $total_jenis }}</h2>
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
    </div>
@endsection --}}

@extends('layout.layout')
@section('content')
<h3 class="mb-2"><b>Selamat Datang, {{ $user->nama }} </b></h3>
<div class="container-fluid px-4">
    <div class="row ">
        <div class="col-xl-4 col-md-6">
            <div class="card bg-success text-white mb-4">
                <div class="card-body mt-3">
                    <h5>Total Siswa</h5>
                    <h2>{{ $total_siswa }}</h2>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-md-6">
            <div class="card bg-primary text-white mb-4">
                <div class="card-body mt-3">
                    <h5>Siswa Yang Hadir Hari Ini</h5>
                    <h2>{{ $siswa_hadir_hari_ini }}</h2>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-md-6">
            <div class="card bg-danger text-white mb-4">
                <div class="card-body mt-3">
                    <h5>Siswa Yang Tidak Hadir Hari Ini</h5>
                    <h2>{{ $siswa_tidak_hadir_hari_ini }}</h2>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
