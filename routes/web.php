<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\loginController;
use App\Http\Controllers\dataController;
use App\Http\Controllers\pjUjianController;
use App\Http\Controllers\prodiController;
use App\Http\Controllers\pjLokasiController;
use App\Http\Controllers\berkasController;
use App\Http\Controllers\assistenController;
use App\Http\Controllers\pjSusulanController;
use App\Http\Controllers\supervisorController;
use App\Http\Controllers\pjOnlineController;
use App\Http\Controllers\mahasiswaController;
use App\Http\Controllers\pelanggaranController;
use Illuminate\Support\Facades\DB;
use App\Models\Prodi;
use App\Models\Semester;
use App\Models\Kelas;
use App\Models\Praktikum;
use App\Models\Matkul;
use App\Models\Ujian;
use Illuminate\Http\Request;

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

    Route::get('getSemester/{id}', function ($id) {
        $semester = Semester::where('prodi_id', $id)->get();
        return response()->json($semester);
    });

    Route::get('getKelas/{id}', function ($id) {
        $kelas = Kelas::where('semester_id', $id)->get();
        return response()->json($kelas);
    });

    Route::get('getPrak/{id}', function($id) {
        $prak = Praktikum::where('kelas_id', $id)->get();
        return response()->json($prak);
    });

    Route::get('getMatkul/{id}', function($id) {
        $matkul = Matkul::where('semester_id', $id)->get();
        return response()->json($matkul);
    });
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
    Route::get('/data/pelanggaran', [dataController::class, 'pelanggaran'])->name('data.pelanggaran');
});

Route::group(['middleware' => ['auth', 'cekrole:pj_ujian']], function () {
    Route::get('/pj_ujian', [pjUjianController::class, 'dashboard'])->name('pjUjianDashboard');
    Route::get('/pj_ujian/jadwal', [pjUjianController::class, 'ujianIndex'])->name('pjUjian.jadwal.index');
    Route::get('/pj_ujian/jadwal/tambah', [pjUjianController::class, 'ujianForm'])->name('pjUjian.jadwal.tambah');
    Route::get('/pj_ujian/jadwal/edit/{id}', [pjUjianController::class, 'ujianEdit'])->name('pjUjian.jadwal.edit');
    Route::get('/pj_ujian/pengawas', [pjUjianController::class, 'pengawasIndex'])->name('pjUjian.pengawas.pengawas.index');
    Route::get('/pj_ujian/pengawas/edit/{id}', [pjUjianController::class, 'pengawasEdit'])->name('pjUjian.pengawas.pengawas.edit');
    Route::get('/pj_ujian/pengawas/penugasan', [pjUjianController::class, 'penugasanIndex'])->name('pjUjian.pengawas.penugasan.index');
    Route::get('/pj_ujian/pengawas/penugasan/tambah/{id}', [pjUjianController::class, 'penugasanForm'])->name('pjUjian.pengawas.penugasan.form');
    Route::get('/pj_ujian/kelengkapan/amplop', [pjUjianController::class, 'amplop'])->name('pjUjian.kelengkapan.amplop');
    Route::get('/pj_ujian/kelengkapan/bap', [pjUjianController::class, 'bap'])->name('pjUjian.kelengkapan.bap');
    Route::get('/pj_ujian/kelengkapan/berkas', [pjUjianController::class, 'berkas'])->name('pjUjian.kelengkapan.berkas');
    Route::get('/pj_ujian/susulan', [pjUjianController::class, 'susulan'])->name('pjUjian.susulan');
    Route::get('/pj_ujian/pelanggaran', [pjUjianController::class, 'pelanggaran'])->name('pjUjian.pelanggaran');

    Route::post('/pj_ujian/pengawas/penugasan/create', [pjUjianController::class, 'penugasanCreate'])->name('pjUjian.pengawas.penugasan.create');
    Route::put('/pj_ujian/pengawas/update/{id}', [pjUjianController::class, 'pengawasUpdate'])->name('pjUjian.pengawas.update');
    Route::delete('/pj_ujian/pengawas/destroy/{id}', [pjUjianController::class, 'pengawasDestroy'])->name('pjUjian.pengawas.destroy');
    Route::put('/pj_ujian/kelengkapan/berkas/update/{id}', [pjUjianController::class, 'berkasUpdate'])->name('pjUjian.berkas.update');
    Route::post('/pj_ujian/jadwal/create', [pjUjianController::class, 'ujianCreate'])->name('pjUjian.jadwal.create');
    Route::put('/pj_ujian/jadwal/edit/update/{id}', [pjUjianController::class, 'ujianUpdate'])->name('pjUjian.jadwal.update');
    Route::delete('/pj_ujian/jadwal/destroy/{id}', [pjUjianController::class, 'ujianDestroy'])->name('pjUjian.jadwal.destroy');
});

