<?php

namespace App\Http\Controllers;
use App\Models\Ujian;


use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class pengawasController extends Controller
{
    public function dashboard()
    {
        $now = "2022-06-08";
        
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

        return view('assisten.dashboard', ["dbUjian" => $ujian->get()]);
    }

    public function absensiIndex()
    {
        $nik = Auth::user()->email;
        $ujian = Ujian::join('matkuls', 'ujians.matkul_id', 'matkuls.id')
        ->join('semesters AS a', 'matkuls.semester_id', 'a.id')
        ->join('praktikums', 'ujians.prak_id', 'praktikums.id')
        ->join('kelas', 'praktikums.kelas_id', 'kelas.id')
        ->join('semesters AS b', 'kelas.semester_id', 'b.id')
        ->join('prodis', 'b.prodi_id', 'prodis.id')
        ->join('penugasans', 'ujians.id', 'penugasans.ujian_id')
        ->join('pengawas', 'penugasans.pengawas_id', 'pengawas.id')
        ->select('pengawas.*', 'penugasans.*', 'prodis.*', 'b.*', 'kelas.*', 'praktikums.*', 'matkuls.*', 'ujians.*')
        ->where('pengawas.nik', $nik)
        ->get();
        
        return view('pengawas.absensi.index', ["jadwal" => $ujian]);
    }

    public function pelanggaranIndex()
    {
        return view('pengawas.pelanggaran.index');
    }
}
