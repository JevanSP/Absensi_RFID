@extends('layout.layout')
@section('content')
<div class="pagetitle">
    <h1>Data Siswa</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="home">Home</a></li>
        <li class="breadcrumb-item">User</li>
        <li class="breadcrumb-item active">Siswa</li>
      </ol>
    </nav>
  </div><!-- End Page Title -->

  <table class="table datatable">
    <thead>
      <tr>
        <th>No</th>
        <th>NIS</th>
        <th>Nama</th>
        <th>Aksi</th>
    </tr>
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
@endsection