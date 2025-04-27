@extends('layout.siswa')
@section('siswa')
    <div class="pagetitle">
        <h1>Rekap Absensiku</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/dashboard/siswa">Beranda</a></li>
                <li class="breadcrumb-item active">Rekap Absen</li>
            </ol>
        </nav>
    </div>

    {{-- Filter Bulan --}}
    <form method="GET" action="{{ route('siswa.absensi') }}" class="row g-3 align-items-end mb-4">
        <div class="col-auto">
            <label for="bulan" class="form-label">Pilih Bulan:</label>
            <input type="month" id="bulan" name="bulan" class="form-control"
                value="{{ request('bulan') ?? now()->format('Y-m') }}">
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-primary">Tampilkan</button>
        </div>
    </form>

    {{-- Rekap Total --}}
    <div class="row mb-4">
        @php
            $statusList = [
                'sakit' => 'primary',
                'izin' => 'info',
                'alfa' => 'danger',
                'terlambat' => 'warning',
            ];
        @endphp

        {{-- Rekap Kartu --}}
        @foreach ($statusList as $status => $color)
            <div class="col-md-3 col-6">
                <div class="card text-white bg-{{ $color }} shadow-sm">
                    <div class="card-body text-center">
                        <h5 class="card-title">{{ ucfirst($status) }}</h5>
                        <p class="card-text display-6">{{ $rekap[$status] ?? 0 }}</p>
                    </div>
                </div>
            </div>
        @endforeach

    </div>

    {{-- Tabel Absensi --}}
    <div class="card shadow">
        <div class="card-body">
            <h5 class="card-title">
                Riwayat Absensi Bulan {{ \Carbon\Carbon::parse($selectedMonth)->translatedFormat('F Y') }}
            </h5>

            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="table-light text-center">
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Status</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $no = 1; @endphp
                        @forelse ($absen as $a)
                            <tr>
                                <td class="text-center">{{ $no++ }}</td>
                                <td class="text-center">{{ \Carbon\Carbon::parse($a->tanggal)->format('d M Y') }}</td>
                                <td class="text-center">
                                    <span class="badge bg-{{ $statusList[strtolower($a->status)] ?? 'secondary' }}">
                                        {{ ucfirst($a->status) }}
                                    </span>
                                </td>
                                <td class="text-center">{{ $a->keterangan }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted">Tidak ada data absensi bulan ini.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
