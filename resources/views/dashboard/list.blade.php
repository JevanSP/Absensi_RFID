{{-- @extends('layout.layout')
@section('content')
<div id="layoutSidenav_content">
    <div class="container-fluid px-4">
        <div class="row ">
            <div class="col-xl-4 col-md-6">
                <div class="card bg-success text-white mb-4">
                    <div class="card-body">
                        <h5>Total Pendapatan</h5>
                        <h2>Rp. {{ number_format($total_pendapatan) }}</h2> <!-- Tampilkan total Pendapatan -->
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-md-6">
                <div class="card bg-danger text-white mb-4">
                    <div class="card-body">
                        <h5>Total Jenis Barang</h5>
                        <h2>{{ $total_jenis }}</h2> <!-- Tampilkan total Jenis -->
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-md-6">
                <div class="card bg-primary text-white mb-4">
                    <div class="card-body">
                        <h5>Total Barang</h5>
                        <h2>{{ $total_barang }}</h2> <!-- Tampilkan total Barang -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <main>
        <div class="container-fluid px-4">
            <!-- Data Stock Card -->
            <div class="card mb-4">
                <div class="card-header text-center">
                    <i class="fas fa-table me-1"></i>
                    DATA BARANG
                </div>
                <div class="card-body">
                    <table id="datatablesBarang" class="table table-striped table-bordered table-hover text-center">
                        <thead class="table-dark">
                            <tr>
                                <th>No</th>
                                <th>Nama Barang</th>
                                <th>Foto</th>
                                <th>Jenis Barang</th>
                                <th>Harga</th>
                                <th>Stok</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $no = 1; @endphp
                            @foreach ($data_barang as $row)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $row->nama_barang }}</td>
                                    <td>
                                        <img src="{{ asset('storage/' . $row->foto) }}" class="rounded"
                                            style="width: 50px; height: auto;">
                                    </td>
                                    <td>{{ $row->nama_jenis }}</td>
                                    <td>Rp. {{ number_format($row->harga) }}</td>
                                    <td>{{ $row->stok }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Data Transaksi Card -->
            <div class="card mb-4">
                @if ($message = Session::get('success'))
                    <div class="alert alert-success" role="alert">
                        {{ $message }}
                    </div>
                @elseif($message = Session::get('error'))
                    <div class="alert alert-danger" role="alert">
                        {{ $message }}
                    </div>
                @endif
                <div class="card-header text-center">
                    <i class="fas fa-table me-1"></i>
                    DATA TRANSAKSI
                </div>
                <div class="card-body">
                    <div class="button-action" style="margin-bottom: 20px">
                        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#import">
                            IMPORT
                        </button>
                        <a href="" class="btn btn-primary btn-md">EXPORT</a>
                    </div>
                    <table id="datatablesTransaksi" class="table table-striped table-bordered table-hover text-center">
                        <thead class="table-dark">
                            <tr>
                                <th>No Transaksi</th>
                                <th>Kasir</th>
                                <th>Tanggal</th>
                                <th>Total Bayar</th>
                                <th>Uang Masuk</th>
                                <th>Uang Kembalian</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data_transaksi as $row)
                                <tr>
                                    <td>NT-{{ $row->id }}</td>
                                    <td>{{ $row->user->name }}</td>
                                    <td>{{ $row->tgl_transaksi }}</td>
                                    <td>Rp. {{ number_format($row->total_bayar) }}</td>
                                    <td>Rp. {{ number_format($row->uang_masuk) }}</td>
                                    <td>Rp. {{ number_format($row->kembalian) }}</td>
                                    <td>
                                        <a href="/transaksi/detail/{{ $row->id }}" class="btn btn-primary btn-sm">
                                            <i class="fas fa-eye"></i> Detail
                                        </a>
                                        <a href="/transaksi/view_pdf/{{ $row->id }}"
                                            class="btn btn-success btn-sm">
                                            <i class="fas fa-print"></i> Cetak
                                        </a>
                                        {{-- Uncomment the below button if delete action is needed --}}
                                        {{-- <button type="button" data-bs-target="#modaldelete{{ $row->id }}" data-bs-toggle="modal" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i> Delete</button> --}}
                                    {{-- </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </main>
</div>
@endsection --}} --}}

@extends('layout.layout')
<p>INI HALAMAN LIST</p>
@section('content')
@endsection 
