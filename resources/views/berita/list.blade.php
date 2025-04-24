@extends('layout.layout')
@section('content')
    <div class="pagetitle">
        <h1>Pengaturan Berita</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/dashboard/admin_guru">Dashboard</a></li>
                <li class="breadcrumb-item active">Pengaturan Berita</li>
            </ol>
        </nav>
    </div>

    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Pengaturan Berita/Acara</h5>
            <form action="{{ route('berita.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="acara" class="form-label">Acara</label>
                    <textarea class="form-control" id="acara" name="acara">{{ old('acara', $berita->acara ?? '') }}</textarea>
                </div>
                <div class="mb-3">
                    <label for="pakaian" class="form-label">Pakaian</label>
                    <select class="form-control" id="pakaian" name="pakaian" required>
                        @foreach (['batik', 'bebas', 'muslim', 'seragam', 'tidak ada'] as $item)
                            <option value="{{ $item }}"
                                {{ old('pakaian', $berita->pakaian ?? 'tidak ada') == $item ? 'selected' : '' }}>
                                {{ ucfirst(str_replace('_', ' ', $item)) }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
            <hr>
        </div>
    </div>
@endsection