Route::group(['middleware' => ['auth', 'cekrole:prodi']], function () {
    Route::get('/prodi', [prodiController::class, 'dashboard'])->name('prodiDashboard');
    Route::get('/prodi/jadwal', [prodiController::class, 'ujianIndex'])->name('prodi.jadwal.index');
    Route::get('/prodi/jadwal/edit/{id}', [prodiController::class, 'ujianEdit'])->name('prodi.jadwal.edit');
    Route::get('/prodi/pengawas/daftar', [prodiController::class, 'pengawasList'])->name('prodi.pengawas.list');
    Route::get('/prodi/pengawas/penugasan', [prodiController::class, 'penugasanIndex'])->name('prodi.pengawas.penugasan.index');
    Route::get('/prodi/pengawas/penugasan/tambah{id}', [prodiController::class, 'penugasanForm'])->name('prodi.pengawas.penugasan.form');
    Route::get('/prodi/pengawas/penugasan/edit/{id}', [prodiController::class, 'penugasanEdit'])->name('prodi.pengawas.penugasan.edit');
    Route::get('/prodi/berkas', [prodiController::class, 'berkas'])->name('prodi.berkas');
    Route::get('/prodi/pelanggaran', [prodiController::class, 'pelanggaran'])->name('prodi.pelanggaran');
});

Route::group(['middleware' => ['auth', 'cekrole:pj_lokasi']], function () {
    Route::get('/pj_lokasi', [pjLokasiController::class, 'dashboard'])->name('pjLokasiDashboard');
    Route::get('/pj_lokasi/pengawas', [pjLokasiController::class, 'pengawasIndex'])->name('pjLokasi.pengawas.daftar.index');
    Route::get('/pj_lokasi/pengawas/edit/{id}', [pjLokasiController::class, 'pengawasEdit'])->name('pjLokasi.pengawas.daftar.edit');
    Route::get('/pj_lokasi/pengawas/absensi', [pjLokasiController::class, 'absensiIndex'])->name('pjLokasi.pengawas.absensi.index');
    Route::get('/pj_lokasi/pengawas/absensi/ttd/{id}', [pjLokasiController::class, 'absensiForm'])->name('pjLokasi.pengawas.absensi.form');
    Route::get('/pj_lokasi/soal', [pjLokasiController::class, 'soalIndex'])->name('pjLokasi.soal.index');
    Route::get('/pj_lokasi/soal/ttd', [pjLokasiController::class, 'soalForm'])->name('pjLokasi.soal.form');
    Route::resource('/pj_lokasi/pelanggaran', pelanggaranController::class);
    Route::get('/pj_lokasi/pelanggaran/tambah', [pjLokasiController::class, 'pelanggaranForm'])->name('pjLokasi.pelanggaran.form');
    Route::get('/pj_lokasi/pelanggaran/edit/{id}', [pjLokasiController::class, 'pelanggaranEdit'])->name('pjLokasi.pelanggaran.edit');
});

Route::group(['middleware' => ['auth', 'cekrole:berkas']], function () {
    Route::get('/berkas', [berkasController::class, 'dashboard'])->name('berkasDashboard');
    Route::get('/berkas/rekapitulasi/mahasiswa', [berkasController::class, 'mahasiswa'])->name('berkas.rekapitulasi.mahasiswa');
    Route::get('/berkas/rekapitulasi/mata_kuliah', [berkasController::class, 'matkul'])->name('berkas.rekapitulasi.matkul');
    Route::get('/berkas/kelengkapan/amplop', [berkasController::class, 'amplop'])->name('berkas.kelengkapan.amplop');
    Route::get('/berkas/kelengkapan/bap', [berkasController::class, 'bap'])->name('berkas.kelengkapan.bap');
    Route::get('/berkas/kelengkapan/berkas', [berkasController::class, 'berkas'])->name('berkas.kelengkapan.berkas');
    Route::get('/berkas/pelanggaran', [berkasController::class, 'pelanggaran'])->name('berkas.pelanggaran');
});

Route::group(['middleware' => ['auth', 'cekrole:assisten']], function () {
    Route::get('/assisten', [assistenController::class, 'dashboard'])->name('assistenDashboard');
    Route::get('/assisten/berkas', [assistenController::class, 'berkas'])->name('assisten.berkas');
    Route::get('/assisten/pelanggaran', [assistenController::class, 'pelanggaran'])->name('assisten.pelanggaran');
});

