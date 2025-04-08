@extends('layout.siswa')
@section('siswa')
<div class="pagetitle">
    <h1>PoinKu</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/dashboard/siswa">Beranda</a></li>
            <li class="breadcrumb-item active">Poin</li>
        </ol>
    </nav>
</div>

<table class="">
    <thead class="table-light">
        ...
      </thead>
      <tbody>
        @php $no = 1; @endphp
            @foreach ($poin as $p)
            @php
                $rowClass = '';
                if ($p->kategori == 'positif') {
                    $rowClass = 'table-success';
                } elseif ($p->kategori == 'negatif') {
                    $rowClass = 'table-danger';
                }
            @endphp
            <tr class="{{ $rowClass }}">
        <tr>
            <td class="text-center">{{ $p->tanggal }}</td>
            <td class="text-capitalize">{{ $p->nama_poin }}</td>
            <td class="text-center">{{ $p->poin }}</td>
        </tr>
        <!-- Repeat for other rows -->
    </tbody>
</table>

@endsection