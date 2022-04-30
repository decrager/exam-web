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

Route::get('/', [loginController::class, 'index'])->name('login')->middleware('guest');
Route::post('/login', [loginController::class, 'authenticate']);

Route::group(['middleware' => ['auth']], function () {
    Route::get('/resetPassword', [loginController::class, 'resetPassword'])->name('resetView');
    Route::post('/resetPassword', [loginController::class, 'reset'])->name('resetPassword');
    Route::post('/logout', [loginController::class, 'logout'])->name('logout');
});

Route::group(['middleware' => ['auth','cekrole:data']], function () {
    Route::get('/dashboard', [dataController::class, 'dashboard'])->name('dashboard');
    Route::get('/mahasiswa', [dataController::class, 'mahasiswaIndex'])->name('mahasiswa.view');
    Route::get('/mahasiswaInputView', [dataController::class, 'mahasiswaInputView'])->name('mahasiswa.input');
    Route::get('/bap', [dataController::class, 'bap'])->name('ketersediaan.bap');
    Route::get('/amplop', [dataController::class, 'amplop'])->name('ketersediaan.amplop');
    Route::get('/berkas', [dataController::class, 'berkas'])->name('berkas');

    Route::post('/logout', [loginController::class, 'logout'])->name('logout');
});

Route::group(['middleware' => ['auth','cekrole:pj_ujian']], function () {
    Route::get('/dashboard', [pjUjianController::class, 'dashboard'])->name('dashboard');

    Route::post('/logout', [loginController::class, 'logout'])->name('logout');
});