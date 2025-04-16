@extends('layout.layout')

@section('content')
    <div class="pagetitle">
        <h1>Cetak Laporan Absensi Bulanan</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/dashboard">Beranda</a></li>
                <li class="breadcrumb-item">Absensi</li>
                <li class="breadcrumb-item active">Cetak Laporan Absensi Bulanan</li>
            </ol>
        </nav>
    </div>

        @if (session('error'))
            <div class="bg-red-100 text-red-700 p-2 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Cetak Laporan Absensi Bulanan</h5>
                <form action="{{ route('laporan.absensi.bulanan.form') }}" method="GET" class="space-y-4">
                    <div class="mb-3">
                        <label for="kelas_id" class="block text-sm font-medium">Pilih Kelas</label>
                        <select name="kelas_id" id="kelas_id" class="w-full border rounded p-2">
                            @foreach ($kelas as $kls)
                                <option value="" disabled selected>Pilih Kelas</option>
                                <option value="{{ $kls->id }}">{{ $kls->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="bulan" class="block text-sm font-medium">Pilih Bulan</label>
                        <input type="month" name="bulan" id="bulan" class="w-full border rounded p-2"
                            value="{{ \Carbon\Carbon::now()->format('Y-m') }}">
                    </div>
                    <button type="submit" class="bg-success text-white px-4 py-2 rounded hover:bg-blue-700">Download
                        Excel</button>
                </form>
            </div>
        </div>
@endsection
