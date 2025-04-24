@extends('layout.layout')
@section('content')
    <div class="pagetitle">
        <h1>Input Pelanggaran</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/dashboard/admin_guru">Dashboard</a></li>
                <li class="breadcrumb-item">Poin</li>
                <li class="breadcrumb-item active">Input Pelanggaran</li>
            </ol>
        </nav>
    </div>

    <button type="button" class="btn btn-primary my-3" data-bs-toggle="modal" data-bs-target="#modalSelectStudent"
        id="addDataButton">+ TAMBAH DATA</button>

    <table class="table datatable table-danger table-striped-columns border-danger">
        <thead>
            <tr class="text-center">
                <th>No</th>
                <th>NIS</th>
                <th>Nama Siswa</th>
                <th>Kelas</th>
                <th>Nama Pelanggaran</th>
                <th>Poin</th>
                <th>Tanggal</th>
                <th>Keterangan</th>
                <th>Guru</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @php $no = 1; @endphp
            @foreach ($poinSiswa as $p)
                <tr class="text-center text-capitalize">
                    <td>{{ $no++ }}</td>
                    <td>{{ $p->siswa->nis }}</td>
                    <td>{{ $p->siswa->nama_siswa }}</td>
                    <td>{{ $p->siswa->kelas->nama }}</td>
                    <td>{{ $p->poinKategori->nama }}</td>
                    <td>{{ $p->poinKategori->poin }}</td>
                    <td>{{ $p->tanggal }}</td>
                    <td>{{ $p->keterangan }}</td>
                    <td>{{ $p->user->nama }}</td>
                    <td>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#modaledit{{ $p->id }}"><i class="bi bi-pencil"></i> Edit</button>
                        <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                            data-bs-target="#modaldelete{{ $p->id }}"><i class="bi bi-trash"></i> Hapus</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="modal fade" id="modalSelectStudent" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5">Pilih Nama Siswa</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="selectStudentBody">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>NIS</th>
                                <th>Nama Siswa</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($siswa as $index => $s)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $s->nis }}</td>
                                    <td>{{ $s->nama_siswa }}</td>
                                    <td>
                                        <button type="button" class="btn btn-primary select-student"
                                            data-id="{{ $s->id }}" data-name="{{ $s->nama_siswa }}">Pilih</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="modal-body d-none" id="inputFormBody">
                    <form method="POST" action="{{ route('poin_siswa.store') }}">
                        @csrf
                        <input type="hidden" name="kategori" value="pelanggaran">
                        <input type="hidden" id="selectedStudentId" name="siswa_id">
                        <div class="form-group">
                            <label>Nama Siswa</label>
                            <input type="text" id="selectedStudentName" class="form-control" readonly>
                        </div>
                        <br>
                        <div class="form-group">
                            <label>Nama Pelanggaran</label>
                            <select name="poin_kategori_id" class="form-select" id="poinKategoriSelect" required>
                                <option value="">Pilih Nama Pelanggaran</option>
                                @foreach ($poinKategori as $pk)
                                    <option value="{{ $pk->id }}" data-poin="{{ $pk->poin }}">
                                        {{ $pk->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <br>
                        <div class="form-group">
                            <label>Poin</label>
                            <input type="number" class="form-control" id="poinInput" name="poin" readonly required>
                        </div>
                        <br>
                        <div class="form-group">
                            <label>Keterangan</label>
                            <input type="text" class="form-control" name="keterangan">
                        </div>
                        <br>
                        <div class="form-group">
                            <label>Tanggal</label>
                            <input type="date" class="form-control" name="tanggal" required>
                        </div>
                        <br>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @foreach ($poinSiswa as $p)
        <div class="modal fade" id="modaledit{{ $p->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5">Edit Poin Kategori</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <form method="POST" action="{{ route('poin_siswa.update', $p->id) }}">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="kategori" value="pelanggaran">
                        <div class="modal-body">
                            <div class="form-group">
                                <label>Nama Siswa</label>
                                <select name="siswa_id" class="form-select" required>
                                    <option value="{{ $p->siswa_id }}">{{ $p->siswa->nama_siswa }}</option>
                                    @foreach ($siswa as $s)
                                        <option value="{{ $s->id }}">{{ $s->nama_siswa }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Nama {{ $title }}</label>
                                <select name="poin_kategori_id" class="form-select" id="poinKategoriSelect" required>
                                    @foreach ($poinKategori as $pk)
                                        <option value="{{ $pk->id }}" data-poin="{{ $pk->poin }}">
                                            {{ $pk->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <br>
                            <div class="form-group">
                                <label>Poin</label>
                                <input type="number" value="{{ $p->poin }}" class="form-control" id="poinInput"
                                    name="poin" readonly required>
                            </div>
                            <br>
                            <div class="form-group">
                                <label>Tanggal</label>
                                <input type="date" value="{{ $p->tanggal }}" class="form-control" name="tanggal"
                                    required>
                            </div>
                            <br>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach

    @foreach ($poinSiswa as $p)
        <div class="modal fade" id="modaldelete{{ $p->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5">Hapus Pelanggaran</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <form method="POST" action="{{ route('poin_siswa.destroy', $p->id) }}">
                        @csrf
                        @method('DELETE')
                        <input type="hidden" name="kategori" value="{{ $p->kategori }}">
                        <div class="modal-body">
                            <p>Apakah anda yakin ingin menghapus data <strong>{{ $p->poinKategori->nama }}</strong> untuk siswa <strong>{{ $p->siswa->nama_siswa }}</strong>?</p>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-outline-danger">Hapus</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach

    <script>
        // Untuk semua dropdown poin_kategori di form (baik tambah maupun edit)
        document.querySelectorAll('select[name="poin_kategori_id"]').forEach(select => {
            select.addEventListener('change', function() {
                var selectedOption = this.options[this.selectedIndex];
                var poin = selectedOption.getAttribute('data-poin');
                var poinInput = this.closest('form').querySelector('input[name="poin"]');
                if (poinInput) {
                    poinInput.value = poin;
                }
            });
        });

        // Pilih siswa di modal tambah
        document.querySelectorAll('.select-student').forEach(button => {
            button.addEventListener('click', function() {
                var studentId = this.getAttribute('data-id');
                var studentName = this.getAttribute('data-name');
                document.getElementById('selectedStudentId').value = studentId;
                document.getElementById('selectedStudentName').value = studentName;
                document.getElementById('selectStudentBody').classList.add('d-none');
                document.getElementById('inputFormBody').classList.remove('d-none');
            });
        });

        // Reset modal tambah saat dibuka ulang
        document.getElementById('addDataButton').addEventListener('click', function() {
            document.getElementById('selectStudentBody').classList.remove('d-none');
            document.getElementById('inputFormBody').classList.add('d-none');
        });
    </script>
@endsection
