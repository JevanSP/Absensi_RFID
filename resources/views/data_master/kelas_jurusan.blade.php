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
                        <th>Jurusan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Mark</td>
                        <td>Otto</td>
                        <td>Mark</td>
                        <td>Otto</td>
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
                    <tr>
                        <td>Mark</td>
                        <td>Otto</td>
                        <td>@mdo</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
