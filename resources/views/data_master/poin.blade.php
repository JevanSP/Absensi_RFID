@extends('layout.layout')
@section('content')
    <div class="pagetitle">
        <h1>Data Prestasi</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/dashboard/admin_guru">Dashboard</a></li>
                <li class="breadcrumb-item">Data Master</li>
                <li class="breadcrumb-item active">Data Prestasi</li>
            </ol>
        </nav>
    </div>

    @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

    <form action="{{ route('poin.store') }}" method="POST">
        @csrf
    
        <!-- Pilih Siswa -->
        <label for="siswa_id">Nama Siswa:</label>
        <select name="siswa_id" id="siswa_id" required>
            <option value="">Pilih Siswa</option>
            @foreach ($siswa as $s)
                <option value="{{ $s->id }}">{{ $s->nama_siswa }} ({{ $s->total_poin }} Poin)</option>
            @endforeach
        </select>
    
        <!-- Pilih Kategori -->
        <label for="kategori_id">Kategori:</label>
        <select id="kategori_select">
            <option value="">Pilih Kategori</option>
            <option value="pelanggaran">Pelanggaran</option>
            <option value="prestasi">Prestasi</option>
            <option value="budaya">Budaya Positif</option>
        </select>
    
        <!-- Pilih Nama Pelanggaran / Prestasi -->
        <label for="kategori_id">Nama Poin:</label>
        <select name="kategori_id" id="nama_poin" required>
            <option value="">Pilih Poin</option>
            @foreach ($poin_kategori as $pk)
                <option value="{{ $pk->id }}" data-kategori="{{ $pk->kategori }}" data-poin="{{ $pk->poin }}">
                    {{ $pk->nama }} ({{ $pk->poin }} Poin)
                </option>
            @endforeach
        </select>
    
        <!-- Poin otomatis terisi -->
        <label for="poin">Poin:</label>
        <input type="text" id="poin" disabled>
    
        <textarea name="keterangan" placeholder="Keterangan (opsional)"></textarea>
    
        <button type="submit">Simpan</button>
    </form>
    
    <!-- Tabel Daftar Poin -->
    <table>
        <tr>
            <th>Nama Siswa</th>
            <th>Kategori</th>
            <th>Poin</th>
            <th>Guru</th>
            <th>Keterangan</th>
            <th>Aksi</th>
        </tr>
        @foreach ($poin_siswa as $poin)
            <tr>
                <td>{{ $poin->siswa->nama_siswa }}</td>
                <td>{{ $poin->kategori->nama }}</td>
                <td>{{ $poin->kategori->poin }}</td>
                <td>{{ $poin->guru->nama }}</td>
                <td>{{ $poin->keterangan }}</td>
                <td>
                    @if(Auth::user()->role == 'admin')
                        <form action="{{ route('poin.destroy', $poin->id) }}" method="POST">
                            @csrf @method('DELETE')
                            <button type="submit">Hapus</button>
                        </form>
                    @endif
                </td>
            </tr>
        @endforeach
    </table>
    
    <script>
    document.addEventListener("DOMContentLoaded", function() {
        const kategoriSelect = document.getElementById("kategori_select");
        const namaPoin = document.getElementById("nama_poin");
        const poinInput = document.getElementById("poin");
    
        kategoriSelect.addEventListener("change", function() {
            const selectedKategori = this.value;
    
            // Filter opsi berdasarkan kategori
            [...namaPoin.options].forEach(option => {
                if (option.value) {
                    option.style.display = (option.dataset.kategori === selectedKategori) ? "block" : "none";
                }
            });
    
            namaPoin.value = "";
            poinInput.value = "";
        });
    
        namaPoin.addEventListener("change", function() {
            const selectedOption = this.options[this.selectedIndex];
            poinInput.value = selectedOption.dataset.poin || "";
        });
    });
    </script>
@endsection
    