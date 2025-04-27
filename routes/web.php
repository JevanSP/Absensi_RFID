<?php

use App\Http\Controllers\SiswaController;
use App\Http\Controllers\PelanggaranController;
use App\Http\Controllers\PretasiController;
use App\Http\Controllers\BudayaPositifController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SekolahController;
use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\DashboaordController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PengaturanAbsensiController;
use App\Http\Controllers\PoinSiswaController;
use App\Http\Controllers\PoinKategoriController;
use App\Http\Controllers\TampilanSiswaController;
use App\Http\Controllers\BeritaController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
})->name('login');

route::post('/login/store', [LoginController::class, 'store'])->name('login.store');
Route::post('/logout', function () {
    Auth::logout();
    return redirect()->route('login');
})->name('logout');

Route::middleware(['login'])->group(function () {
    Route::middleware(['khusus_admin'])->group(function () {
        Route::get('/dashboard/admin_guru', [DashboaordController::class, 'admin_guru'])->name('dashboard.admin_guru');
        route::get('/data_kelas', [KelasController::class, 'index']);
        route::get('/data_kelas/create', [KelasController::class, 'create']);
        route::post('/data_kelas/store', [KelasController::class, 'store']);
        route::put('/data_kelas/update/{id}', [KelasController::class, 'update']);
        route::get('/data_kelas/destroy/{id}', [KelasController::class, 'destroy']);

        route::get('/data_siswa', [SiswaController::class, 'index'])->name('siswa.data_siswa');
        route::get('/add_siswa', [SiswaController::class, 'create'])->name('siswa.add_siswa');
        route::get('/edit_siswa/{id}', [SiswaController::class, 'edit'])->name('siswa.edit_siswa');
        route::post('/data_siswa/store', [SiswaController::class, 'store'])->name('siswa.store');
        route::put('/data_siswa/update/{id}', [SiswaController::class, 'update']);
        route::put('/data_siswa/update/{id}/rfid', [SiswaController::class, 'update_rfid'])->name('siswa.update_rfid');
        route::delete('/data_siswa/destroy/{id}', [SiswaController::class, 'destroy']);

        Route::get('/berita', [BeritaController::class, 'index'])->name('berita.list');
        Route::post('/berita/create', [BeritaController::class, 'store'])->name('berita.store');

        Route::get('/data_sekolah', [SekolahController::class, 'index'])->name('data_sekolah');

        Route::get('/user/{role}', [UserController::class, 'getIndexByRole'])->name('user.index');
        Route::post('/user', [UserController::class, 'store'])->name('user.store');
        Route::put('/user/{user}', [UserController::class, 'update'])->name('user.update');
        Route::delete('/user/{user}', [UserController::class, 'destroy'])->name('user.destroy');

        Route::middleware(['absen_role'])->group(function () {
            Route::get('/absen_masuk', [AbsensiController::class, 'absensi_masuk'])->name('absensi.masuk');
            Route::get('/absen_pulang', [AbsensiController::class, 'absensi_pulang'])->name('absensi.pulang');
        });

        Route::get('/absen', [AbsensiController::class, 'index'])->name('absen.list');
        Route::post('/absen-rfid-masuk', [AbsensiController::class, 'absen_masuk_RFID'])->name('absen_masuk.rfid');
        Route::post('/absen-rfid-pulang', [AbsensiController::class, 'absen_pulang_RFID'])->name('absen_pulang.rfid');
        Route::post('/check_absensi_hari_ini', [AbsensiController::class, 'checkAbsensiHariIni'])->name('check_absensi_hari_ini');
        Route::get('/absen/filter', [AbsensiController::class, 'filter'])->name('absen.filter');
        Route::put('/absen/manual/{id}', [AbsensiController::class, 'absensi_manual'])->name('absen.manual');
        
        Route::get('/laporan-absensi-bulanan-form', function () {
            $kelas = \App\Models\Kelas::all();
            return view('absen.form_laporan_bulanan', compact('kelas'));
        })->name('laporan.absensi.bulanan.form');

        Route::get('/laporan-absensi-bulanan', [AbsensiController::class, 'cetak_laporan_bulanan'])->name('laporan.absensi.bulanan');

        Route::get('/laporan-absensi/pdf', [AbsensiController::class, 'cetak_laporan_bulanan_pdf'])->name('laporan.absensi.bulanan.pdf');

        Route::get('/pengaturan', [PengaturanAbsensiController::class, 'index'])->name('pengaturan.index');
        Route::post('/pengaturan', [PengaturanAbsensiController::class, 'store'])->name('pengaturan.store');
        Route::delete('/pengaturan/{pengaturanAbsensi}', [PengaturanAbsensiController::class, 'destroy'])->name('pengaturan.destroy');

        Route::get('poin_kategori/{category}', [PoinKategoriController::class, 'indexByCategory'])->name('poin_kategori.indexByCategory');
        Route::post('poin_kategori', [PoinKategoriController::class, 'store'])->name('poin_kategori.store');
        Route::put('poin_kategori/{category}', [PoinKategoriController::class, 'update'])->name('poin_kategori.update');
        Route::delete('poin_kategori/{category}', [PoinKategoriController::class, 'destroy'])->name('poin_kategori.destroy');

        Route::get('poin_siswa/{kategori}', [PoinSiswaController::class, 'indexBySiswaCategory'])->name('poin_siswa.index');
        Route::post('poin_siswa', [PoinSiswaController::class, 'store'])->name('poin_siswa.store');
        Route::put('poin_siswa/{kategori}', [PoinSiswaController::class, 'update'])->name('poin_siswa.update');
        Route::delete('poin_siswa/{id}', [PoinSiswaController::class, 'destroy'])->name('poin_siswa.destroy');   
    });


    Route::middleware(['khusus_siswa'])->group(function () {
        Route::get('/dashboard/siswa', [DashboaordController::class, 'siswa'])->name('dashboard.siswa');
        Route::get('/siswa/poin', [TampilanSiswaController::class, 'poin'])->name('siswa.poin');
        Route::get('/siswa/absensi', [TampilanSiswaController::class, 'absensi'])->name('siswa.absensi');
        Route::get('/siswa/berita', [TampilanSiswaController::class, 'berita'])->name('siswa.berita');
        Route::get('/siswa/sekolah', [TampilanSiswaController::class, 'sekolah'])->name('siswa.sekolah');
    });
});


