<?php

use App\Models\Kelas;
use App\Models\Prodi;
use App\Models\Ujian;
use App\Models\Matkul;
use App\Models\Pengawas;
use App\Models\Semester;
use App\Models\Praktikum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\dataController;
use App\Http\Controllers\loginController;
use App\Http\Controllers\prodiController;
use App\Http\Controllers\berkasController;
use App\Http\Controllers\pjUjianController;
use App\Http\Controllers\assistenController;
use App\Http\Controllers\pjLabkomController;
use App\Http\Controllers\pjLokasiController;
use App\Http\Controllers\pjOnlineController;
use App\Http\Controllers\mahasiswaController;
use App\Http\Controllers\pjSusulanController;
use App\Http\Controllers\superadminController;
use App\Http\Controllers\supervisorController;
use App\Http\Controllers\pelanggaranController;
use App\Http\Controllers\pelanggaranOnlineController;

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
Route::get('/presensi/{id}', [pjLokasiController::class, 'presence'])->name('presensi');
Route::put('/presensi/update/{id}', [pjLokasiController::class, 'presenceUpdate'])->name('presensi.update');
Route::get('/hadir', [pjLokasiController::class, 'hadir'])->name('presensi.hadir');

Route::group(['middleware' => ['auth']], function () {
    Route::get('/resetPassword', [loginController::class, 'resetPassword'])->name('resetView');
    Route::post('/resetPassword', [loginController::class, 'reset'])->name('resetPassword');
    Route::post('/logout', [loginController::class, 'logout'])->name('logout');

    Route::get('getPengawas/{id}', function ($id) {
        $pengawas = Pengawas::where('id', $id)->get();
        return response()->json($pengawas);
    });

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
    Route::get('/data/ujian', [dataController::class, 'ujian'])->name('data.ujian');
    Route::get('/data/jadwal/export', [prodiController::class, 'export'])->name('data.ujian.export');
    Route::get('/data/mahasiswa', [dataController::class, 'mahasiswaIndex'])->name('data.mahasiswa.view');
    Route::get('/data/mahasiswa/tambah', [dataController::class, 'mahasiswaForm'])->name('data.mahasiswa.form');
    Route::get('/data/mahasiswa/edit/{id}', [dataController::class, 'mahasiswaEdit'])->name('data.mahasiswa.edit');
    Route::get('/data/bap', [dataController::class, 'bap'])->name('data.ketersediaan.bap');
    Route::get('/data/amplop', [dataController::class, 'amplop'])->name('data.ketersediaan.amplop');
    Route::get('/data/pengguna', [dataController::class, 'penggunaIndex'])->name('data.pengguna.index');
    Route::get('/data/pengguna/tambah', [dataController::class, 'penggunaForm'])->name('data.pengguna.form');
    Route::get('/data/pengguna/edit/{id}', [dataController::class, 'penggunaEdit'])->name('data.pengguna.edit');
    Route::get('/data/pelanggaran', [dataController::class, 'pelanggaran'])->name('data.pelanggaran');
    Route::get('/data/aktivitas', [dataController::class, 'logActivity'])->name('data.activity');

    Route::get('/data/pengawas/rekapitulasi/export', [dataController::class, 'pengawasExport'])->name('data.pengawas.recap.export');
    Route::get('/data/pengawas/rekapitulasi', [dataController::class, 'pengawasRecap'])->name('data.pengawas.recap');
    Route::get('/data/pengawas/presensi', [dataController::class, 'pengawasPresensi'])->name('data.pengawas.presensi');
    Route::get('/data/pengawas/data', [dataController::class, 'pengawasIndex'])->name('data.pengawas.data.index');
    Route::get('/data/pengawas/data/tambah', [dataController::class, 'pengawasForm'])->name('data.pengawas.data.form');
    Route::get('/data/pengawas/data/edit/{id}', [dataController::class, 'pengawasEdit'])->name('data.pengawas.data.edit');
    Route::post('/data/pengawas/data/create', [dataController::class, 'pengawasCreate'])->name('data.pengawas.data.create');
    Route::put('/data/pengawas/data/update/{id}', [dataController::class, 'pengawasUpdate'])->name('data.pengawas.data.update');
    Route::delete('/data/pengawas/data/delete/{id}', [dataController::class, 'pengawasDestroy'])->name('data.pengawas.data.delete');
    
    Route::get('/data/periode', [dataController::class, 'periodeIndex'])->name('data.periode.index');
    Route::get('/data/periode/edit/{id}', [dataController::class, 'periodeEdit'])->name('data.periode.edit');
    Route::get('/data/akademik/prodi', [dataController::class, 'prodiIndex'])->name('data.akademik.prodi.index');
    Route::get('/data/akademik/prodi/tambah', [dataController::class, 'prodiForm'])->name('data.akademik.prodi.form');
    Route::get('/data/akademik/prodi/edit/{id}', [dataController::class, 'prodiEdit'])->name('data.akademik.prodi.edit');
    Route::get('/data/akademik/semester', [dataController::class, 'semesterIndex'])->name('data.akademik.semester.index');
    Route::get('/data/akademik/semester/tambah', [dataController::class, 'semesterForm'])->name('data.akademik.semester.form');
    Route::get('/data/akademik/semester/edit/{id}', [dataController::class, 'semesterEdit'])->name('data.akademik.semester.edit');
    Route::get('/data/akademik/kelas', [dataController::class, 'kelasIndex'])->name('data.akademik.kelas.index');
    Route::get('/data/akademik/kelas/tambah', [dataController::class, 'kelasForm'])->name('data.akademik.kelas.form');
    Route::get('/data/akademik/kelas/edit/{id}', [dataController::class, 'kelasEdit'])->name('data.akademik.kelas.edit');
    Route::get('/data/akademik/praktikum', [dataController::class, 'praktikumIndex'])->name('data.akademik.praktikum.index');
    Route::get('/data/akademik/praktikum/tambah', [dataController::class, 'praktikumForm'])->name('data.akademik.praktikum.form');
    Route::get('/data/akademik/praktikum/edit/{id}', [dataController::class, 'praktikumEdit'])->name('data.akademik.praktikum.edit');
    Route::get('/data/akademik/matkul', [dataController::class, 'matkulIndex'])->name('data.akademik.matkul.index');
    Route::get('/data/akademik/matkul/tambah', [dataController::class, 'matkulForm'])->name('data.akademik.matkul.form');
    Route::get('/data/akademik/matkul/edit/{id}', [dataController::class, 'matkulEdit'])->name('data.akademik.matkul.edit');

    Route::put('/data/bap/update/{id}', [dataController::class, 'bapUpdate'])->name('data.bap.update');
    Route::put('/data/amplop/update/{id}', [dataController::class, 'amplopUpdate'])->name('data.amplop.update');
    Route::put('/data/periode/update/{id}', [dataController::class, 'periodeUpdate'])->name('data.periode.update');

    Route::post('/data/pengguna/create', [dataController::class, 'penggunaCreate'])->name('data.pengguna.create');
    Route::put('/data/pengguna/update/{id}', [dataController::class, 'penggunaUpdate'])->name('data.pengguna.update');
    Route::delete('/data/pengguna/delete/{id}', [dataController::class, 'penggunaDestroy'])->name('data.pengguna.destroy');
    Route::post('/data/mahasiswa/create', [dataController::class, 'mahasiswaCreate'])->name('data.mahasiswa.create');
    Route::put('/data/mahasiswa/update/{id}', [dataController::class, 'mahasiswaUpdate'])->name('data.mahasiswa.update');
    Route::delete('/data/mahasiswa/delete/{id}', [dataController::class, 'mahasiswaDestroy'])->name('data.mahasiswa.destroy');
    Route::post('/data/prodi/create', [dataController::class, 'prodiCreate'])->name('data.prodi.create');
    Route::put('/data/prodi/update/{id}', [dataController::class, 'prodiUpdate'])->name('data.prodi.update');
    Route::delete('/data/prodi/delete/{id}', [dataController::class, 'prodiDestroy'])->name('data.prodi.destroy');
    Route::post('/data/semester/create', [dataController::class, 'semesterCreate'])->name('data.semester.create');
    Route::put('/data/semester/update/{id}', [dataController::class, 'semesterUpdate'])->name('data.semester.update');
    Route::delete('/data/semester/delete/{id}', [dataController::class, 'semesterDestroy'])->name('data.semester.destroy');
    Route::post('/data/kelas/create', [dataController::class, 'kelasCreate'])->name('data.kelas.create');
    Route::put('/data/kelas/update/{id}', [dataController::class, 'kelasUpdate'])->name('data.kelas.update');
    Route::delete('/data/kelas/delete/{id}', [dataController::class, 'kelasDestroy'])->name('data.kelas.destroy');
    Route::post('/data/praktikum/create', [dataController::class, 'praktikumCreate'])->name('data.praktikum.create');
    Route::put('/data/praktikum/update/{id}', [dataController::class, 'praktikumUpdate'])->name('data.praktikum.update');
    Route::delete('/data/praktikum/delete/{id}', [dataController::class, 'praktikumDestroy'])->name('data.praktikum.destroy');
    Route::post('/data/matkul/create', [dataController::class, 'matkulCreate'])->name('data.matkul.create');
    Route::put('/data/matkul/update/{id}', [dataController::class, 'matkulUpdate'])->name('data.matkul.update');
    Route::delete('/data/matkul/delete/{id}', [dataController::class, 'matkulDestroy'])->name('data.matkul.destroy');

    Route::get('/data/jadwal/export', [dataController::class, 'export'])->name('data.jadwal.export');
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
    Route::get('/pj_ujian/kelengkapan/berkas', [pjUjianController::class, 'berkas'])->name('pjUjian.kelengkapan.berkas.index');
    Route::get('/pj_ujian/kelengkapan/berkas/ttd', [pjUjianController::class, 'ttd'])->name('pjUjian.kelengkapan.berkas.ttd');
    Route::get('/pj_ujian/pelanggaran', [pjUjianController::class, 'pelanggaran'])->name('pjUjian.pelanggaran');
    Route::get('/pj_ujian/susulan/mahasiswa', [pjUjianController::class, 'susulan'])->name('pjUjian.susulan.mahasiswa');
    Route::get('/pj_ujian/susulan/penjadwalan', [pjUjianController::class, 'penjadwalanIndex'])->name('pjUjian.susulan.penjadwalan.index');
    Route::get('/pj_ujian/susulan/penjadwalan/tambah', [pjUjianController::class, 'penjadwalanForm'])->name('pjUjian.susulan.penjadwalan.form');
    Route::get('/pj_ujian/susulan/susulan', [pjUjianController::class, 'susulanIndex'])->name('pjUjian.susulan.susulan.index');
    Route::get('/pj_ujian/susulan/susulan/edit/{id}', [pjUjianController::class, 'susulanEdit'])->name('pjUjian.susulan.susulan.edit');
    Route::get('/pj_ujian/aktivitas', [pjUjianController::class, 'logActivities'])->name('pjUjian.activity');

    Route::put('/pj_ujian/susulan/update/{id}', [pjUjianController::class, 'susulanUpdate'])->name('pjUjian.susulan.update');
    Route::post('/pj_ujian/pengawas/penugasan/create', [pjUjianController::class, 'penugasanCreate'])->name('pjUjian.pengawas.penugasan.create');
    Route::put('/pj_ujian/pengawas/update/{id}', [pjUjianController::class, 'pengawasUpdate'])->name('pjUjian.pengawas.update');
    Route::delete('/pj_ujian/pengawas/destroy/{id}', [pjUjianController::class, 'pengawasDestroy'])->name('pjUjian.pengawas.destroy');
    Route::put('/pj_ujian/kelengkapan/berkas/update/{id}', [pjUjianController::class, 'berkasUpdate'])->name('pjUjian.berkas.update');
    Route::post('/pj_ujian/jadwal/create', [pjUjianController::class, 'ujianCreate'])->name('pjUjian.jadwal.create');
    Route::put('/pj_ujian/jadwal/edit/update/{id}', [pjUjianController::class, 'ujianUpdate'])->name('pjUjian.jadwal.update');
    Route::delete('/pj_ujian/jadwal/destroy/{id}', [pjUjianController::class, 'ujianDestroy'])->name('pjUjian.jadwal.destroy');
    Route::post('/pj_ujian/susulan/jadwal/create', [pjUjianController::class, 'penjadwalanCreate'])->name('pjUjian.penjadwalan.create');
    Route::put('/pj_ujian/susulan/jadwal/edit/update/{id}', [pjUjianController::class, 'jadwalUpdate'])->name('pjUjian.susulan.jadwal.update');
    Route::delete('/pj_ujian/susulan/jadwal/destroy/{id}', [pjUjianController::class, 'jadwalDestroy'])->name('pjUjian.susulan.jadwal.destroy');

    Route::get('/pj_ujian/jadwal/export', [pjUjianController::class, 'export'])->name('pjUjian.jadwal.export');
});

