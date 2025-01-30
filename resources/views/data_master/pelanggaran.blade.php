@extends('layout.layout')
@section('content')
    <div class="pagetitle">
        <h1>Data Pelanggaran</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
                <li class="breadcrumb-item">Data Master</li>
                <li class="breadcrumb-item active">Data Pelanggaran</li>
            </ol>
        </nav>
    </div>
    <button type="button" class="btn btn-primary my-3" data-bs-toggle="modal" data-bs-target="#modalcreate">+ TAMBAH DATA</button>
    <table class="table datatable table-danger table-striped-columns border-danger">
        <thead>
            <tr>
                <th class="text-center">No</th>
                <th class="text-center">Nama Pelanggaran</th>
                <th class="text-center">Poin</th>
                <th class="text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @php
                $no = 1;
            @endphp
            @foreach ($data_pelanggaran as $row)
                <tr>
                    <td class="text-center">{{ $no++ }}</td>
                    <td class="text-capitalize">{{ $row->pelanggaran }}</td>
                    <td class="text-center">{{ $row->poin }}</td>
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
                    <form method="POST" action="/data_pelanggaran/store/">
                        @csrf
                        <div class="form-group">
                            <label>Nama Pelanggaran</label>
                            <input type="text" class="form-control" name="pelanggaran"required>
                        </div>
                        <br>
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

    @foreach ($data_pelanggaran as $d)
        <div class="modal fade" id="modaledit{{ $d->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5">Edit {{ $title }}</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form method="POST" action="/data_pelanggaran/update/{{ $d->id }}">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group">
                                <label>Nama Pelanggaran</label>
                                <input type="text" value="{{ $d->pelanggaran }}" class="form-control"
                                    name="pelanggaran"required>
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
        
        @foreach ($data_pelanggaran as $c)
        <div class="modal fade" id="modaldelete{{ $c->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Delete {{ $title }}</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form method="GET" action="/data_pelanggaran/destroy/{{ $c->id }}">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group">
                                <h7>Apakah anda yakin ingin menghapus data ini?</h7>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-outline-danger">Buak</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
@endforeach
@endsection
