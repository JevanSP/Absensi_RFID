@extends('layout.layout')
@section('content')
    <div class="pagetitle">
        <h1>Data Jurusan</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="home">Beranda</a></li>
                <li class="breadcrumb-item">Data Master</li>
                <li class="breadcrumb-item active">Data Kelas</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->
    <button type="button" class="btn btn-primary my-3" data-bs-toggle="modal" data-bs-target="#modalcreate">+ TAMBAH
        DATA</button>
    <table class="table datatable table-warning table-striped-columns border-warning">
        <thead>
            <tr>
                <th class="text-center">No</th>
                <th class="text-center">Tingkatan</th>
                <th class="text-center">Nama Kelas</th>
                <th class="text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @php
                $no = 1;
            @endphp
            @foreach ($data_kelas as $row)
                <tr>
                    <td class="text-center">{{ $no++ }}</td>
                    <td class="text-capitalize text-center">{{ $row->tingkatan }}</td>
                    <td class="text-center text-capitalize">{{ $row->nama }}</td>
                    <td class="text-center">
                        <button type="button" data-bs-target="#modaledit{{ $row->id }}" data-bs-toggle="modal"
                            class="btn btn-primary"><i class="bi bi-pencil"></i> Edit</button>
                        <button type="button" data-bs-target="#modaldelete{{ $row->id }}" data-bs-toggle="modal"
                            class="btn btn-danger"><i class="bi bi-trash"></i> Hapus</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="modal fade" id="modalcreate" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5">Tambah Data {{ $title }}</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="/data_kelas/store/">
                        @csrf
                        <div class="form-group">
                            <label>Tingkatan {{ $title }}</label>
                            <select class="form-control" name="tingkatan" required>
                                <option value="" disabled selected>Pilih Tingkatan</option>
                                @foreach (['X', 'XI', 'XII'] as $tingkatan)
                                    <option value="{{ $tingkatan }}">{{ $tingkatan }}</option>
                                @endforeach
                            </select>
                        </div>
                        <br>
                        <div class="form-group">
                            <label>Nama {{ $title }}</label>
                            <input type="text" class="form-control text-capitalize" name="nama"required>
                        </div>
                        <br>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" class="fas fa-save">Save Changes</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    @foreach ($data_kelas as $d)
        <div class="modal fade" id="modaledit{{ $d->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5">Edit {{ $title }}</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form method="POST" action="/data_kelas/update/{{ $d->id }}">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group">
                                <label>Tingkatan {{ $title }}</label>
                                <select class="form-control" name="tingkatan" required>
                                    <option value="{{ $d->tingkatan }}" selected>{{ $d->tingkatan }}</option>
                                    @foreach (['X', 'XI', 'XII'] as $tingkatan)
                                        <option value="{{ $tingkatan }}">{{ $tingkatan }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <br>
                            <div class="form-group">
                                <label>Nama {{ $title }}</label>
                                <input type="text" value="{{ $d->nama }}" class="form-control"
                                    name="nama"required>
                            </div>
                            <br>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary" class="fas fa-save">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach

    @foreach ($data_kelas as $c)
        <div class="modal fade" id="modaldelete{{ $c->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5">Hapus {{ $title }}</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form method="GET" action="/data_kelas/destroy/{{ $c->id }}">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group">
                                <h7>Apakah anda yakin ingin menghapus data ini?</h7>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-outline-danger bi bi-trash"> Hapus</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
@endsection
