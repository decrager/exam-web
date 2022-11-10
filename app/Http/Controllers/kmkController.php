<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Ujian;
use App\Models\Kehadiran;
use Illuminate\Http\Request;

class kmkController extends Controller
{
    public function dashboard()
    {
        $now = Carbon::now()->toDateString();
        
        $ujian = Ujian::join('matkuls', 'ujians.matkul_id', '=', 'matkuls.id')
        ->join('semesters AS a', 'matkuls.semester_id', '=', 'a.id')
        ->join('praktikums', 'ujians.prak_id', '=', 'praktikums.id')
        ->join('kelas', 'praktikums.kelas_id', '=', 'kelas.id')
        ->join('semesters AS b', 'kelas.semester_id', '=', 'b.id')
        ->join('prodis', 'b.prodi_id', '=', 'prodis.id')
        ->join('amplops', 'amplops.ujian_id', '=', 'ujians.id')
        ->join('baps', 'baps.ujian_id', '=', 'ujians.id')
        ->join('berkas', 'berkas.ujian_id', '=', 'ujians.id');
        
        if (request(['dbProdi', 'dbSemester', 'dbPraktikum', 'dbKelas', 'dbMatkul', 'dbRuang'])) {
            $ujian->filter(request(['dbProdi', 'dbSemester', 'dbPraktikum', 'dbKelas', 'dbMatkul', 'dbRuang']));
        }

        if (request(['dbTanggal'])) {
            $ujian->filter(request(['dbTanggal']));
        } else {
            $ujian->where('ujians.tanggal', $now);
        }

        return view('kmk.dashboard', [
            "dbUjian" => $ujian->get()
        ]);
    }

    public function ketidakhadiran()
    {
        return view('kmk.pelanggaran');
    }

    public function kehadiran()
    {
        $ujian = Kehadiran::join('mahasiswas', 'kehadirans.mhs_id', 'mahasiswas.id')
        ->join('ujians', 'kehadirans.ujian_id', 'ujians.id')
        ->join('matkuls', 'ujians.matkul_id', 'matkuls.id')
        ->join('baps', 'ujians.id', 'baps.ujian_id')
        ->join('praktikums', 'ujians.prak_id', 'praktikums.id')
        ->join('kelas', 'praktikums.kelas_id', 'kelas.id')
        ->join('semesters', 'kelas.semester_id', 'semesters.id')
        ->join('prodis', 'semesters.prodi_id', 'prodis.id')
        ->groupBy('ujians.tanggal', 'prodis.nama_prodi','semesters.semester', 'kelas.kelas', 'praktikums.praktikum', 'matkuls.nama_matkul', 'baps.kehadiran')
        ->selectRaw('ujians.tanggal, prodis.nama_prodi, semesters.semester, kelas.kelas, praktikums.praktikum, matkuls.nama_matkul, baps.kehadiran, count(mahasiswas.nim) AS total')
        ->where('kehadirans.kehadiran', 'Hadir')
        ->get();

        $absen = Kehadiran::join('mahasiswas', 'kehadirans.mhs_id', 'mahasiswas.id')
        ->join('ujians', 'kehadirans.ujian_id', 'ujians.id')
        ->join('matkuls', 'ujians.matkul_id', 'matkuls.id')
        ->join('praktikums', 'ujians.prak_id', 'praktikums.id')
        ->join('kelas', 'praktikums.kelas_id', 'kelas.id')
        ->join('semesters', 'kelas.semester_id', 'semesters.id')
        ->join('prodis', 'semesters.prodi_id', 'prodis.id')
        ->groupBy('ujians.tanggal', 'prodis.nama_prodi','semesters.semester', 'kelas.kelas', 'praktikums.praktikum', 'matkuls.nama_matkul')
        ->selectRaw('ujians.tanggal, prodis.nama_prodi, semesters.semester, kelas.kelas, praktikums.praktikum, matkuls.nama_matkul, count(mahasiswas.nim) AS total')
        ->where('kehadirans.kehadiran', 'Tidak Hadir')
        ->get();

        return view('kmk.kehadiran', [
            'kehadiran' => $ujian,
            'absen' => $absen
        ]);
    }
}
