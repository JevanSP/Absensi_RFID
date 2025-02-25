@extends('layout.layout')
@section('content')
    <div class="pagetitle">
        <h1>Pengaturan Jam</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
                <li class="breadcrumb-item active">Pengaturan</li>
            </ol>
        </nav>
    </div>

    <div class="card">
      <div class="card-body">
          <h5 class="card-title">Pengaturan Jam Masuk dan Jam Pulang</h5>
          <form action="{{ route('pengaturan.store') }}" method="POST">
              @csrf
              <div class="mb-3">
                  <label for="jam_masuk" class="form-label">Jam Masuk</label>
                  <input type="time" class="form-control" id="jam_masuk" name="jam_masuk"
                      value="{{ old('jam_masuk', $pengaturanAbsensi->jam_masuk ?? '07:00') }}" required>
              </div>
              <div class="mb-3">
                  <label for="jam_pulang" class="form-label">Jam Pulang</label>
                  <input type="time" class="form-control" id="jam_pulang" name="jam_pulang"
                      value="{{ old('jam_pulang', $pengaturanAbsensi->jam_pulang ?? '15:00') }}" required>
              </div>
              <button type="submit" class="btn btn-primary">Simpan</button>
          </form>
      </div>
  </div>
@endsection
