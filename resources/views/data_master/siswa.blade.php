@extends('layout.layout')
@section('content')

    <div class="pagetitle">
        <h1>Data Siswa</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="home">Beranda</a></li>
                <li class="breadcrumb-item">Data Master</li>
                <li class="breadcrumb-item active">Data Siswa</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->
    <button type="button" class="btn btn-primary my-3" data-bs-toggle="modal" data-bs-target="#modalcreate">+ TAMBAH DATA</button>
    <table class="table datatable table-secondary table-striped-columns border-secondary">
        <thead>
            <tr>
                <th class="text-center">No</th>
                <th class="text-center">NIS</th>
                <th class="text-center">Nama</th>
                <th class="text-center">Jenis Kelamin</th>
                <th class="text-center">Kelas</th>
                <th class="text-center">Jurusan</th>
                <th class="text-center">RFID</th>
                <th class="text-center">Foto</th>
                <th class="text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @php
                $no = 1;
            @endphp
            @foreach ($data_siswa as $row)
                <tr>
                    <td class="text-center">{{ $no++ }}</td>
                    <td class="text-center">{{ $row->nis }}</td>
                    <td class="text-capitalize">{{ $row->nama_siswa }}</td>
                    <td class="text-center text-capitalize">{{ $row->jenis_kelamin }}</td>
                    <td class="text-center">{{ $row->kelas }}</td>
                    <td class="text-center">{{ $row->singkatan }}</td>
                    <td class="text-center">{{ $row->rfid_tag }}</td>
                    <td class="text-center">{{ $row->foto }}
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
                    <form method="POST" action="/data_siswa/store/">
                        @csrf
                        <div class="form-group">
                            <label>NIS</label>
                            <input type="number" class="form-control" name="nis"required>
                        </div>
                        <br>
                        <div class="form-group">
                            <label>Nama</label>
                            <input type="text" class="form-control text-capitalize" name="nama_siswa"required>
                        </div>
                        <br>
                        <div class="form-group">
                            <label>Jenis Kelamin</label>
                            <div>
                                <select class="form-control" name="jenis_kelamin" required>
                                    <option value="" >-- Pilih Jenis Kelamin --</option>
                                    <option value="L">Laki-laki</option>
                                    <option value="P">Perempuan</option>
                                </select>
                            </div>
                        </div>
                        <br>
                        <div class="form-group">
                            <label>Kelas</label>
                            <div>
                                <select class="form-control" name="kelas" required>
                                    <option value="" >-- Pilih Kelas --</option>
                                    <option value="X">X</option>
                                    <option value="XI">XI</option>
                                    <option value="XII">XII</option>
                                </select>
                            </div>
                        </div>
                        <br>
                        <div class="form-group">
                            <label>Jurusan</label>
                            <select name="jurusan_id" class="form-control" required>
                                <option value="" >-- Nama Jurusan --</option>
                                @foreach ($data_jurusan as $b)
                                    <option value="{{ $b->id }}">{{ $b->singkatan }}</option>
                                @endforeach
                            </select>
                        </div>
                        <br>
                        <div class="form-group">
                            <label>RFID</label>
                            <input type="number" class="form-control" name="rfid_tag" required>
                        </div>
                        <br>
                        <div class="form-group">
                            <label>Foto</label>
                            <input type="file" class="form-control" name="foto">
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

    @foreach ($data_siswa as $d)
        <div class="modal fade" id="modaledit{{ $d->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5">Edit {{ $title }}</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form method="POST" action="/data_siswa/update/{{ $d->id }}">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group">
                                <label>NIS {{ $title }}</label>
                                <input type="number" value="{{ $d->nis }}" class="form-control"
                                    name="nis"required>
                            </div>
                            <br>
                            <div class="form-group">
                                <label>Nama</label>
                                <input type="text" value="{{ $d->nama_siswa }}" class="form-control text-capitalize"
                                    name="nama_siswa"required>
                            </div>
                            <br>
                            <div class="form-group">
                                <label>Jenis Kelamin</label>
                                <div>
                                    <select class="form-control" name="jenis_kelamin" required>
                                        <option value="L" {{ $d->jenis_kelamin == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                        <option value="P" {{ $d->jenis_kelamin == 'P' ? 'selected' : '' }}>Perempuan</option>
                                    </select>
                                </div>
                            </div>
                            <br>
                            <div class="form-group">
                                <label>Kelas</label>
                                <div>
                                    <select class="form-control" name="kelas" value="{{ $d->kelas }}" required>
                                        <option value="X">X</option>
                                        <option value="XI">XI</option>
                                        <option value="XII">XII</option>
                                    </select>
                                </div>
                            </div>
                            <br>
                            <div class="form-group">
                                <label>Jurusan</label>
                                <div>
                                    <select class="form-control" name="jurusan_id" required>
                                        <option value="{{ $d->jurusan_id }}" >{{ $d->singkatan }}</option>
                                        @foreach ($data_jurusan as $d)
                                            <option value="{{ $d->id }}">{{ $d->singkatan }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <br>
                            <div class="form-group">
                                <label>RFID</label>
                                <input type="number" value="{{ $d->rfid_tag }}" class="form-control" 
                                name="rfid_tag" required>
                            </div>
                            <br>
                            <div class="form-group">
                                <label>Foto</label>
                                <input type="file" value="{{ $d->foto }}" class="form-control" name="foto">
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
        
        @foreach ($data_siswa as $c)
        <div class="modal fade" id="modaldelete{{ $c->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5">Hapus {{ $title }}</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form method="GET" action="/data_siswa/destroy/{{ $c->id }}"> 
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