Route::group(['middleware' => ['auth', 'cekrole:pj_susulan']], function () {
    Route::get('/pj_susulan', [pjSusulanController::class, 'dashboard'])->name('pjSusulanDashboard');
    Route::get('/pj_susulan/ketentuan', [pjSusulanController::class, 'ketentuanIndex'])->name('pjSusulan.ketentuan.index');
    Route::get('/pj_susulan/ketentuan/tambah', [pjSusulanController::class, 'ketentuanForm'])->name('pjSusulan.ketentuan.form');
    Route::get('/pj_susulan/ketentuan/edit/{id}', [pjSusulanController::class, 'ketentuanEdit'])->name('pjSusulan.ketentuan.edit');
    Route::get('/pj_susulan/mahasiswa', [pjSusulanController::class, 'mahasiswaIndex'])->name('pjSusulan.mahasiswa.index');
    Route::get('/pj_susulan/penjadwalan', [pjSusulanController::class, 'penjadwalanIndex'])->name('pjSusulan.penjadwalan.index');
    Route::get('/pj_susulan/penjadwalan/tambah', [pjSusulanController::class, 'penjadwalanForm'])->name('pjSusulan.penjadwalan.form');
    Route::get('/pj_susulan/jadwal', [pjSusulanController::class, 'jadwalIndex'])->name('pjSusulan.jadwal.index');
    Route::get('/pj_susulan/jadwal/edit/{id}', [pjSusulanController::class, 'jadwalEdit'])->name('pjSusulan.jadwal.edit');
    Route::get('/pj_susulan/pelanggaran', [pjSusulanController::class, 'pelanggaran'])->name('pjSusulan.pelanggaran');
});

Route::group(['middleware' => ['auth', 'cekrole:supervisor']], function () {
    Route::get('/supervisor', [supervisorController::class, 'dashboard'])->name('supervisorDashboard');
    Route::get('/supervisor/ujian', [supervisorController::class, 'ujian'])->name('supervisor.ujian');
    Route::get('/supervisor/susulan', [supervisorController::class, 'susulan'])->name('supervisor.susulan');
    Route::get('/supervisor/mhs_susulan', [supervisorController::class, 'mhs_susulan'])->name('supervisor.mhs_susulan');
    Route::get('/supervisor/pengawas', [supervisorController::class, 'pengawas'])->name('supervisor.pengawas');
    Route::get('/supervisor/mahasiswa', [supervisorController::class, 'mahasiswa'])->name('supervisor.mahasiswa');
    Route::get('/supervisor/matkul', [supervisorController::class, 'matkul'])->name('supervisor.matkul');
    Route::get('/supervisor/kelengkapan/amplop', [supervisorController::class, 'amplop'])->name('supervisor.kelengkapan.amplop');
    Route::get('/supervisor/kelengkapan/bap', [supervisorController::class, 'bap'])->name('supervisor.kelengkapan.bap');
    Route::get('/supervisor/kelengkapan/berkas', [supervisorController::class, 'berkas'])->name('supervisor.kelengkapan.berkas');
    Route::get('/supervisor/pengguna', [supervisorController::class, 'pengguna'])->name('supervisor.pengguna');
    Route::get('/supervisor/pelanggaran', [supervisorController::class, 'pelanggaran'])->name('supervisor.pelanggaran');
});

Route::group(['middleware' => ['auth', 'cekrole:pj_online']], function () {
    Route::get('/pj_online', [pjOnlineController::class, 'dashboard'])->name('pjOnlineDashboard');
    Route::get('/pj_online/jadwal_ujian', [pjOnlineController::class, 'ujian'])->name('pjOnline.ujian');
    Route::get('/pj_online/pelanggaran', [pjOnlineController::class, 'pelanggaranIndex'])->name('pjOnline.pelanggaran.index');
    Route::get('/pj_online/pelanggaran/tambah', [pjOnlineController::class, 'pelanggaranForm'])->name('pjOnline.pelanggaran.form');
    Route::get('/pj_online/pelanggaran/edit/{id}', [pjOnlineController::class, 'pelanggaranEdit'])->name('pjOnline.pelanggaran.edit');
});

Route::group(['middleware' => ['auth', 'cekrole:mahasiswa']], function () {
    Route::get('/mahasiswa', [mahasiswaController::class, 'dashboard'])->name('mahasiswaDashboard');
    Route::get('/mahasiswa/susulan/jadwal', [mahasiswaController::class, 'ujian'])->name('mahasiswa.susulan.jadwal');
    Route::get('/mahasiswa/susulan/pengajuan', [mahasiswaController::class, 'pengajuanIndex'])->name('mahasiswa.susulan.pengajuan.index');
    Route::get('/mahasiswa/susulan/pengajuan/tambah', [mahasiswaController::class, 'pengajuanForm'])->name('mahasiswa.susulan.pengajuan.form');
    Route::get('/mahasiswa/susulan/pengajuan/edit/{id}', [mahasiswaController::class, 'pengajuanEdit'])->name('mahasiswa.susulan.pengajuan.edit');
});