<?php

namespace App\Http\Controllers;

use App\Models\Ujian;
use Illuminate\Http\Request;
use function PHPUnit\Framework\isEmpty;

class pjOnlineController extends Controller
{
    public function dashboard(Request $request)
    {
        if (isEmpty($request)) {
            $ujian = Ujian::all();
        } else {
            $prodi = $request->prodi;
            $semester = $request->semester;
            $matkul = $request->matkul;
            $kelas = $request->kelas;
            $praktikum = $request->praktikum;
            $tanggal = $request->tanggal;
            $ruang = $request->ruang;

            $ujian = $this->filter($prodi, $semester, $matkul, $kelas, $praktikum, $tanggal, $ruang);
            $ujian->get();
        }

        return view('pj_online.dashboard', [
            "ujian" => $ujian
        ]);
    }

    public function ujian(Request $request)
    {
        if (isEmpty($request)) {
            $ujian = Ujian::where('pelaksanaan', 'like', '%Online%')->get();
        } else {
            $prodi = $request->prodi;
            $semester = $request->semester;
            $matkul = $request->matkul;
            $kelas = $request->kelas;
            $praktikum = $request->praktikum;
            $tanggal = $request->tanggal;
            $ruang = $request->ruang;
{{  }}
            $ujian = $this->filter($prodi, $semester, $matkul, $kelas, $praktikum, $tanggal, $ruang);
            $ujian->where('ujians.pelaksanaan', 'like', '%Online%')->get();
        }

        return view('pj_online.ujian', ["title" => env('APP_NAME')]);
    }

    public function pelanggaranIndex()
    {
        return view('pj_online.pelanggaran.index', ["title" => env('APP_NAME')]);
    }

    public function pelanggaranForm()
    {
        return view('pj_online.pelanggaran.form', ["title" => env('APP_NAME')]);
    }

    public function pelanggaranEdit()
    {
        return view('pj_online.pelanggaran.edit', ["title" => env('APP_NAME')]);
    }
}
