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

    <form method="GET" action="{{ route('absen.filter') }}">
        <div class="row mb-3">
            <div class="col-md-3">
                <label>NIS</label>
                <input type="text" name="nis" class="form-control" placeholder="NIS">
            </div>

            <div class="col-md-3">
                <label>Kelas</label>
                <select name="kelas" class="form-control">
                    <option value="">Semua kelas</option>
                    @foreach ($kelas as $j)
                        <option value="{{ $j->id }}">{{ $j->nama }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-3">
                <label>Tanggal</label>
                <input type="date" name="tanggal" class="form-control">
            </div>

            <div class="col-md-3 d-flex align-items-end">
                <button type="submit" class="btn btn-primary w-100">Filter</button>
            </div>
        </div>
    </form>

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
            @if($absensi->isEmpty())
                <tr>
                    <td colspan="9" class="text-center">Tidak ada data absensi</td>
                </tr>
            @else
                @foreach ($absensi as $siswa)
                    @php
                        $absen = $siswa->absensi->first();
                    @endphp
                    <tr>
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
                            <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editModal{{ $siswa->id }}">
                                Edit
                            </button>
                        </td>
                    </tr>

                    <!-- Modal -->
                    <div class="modal fade" id="editModal{{ $siswa->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $siswa->id }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <form method="POST" action="{{ route('absen.update', $siswa->id) }}">
                                @csrf
                                @method('PUT')
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editModalLabel{{ $siswa->id }}">Edit Absensi</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label for="jam_masuk{{ $siswa->id }}" class="form-label">Jam Masuk</label>
                                            <input type="time" class="form-control" id="jam_masuk{{ $siswa->id }}" name="jam_masuk" value="{{ $siswa->absensi->first()->jam_masuk ?? '' }}">
                                        </div>
                                        <div class="mb-3">
                                            <label for="jam_pulang{{ $siswa->id }}" class="form-label">Jam Pulang</label>
                                            <input type="time" class="form-control" id="jam_pulang{{ $siswa->id }}" name="jam_pulang" value="{{ $siswa->absensi->first()->jam_pulang ?? '' }}">
                                        </div>
                                        <div class="mb-3">
                                            <label for="status{{ $siswa->id }}" class="form-label">Status</label>
                                            <select class="form-control" id="status{{ $siswa->id }}" name="status">
                                                <option value="hadir" {{ $siswa->absensi->first()->status == 'hadir' ? 'selected' : '' }}>Hadir</option>
                                                <option value="izin" {{ $siswa->absensi->first()->status == 'izin' ? 'selected' : '' }}>Izin</option>
                                                <option value="sakit" {{ $siswa->absensi->first()->status == 'sakit' ? 'selected' : '' }}>Sakit</option>
                                                <option value="alpa" {{ $siswa->absensi->first()->status == 'alpa' ? 'selected' : '' }}>Alpa</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="keterangan{{ $siswa->id }}" class="form-label">Keterangan</label>
                                            <textarea class="form-control" id="keterangan{{ $siswa->id }}" name="keterangan">{{ $siswa->absensi->first()->keterangan ?? '' }}</textarea>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Save changes</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                @endforeach
            @endif
        </tbody>
    </table>
@endsection
