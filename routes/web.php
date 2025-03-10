<?php

use App\Http\Controllers\JurusanController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\PelanggaranController;
use App\Http\Controllers\PretasiController;
use App\Http\Controllers\BudayaPositifController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SekolahController;
use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\PengaturanAbsensiController;
use App\Http\Controllers\PoinSiswaController;
use App\Http\Controllers\PoinKategoriController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('layout.layout');
});

route::get('/data_jurusan', [JurusanController::class, 'index']);
route::get('/data_jurusan/create', [JurusanController::class, 'create']);
route::post('/data_jurusan/store', [JurusanController::class, 'store']);
route::post('/data_jurusan/update/{id}', [JurusanController::class, 'update']);
route::get('/data_jurusan/destroy/{id}', [JurusanController::class, 'destroy']);

route::get('/data_siswa', [SiswaController::class, 'index'])->name('siswa.data_siswa');
route::get('/add_siswa', [SiswaController::class, 'create'])->name('siswa.add_siswa');
route::get('/edit_siswa/{id}', [SiswaController::class, 'edit'])->name('siswa.edit_siswa');
route::post('/data_siswa/store', [SiswaController::class, 'store'])->name('siswa.store');
route::post('/data_siswa/update/{id}', [SiswaController::class, 'update']);
route::get('/data_siswa/destroy/{id}', [SiswaController::class, 'destroy']);

Route::get('/data_sekolah', [SekolahController::class, 'index'])->name('data_sekolah');

Route::get('/user/{role}', [UserController::class, 'getIndexByRole'])->name('user.index');
Route::post('/user', [UserController::class, 'store'])->name('user.store');
Route::put('/user/{user}', [UserController::class, 'update'])->name('user.update');
Route::delete('/user/{user}', [UserController::class, 'destroy'])->name('user.destroy');

Route::get('/absen', [AbsensiController::class, 'index'])->name('absen.list');
Route::post('/absen-rfid', [AbsensiController::class, 'absenRFID']);
Route::get('/absen/filter', [AbsensiController::class, 'filter'])->name('absen.filter');

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
Route::delete('poin_siswa/{kategori}', [PoinSiswaController::class, 'destroy'])->name('poin_siswa.destroy');