Route::group(['middleware' => ['auth', 'cekrole:prodi']], function () {
    Route::get('/prodi', [prodiController::class, 'dashboard'])->name('prodiDashboard');
    Route::get('/prodi/ujian', [prodiController::class, 'ujianIndex'])->name('prodi.jadwal.index');
    Route::get('/prodi/ujian/edit', [prodiController::class, 'ujianEdit'])->name('prodi.jadwal.edit');
    Route::get('/prodi/pengawas/daftar', [prodiController::class, 'pengawasList'])->name('prodi.pengawas.list');
    Route::get('/prodi/pengawas/penugasan', [prodiController::class, 'penugasanIndex'])->name('prodi.pengawas.penugasan.index');
    Route::get('/prodi/pengawas/penugasan/tambah/{id}', [prodiController::class, 'penugasanForm'])->name('prodi.pengawas.penugasan.form');
    Route::get('/prodi/pengawas/penugasan/edit/{id}', [prodiController::class, 'penugasanEdit'])->name('prodi.pengawas.penugasan.edit');
    Route::get('/prodi/berkas', [prodiController::class, 'berkas'])->name('prodi.berkas');
    Route::get('/prodi/pelanggaran', [prodiController::class, 'pelanggaran'])->name('prodi.pelanggaran');
    Route::get('/prodi/jadwal', [prodiController::class, 'jadwal'])->name('prodi.jadwalUjian');

    Route::put('/prodi/jadwal/update/{id}', [prodiController::class, 'ujianUpdate'])->name('prodi.ujian.update');
    Route::put('/prodi/berkas/update/{id}', [prodiController::class, 'berkasUpdate'])->name('prodi.berkas.update');
    Route::put('/prodi/kalibrasi/update/{id}', [prodiController::class, 'kalibrasi'])->name('prodi.kalibrasi.update');
    Route::post('/prodi/pengawas/create', [prodiController::class, 'pengawasCreate'])->name('prodi.pengawas.create');
    Route::put('/prodi/pengawas/update/{id}', [prodiController::class, 'pengawasUpdate'])->name('prodi.pengawas.update');
    Route::delete('/prodi/pengawas/destroy/{id}', [prodiController::class, 'pengawasDestroy'])->name('prodi.pengawas.destroy');

    Route::get('/prodi/jadwal/export', [prodiController::class, 'export'])->name('prodi.jadwal.export');
});

