<?php

use App\Http\Controllers\JurusanController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\PelanggaranController;
use App\Http\Controllers\PretasiController;
use App\Http\Controllers\BudayaPositifController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SekolahController;
use App\Models\Jurusan;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('layout.layout');
});


route::get('/data_prestasi', [PretasiController::class, 'index']);
route::get('/data_prestasi/create', [PretasiController::class, 'create']);
route::post('/data_prestasi/store', [PretasiController::class, 'store']);
route::post('/data_prestasi/update/{id}', [PretasiController::class, 'update']);
route::get('/data_prestasi/destroy/{id}', [PretasiController::class, 'destroy']);

route::get('/data_pelanggaran', [PelanggaranController::class, 'index']);
route::get('/data_pelanggaran/create', [PelanggaranController::class, 'create']);
route::post('/data_pelanggaran/store', [PelanggaranController::class, 'store']);
route::post('/data_pelanggaran/update/{id}', [PelanggaranController::class, 'update']);
route::get('/data_pelanggaran/destroy/{id}', [PelanggaranController::class, 'destroy']);

route::get('/data_budaya_positif', [BudayaPositifController::class, 'index']);
route::get('/data_budaya_positif/create', [BudayaPositifController::class, 'create']);
route::post('/data_budaya_positif/store', [BudayaPositifController::class, 'store']);
route::post('/data_budaya_positif/update/{id}', [BudayaPositifController::class, 'update']);
route::get('/data_budaya_positif/destroy/{id}', [BudayaPositifController::class, 'destroy']);

route::get('/data_jurusan', [JurusanController::class, 'index']);
route::get('/data_jurusan/create', [JurusanController::class, 'create']);
route::post('/data_jurusan/store', [JurusanController::class, 'store']);
route::post('/data_jurusan/update/{id}', [JurusanController::class, 'update']);
route::get('/data_jurusan/destroy/{id}', [JurusanController::class, 'destroy']);

route::get('/data_siswa', [SiswaController::class,'index'])->name('siswa.data_siswa');
route::get('/add_siswa', [SiswaController::class,'create'])->name('siswa.add_siswa');
route::get('/edit_siswa/{id}', [SiswaController::class,'edit'])->name('siswa.edit_siswa');
route::post('/data_siswa/store', [SiswaController::class,'store'])->name('siswa.store');
route::post('/data_siswa/update/{id}', [SiswaController::class,'update']);
route::get('/data_siswa/destroy/{id}', [SiswaController::class,'destroy']);

Route::get('/data_sekolah', [SekolahController::class,'index'])->name('data_sekolah');

route::get('/user_admin', [UserController::class,'admin'])->name('user_admin');