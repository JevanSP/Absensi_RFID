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

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <button type="button" class="btn btn-primary my-3"><a href="/add_siswa" style="color: white">+ TAMBAH DATA</a></button>

    <table class="table datatable table-secondary table-striped-columns border-secondary">
        <thead>
            <tr>
                <th class="text-center">No</th>
                <th class="text-center">NIS</th>
                <th class="text-center">Nama</th>
                <th class="text-center">Jenis Kelamin</th>
                <th class="text-center">Kelas</th>
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
                    <td data-label="No" class="text-center">{{ $no++ }}</td>
                    <td data-label="NIS" class="text-center">{{ $row->nis }}</td>
                    <td data-label="Nama" class="text-capitalize">{{ $row->nama_siswa }}</td>
                    <td data-label="Jenis Kelamin" class="text-center text-capitalize">{{ $row->jenis_kelamin }}</td>
                    <td data-label="Kelas" class="text-center">{{ $row->kelas->nama }}</td>
                    <td data-label="RFID" class="text-center">{{ $row->rfid_tag }}</td>
                    <td data-label="Aksi" class="text-center">
                        @if ($row->foto)
                            <img src="{{ asset('storage/' . $row->foto) }}" alt="Foto Siswa" width="50"
                                style="border: 2px solid #ddd; padding: 5px; border-radius: 5px;">
                        @else
                            Tidak ada foto
                        @endif
                    </td>
                    <td class="text-center">
                        <a href="{{ route('siswa.edit_siswa', $row->id) }}" class="btn btn-primary">
                            <i class="bi bi-pencil"></i> Edit
                        </a>
                        <button type="button" class="btn btn-success" data-bs-toggle="modal"
                            data-bs-target="#modalEditRFID{{ $row->id }}">
                            <i class="bi bi-card-heading"></i> Edit RFID
                        </button>
                        <button type="button" data-bs-target="#modaldelete{{ $row->id }}" data-bs-toggle="modal"
                            class="btn btn-danger"><i class="bi bi-trash"></i> Hapus</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    @foreach ($data_siswa as $c)
        <!-- Modal Edit RFID -->
        <div class="modal fade" id="modalEditRFID{{ $c->id }}" tabindex="-1"
            aria-labelledby="editRFIDLabel{{ $c->id }}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content border border-primary">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="editRFIDLabel{{ $c->id }}">Edit RFID - {{ $c->nama_siswa }}
                        </h5>
                        <button type="button" class="btn-close text-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <form action="{{ route('siswa.update_rfid', $c->id) }}" method="POST"
                        id="formRFID{{ $c->id }}">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="rfidInput{{ $c->id }}" class="form-label">Scan Kartu RFID</label>
                                <input type="text" name="rfid_tag" id="rfidInput{{ $c->id }}"
                                    class="form-control" placeholder="Tempelkan kartu ke reader..." style="autocomplete: off; position: absolute; left: -9999999px;" autofocus>
                                <img src="{{ asset('assets/img/scan.png') }}" alt="" width="120" class="mx-auto d-block">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success"><i class="bi bi-save"></i> Simpan</button>
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
                    <form method="POST" action="/data_siswa/destroy/{{ $c->id }}">
                        @csrf
                        @method('DELETE')
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
<script>
    document.addEventListener('DOMContentLoaded', function () {
        @foreach ($data_siswa as $c)
            const input{{ $c->id }} = document.getElementById("rfidInput{{ $c->id }}");
            const form{{ $c->id }} = document.getElementById("formRFID{{ $c->id }}");

            if (input{{ $c->id }} && form{{ $c->id }}) {
                input{{ $c->id }}.addEventListener("keypress", function (e) {
                    if (e.key === "Enter") {
                        e.preventDefault();
                        form{{ $c->id }}.submit();
                    }
                });
            }
        @endforeach
    });
</script>
<script>
    @foreach ($data_siswa as $c)
    document.addEventListener('shown.bs.modal', function (event) {
        const modal = document.getElementById('modalEditRFID{{ $c->id }}');
        if (event.target === modal) {
            const input = document.getElementById("rfidInput{{ $c->id }}");
            if (input) input.focus();
        }
    });
    @endforeach
</script>