Route::group(['middleware' => ['auth', 'cekrole:pj_lokasi']], function () {
    Route::get('/pj_lokasi', [pjLokasiController::class, 'dashboard'])->name('pjLokasiDashboard');
    Route::get('/pj_lokasi/pengawas', [pjLokasiController::class, 'pengawasIndex'])->name('pjLokasi.pengawas.daftar.index');
    Route::get('/pj_lokasi/pengawas/edit/{id}', [pjLokasiController::class, 'pengawasEdit'])->name('pjLokasi.pengawas.daftar.edit');
    Route::get('/pj_lokasi/pengawas/kehadiran', [pjLokasiController::class, 'absensiIndex'])->name('pjLokasi.pengawas.absensi.index');
    Route::get('/pj_lokasi/pengawas/kehadiran/ttd/{id}', [pjLokasiController::class, 'absensiForm'])->name('pjLokasi.pengawas.absensi.form');
    Route::get('/pj_lokasi/soal', [pjLokasiController::class, 'soalIndex'])->name('pjLokasi.soal.index');
    Route::get('/pj_lokasi/soal/ttd', [pjLokasiController::class, 'soalForm'])->name('pjLokasi.soal.form');
    Route::resource('/pj_lokasi/pelanggaran', pelanggaranController::class);
    Route::get('/pj_lokasi/pelanggaran/tambah', [pjLokasiController::class, 'pelanggaranForm'])->name('pjLokasi.pelanggaran.form');
    Route::get('/pj_lokasi/pelanggaran/edit/{id}', [pjLokasiController::class, 'pelanggaranEdit'])->name('pjLokasi.pelanggaran.edit');
    Route::put('/pj_lokasi/pengawas/update/{id}', [pjLokasiController::class, 'pengawasUpdate'])->name('pjLokasi.pengawas.update');
    Route::delete('/pj_lokasi/pengawas/delete/{id}', [pjLokasiController::class, 'presenceDestroy'])->name('pjLokasi.pengawas.destroy');
    
    Route::get('/pj_lokasi/presensi/export', [pjLokasiController::class, 'pdf'])->name('pjLokasi.pdf');
});

