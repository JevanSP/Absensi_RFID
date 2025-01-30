@extends('layout.layout')
@section('content')
    <div class="pagetitle">
        <h1>Data {{ $title }}</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
                <li class="breadcrumb-item">User Manajemen</li>
                <li class="breadcrumb-item active">User {{ $title }}</li>
            </ol>
        </nav>
    </div>
    <button type="button" class="btn btn-primary my-3" data-bs-toggle="modal" data-bs-target="#modalcreate">+ TAMBAH
        DATA</button>
    <table class="table datatable table-striped table-bordered border-success">
        <thead>
            <tr>
                <th class="text-center">No</th>
                <th class="text-center">Nama {{ $title }}</th>
                <th class="text-center">Jenis Kelamin</th>
                <th class="text-center">Username</th>
                <th class="text-center">Password</th>
                <th class="text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @php
                $no = 1;
            @endphp
            @foreach ($user_admin as $row)
                <tr>
                    <td class="text-center">{{ $no++ }}</td>
                    <td class="text-capitalize">{{ $row->nama }}</td>
                    <td class="text-center">{{ $row->jenis_kelamin }}</td>
                    <td class="text-center">{{ $row->username }}</td>
                    <td class="text-center">{{ $row->password }}</td>
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
                    <h1 class="modal-title fs-5">Tambah User {{ $title }}</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="/user_admin/store/">
                        @csrf
                        <div class="form-group">
                            <label>Nama {{ $title }}</label>
                            <input type="text" class="form-control" name="admin"required>
                        </div>
                        <br>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1">
                            <label class="form-check-label" for="flexRadioDefault1">
                                Default radio
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2"
                                checked>
                            <label class="form-check-label" for="flexRadioDefault2">
                                Default checked radio
                            </label>
                        </div>
                        </br>
                        <div class="form-group">
                            <label>Poin</label>
                            <input type="number" class="form-control" name="poin"required>
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

    @foreach ($user_admin as $d)
        <div class="modal fade" id="modaledit{{ $d->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5">Edit {{ $title }}</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form method="POST" action="/user_admin/update/{{ $d->id }}">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group">
                                <label>Nama {{ $title }}</label>
                                <input type="text" value="{{ $d->nama }}" class="form-control"
                                    name="nama_admin"required>
                            </div>
                            <br>
                            <div class="form-group">
                                <label>Jenis Kelamin</label>
                                <input type="radio" value="{{ $d->jenis_kelamin }}" class="form-control"
                                    name="jenis_kelamin"required>
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

    @foreach ($user_admin as $c)
        <div class="modal fade" id="modaldelete{{ $c->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5">Hapus {{ $title }}</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form method="GET" action="/user_admin/destroy/{{ $c->id }}">
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