// route::post('/login', [LoginController::class, 'store'])->name('login.post');
// route::get('/data_kelas', [KelasController::class, 'index']);
// route::get('/data_kelas/create', [KelasController::class, 'create']);
// route::post('/data_kelas/store', [KelasController::class, 'store']);
// route::post('/data_kelas/update/{id}', [KelasController::class, 'update']);
// route::get('/data_kelas/destroy/{id}', [KelasController::class, 'destroy']);

// route::get('/data_siswa', [SiswaController::class, 'index'])->name('siswa.data_siswa');
// route::get('/add_siswa', [SiswaController::class, 'create'])->name('siswa.add_siswa');
// route::get('/edit_siswa/{id}', [SiswaController::class, 'edit'])->name('siswa.edit_siswa');
// route::post('/data_siswa/store', [SiswaController::class, 'store'])->name('siswa.store');
// route::put('/data_siswa/update/{id}', [SiswaController::class, 'update']);
// route::delete('/data_siswa/destroy/{id}', [SiswaController::class, 'destroy']);

// Route::get('/data_sekolah', [SekolahController::class, 'index'])->name('data_sekolah');

// Route::get('/user/{role}', [UserController::class, 'getIndexByRole'])->name('user.index');
// Route::post('/user', [UserController::class, 'store'])->name('user.store');
// Route::put('/user/{user}', [UserController::class, 'update'])->name('user.update');
// Route::delete('/user/{user}', [UserController::class, 'destroy'])->name('user.destroy');

// Route::get('/absen', [AbsensiController::class, 'index'])->name('absen.list');
// Route::post('/absen-rfid', [AbsensiController::class, 'absenRFID']);
// Route::post('/absen/filter', [AbsensiController::class, 'filter'])->name('absen.filter');
// Route::put('/absen/{id}', [AbsensiController::class, 'update'])->name('absen.update');

// Route::get('/pengaturan', [PengaturanAbsensiController::class, 'index'])->name('pengaturan.index');
// Route::post('/pengaturan', [PengaturanAbsensiController::class, 'store'])->name('pengaturan.store');
// Route::delete('/pengaturan/{pengaturanAbsensi}', [PengaturanAbsensiController::class, 'destroy'])->name('pengaturan.destroy');

// Route::get('poin_kategori/{category}', [PoinKategoriController::class, 'indexByCategory'])->name('poin_kategori.indexByCategory');
// Route::post('poin_kategori', [PoinKategoriController::class, 'store'])->name('poin_kategori.store');
// Route::put('poin_kategori/{category}', [PoinKategoriController::class, 'update'])->name('poin_kategori.update');
// Route::delete('poin_kategori/{category}', [PoinKategoriController::class, 'destroy'])->name('poin_kategori.destroy');

// Route::get('poin_siswa/{kategori}', [PoinSiswaController::class, 'indexBySiswaCategory'])->name('poin_siswa.index');
// Route::post('poin_siswa', [PoinSiswaController::class, 'store'])->name('poin_siswa.store');
// Route::put('poin_siswa/{kategori}', [PoinSiswaController::class, 'update'])->name('poin_siswa.update');
// Route::delete('poin_siswa/{kategori}', [PoinSiswaController::class, 'destroy'])->name('poin_siswa.destroy');

// Route::get('/siswa/poin', [TampilanSiswaController::class, 'poin']);
// Route::get('/siswa/absensi', [TampilanSiswaController::class, 'absensi']);
// Route::get('/siswa/berita', [TampilanSiswaController::class, 'berita']);

// Route::get('/dashboard', [DashboaordController::class, 'admin_guru']);
// Route::get('/dashboard/siswa', [DashboaordController::class, 'siswa']);
