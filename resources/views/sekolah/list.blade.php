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
            <div class="col-lg- mr-2">
                <div class="card">
                    <div class="card-header">Progam Keahlian Sekolah</div>
                    <br>
                    <div class="card-body">
                        <table class="table">
                            <tbody>
                            <td class="text-capitalize">Rekaya Perangkat Lunak (RPL)</td>
                            <td class="text-capitalize">Teknik Komputer Jaringan (TKJ)</td>
                            <td class="text-capitalize">Desain Komunikasi Visual (DKV)</td>
                            <td class="text-capitalize">Produksi dan Siaran Program Televisi(PSPT)</td>
                            <td class="text-capitalize">Animasi</td>
                            <td class="text-capitalize">Desain Pemodelan dan Informasi Bangunan (DPIB)</td>
                            <td class="text-capitalize">Usaha Perjalanan Wisata (UPW)</td>
                            <td class="text-capitalize">Tata Kecantikan Kulit dan Rambut (TKKR)</td>
                            <td class="text-capitalize">Tata Busana (TB)</td>
                            <td class="text-capitalize">Kriya Kreatif Batik dan Tekstil (KKBT)</td>
                            <td class="text-capitalize">Kriya Kreatif Kulit dan Imitasi (KKKI)</td>
                            <td class="text-capitalize">Kriya Kreatif Kayu dan Rotan (KKKR)</td>
                        </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