Route::group(['middleware' => ['auth', 'cekrole:berkas']], function () {
    Route::get('/berkas', [berkasController::class, 'dashboard'])->name('berkasDashboard');
    Route::get('/berkas/soal', [berkasController::class, 'soal'])->name('berkas.soal');
    Route::get('/berkas/kelengkapan/amplop', [berkasController::class, 'amplop'])->name('berkas.kelengkapan.amplop');
    Route::get('/berkas/kelengkapan/bap', [berkasController::class, 'bap'])->name('berkas.kelengkapan.bap');
    Route::get('/berkas/kelengkapan/berkas', [berkasController::class, 'berkas'])->name('berkas.kelengkapan.berkas.index');
    Route::get('/berkas/kelengkapan/berkas/ttd', [berkasController::class, 'ttd'])->name('berkas.kelengkapan.berkas.ttd');
    Route::get('/berkas/pelanggaran', [berkasController::class, 'pelanggaran'])->name('berkas.pelanggaran');

    Route::put('/berkas/amplop/{id}', [berkasController::class, 'amplopUpdate'])->name('berkas.amplop.update');
    Route::put('/berkas/bap/{id}', [berkasController::class, 'bapUpdate'])->name('berkas.bap.update');
    Route::put('/berkas/amplop/fotokopi/{id}', [berkasController::class, 'berkasFotokopi'])->name('berkas.fotokopi.update');
    Route::put('/berkas/amplop/lengkap/{id}', [berkasController::class, 'berkasLengkap'])->name('berkas.lengkap.update');
    Route::put('/berkas/amplop/serah_terima/{id}', [berkasController::class, 'berkasSerahTerima'])->name('berkas.serahterima.update');
});

