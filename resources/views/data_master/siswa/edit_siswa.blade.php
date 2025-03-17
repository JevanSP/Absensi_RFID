@extends('layout.layout')

@section('content')
<div class="pagetitle">
    <h1>Edit Data Siswa</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/dashboard">Beranda</a></li>
            <li class="breadcrumb-item">Data Master</li>
            <li class="breadcrumb-item"><a href="/data_siswa">Data Siswa</a></li>
            <li class="breadcrumb-item active">Edit Data Siswa</li>
        </ol>
    </nav>
</div>

<div class="card">
    <div class="card-body">
        <h5 class="card-title">Form Edit Data Siswa</h5>

        <form method="POST" action="/data_siswa/{{ $data_siswa->id }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="nis" class="form-label">NIS</label>
                <input type="number" class="form-control @error('nis') is-invalid @enderror" id="nis" name="nis" value="{{ old('nis', $data_siswa->nis) }}" required>
                @error('nis')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="nama_siswa" class="form-label">Nama</label>
                <input type="text" class="form-control text-capitalize @error('nama_siswa') is-invalid @enderror" id="nama_siswa" name="nama_siswa" value="{{ old('nama_siswa', $data_siswa->nama_siswa) }}" required>
                @error('nama_siswa')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                <select class="form-control @error('jenis_kelamin') is-invalid @enderror" id="jenis_kelamin" name="jenis_kelamin" required>
                    <option value="L" {{ old('jenis_kelamin', $data_siswa->jenis_kelamin) == 'L' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="P" {{ old('jenis_kelamin', $data_siswa->jenis_kelamin) == 'P' ? 'selected' : '' }}>Perempuan</option>
                </select>
                @error('jenis_kelamin')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="kelas" class="form-label">Kelas</label>
                <select class="form-control @error('kelas') is-invalid @enderror" id="kelas" name="kelas" required>
                    <option value="X" {{ old('kelas', $data_siswa->kelas) == 'X' ? 'selected' : '' }}>X</option>
                    <option value="XI" {{ old('kelas', $data_siswa->kelas) == 'XI' ? 'selected' : '' }}>XI</option>
                    <option value="XII" {{ old('kelas', $data_siswa->kelas) == 'XII' ? 'selected' : '' }}>XII</option>
                </select>
                @error('kelas')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="kelas_id" class="form-label">Kelas</label>
                <select class="form-control @error('kelas_id') is-invalid @enderror" id="kelas_id" name="kelas_id" required>
                    @foreach ($data_kelas as $kelas)
                        <option value="{{ $kelas->id }}" {{ old('kelas_id', $data_siswa->kelas_id) == $kelas->id ? 'selected' : '' }}>   
                            {{ $kelas->singkatan }}
                        </option>
                    @endforeach
                </select>
                @error('kelas_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="rfid_tag" class="form-label">RFID</label>
                <input type="number" class="form-control @error('rfid_tag') is-invalid @enderror" id="rfid_tag" name="rfid_tag" value="{{ old('rfid_tag', $data_siswa->rfid_tag) }}" required readonly data-bs-toggle="modal" data-bs-target="#rfidModal">
                @error('rfid_tag')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- RFID Modal -->
            <div class="modal fade" id="rfidModal" tabindex="-1" aria-labelledby="rfidModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Scan RFID</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>  
                        <div class="modal-body">
                            <p>Tempelkan kartu RFID Anda pada pembaca.</p>
                            <input type="number" class="form-control" placeholder="Scanning...." >
                        </div>
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label for="foto" class="form-label">Foto</label>
                <input type="file" class="form-control @error('foto') is-invalid @enderror" id="foto" name="foto" onchange="previewImage(event)">
                <small class="text-muted">Kosongkan jika tidak ingin mengubah foto.</small>
                <br>
                @error('foto')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <br>
                @if ($data_siswa->foto)  
                    <img src="{{ asset('storage/siswa/' . $data_siswa->foto) }}" alt="Foto Siswa" width="100" class="mt-2" id="preview" style="border: 2px solid #ddd; padding: 5px; border-radius: 5px;">
                @endif
            </div>
            <br>

            <script>
                function previewImage(event) {
                    const reader = new FileReader();
                    reader.onload = function(){
                        const output = document.getElementById('preview');
                        output.src = reader.result;
                        output.style.border = '2px solid #ddd';
                        output.style.padding = '5px';
                        output.style.borderRadius = '5px';
                    };
                    reader.readAsDataURL(event.target.files[0]);
                }
            </script>

            <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Perbarui Data</button>
            <a href="/data_siswa" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Kembali</a>
        </form>
    </div>
</div>
@endsection
