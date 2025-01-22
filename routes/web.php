<?php

use App\Http\Controllers\SiswaController;
use App\Http\Controllers\PelanggaranController;
use App\Http\Controllers\PretasiController;
use App\Http\Controllers\BudayaPositifController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('layout.layout');
});

Route::get('/data_siswa', [SiswaController::class, 'index']) -> name('data_siswa');

Route::get('/data_pelanggaran', [PelanggaranController::class, 'index']) -> name('data_pelanggaran');

Route::get('/data_pretasi', [PretasiController::class, 'index']) -> name('data_pretasi');

Route::get('/data_budaya_positif', [BudayaPositifController::class, 'index']) -> name('data_budaya_positif');
