@extends('layout.layout')
@section('content')

    <div class="pagetitle">
        <h1>Kelas Dan Jurusan</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="home">Beranda</a></li>
                <li class="breadcrumb-item">Data Master</li>
                <li class="breadcrumb-item active">Data Kelas dan Jurusan</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-6">
            <table class="table datatable">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kelas</th>
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
                        <td>
                            <button type="button" class="btn btn-primary bi bi-pencil"></button>
                            <button type="button" class="btn btn-danger bi bi-trash"></button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="col-lg-6 col-md-6">
            <table class="table datatable">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Jurusan</th>
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
                        <td>
                            <button type="button" class="btn btn-primary bi bi-pencil"></button>
                            <button type="button" class="btn btn-danger bi bi-trash"></button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
