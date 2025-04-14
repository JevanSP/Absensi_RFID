@extends('layout.layout')

@section('content')
    <div class="pagetitle">
        <h1>Absensi Siswa</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="home">Beranda</a></li>
                <li class="breadcrumb-item active">Absensi Siswa</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <!-- Filter Form -->
    <form method="POST" action="{{ route('absen.filter') }}">
        @csrf
        <div class="row mb-3">
            <div class="col-md-3">
                <label for="nis">NIS</label>
                <input type="text" name="nis" class="form-control" placeholder="NIS" value="{{ request('nis') }}">
            </div>
            <div class="col-md-3">
                <label for="kelas">Kelas</label>
                <select name="kelas" class="form-control">
                    <option value="">Pilih Kelas</option>
                    @foreach ($kelas as $j)
                        <option value="{{ $j->id }}" {{ request('kelas') == $j->id ? 'selected' : '' }}>
                            {{ $j->nama }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label for="tanggal">Tanggal</label>
                <input type="date" name="tanggal" class="form-control" value="{{ request('tanggal') }}">
            </div>
            <div class="col-md-3 d-flex align-items-end">
                <button type="submit" class="btn btn-primary w-100">Filter</button>
            </div>
        </div>
    </form>
    <!-- End Filter Form -->

    <!-- Absensi Table -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>NIS</th>
                <th>Nama Siswa</th>
                <th>Kelas</th>
                <th>Tanggal</th>
                <th>Jam Masuk</th>
                <th>Jam Pulang</th>
                <th>Status</th>
                <th>Keterangan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @if ($absensi->isEmpty())
                <tr>
                    <td colspan="9" class="text-center">Tidak ada data absensi</td>
                </tr>
            @else
                @foreach ($absensi as $siswa)
                    @php
                        $absen = $siswa->absensi->first();
                    @endphp
                    <tr
                        class="@if ($absen && $absen->status == 'terlambat') table-warning @elseif ($absen && $absen->status == 'izin') table-info @elseif ($absen && $absen->status == 'sakit') table-secondary @elseif ($absen && $absen->status == 'alpa') table-danger @endif{{ $absen && $absen->status == 'hadir' ? 'table-success' : '' }} text-center">
                        <td>{{ $siswa->nis }}</td>
                        <td>{{ $siswa->nama_siswa }}</td>
                        <td>{{ $siswa->kelas->nama }}</td>
                        <td>{{ $absen->tanggal ?? '-' }}</td>
                        <td>{{ $absen->jam_masuk ?? '-' }}</td>
                        <td>{{ $absen->jam_pulang ?? '-' }}</td>
                        <td>{{ ucfirst($absen->status ?? '-') }}</td>
                        <td>
                            @if (is_null($absen))
                                Belum ada data absensi
                            @elseif (is_null($absen->jam_masuk))
                                Belum absen masuk
                            @elseif (is_null($absen->jam_pulang))
                                Belum absen pulang
                            @else
                                Sudah absen lengkap
                            @endif
                        </td>
                        <td>
                            <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                data-bs-target="#manualAbsenModal{{ $siswa->id }}">
                                Absen Manual
                            </button>
                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
    <!-- End Absensi Table -->

    <!-- Modal Absensi Manual -->
    @foreach ($absensi as $siswa)
        @php
            $absen = $siswa->absensi->first();
        @endphp
        <div class="modal fade" id="manualAbsenModal{{ $siswa->id }}" tabindex="-1"
            aria-labelledby="manualAbsenModalLabel{{ $siswa->id }}" aria-hidden="true">
            <div class="modal-dialog">
                <form method="POST" action="{{ route('absen.manual', $siswa->id) }}">
                    @csrf
                    @method('PUT')
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Edit Absensi - {{ $siswa->nama_siswa }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" name="siswa_id" value="{{ $siswa->id }}">
                            <div class="mb-3">
                                <label for="tanggal{{ $siswa->id }}" class="form-label">Tanggal</label>
                                <input type="date" class="form-control" id="tanggal{{ $siswa->id }}" name="tanggal"
                                    value="{{ old('tanggal', now()->toDateString()) }}">
                            </div>
                            <div class="mb-3">
                                <label for="jam_masuk{{ $siswa->id }}" class="form-label">Jam Masuk</label>
                                <input type="time" class="form-control" id="jam_masuk{{ $siswa->id }}"
                                    name="jam_masuk" value="{{ $absen->jam_masuk ?? '' }}">
                            </div>
                            <div class="mb-3">
                                <label for="jam_pulang{{ $siswa->id }}" class="form-label">Jam Pulang</label>
                                <input type="time" class="form-control" id="jam_pulang{{ $siswa->id }}"
                                    name="jam_pulang" value="{{ $absen->jam_pulang ?? '' }}">
                            </div>
                            <div class="mb-3">
                                <label>Status</label><br>
                                @foreach (['hadir', 'terlambat', 'izin', 'sakit', 'alpa'] as $status)
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="status"
                                            id="{{ $status . $siswa->id }}" value="{{ $status }}"
                                            {{ $absen && $absen->status == $status ? 'checked' : '' }}>
                                        <label class="form-check-label" for="{{ $status . $siswa->id }}">
                                            {{ ucfirst($status) }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                            <div class="mb-3">
                                <label for="keterangan{{ $siswa->id }}" class="form-label">Keterangan</label>
                                <textarea class="form-control" name="keterangan" id="keterangan{{ $siswa->id }}">{{ $absen->keterangan ?? '' }}</textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    @endforeach
@endsection
