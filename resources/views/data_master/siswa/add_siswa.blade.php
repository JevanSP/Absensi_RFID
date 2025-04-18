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
                    <label for="foto" class="form-label">Foto</label>
                    <input type="file" class="form-control @error('foto') is-invalid @enderror" id="foto"
                        name="foto" onchange="previewImage(event)">
                    @error('foto')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <br>
                    <img id="preview" alt="Preview Foto" width="100" class="mt-2"
                        style="display: none; border: 2px solid #ddd; padding: 5px; border-radius: 5px;">
                </div>

                <div class="mb-3">
                    <label for="nis" class="form-label">NIS</label>
                    <input type="number" class="form-control @error('nis') is-invalid @enderror" id="nis"
                        name="nis" value="{{ old('nis') }}" required>
                    @error('nis')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="nama_siswa" class="form-label">Nama</label>
                    <input type="text" class="form-control text-capitalize @error('nama_siswa') is-invalid @enderror"
                        id="nama_siswa" name="nama_siswa" value="{{ old('nama_siswa') }}" required>
                    @error('nama_siswa')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                    <select class="form-control @error('jenis_kelamin') is-invalid @enderror" id="jenis_kelamin"
                        name="jenis_kelamin" required>
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
                    <select class="form-control @error('kelas_id') is-invalid @enderror" id="kelas_id" name="kelas_id"
                        required>
                        <option value="">-- Pilih kelas --</option>
                        @foreach ($data_kelas as $kelas)
                            <option value="{{ $kelas->id }}" {{ old('kelas_id') == $kelas->id ? 'selected' : '' }}>
                                {{ $kelas->nama }}</option>
                        @endforeach
                    </select>
                    @error('kelas_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Input RFID -->
                <div class="mb-3">
                    <label for="rfid_tag" class="form-label">RFID</label>
                    <input type="text" class="form-control @error('rfid_tag') is-invalid @enderror" id="rfid_tag"
                    name="rfid_tag" value="{{ old('rfid_tag') }}" required disabled style="opacity: 0.5;">
                    @error('rfid_tag')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <br>

                <!-- Script -->
                <script>
                    let timer = null;

                    document.getElementById('rfid_tag').addEventListener('input', function() {
                        const rfidValue = this.value.trim();

                        // Reset timer jika masih mengetik
                        clearTimeout(timer);

                        // Tunggu 500ms setelah input terakhir
                        timer = setTimeout(() => {
                            if (rfidValue.length > 0) {
                                console.log("RFID terbaca: " + rfidValue);
                                document.querySelector('form').submit();
                            }
                        }, 500); // Waktu tunggu untuk memastikan input selesai
                    });

                    function previewImage(event) {
                        const reader = new FileReader();
                        reader.onload = function() {
                            const output = document.getElementById('preview');
                            output.src = reader.result;
                            output.style.display = 'block';
                        };
                        reader.readAsDataURL(event.target.files[0]);
                    }

                    function checkFormFields() {
                        const nis = document.getElementById('nis').value.trim();
                        const nama = document.getElementById('nama_siswa').value.trim();
                        const jk = document.getElementById('jenis_kelamin').value;
                        const kelas = document.getElementById('kelas_id').value;

                        const rfidInput = document.getElementById('rfid_tag');

                        if (nis && nama && jk && kelas) {
                            rfidInput.disabled = false;
                            rfidInput.style.opacity = '1';
                        } else {
                            rfidInput.disabled = true;
                            rfidInput.style.opacity = '0.5';
                        }
                    }

                    // Jalankan saat halaman dimuat
                    document.addEventListener('DOMContentLoaded', function() {
                        checkFormFields();

                        document.getElementById('nis').addEventListener('input', checkFormFields);
                        document.getElementById('nama_siswa').addEventListener('input', checkFormFields);
                        document.getElementById('jenis_kelamin').addEventListener('change', checkFormFields);
                        document.getElementById('kelas_id').addEventListener('change', checkFormFields);
                    });
                </script>

                <br>
                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i>Simpan Data</button>
                <a href="/data_siswa" class="btn btn-secondary"><i class="fas fa-arrow-left"></i>Kembali</a>
            </form>
        </div>
    </div>
    <script>
        function previewImage(event) {
            const reader = new FileReader();
            reader.onload = function() {
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
