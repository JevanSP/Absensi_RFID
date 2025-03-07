@extends('layout.layout')
@section('content')
    <div class="pagetitle">
        <h1>Data Prestasi</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/dashboard">Beranda</a></li>
                <li class="breadcrumb-item">Data Master</li>
                <li class="breadcrumb-item active">Data Prestasi</li>
            </ol>
        </nav>
    </div>

    <button type="button" class="btn btn-primary my-3" data-bs-toggle="modal" data-bs-target="#modalcreate">+ TAMBAH DATA</button>

    <table class="table datatable table-success table-striped-columns border-success">
        <thead>
            <tr class="text-center">
                <th>No</th>
                <th>NIS</th>
                <th>Nama Siswa</th>
                <th>Kelas</th>
                <th>Nama Prestasi</th>
                <th>Poin</th>
                <th>Tanggal</th>
                <th>Keterangan</th>
                <th>Guru</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @php $no = 1; @endphp
            @foreach ($poinSiswa as $p)
                <tr class="text-center text-capitalize">
                    <td>{{ $no++ }}</td>
                    <td>{{ $p->nis }}</td>
                    <td>{{ $p->siswa->nama_siswa }}</td>
                    <td>{{ $p->kelas }} {{ $p->jurusan->singkatan }}</td>
                    <td>{{ $p->nama }}</td>
                    <td>{{ $p->poin }}</td>
                    <td>{{ $p->tanggal }}</td>
                    <td>{{ $p->keterangan }}</td>
                    <td>{{ $p->user->name }}</td>
                    <td>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modaledit{{ $p->id }}"><i class="bi bi-pencil"></i> Edit</button>
                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modaldelete{{ $p->id }}"><i class="bi bi-trash"></i> Hapus</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="modal fade" id="modalcreate" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5">Tambah Data Poin Kategori</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('poin_siswa.store') }}">
                        @csrf
                        <input type="hidden" name="kategori" value="prestasi">
                        <div class="form-group">
                            <label>Nama Siswa</label>
                            <select name="siswa_id" class="form-select" required>
                                <option value="">Pilih Nama Siswa</option>
                                @foreach ($siswa as $s)
                                    <option value="{{ $s->id }}">{{ $s->nama_siswa }}</option>
                                @endforeach
                            </select>
                        </div>
                        <br>
                        <div class="form-group">
                            <label>Nama Prestasi</label>
                            <select name="poin_kategori_id" class="form-select" id="poinKategoriSelect" required>
                                <option value="">Pilih Nama Prestasi</option>
                                @foreach ($poinKategori as $pk)
                                    <option value="{{ $pk->id }}" data-poin="{{ $pk->poin }}">{{ $pk->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <br>
                        <div class="form-group">
                            <label>Poin</label>
                            <input type="number" class="form-control" id="poinInput" name="poin" readonly required>
                        </div>
                        <br>
                        <div class="form-group">
                            <label>Keterangan</label>
                            <input type="text" class="form-control" name="keterangan" required>
                        </div>
                        <br>
                        <div class="form-group">
                            <label>Tanggal</label>
                            <input type="date" class="form-control" name="tanggal" required>
                        </div>
                        <br>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @foreach ($poinSiswa as $p)
        <div class="modal fade" id="modaledit{{ $p->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5">Edit Poin Kategori</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <form method="POST" action="{{ route('poin_siswa.update', $p->id) }}">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="kategori" value="prestasi">
                        <div class="modal-body">
                            <div class="form-group">
                                <label>Nama Siswa</label>
                                <select name="siswa_id" class="form-select" required>
                                    <option value="{{ $p->siswa_id }}">{{ $p->siswa->nama_siswa }}</option>
                                    @foreach ($siswa as $s)
                                        <option value="{{ $s->id }}">{{ $s->nama_siswa }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <br>
                            <div class="form-group">
                                <label>Nama Prestasi</label>
                                <select name="poin_kategori_id" class="form-select" id="poinKategoriSelect" required>
                                    <option value="{{ $p->poin_kategori_id }}">{{ $p->poinKategori->nama }}</option>
                                    @foreach ($poinKategori as $pk)
                                        <option value="{{ $pk->id }}" data-poin="{{ $pk->poin }}">{{ $pk->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <br>
                            <div class="form-group">
                                <label>Poin</label>
                                <input type="number" value="{{ $p->poin }}" class="form-control" id="poinInput" name="poin" readonly required>
                            </div>
                            <br>
                            <div class="form-group">
                                <label>Keterangan</label>
                                <input type="date" class="form-control" name="keterangan" required>
                            </div>
                            <br>
                            <div class="form-group">
                                <label>Tanggal</label>
                                <input type="date" value="{{ $p->tanggal }}" class="form-control" name="tanggal" required>
                            </div>
                            <br>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach

    @foreach ($poinKategori as $p)
        <div class="modal fade" id="modaldelete{{ $p->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5">Hapus Poin Kategori</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <form method="POST" action="{{ route('poin_siswa.destroy', $p->id) }}">
                        @csrf
                        @method('DELETE')
                        <div class="modal-body">
                            <p>Apakah anda yakin ingin menghapus data ini?</p>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-outline-danger">Hapus</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach

    <script>
        document.getElementById('poinKategoriSelect').addEventListener('change', function() {
            var selectedOption = this.options[this.selectedIndex];
            var poin = selectedOption.getAttribute('data-poin');
            document.getElementById('poinInput').value = poin;
        });
    </script>
@endsection
