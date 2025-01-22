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
            <tr>
                <td>Mark</td>
                <td>Otto</td>
                <td>@mdo</td>
                <td>Mark</td>
            </tr>
        </tbody>
    </table>

@endsection