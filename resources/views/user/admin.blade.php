@extends('layout.layout')
@section('content')
    <div class="pagetitle">
        <h1>User Admin</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/dashboard">Beranda</a></li>
                <li class="breadcrumb-item">User Manajemen</li>
                <li class="breadcrumb-item active">User Admin</li>
            </ol>
        </nav>
    </div>
    <button type="button" class="btn btn-primary my-3" data-bs-toggle="modal" data-bs-target="#modalcreate">+ TAMBAH DATA</button>
    <table class="table datatable table-success table-striped-columns border-success">
        <thead>
            <tr>
                <th class="text-center">No</th>
                <th class="text-center">NIK</th>
                <th class="text-center">Nama Admin</th>
                <th class="text-center">Username</th>
                <th class="text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @php
                $no = 1;
            @endphp
            @foreach ($data_admin as $row)
                <tr>
                    <td class="text-center">{{ $no++ }}</td>
                    <td class="text-capitalize">{{ $row->ni }}</td>
                    <td class="text-center">{{ $row->nama }}</td>
                    <td class="text-center">{{ $row->username }}</td>
                    <td class="text-center">
                        <button type="button" data-bs-target="#modaledit" data-bs-toggle="modal"
                            class="btn btn-primary"><i class="bi bi-pencil"></i> Edit</button>
                        <button type="button" data-bs-target="#modaldelete" data-bs-toggle="modal"
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
                    <form method="POST" action="{{ route('addadmin') }}">
                        @csrf
                        <div class="form-group">
                            <label>NIK</label>
                            <input type="text" class="form-control text-capitalize" name="ni" required>
                        </div>
                        <br>
                        <div class="form-group">
                            <label>Nama {{ $title }}</label>
                            <input type="text" class="form-control text-capitalize" name="nama"required>
                        </div>
                        <br>
                        <div class="form-group">
                            <label>Username</label>
                            <input type="text" class="form-control" name="username"required>
                        </div>
                        <br>
                        <div class="form-group">
                            <label>Password</label>
                            <input type="text" class="form-control text-capitalize" name="password"required>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" class="fas fa-save">Save Changes</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    {{-- @foreach ($data_budaya_positif as $d)
        <div class="modal fade" id="modaledit{{ $d->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5">Edit {{ $title }}</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form method="POST" action="/data_budaya_positif/update/{{ $d->id }}">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group">
                                <label>Nama {{ $title }}</label>
                                <input type="text" value="{{ $d->budaya_positif }}" class="form-control"
                                    name="budaya_positif"required>
                            </div>
                            <br>
                            <div class="form-group">
                                <label>Poin</label>
                                <input type="number" value="{{ $d->poin }}" class="form-control"
                                    name="poin"required>
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
        
        @foreach ($data_budaya_positif as $c)
        <div class="modal fade" id="modaldelete{{ $c->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5">Hapus {{ $title }}</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form method="GET" action="/data_budaya_positif/destroy/{{ $c->id }}">
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
@endforeach --}}
@endsection
