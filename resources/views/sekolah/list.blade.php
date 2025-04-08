@extends('layout.layout')
@section('content')
    <div class="pagetitle">
        <h1>Data Sekolah</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="home">Home</a></li>
                <li class="breadcrumb-item active">Sekolah</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->
    <div class="container">
        <div class="row">
            <div class="col-lg-6 mr-2">
                <div class="card">
                    <div class="card-header">Identitas Sekolah</div>
                    <br>
                    <div class="card-body">
                        <p><b>NPSN</b> : 20511014</p>
                        <P><b>Status Sekolah</b> : Negeri</P>
                        <p><b>Bentuk Pendidikan</b> : SMK</p>
                        <p><b>SK Pendirian Sekolah</b> : 383/UKK.3/1968</p>
                        <p><b>Tanggal SK Pendirian</b> : 1968-11-30</p>
                        <p><b>Alamat</b> : Jl. Letjend Soeprapto No.53, Barean, Ploso, Kec. Pacitan, Kabupaten Pacitan, Jawa
                            Timur 63515</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 mr-2">
                <div class="card">
                    <div class="card-header">Informasi</div>
                    <br>
                    <div class="card-body">
                        <p><b>Kepala Sekolah</b> : Joko Supriyadi S.Pd,</p>
                        <p><b>Akredasi</b> : A</p>
                        <p><b>Kurikulum</b> : Kurikulum Merdeka</p>
                        <p><b>Pendidik</b> : </p>
                        <p><b>Peserta Didik</b> : </p>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 mr-2">
                <div class="card">
                    <div class="card-header">Progam Keahlian Sekolah</div>
                    <br>
                    <div class="card-body">
                        @foreach ($kelas as $row)
                            <table class="table table-sm">
                                <td class="text-capitalize">{{ $row->nama }}</td>
                            </table>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
