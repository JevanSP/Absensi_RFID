@extends('layout.layout')

@section('content')
    <div class="pagetitle">
        <h1>Import Data Siswa</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/dashboard/admin_guru">Dashboard</a></li>
                <li class="breadcrumb-item">Data Master</li>
                <li class="breadcrumb-item"><a href="/data_siswa">Data Siswa</a></li>
                <li class="breadcrumb-item active">Import Excel</li>
            </ol>
        </nav>
    </div>

    <div class="card">
        <div class="card-body">
            <h5 class="card-title">{{ $title }}</h5>
            
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <div class="alert alert-info" role="alert">
                <strong>Perhatian:</strong> Pastikan file Excel Anda menggunakan format header yang benar: 
                <br><code>nis, nama_siswa, jenis_kelamin (L/P), nama_kelas (harus ada di database), rfid_tag (opsional)</code>.
                <br>
                <a href="{{ asset('assets/template_siswa.xlsx') }}" download class="alert-link">
                    <i class="bi bi-download"></i> Unduh Template Excel
                </a>
            </div>

            <form action="{{ route('siswa.import_excel_store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="file_excel" class="form-label">Pilih File Excel (.xlsx/.xls)</label>
                    <input type="file" class="form-control @error('file_excel') is-invalid @enderror" id="file_excel"
                        name="file_excel" required>
                    @error('file_excel')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <br>
                <button type="submit" class="btn btn-success"><i class="bi bi-file-earmark-spreadsheet"></i> Import Data</button>
                <a href="{{ route('siswa.data_siswa') }}" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Kembali</a>
            </form>
        </div>
    </div>
@endsection