@extends('layout.layout')
@section('content')

<div class="pagetitle">
    <h1>Data Prestasi</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
            <li class="breadcrumb-item">Data Master</li>
            <li class="breadcrumb-item active">Data Prestasi</li>
        </ol>
    </nav>
</div>

    <table class="table datatable">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Prestasi</th>
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
                <td>Otto</td>
                <td>@mdo</td>
                <td>
                    <button type="button" class="btn btn-primary bi bi-pencil"></button>
                    <button type="button" class="btn btn-danger bi bi-trash"></button>
                </td>
            </tr>
        </tbody>
    </table>

@endsection