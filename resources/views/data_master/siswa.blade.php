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
            @php
                $no = 1;
            @endphp
            <tr>
                <td>{{ $no++ }}</td>
                <td>Otto</td>
                <td>@mdo</td>
                <td>Mark</td>
                <td>Otto</td>
                <td>Mark</td>
                <td>
                    <button type="button" class="btn btn-primary bi bi-pencil"></button>
                    <button type="button" class="btn btn-danger bi bi-trash"></button>
                </td>
            </tr>
        </tbody>
    </table>
@endsection
