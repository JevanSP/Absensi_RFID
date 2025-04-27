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


    <div class="col-12 mb-4">
        <h4 class="text-center mb-3"><span class="badge bg-success">Peringkat Poin Siswa</span></h4>
        <table class="table table-bordered table-hover">
            <thead class="thead-dark">
                <tr>
                    <th class="text-center">Peringkat</th>
                    <th class="text-center">Nama</th>
                    <th class="text-center">Kelas</th>
                    <th class="text-center">Total Poin</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $rank = 1;
                @endphp
                @foreach ($peringkat_poin as $index => $item)
                    <tr
                        @if ($index == 0) class="table-warning"
                @elseif($index == 1) class="table-success"
                @elseif($index == 2) class="table-info" @endif>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td class="text-center text-capitalize">{{ $item->siswa->nama_siswa }}</td>
                        <td class="text-center">{{ $item->siswa->kelas->nama }}</td>
                        <td class="text-center">{{ $item->total_poin }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="row">
        <div class="col-xl-3 col-md-6 col-6 mb-4">
            <a href="{{ route('poin_siswa.index', 'budaya_positif') }}"
                class="btn btn-white bg-white border-success d-flex flex-column justify-content-center align-items-center text-white"
                style="height: 120px;">
                <img src="{{ asset('assets/img/positif.png') }}" alt="positif"
                    style="width: 60px; height: 60px; object-fit: contain;">
                <h5 class="mb-2 text-success">Budaya Positif</h5>
            </a>
        </div>
        <div class="col-xl-3 col-md-6 col-6 mb-4">
            <a href="{{ route('poin_siswa.index', 'prestasi') }}"
                class="btn btn-white bg-white border-primary d-flex flex-column justify-content-center align-items-center text-white"
                style="height: 120px;">
                <img src="{{ asset('assets/img/prestasi.png') }}" alt="prestasi"
                    style="width: 60px; height: 60px; object-fit: contain;">
                <h5 class="mb-2 text-primary">Prestasi</h5>
            </a>
        </div>
        <div class="col-xl-3 col-md-6 col-6 mb-4">
            <a href="{{ route('poin_siswa.index', 'pelanggaran') }}"
                class="btn btn-white bg-white border-danger d-flex flex-column justify-content-center align-items-center text-white"
                style="height: 120px;">
                <img src="{{ asset('assets/img/pelanggaran.png') }}" alt="pelanggaran"
                    style="width: 60px; height: 60px; object-fit: contain;">
                <h5 class="mb-2 text-danger">Pelanggaran</h5>
            </a>
        </div>
        <div class="col-xl-3 col-md-6 col-6 mb-4">
            <a href="{{ route('data_sekolah') }}"
                class="btn btn-white bg-white border-info d-flex flex-column justify-content-center align-items-center text-white"
                style="height: 120px;">
                <img src="{{ asset('assets/img/sekolah.svg') }}" alt="Sekolah"
                    style="width: 60px; height: 60px; object-fit: contain;">
                <h5 class="mb-2 text-info">Tentang Sekolah</h5>
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-6 col-md-6">
            <div class="card text-black mb-4 border border-success">
                <div class="card-body mt-3">
                    <h5 class="text-capitalize"><span class="badge bg-success">Tanggal :</span><br></h5>
                    <p class="text-capitalize">
                        @if ($tanggalDibuat instanceof \Carbon\Carbon)
                            {{ $tanggalDibuat->format('d M Y') }}
                        @else
                            {{ $tanggalDibuat ?: '-' }}
                        @endif
                    </p>
                    <br>
                    <h5 class="text-capitalize"><span class="badge bg-success">Acara :</span><br></h5>
                    <p class="text-capitalize">{{ $acara }}</p>
                    <br>
                    <h5 class="text-capitalize"><span class="badge bg-success">Pakaian :</span><br></h5>
                    <p class="text-capitalize">{{ $pakaian }}</p>
                </div>
            </div>
        </div>
        <div class="col-xl-6 col-md-6">
            <div class="card text-black mb-4 border border-info">
                <div class="card-body mt-3">
                    <h5 class="text-capitalize"><span class="badge bg-primary">Jam Masuk Dan Pulang</span><br></h5>
                    <h2>{{ $jam_masuk }} WIB - {{ $jam_pulang }} WIB</h2>
                </div>
            </div>
        </div>
    </div>
@endsection
