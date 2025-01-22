@extends('layout.layout')
@section('content')

<div class="pagetitle">
    <h1>Data Siswa</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
            <li class="breadcrumb-item">Data Master</li>
            <li class="breadcrumb-item active">Data Siswa</li>
        </ol>
    </nav>
</div>

    <table class="table datatable">
        <thead>
            <tr>
                <th>No</th>
                <th>NIS</th>
                <th>Nama</th>
                <th>Kelas</th>
                <th>Jurusan</th>
                <th>RFID</th>
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