Route::group(['middleware' => ['auth', 'cekrole:assisten']], function () {
    Route::get('/assisten', [assistenController::class, 'dashboard'])->name('assistenDashboard');
    Route::get('/assisten/berkas', [assistenController::class, 'berkas'])->name('assisten.berkas');
    Route::get('/assisten/pelanggaran', [assistenController::class, 'pelanggaran'])->name('assisten.pelanggaran');

    Route::put('/assisten/berkas/{id}', [assistenController::class, 'berkasUpdate'])->name('assisten.berkas.update');
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

    Route::post('/pj_susulan/ketentuan/create', [pjSusulanController::class, 'ketentuanCreate'])->name('pjSusulan.ketentuan.create');
    Route::put('/pj_susulan/ketentuan/update/{id}', [pjSusulanController::class, 'ketentuanUpdate'])->name('pjSusulan.ketentuan.update');
    Route::delete('/pj_susulan/ketentuan/delete/{id}', [pjSusulanController::class, 'ketentuanDestroy'])->name('pjSusulan.ketentuan.delete');
    Route::put('/pj_susulan/mahasiswa/update/{id}', [pjSusulanController::class, 'mahasiswaUpdate'])->name('pjSusulan.mahasiswa.update');
    Route::post('/pj_susulan/jadwal/create', [pjSusulanController::class, 'jadwalCreate'])->name('pjSusulan.jadwal.create');
    Route::put('/pj_susulan/jadwal/update/{id}', [pjSusulanController::class, 'jadwalUpdate'])->name('pjSusulan.jadwal.update');
    Route::delete('/pj_susulan/jadwal/delete/{id}', [pjSusulanController::class, 'jadwalDestroy'])->name('pjSusulan.jadwal.destroy');
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
    Route::resource('/pj_online/pelanggaran', pelanggaranOnlineController::class);
});

