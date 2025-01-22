<?php

use App\Http\Controllers\SiswaController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('layout.layout');
});

Route::get('/data_siswa', [SiswaController::class, 'index']) -> name('data_siswa');
