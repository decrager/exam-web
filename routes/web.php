<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\loginController;
use App\Http\Controllers\dataController;
use App\Http\Controllers\pjUjianController;
use App\Http\Controllers\prodiController;
use App\Http\Controllers\pjLokasiController;
use App\Http\Controllers\berkasController;

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

Route::group(['middleware' => ['auth', 'cekrole:data']], function () {
    Route::get('/data', [dataController::class, 'dashboard'])->name('dashboardData');
    Route::get('/data/mahasiswa', [dataController::class, 'mahasiswaIndex'])->name('data.mahasiswa.view');
    Route::get('/data/mahasiswa/tambah', [dataController::class, 'mahasiswaForm'])->name('data.mahasiswa.form');
    Route::get('/data/mahasiswa/edit/{id}', [dataController::class, 'mahasiswaEdit'])->name('data.mahasiswa.edit');
    Route::get('/data/bap', [dataController::class, 'bap'])->name('data.ketersediaan.bap');
    Route::get('/data/amplop', [dataController::class, 'amplop'])->name('data.ketersediaan.amplop');
    Route::get('/data/pengguna', [dataController::class, 'penggunaIndex'])->name('data.pengguna.index');
    Route::get('/data/pengguna/tambah', [dataController::class, 'penggunaForm'])->name('data.pengguna.form');
    Route::get('/data/pengguna/edit/{id}', [dataController::class, 'penggunaEdit'])->name('data.pengguna.edit');
    Route::get('/data/berkas', [dataController::class, 'berkas'])->name('data.berkas');
    Route::get('/data/pelanggaran', [dataController::class, 'pelanggaran'])->name('data.pelanggaran');
});

Route::group(['middleware' => ['auth', 'cekrole:pj_ujian']], function () {
    Route::get('/pj_ujian', [pjUjianController::class, 'dashboard'])->name('pjUjianDashboard');
    Route::get('/pj_ujian/jadwal', [pjUjianController::class, 'ujianIndex'])->name('pjUjian.jadwal.index');
    Route::get('/pj_ujian/jadwal/tambah', [pjUjianController::class, 'ujianForm'])->name('pjUjian.jadwal.tambah');
    Route::get('/pj_ujian/jadwal/edit/{id}', [pjUjianController::class, 'ujianEdit'])->name('pjUjian.jadwal.edit');
    Route::get('/pj_ujian/soal', [pjUjianController::class, 'soalIndex'])->name('pjUjian.soal.index');
    Route::get('/pj_ujian/soal/tambah', [pjUjianController::class, 'soalForm'])->name('pjUjian.soal.form');
    Route::get('/pj_ujian/soal/edit/{id}', [pjUjianController::class, 'soalEdit'])->name('pjUjian.soal.edit');
    Route::get('/pj_ujian/pengawas/daftar', [pjUjianController::class, 'listPengawas'])->name('pjUjian.pengawas.daftar');
    Route::get('/pj_ujian/pengawas/penugasan', [pjUjianController::class, 'penugasanIndex'])->name('pjUjian.pengawas.penugasan.index');
    Route::get('/pj_ujian/pengawas/penugasan/tambah', [pjUjianController::class, 'penugasanForm'])->name('pjUjian.pengawas.penugasan.form');
    Route::get('/pj_ujian/pengawas/penugasan/edit/{id}', [pjUjianController::class, 'penugasanEdit'])->name('pjUjian.pengawas.penugasan.edit');
    Route::get('/pj_ujian/kelengkapan/amplop', [pjUjianController::class, 'amplop'])->name('pjUjian.kelengkapan.amplop');
    Route::get('/pj_ujian/kelengkapan/bap', [pjUjianController::class, 'bap'])->name('pjUjian.kelengkapan.bap');
    Route::get('/pj_ujian/kelengkapan/berkas', [pjUjianController::class, 'berkas'])->name('pjUjian.kelengkapan.berkas');
    Route::get('/pj_ujian/susulan', [pjUjianController::class, 'susulan'])->name('pjUjian.susulan');
    Route::get('/pj_ujian/pelanggaran', [pjUjianController::class, 'pelanggaran'])->name('pjUjian.pelanggaran');
});

