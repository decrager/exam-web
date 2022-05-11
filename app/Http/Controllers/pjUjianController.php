<?php

namespace App\Http\Controllers;

use App\Models\Prodi;
use Illuminate\Http\Request;
use App\Models\Ujian;

class pjUjianController extends Controller
{
    public function dashboard(Request $request)
    {
        // $ujian = Ujian::join('matkuls', 'ujians.matkul_id', '=', 'matkuls.id')
        //         ->join('semesters AS a', 'matkuls.semester_id', '=', 'a.id')
        //         ->join('praktikums', 'ujians.prak_id', '=', 'praktikums.id')
        //         ->join('kelas', 'praktikums.kelas_id', '=', 'kelas.id')
        //         ->join('semesters AS b', 'kelas.semester_id', '=', 'b.id')
        //         ->join('prodis', 'b.prodi_id', '=', 'prodis.id');

        // if ($request->dbProdi)
        // {
        //     $ujian->where('prodis.nama_prodi', 'like', '%' . $request->dbProdi . '%');
        //     if ($request->dbSemester){
        //         $ujian->where('b.semester', 'like', '%' . $request->dbSemester . '%');
        //         if ($request->dbKelas) {
        //             $ujian->where('kelas.kelas', 'like', '%' . $request->dbKelas . '%');
        //             if ($request->dbPraktikum) {
        //                 $ujian->where('praktikums.praktikum', 'like', '%' . $request->dbPraktikum . '%');
        //             }
        //         }
        //         if ($request->dbMatkul) {
        //             $ujian->where('matkuls.nama_matkul', 'like', '%' . $request->dbMatkul . '%');
        //         }
        //     }
        // }

        // if ($request->dbTanggal) {
        //     $ujian->where('tanggal', 'like', '%' . $request->dbTanggal . '%');
        // }

        // if ($request->dbRuang) {
        //     $ujian->where('ruang', 'like', '%' . $request->dbRuang . '%');
        // }

        // $ujian->get();

        return view('pj_ujian.dashboard', [
            "title" => env('APP_NAME'),
            // "dbUjian" => $ujian
        ]);
    }

    public function ujianIndex()
    {
        return view('pj_ujian.ujian.index', ["title" => env('APP_NAME')]);
    }

    public function ujianForm()
    {
        return view('pj_ujian.ujian.form', ["title" => env('APP_NAME')]);
    }

    public function ujianEdit()
    {
        return view('pj_ujian.ujian.edit', ["title" => env('APP_NAME')]);
    }

    public function pengawasIndex()
    {
        return view('pj_ujian.pengawas.index', ["title" => env('APP_NAME')]);
    }

    public function pengawasEdit()
    {
        return view('pj_ujian.pengawas.edit', ["title" => env('APP_NAME')]);
    }

    public function penugasanIndex()
    {
        return view('pj_ujian.penugasan.index', ["title" => env('APP_NAME')]);
    }

    public function penugasanForm()
    {
        return view('pj_ujian.penugasan.form', ["title" => env('APP_NAME')]);
    }

    public function amplop()
    {
        return view('pj_ujian.amplop', ["title" => env('APP_NAME')]);
    }

    public function bap()
    {
        return view('pj_ujian.bap', ["title" => env('APP_NAME')]);
    }

    public function berkas()
    {
        return view('pj_ujian.berkas', ["title" => env('APP_NAME')]);
    }

    public function susulan()
    {
        return view('pj_ujian.susulan', ["title" => env('APP_NAME')]);
    }

    public function pelanggaran()
    {
        return view('pj_ujian.pelanggaran', ["title" => env('APP_NAME')]);
    }
}
