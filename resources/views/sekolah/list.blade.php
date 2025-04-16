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
                        @php
                            $keahlian = [
                                'Rekayasa Perangkat Lunak (RPL)',
                                'Teknik Komputer Jaringan (TKJ)',
                                'Desain Komunikasi Visual (DKV)',
                                'Produksi dan Siaran Program Televisi (PSPT)',
                                'Animasi',
                                'Desain Pemodelan dan Informasi Bangunan (DPIB)',
                                'Usaha Perjalanan Wisata (UPW)',
                                'Tata Kecantikan Kulit dan Rambut (TKKR)',
                                'Tata Busana (TB)',
                                'Kriya Kreatif Batik dan Tekstil (KKBT)',
                                'Kriya Kreatif Kulit dan Imitasi (KKKI)',
                                'Kriya Kreatif Kayu dan Rotan (KKKR)',
                            ];
                        @endphp

                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th class="text-capitalize">Nama Keahlian</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($keahlian as $k)
                                        <tr>
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td class="text-capitalize">{{ $k }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg mr-2">
                <div class="card">
                    <div class="card-header">Alamat</div>
                    <br>
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3948.964085516717!2d111.08978727500939!3d-8.206366191825705!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e7bdf7de1e8387f%3A0x4d70ae1734962587!2sSMK%20Negeri%201%20Pacitan!5e0!3m2!1sid!2sid!4v1744816900541!5m2!1sid!2sid" width="400" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </div>
        </div>
    @endsection
