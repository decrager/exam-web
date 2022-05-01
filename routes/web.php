<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\loginController;
use App\Http\Controllers\dataController;
use App\Http\Controllers\pjUjianController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [loginController::class, 'index'])->name('login');
Route::post('/login', [loginController::class, 'authenticate']);

Route::group(['middleware' => ['auth']], function () {
    Route::get('/resetPassword', [loginController::class, 'resetPassword'])->name('resetView');
    Route::post('/resetPassword', [loginController::class, 'reset'])->name('resetPassword');
    Route::post('/logout', [loginController::class, 'logout'])->name('logout');
});

Route::group(['middleware' => ['auth','cekrole:data']], function () {
    Route::get('/data', [dataController::class, 'dashboard'])->name('dashboardData');
    Route::get('/data/mahasiswa', [dataController::class, 'mahasiswaIndex'])->name('data.mahasiswa.view');
    Route::get('/data/mahasiswaInputView', [dataController::class, 'mahasiswaInputView'])->name('data.mahasiswa.input');
    Route::get('/data/bap', [dataController::class, 'bap'])->name('data.ketersediaan.bap');
    Route::get('/data/amplop', [dataController::class, 'amplop'])->name('data.ketersediaan.amplop');
    Route::get('/data/berkas', [dataController::class, 'berkas'])->name('data.berkas');
    Route::get('/data/pelanggaran', [dataController::class, 'pelanggaran'])->name('data.pelanggaran');
});

Route::group(['middleware' => ['auth','cekrole:pj_ujian']], function () {
    Route::get('/pj_ujian', [pjUjianController::class, 'dashboard'])->name('dashboardPJUjian');
});