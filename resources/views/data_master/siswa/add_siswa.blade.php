@extends('layout.layout')

@section('content')
    <div class="pagetitle">
        <h1>Tambah Data Siswa</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/dashboard/admin_guru">Dashboard</a></li>
                <li class="breadcrumb-item">Data Master</li>
                <li class="breadcrumb-item"><a href="/data_siswa">Data Siswa</a></li>
                <li class="breadcrumb-item active">Tambah Data Siswa</li>
            </ol>
        </nav>
    </div>

    <div class="card">
        <div class="card-body">
            <ul class="nav nav-tabs nav-tabs-bordered" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="manual-tab" data-bs-toggle="tab" data-bs-target="#manual"
                        type="button" role="tab" aria-controls="manual" aria-selected="true">Input Manual</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="excel-tab" data-bs-toggle="tab" data-bs-target="#excel"
                        type="button" role="tab" aria-controls="excel" aria-selected="false">Import Excel</button>
                </li>
            </ul>

            <div class="tab-content pt-2" id="myTabContent">
                <div class="tab-pane fade show active" id="manual" role="tabpanel" aria-labelledby="manual-tab">
                    <h5 class="card-title">Form Tambah Data Siswa (Manual)</h5>
                    
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
                        
                        <br>
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i>Simpan Data</button>
                        <a href="/data_siswa" class="btn btn-secondary"><i class="fas fa-arrow-left"></i>Kembali</a>
                    </form>
                </div>

                <div class="tab-pane fade" id="excel" role="tabpanel" aria-labelledby="excel-tab">
                    <h5 class="card-title">Form Import Data Siswa (Excel)</h5>
                    <div class="alert alert-info" role="alert">
                        <strong>Perhatian:</strong> Pastikan kolom di file Excel Anda berurutan seperti ini: <code>NIS, Nama Siswa, Jenis Kelamin (L/P), Nama Kelas (Harus Sesuai Database), RFID Tag (Opsional)</code>.
                        <br>
                        <a href="{{ asset('assets/template_siswa.xlsx') }}" download>Unduh Template Excel</a>
                    </div>
                    
                    <form action="{{ route('siswa.import_excel_store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="file_excel" class="form-label">Pilih File Excel</label>
                            <input type="file" class="form-control @error('file_excel') is-invalid @enderror" id="file_excel"
                                name="file_excel" required>
                            @error('file_excel')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <br>
                        <button type="submit" class="btn btn-success"><i class="bi bi-file-earmark-spreadsheet"></i> Import Data</button>
                        <a href="/data_siswa" class="btn btn-secondary"><i class="fas fa-arrow-left"></i>Kembali</a>
                    </form>
                </div>
            </div>
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