Route::group(['middleware' => ['auth', 'cekrole:mahasiswa']], function () {
    Route::get('/mahasiswa', [mahasiswaController::class, 'dashboard'])->name('mahasiswaDashboard');
    Route::get('/mahasiswa/susulan/jadwal', [mahasiswaController::class, 'ujian'])->name('mahasiswa.susulan.jadwal');
    Route::get('/mahasiswa/susulan/pengajuan', [mahasiswaController::class, 'pengajuanIndex'])->name('mahasiswa.susulan.pengajuan.index');
    Route::get('/mahasiswa/susulan/pengajuan/tambah', [mahasiswaController::class, 'pengajuanForm'])->name('mahasiswa.susulan.pengajuan.form');
    Route::get('/mahasiswa/susulan/pengajuan/edit/{id}', [mahasiswaController::class, 'pengajuanEdit'])->name('mahasiswa.susulan.pengajuan.edit');
    
    Route::post('/mahasiswa/susulan/create', [mahasiswaController::class, 'pengajuanCreate'])->name('mahasiswa.susulan.create');
    Route::put('/mahasiswa/susulan/update/{id}', [mahasiswaController::class, 'pengajuanUpdate'])->name('mahasiswa.susulan.update');
    Route::delete('/mahasiswa/susulan/delete/{id}', [mahasiswaController::class, 'pengajuanDestroy'])->name('mahasiswa.susulan.delete');
});

Route::group(['middleware' => ['auth', 'cekrole:pj_labkom']], function () {
    Route::get('/pj_labkom', [pjLabkomController::class, 'dashboard'])->name('pjLabkomDashboard');
    Route::get('/pj_labkom/ujian', [pjLabkomController::class, 'ujian'])->name('pjLabkom.ujian');
});

Route::group(['middleware' => ['auth', 'cekrole:superadmin']], function () {
    Route::get('/superadmin', [superadminController::class, 'dashboard'])->name('superadminDashboard');
});