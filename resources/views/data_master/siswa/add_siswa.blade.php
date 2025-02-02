@extends('layout.layout')

@section('content')
<div class="pagetitle">
    <h1>Tambah Data Siswa</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/dashboard">Beranda</a></li>
            <li class="breadcrumb-item">Data Master</li>
            <li class="breadcrumb-item"><a href="/data_siswa">Data Siswa</a></li>
            <li class="breadcrumb-item active">Tambah Data Siswa</li>
        </ol>
    </nav>
</div>

<div class="card">
    <div class="card-body">
        <h5 class="card-title">Form Tambah Data Siswa</h5>

        <form method="POST" action="/data_siswa/store" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label for="nis" class="form-label">NIS</label>
                <input type="number" class="form-control @error('nis') is-invalid @enderror" id="nis" name="nis" value="{{ old('nis') }}" required>
                @error('nis')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="nama_siswa" class="form-label">Nama</label>
                <input type="text" class="form-control text-capitalize @error('nama_siswa') is-invalid @enderror" id="nama_siswa" name="nama_siswa" value="{{ old('nama_siswa') }}" required>
                @error('nama_siswa')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                <select class="form-control @error('jenis_kelamin') is-invalid @enderror" id="jenis_kelamin" name="jenis_kelamin" required>
                    <option value="">-- Pilih Jenis Kelamin --</option>
                    <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                </select>
                @error('jenis_kelamin')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="kelas" class="form-label">Kelas</label>
                <select class="form-control @error('kelas') is-invalid @enderror" id="kelas" name="kelas" required>
                    <option value="">-- Pilih Kelas --</option>
                    <option value="X" {{ old('kelas') == 'X' ? 'selected' : '' }}>X</option>
                    <option value="XI" {{ old('kelas') == 'XI' ? 'selected' : '' }}>XI</option>
                    <option value="XII" {{ old('kelas') == 'XII' ? 'selected' : '' }}>XII</option>
                </select>
                @error('kelas')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="jurusan_id" class="form-label">Jurusan</label>
                <select class="form-control @error('jurusan_id') is-invalid @enderror" id="jurusan_id" name="jurusan_id" required>
                    <option value="">-- Pilih Jurusan --</option>
                    @foreach ($data_jurusan as $jurusan)
                        <option value="{{ $jurusan->id }}" {{ old('jurusan_id') == $jurusan->id ? 'selected' : '' }}>{{ $jurusan->singkatan }}</option>
                    @endforeach
                </select>
                @error('jurusan_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="rfid_tag" class="form-label">RFID</label>
                <input type="number" class="form-control @error('rfid_tag') is-invalid @enderror" id="rfid_tag" name="rfid_tag" value="{{ old('rfid_tag') }}" required>
                @error('rfid_tag')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="foto" class="form-label">Foto</label>
                <input type="file" class="form-control @error('foto') is-invalid @enderror" id="foto" name="foto">
                @error('foto')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <br>
            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan Data</button>
            <a href="/data_siswa" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Kembali</a>
        </form>
    </div>
</div>
@endsection
