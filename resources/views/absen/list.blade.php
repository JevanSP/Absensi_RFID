@extends('layout.layout')

@section('content')
    <div class="pagetitle">
        <h1>Absensi Siswa</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/dashboard/admin_guru">Dashboard</a></li>
                <li class="breadcrumb-item active">Absensi Siswa</li>
            </ol>
        </nav>
    </div>

    <form method="GET" action="{{ route('absen.filter') }}">
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

    <table class="table table-bordered">
        <thead>
            <tr class="text-center">
                <th>NIS</th>
                <th>Nama Siswa</th>
                <th>Kelas</th>
                <th>Tanggal</th>
                <th>Jam Masuk</th>
                <th>Jam Pulang</th>
                <th>Status</th>
                <th>Info</th>
                <th>Keterangan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($semuaSiswa as $siswa)
                @php
                    $absen = $siswa->absensi->first();
                @endphp
                <tr
                    class="text-center
                    @if (!$absen) table-secondary
                    @elseif ($absen->status == 'terlambat') table-warning
                    @elseif ($absen->status == 'izin') table-info
                    @elseif ($absen->status == 'sakit') table-primary
                    @elseif ($absen->status == 'alpa') table-danger
                    @elseif ($absen->status == 'hadir') table-success @endif
                ">
                    <td>{{ $siswa->nis }}</td>
                    <td>{{ $siswa->nama_siswa }}</td>
                    <td>{{ $siswa->kelas->nama }}</td>
                    <td>{{ $absen->tanggal ?? '-' }}</td>
                    <td>{{ $absen->jam_masuk ?? '-' }}</td>
                    <td>{{ $absen->jam_pulang ?? '-' }}</td>
                    <td>{{ ucfirst($absen->status ?? 'Belum Absen') }}</td>
                    <td>
                        @if (!$absen)
                            Belum ada data absensi
                        @elseif (is_null($absen->jam_masuk) && is_null($absen->jam_pulang))
                            Belum absen masuk & pulang
                        @elseif (is_null($absen->jam_masuk))
                            Belum absen masuk
                        @elseif (is_null($absen->jam_pulang))
                            Belum absen pulang
                        @else
                            Sudah absen lengkap
                        @endif
                    </td>
                    <td data-label="Keterangan">
                        @if (
                            $absen &&
                                ($absen->status == 'izin' || $absen->status == 'sakit') &&
                                $absen->keterangan &&
                                strpos($absen->keterangan, 'Bukti: ') !== false)
                            @php
                                $imgPath = str_replace('Bukti: ', '', $absen->keterangan);
                            @endphp
                            <button type="button" class="btn btn-link" data-bs-toggle="modal"
                                data-bs-target="#gambarModal{{ $siswa->id }}">
                                Lihat Bukti
                            </button>
                            <div class="modal fade" id="gambarModal{{ $siswa->id }}" tabindex="-1">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">
                                                Bukti {{ ucfirst($absen->status) }} -
                                                {{ $siswa->nama_siswa }}
                                            </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <img src="{{ asset('storage/' . $imgPath) }}" alt="Bukti {{ $absen->status }}"
                                                style="width: 100%; max-height: 500px; object-fit: contain;">
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Tutup</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @else
                            {{ $absen->keterangan ?? '-' }}
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
        </tbody>
    </table>
    @foreach ($semuaSiswa as $siswa)
        @php
            $absen = $siswa->absensi->first();
        @endphp
        <div class="modal fade" id="manualAbsenModal{{ $siswa->id }}" tabindex="-1"
            aria-labelledby="manualAbsenModalLabel{{ $siswa->id }}" aria-hidden="true">
            <div class="modal-dialog">
                <form method="POST" action="{{ route('absen.manual', $siswa->id) }}" enctype="multipart/form-data">
                    @method('PUT')
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">
                                @if ($absen)
                                    Edit Absensi - {{ $siswa->nama_siswa }}
                                @else
                                    Absen Manual - {{ $siswa->nama_siswa }}
                                @endif
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" name="siswa_id" value="{{ $siswa->id }}">
                            <div class="mb-3">
                                <label class="form-label">Tanggal</label>
                                <input type="date" class="form-control" name="tanggal"
                                    value="{{ old('tanggal', $absen->tanggal ?? now()->toDateString()) }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Jam Masuk</label>
                                <input type="time" class="form-control" name="jam_masuk"
                                    value="{{ old('jam_masuk', $absen->jam_masuk ?? '') }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Jam Pulang</label>
                                <input type="time" class="form-control" name="jam_pulang"
                                    value="{{ old('jam_pulang', $absen->jam_pulang ?? '') }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Status</label><br>
                                @foreach (['hadir', 'terlambat', 'izin', 'sakit', 'alpa', 'none'] as $status)
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input status-radio {{ $status == 'none' ? 'text-danger' : '' }}" type="radio" name="status"
                                            id="{{ $status . $siswa->id }}" value="{{ $status }}"
                                            {{ old('status', $absen->status ?? ($status == 'none' ? 'none' : '')) == $status ? 'checked' : '' }}
                                            data-siswa-id="{{ $siswa->id }}">
                                        <label class="form-check-label {{ $status == 'none' ? 'text-danger' : '' }}" for="{{ $status . $siswa->id }}">
                                            {{ ucfirst($status) }}
                                        </label>
                                    </div>
                                    
                                @endforeach
                            </div>
                            <div class="mb-3" id="keterangan-container-{{ $siswa->id }}">
                                <label for="keterangan{{ $siswa->id }}"
                                    class="form-label keterangan-label">Keterangan</label>
                                <textarea class="form-control" name="keterangan" id="keterangan{{ $siswa->id }}">{{ old('keterangan', $absen->keterangan ?? '') }}</textarea>
                            </div>
                            <div class="mb-3" id="bukti-izin-sakit-container-{{ $siswa->id }}"
                                style="display: none;">
                                <label for="bukti_file{{ $siswa->id }}" class="form-label">Upload Bukti (Foto)</label>
                                <input type="file" class="form-control" name="bukti_file"
                                    id="bukti_file{{ $siswa->id }}" accept="image/*"
                                    {{ old('status', $absen->status ?? '') == 'izin' || old('status', $absen->status ?? '') == 'sakit' ? 'required' : '' }}>
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

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script>
        $(document).ready(function() {
            $(document).on('change', '.status-radio', function() {
                var status = $(this).val();
                var siswaId = $(this).data('siswa-id');
                var keteranganContainer = $('#keterangan-container-' + siswaId);
                var buktiContainer = $('#bukti-izin-sakit-container-' + siswaId);
                var buktiFileInput = $('#bukti_file' + siswaId);

                console.log('Status berubah menjadi:', status);
                console.log('Siswa ID:', siswaId);

                if (status === 'izin' || status === 'sakit') {
                    keteranganContainer.hide();
                    buktiContainer.show();
                    buktiFileInput.attr('required', true);
                } else {
                    keteranganContainer.show();
                    buktiContainer.hide();
                    buktiFileInput.removeAttr('required');
                }
            });

            $('.modal').on('show.bs.modal', function() {
                var modalId = $(this).attr('id');
                var siswaId = modalId.replace('manualAbsenModal', '');
                var selectedStatus = $('input[name="status"][data-siswa-id="' + siswaId + '"]:checked')
                    .val();
                var keteranganContainer = $('#keterangan-container-' + siswaId);
                var buktiContainer = $('#bukti-izin-sakit-container-' + siswaId);
                var buktiFileInput = $('#bukti_file' + siswaId);

                if (selectedStatus === 'izin' || selectedStatus === 'sakit') {
                    keteranganContainer.hide();
                    buktiContainer.show();
                    buktiFileInput.attr('required', true);
                } else {
                    keteranganContainer.show();
                    buktiContainer.hide();
                    buktiFileInput.removeAttr('required');
                }
            });
        });
    </script>
@endsection
