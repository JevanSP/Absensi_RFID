@extends('layout.layout')
@section('content')
    <div class="pagetitle">
        <h1>Pengaturan Berita</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
                <li class="breadcrumb-item active">Pengaturan Berita</li>
            </ol>
        </nav>
    </div>

    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Pengaturan Berita/Acara</h5>
            <form action="{{ 'berita.store' }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="acara" class="form-label">Acara</label>
                    <input type="text" class="form-control" id="acara" name="acara" value="{{ old('acara', $berita->acara ?? '') }}"
                        required>
                </div>
                <div class="mb-3">
                    <label for="pakaian" class="form-label">Pakaian</label>
                    <select class="form-control" id="pakaian" name="pakaian[]" multiple>
                        @foreach(['Baju Batik', 'Baju Bebas', 'Baju Muslim', 'Belum Ditentukan'] as $item)
                            <option value="{{ $item }}"
                                {{ (isset($berita->pakaian) && in_array($item, $berita->pakaian)) ? 'selected' : '' }}>
                                {{ $item }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
            <hr>
            <h6>Data Saat Ini:</h6>
            <p><strong>Acara:</strong></p>
            <p><strong>Pakaian:</strong></p>
        </div>
    </div>
@endsection
