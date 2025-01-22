@extends('layout.layout')
@section('content')
    <div class="pagetitle">
        <h1>Data Budaya Positif</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
                <li class="breadcrumb-item">Data Master</li>
                <li class="breadcrumb-item active">Data Budaya Positif</li>
            </ol>
        </nav>
    </div>
    {{-- <button type="button" class="btn btn-primary bi bi-plus float-end" data-bs-toggle="modal" data-bs-target="#modalcreate">TAMBAH DATA</button> --}}
    <div class="table-responsive"> <!-- Tambahkan elemen ini -->
        <table class="table datatable responsive">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Budaya Positif</th>
                    <th>Poin</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $no = 1;
                @endphp
                <tr>
                    <td>{{ $no++ }}</td>
                    <td>bfjbfkjsgfbdkjfgbdkjfbk</td>
                    <td>@mdo</td>
                    <td class="d-flex">
                        <button type="button" class="btn btn-primary bi bi-pencil"></button>
                        <button type="button" class="btn btn-danger bi bi-trash"></button>
                    </td>
                </tr> 
            </tbody>
        </table>
    </div>
@endsection
