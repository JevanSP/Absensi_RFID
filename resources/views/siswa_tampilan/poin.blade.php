@extends('layout.siswa')
@section('siswa')
    <div class="pagetitle">
        <h1>PoinKu</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/dashboard/siswa">Beranda</a></li>
                <li class="breadcrumb-item active">PoinKU</li>
            </ol>
        </nav>
    </div>

    <div class="table-responsive">
    <table class="table table-bordered table-striped">
        <thead class="table-light">
            <tr class="text-center">
                <th class="text-center">Tanggal</th>
                <th class="text-capitalize">Nama Poin</th>
                <th class="text-capitalize">Kategori</th>
                <th class="text-center">Poin</th>
            </tr>
        </thead>
        <tbody class="text-center">
            @php $no = 1; @endphp
            @foreach ($poin as $p)
                @php
                    $rowClass = '';
                    if ($p->poinKategori && $p->poinKategori->kategori == 'budaya_positif') {
                        $rowClass = 'table-success';
                    } elseif ($p->poinKategori && $p->poinKategori->kategori == 'pelanggaran') {
                        $rowClass = 'table-danger';
                    } elseif ($p->poinKategori && $p->poinKategori->kategori == 'prestasi') {
                        $rowClass = 'table-primary';
                        $rowClass = '';
                    }
                @endphp
                <tr class="{{ $rowClass }}">
                    <td class="text-center">{{ \Carbon\Carbon::parse($p->tanggal)->format('d-m-Y') }}</td>
                    <td class="text-capitalize">{{ $p->poinKategori->nama ?? '-' }}</td>
                    <td class="text-capitalize">{{ $p->poinKategori->kategori ?? '-' }}</td>
                    <td class="text-center">{{ $p->poinKategori->poin }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    </div>
@endsection
