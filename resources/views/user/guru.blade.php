@extends('layout.layout')
@section('content')
    <div class="pagetitle">
        <h1>User Guru</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/dashboard">Beranda</a></li>
                <li class="breadcrumb-item">User Manajemen</li>
                <li class="breadcrumb-item active">User Guru</li>
            </ol>
        </nav>
    </div>

    @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

    <button type="button" class="btn btn-primary my-3" data-bs-toggle="modal" data-bs-target="#modalcreate">+ TAMBAH DATA</button>

    <table class="table datatable table-success table-striped-columns border-success">
        <thead>
            <tr>
                <th class="text-center">No</th>
                <th class="text-center">Nama Guru</th>
                <th class="text-center">Username</th>
                <th class="text-center">Password</th>
                <th class="text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $key => $row)
                <tr>
                    <td class="text-center">{{ $key + 1 }}</td>
                    <td class="text-center">{{ $row->nama }}</td>
                    <td class="text-center">{{ $row->username }}</td>
                    <td class="text-center">{{ $row->password }}</td>
                    <td class="text-center">
                        <!-- Tombol Edit -->
                        <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#modaledit{{ $row->id }}">
                            <i class="bi bi-pencil"></i> Edit
                        </button>
                        <!-- Tombol Hapus -->
                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modaldelete{{ $row->id }}">
                            <i class="bi bi-trash"></i> Hapus
                        </button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Modal Tambah -->
    <div class="modal fade" id="modalcreate" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5">Tambah {{ $title }}</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('user.store') }}">
                        @csrf
                        <div class="form-group">
                            <label>Nama Guru</label>
                            <input type="text" class="form-control" name="nama" required>
                        </div>
                        <div class="form-group">
                            <label>Username</label>
                            <input type="text" class="form-control" name="username" required>
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" class="form-control" name="password" required>
                        </div>
                        <input type="hidden" name="role" value="guru">
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
                    </form>
            </div>
        </div>
    </div>

    <!-- Modal Edit -->
    @foreach ($users as $d)
    <div class="modal fade" id="modaledit{{ $d->id }}" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5">Edit {{ $title }}</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST" action="{{ route('user.update', $d->id) }}">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Nama Guru</label>
                            <input type="text" value="{{ $d->nama }}" class="form-control" name="nama" required>
                        </div>
                        <div class="form-group">
                            <label>Username</label>
                            <input type="text" value="{{ $d->username }}" class="form-control" name="username" required>
                        </div>
                        <div class="form-group">
                            <label>Password (Isi jika ingin mengubah)</label>
                            <input type="password" class="form-control" name="password">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endforeach

    <!-- Modal Delete -->
    @foreach ($users as $c)
    <div class="modal fade" id="modaldelete{{ $c->id }}" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5">Hapus {{ $title }}</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST" action="{{ route('user.destroy', $c->id) }}">
                    @csrf
                    @method('DELETE')
                    <div class="modal-body">
                        <p>Apakah anda yakin ingin menghapus <strong>{{ $c->nama }}</strong>?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-danger">Hapus</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endforeach
@endsection
