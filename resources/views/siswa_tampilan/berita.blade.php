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

    <div class="card bg-success text-white mb-4">
        <div class="card-body mt-3">
            <p class="text-capitalize"><strong>Tanggal : <br>
                </strong>
                @if ($tanggalDibuat instanceof \Carbon\Carbon)
                    {{ $tanggalDibuat->format('d M Y') }}
                @else
                    {{ $tanggalDibuat ?: '-' }}
                @endif
            </p>
            <br>
            <p class="text-capitalize"><strong>Acara : <br>
                </strong> {{ $berita->acara }}</p>
            <br>
            <p class="text-capitalize"><strong>Pakaian : <br>
                </strong> {{ $berita->pakaian }}</p>
        </div>
    </div>
@endsection
