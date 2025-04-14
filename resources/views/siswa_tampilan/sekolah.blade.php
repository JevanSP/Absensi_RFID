@extends('layout.siswa')
@section('siswa')
    <div class="pagetitle">
        <h1>Tentang Sekolah</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/dashboard/siswa">Beranda</a></li>
                <li class="breadcrumb-item active">Tentang Sekolah</li>
            </ol>
        </nav>
    </div>
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
                        <table class="table table-sm">
                            <td class="text-capitalize">Rekaya Perangkat Lunak</td>
                            <td class="text-capitalize">Teknik Komputer Jaringan</td>
                            <td class="text-capitalize">Desain Komunikasi Visual</td>
                            <td class="text-capitalize">Animasi</td>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
