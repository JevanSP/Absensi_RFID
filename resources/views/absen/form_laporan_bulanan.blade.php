@extends('layout.layout')

@section('content')
    <div class="pagetitle">
        <h1>Cetak Laporan Absensi Bulanan</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/dashboard/admin_guru">Dashboard</a></li>
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
            <form id="laporan-form" method="GET" class="space-y-4">
                <div class="mb-3">
                    <label for="kelas_id" class="block text-sm font-medium">Pilih Kelas</label>
                    <select name="kelas_id" id="kelas_id" class="w-full border rounded p-2" required>
                        <option value="" selected disabled>Pilih Kelas</option>
                        @foreach ($kelas as $kls)
                            <option value="{{ $kls->id }}">{{ $kls->nama }}</option>
                        @endforeach
                    </select>
                    @error('kelas_id')
                        <div class="text-danger text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="bulan" class="block text-sm font-medium">Pilih Bulan</label>
                    <input type="month" name="bulan" id="bulan" class="w-full border rounded p-2"
                        value="{{ \Carbon\Carbon::now()->format('Y-m') }}">
                </div>

                <!-- Tombol untuk download Excel -->
                <button type="button" class="bg-success text-white px-4 py-2 rounded hover:bg-blue-700"
                    id="excel-button">Download Excel</button>

                <!-- Tombol untuk download PDF -->
                <button type="button" class="bg-danger text-white px-4 py-2 rounded hover:bg-red-700"
                    id="pdf-button">Download PDF</button>
            </form>

            <script>
                // Ambil referensi form dan tombol
                const form = document.getElementById('laporan-form');
                const excelButton = document.getElementById('excel-button');
                const pdfButton = document.getElementById('pdf-button');

                // Saat tombol Excel ditekan
                excelButton.addEventListener('click', function() {
                    form.action = "{{ route('laporan.absensi.bulanan') }}"; // Aksi untuk Excel
                    form.submit(); // Kirim form untuk download Excel
                });

                // Saat tombol PDF ditekan
                pdfButton.addEventListener('click', function() {
                    form.action = "{{ route('laporan.absensi.bulanan.pdf') }}"; // Aksi untuk PDF
                    form.target = "_blank"; // Buka di tab baru untuk preview
                    form.submit(); // Kirim form untuk download PDF
                });
            </script>
        </div>
    </div>
@endsection