Route::group(['middleware' => ['auth', 'cekrole:prodi']], function () {
    Route::get('/prodi', [prodiController::class, 'dashboard'])->name('prodiDashboard');
    Route::get('/prodi/jadwal', [prodiController::class, 'ujianIndex'])->name('prodi.jadwal.index');
    Route::get('/prodi/jadwal/tambah', [prodiController::class, 'ujianForm'])->name('prodi.jadwal.form');
    Route::get('/prodi/jadwal/edit/{id}', [prodiController::class, 'ujianEdit'])->name('prodi.jadwal.edit');
    Route::get('/prodi/pengawas/daftar', [prodiController::class, 'pengawasList'])->name('prodi.pengawas.list');
    Route::get('/prodi/pengawas/penugasan', [prodiController::class, 'penugasanIndex'])->name('prodi.pengawas.penugasan.index');
    Route::get('/prodi/pengawas/penugasan/tambah', [prodiController::class, 'penugasanForm'])->name('prodi.pengawas.penugasan.form');
    Route::get('/prodi/pengawas/penugasan/edit/{id}', [prodiController::class, 'penugasanEdit'])->name('prodi.pengawas.penugasan.edit');
    Route::get('/prodi/berkas', [prodiController::class, 'berkas'])->name('prodi.berkas');
    Route::get('/prodi/pelanggaran', [prodiController::class, 'pelanggaran'])->name('prodi.pelanggaran');
});

Route::group(['middleware' => ['auth', 'cekrole:pj_lokasi']], function () {
    Route::get('/pj_lokasi', [pjLokasiController::class, 'dashboard'])->name('pjLokasiDashboard');
    Route::get('/pj_lokasi/pengawas/daftar', [pjLokasiController::class, 'pengawasList'])->name('pjLokasi.pengawas.list');
    Route::get('/pj_lokasi/pengawas/penugasan', [pjLokasiController::class, 'penugasanIndex'])->name('pjLokasi.pengawas.penugasan.index');
    Route::get('/pj_lokasi/pengawas/penugasan/tambah', [pjLokasiController::class, 'penugasanForm'])->name('pjLokasi.pengawas.penugasan.form');
    Route::get('/pj_lokasi/pengawas/penugasan/edit/{id}', [pjLokasiController::class, 'penugasanEdit'])->name('pjLokasi.pengawas.penugasan.edit');
    Route::get('/pj_lokasi/pengawas/absensi', [pjLokasiController::class, 'absensiIndex'])->name('pjLokasi.pengawas.absensi.index');
    Route::get('/pj_lokasi/pengawas/absensi/tambah', [pjLokasiController::class, 'absensiForm'])->name('pjLokasi.pengawas.absensi.form');
    Route::get('/pj_lokasi/berkas', [pjLokasiController::class, 'berkas'])->name('pjLokasi.berkas');
    Route::get('/pj_lokasi/pelanggaran', [pjLokasiController::class, 'pelanggaranIndex'])->name('pjLokasi.pelanggaran.index');
    Route::get('/pj_lokasi/pelanggaran/tambah', [pjLokasiController::class, 'pelanggaranForm'])->name('pjLokasi.pelanggaran.form');
    Route::get('/pj_lokasi/pelanggaran/edit/{id}', [pjLokasiController::class, 'pelanggaranEdit'])->name('pjLokasi.pelanggaran.edit');
});

Route::group(['middleware' => ['auth', 'cekrole:berkas']], function () {
    Route::get('/berkas', [berkasController::class, 'dashboard'])->name('berkasDashboard');
    Route::get('/berkas/soal_ujian', [berkasController::class, 'soal'])->name('berkas.soal');
    Route::get('/berkas/rekapitulasi/mahasiswa', [berkasController::class, 'mahasiswa'])->name('berkas.rekapitulasi.mahasiswa');
    Route::get('/berkas/rekapitulasi/mata_kuliah', [berkasController::class, 'matkul'])->name('berkas.rekapitulasi.matkul');
    Route::get('/berkas/kelengkapan/amplop', [berkasController::class, 'amplop'])->name('berkas.kelengkapan.amplop');
    Route::get('/berkas/kelengkapan/bap', [berkasController::class, 'bap'])->name('berkas.kelengkapan.bap');
    Route::get('/berkas/kelengkapan/berkas', [berkasController::class, 'berkas'])->name('berkas.kelengkapan.berkas');
    Route::get('/berkas/pelanggaran', [berkasController::class, 'pelanggaran'])->name('berkas.pelanggaran');
});