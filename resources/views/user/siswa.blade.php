@extends('layout.layout')
@section('content')
    <div class="pagetitle">
        <h1>User Siswa</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/dashboard/admin_guru">Dashboard</a></li>
                <li class="breadcrumb-item">User Manajemen</li>
                <li class="breadcrumb-item active">User Siswa</li>
            </ol>
        </nav>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <button type="button" class="btn btn-success my-3" data-bs-toggle="modal" data-bs-target="#modalSelectStudentUser"
        id="btnPilihUserSiswa">
        + PILIH SISWA DARI DAFTAR
    </button>

    <table class="table datatable table-success table-striped-columns border-success">
        <thead>
            <tr>
                <th class="text-center">No</th>
                <th class="text-center">Nama Siswa</th>
                <th class="text-center">Username</th>
                <th class="text-center">Password</th>
                <th class="text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $key => $row)
                <tr>
                    <td class="text-center">{{ $key + 1 }}</td>
                    <td class="text-center">{{ $row->nama }}</td>
                    <td class="text-center">{{ $row->username }}</td>
                    <td class="text-center">
                        <span class="password-text" id="password-text-{{ $row->id }}">••••••••</span>
                        <button type="button" class="btn btn-sm btn-secondary toggle-password"
                            data-id="{{ $row->id }}">
                            <i class="bi bi-eye"></i>
                        </button>
                        <input type="hidden" value="{{ $row->password }}" id="password-hidden-{{ $row->id }}">
                    </td>
                    <td class="text-center">
                        <!-- Tombol Edit -->
                        <button type="button" class="btn btn-warning" data-bs-toggle="modal"
                            data-bs-target="#modalEditUser{{ $row->id }}">
                            <i class="bi bi-pencil"></i> Edit
                        </button>
                        <!-- Tombol Hapus -->
                        <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                            data-bs-target="#modaldelete{{ $row->id }}">
                            <i class="bi bi-trash"></i> Hapus
                        </button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Modal Tambah -->
    <!-- Modal Pilih Siswa -->
    <div class="modal fade" id="modalSelectStudentUser" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5">Pilih Siswa</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="studentSelectBody">
                    <table class="table datatable table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>NIS</th>
                                <th>Nama Siswa</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data_siswa as $i => $siswa)
                                <tr>
                                    <td>{{ $i + 1 }}</td>
                                    <td>{{ $siswa->nis }}</td>
                                    <td>{{ $siswa->nama_siswa }}</td>
                                    <td>
                                        <button type="button" class="btn btn-primary select-siswa-user"
                                            data-id="{{ $siswa->id }}" data-name="{{ $siswa->nama_siswa }}">
                                            Pilih
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="modal-body d-none" id="studentInputForm">
                    <form method="POST" action="{{ route('user.store') }}">
                        @csrf
                        <input type="hidden" name="siswa_id" id="selectedUserSiswaId">
                        <input type="hidden" name="role" value="siswa">
                        <div class="form-group">
                            <label>Nama Siswa</label>
                            <input type="text" class="form-control" id="selectedUserSiswaName" readonly>
                        </div>
                        <br>
                        <div class="form-group">
                            <label>Username</label>
                            <input type="text" class="form-control" name="username" required>
                        </div>
                        <br>
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" class="form-control" name="password" required>
                        </div>
                        <br>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.querySelectorAll('.select-siswa-user').forEach(button => {
            button.addEventListener('click', function() {
                const siswaId = this.getAttribute('data-id');
                const siswaName = this.getAttribute('data-name');
                document.getElementById('selectedUserSiswaId').value = siswaId;
                document.getElementById('selectedUserSiswaName').value = siswaName;
                document.getElementById('studentSelectBody').classList.add('d-none');
                document.getElementById('studentInputForm').classList.remove('d-none');
            });
        });
    
        // Reset tampilan form saat modal dibuka ulang
        document.getElementById('btnPilihUserSiswa').addEventListener('click', function() {
            document.getElementById('studentSelectBody').classList.remove('d-none');
            document.getElementById('studentInputForm').classList.add('d-none');
        });
    </script>
    
    <!-- Modal Edit -->
    <!-- Modal Edit User Siswa -->
    @foreach ($users as $u)
        <div class="modal fade" id="modalEditUser{{ $u->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5">Edit User Siswa - {{ $u->nama }}</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <form method="POST" action="{{ route('user.update', $u->id) }}">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="role" value="{{ $u->role }}">
                        @if ($u->role === 'siswa')
                            <input type="hidden" name="siswa_id" value="{{ $u->siswa_id }}">
                        @endif
                        <div class="modal-body">
                            <div class="form-group">
                                <label>Nama Siswa</label>
                                <input type="text" value="{{ $u->nama }}" class="form-control" name="nama"
                                    required>
                            </div>
                            <br>
                            <div class="form-group">
                                <label>Username</label>
                                <input type="text" value="{{ $u->username }}" class="form-control" name="username"
                                    required>
                            </div>
                            <br>
                            <div class="form-group">
                                <label>Password (Isi jika ingin mengubah)</label>
                                <input type="password" class="form-control" name="password">
                            </div>
                            <br>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach


    <!-- Modal Delete -->
    @foreach ($users as $c)
        <div class="modal fade" id="modaldelete{{ $c->id }}" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5">Hapus {{ $title }}</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <form method="POST" action="{{ route('user.destroy', $c->id) }}">
                        @csrf
                        @method('DELETE')
                        <div class="modal-body">
                            <p>Apakah anda yakin ingin menghapus <strong>{{ $c->nama }}</strong>?</p>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-danger">Hapus</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach

    <script>
        document.querySelectorAll('.toggle-password').forEach(button => {
            button.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                const passwordText = document.getElementById(`password-text-${id}`);
                const hiddenPassword = document.getElementById(`password-hidden-${id}`);
                if (passwordText.textContent === '••••••••') {
                    passwordText.textContent = hiddenPassword.value;
                    this.innerHTML = '<i class="bi bi-eye-slash"></i>';
                } else {
                    passwordText.textContent = '••••••••';
                    this.innerHTML = '<i class="bi bi-eye"></i>';
                }
            });
        });
    </script>
@endsection
