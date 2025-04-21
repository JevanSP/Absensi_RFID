@extends('layout.siswa')
@section('siswa')
    <div class="pagetitle">
        <h1>Berita/Acara</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/dashboard/siswa">Beranda</a></li>
                <li class="breadcrumb-item active">Berita/Acara</li>
            </ol>
        </nav>
    </div>

    <p><strong>Acara:</strong> {{ $berita->acara }}</p>
    <p><strong>Pakaian:</strong> {{ $berita->pakaian }}</p>
@endsection
