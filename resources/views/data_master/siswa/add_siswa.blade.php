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
                <label for="kelas_id" class="form-label">Kelas</label>
                <select class="form-control @error('kelas_id') is-invalid @enderror" id="kelas_id" name="kelas_id" required>
                    <option value="">-- Pilih kelas --</option>
                    @foreach ($data_kelas as $kelas)
                        <option value="{{ $kelas->id }}" {{ old('kelas_id') == $kelas->id ? 'selected' : '' }}>{{ $kelas->nama }}</option>
                    @endforeach
                </select>
                @error('kelas_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Modal for RFID Input -->
            <div class="mb-3">
                <label for="rfid_tag" class="form-label">RFID</label>
                <input type="text" class="form-control @error('rfid_tag') is-invalid @enderror" id="rfid_tag" name="rfid_tag" value="{{ old('rfid_tag') }}" required readonly data-bs-toggle="modal" data-bs-target="#rfidModal">
                @error('rfid_tag')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- RFID Modal -->
            <div class="modal fade" id="rfidModal" tabindex="-1" aria-labelledby="rfidModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="rfidModalLabel">Scan RFID</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p>Tempelkan kartu RFID Anda pada pembaca.</p>
                            <input type="text" class="form-control" id="rfid_input" placeholder="Scanning..." readonly>
                        </div>
                    </div>
                </div>
            </div>

            {{-- <script>
                document.addEventListener('DOMContentLoaded', function () {
                    const rfidInput = document.getElementById('rfid_input');
                    const rfidTag = document.getElementById('rfid_tag');
                    
                    // Simulate RFID scanning
                    document.addEventListener('rfidScan', function (event) {
                        const rfidValue = event.detail.rfid;
                        rfidInput.value = rfidValue;
                        rfidTag.value = rfidValue;
                        const rfidModal = new bootstrap.Modal(document.getElementById('rfidModal'));
                        rfidModal.hide();
                    });

                    // Example of triggering the RFID scan event
                    setTimeout(() => {
                        const event = new CustomEvent('rfidScan', { detail: { rfid: '1234567890' } });
                        document.dispatchEvent(event);
                    }, 3000); // Simulate a scan after 3 seconds
                });
            </script> --}}
            
            <div class="mb-3">
                <label for="foto" class="form-label">Foto</label>
                <input type="file" class="form-control @error('foto') is-invalid @enderror" id="foto" name="foto" onchange="previewImage(event)">
                @error('foto')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <br>
                <img id="preview" alt="Preview Foto" width="100" class="mt-2" style="display: none; border: 2px solid #ddd; padding: 5px; border-radius: 5px;">
            </div>
            <br>
            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i>Simpan Data</button>
            <a href="/data_siswa" class="btn btn-secondary"><i class="fas fa-arrow-left"></i>Kembali</a>
        </form>
    </div>
</div>
<script>
    function previewImage(event) {
        const reader = new FileReader();
        reader.onload = function(){
            const output = document.getElementById('preview');
            output.src = reader.result;
            output.style.display = 'block';
            output.style.border = '2px solid #ddd';
            output.style.padding = '5px';
            output.style.borderRadius = '5px';
        };
        reader.readAsDataURL(event.target.files[0]);
    }
</script>
@endsection
