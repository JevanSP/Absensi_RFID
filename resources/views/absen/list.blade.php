@extends('layout.layout')
@section('content')
<div class="pagetitle">
    <h1>Data Tables</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="home">Home</a></li>
        <li class="breadcrumb-item">Tables</li>
        <li class="breadcrumb-item active">Data</li>
      </ol>
    </nav>
  </div><!-- End Page Title -->

  {{-- pada tabel paling ataas menampilkan pilihan kelas dan tanggalnya --}}
  
  <table class="table datatable">
    <thead>
        <tr>
            <th>No</th>
            <th>NIS</th>
            <th>Nama</th>
            <th>Kehadiran</th>
            <th>Jam Masuk</th>
            <th>Jam Pulang</th>
            <th>Keterangan</th>
            <th>Aksi</th>
    </thead>
    <tbody>
        <tr>
            <td>Mark</td>
            <td>Otto</td>
            <td>@mdo</td>
            <td>Mark</td>
            <td>Otto</td>
        </tr>
    </tbody>
</table>