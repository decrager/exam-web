<?php

namespace App\Http\Controllers;

use App\Models\Ketentuan;
use App\Models\Ujian;
use Illuminate\Http\Request;
use function PHPUnit\Framework\isEmpty;

class pjSusulanController extends Controller
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

        return view('pj_susulan.dashboard', [
            "title" => env('APP_NAME'),
            "ujian" => $ujian
        ]);
    }

    public function ketentuanIndex()
    {
        $ketentuan = Ketentuan::all();

        return view('pj_susulan.ketentuan.index', [
            "title" => env('APP_NAME'),
            "ketentuan" => $ketentuan
        ]);
    }

    public function ketentuanForm()
    {
        return view('pj_susulan.ketentuan.form', ["title" => env('APP_NAME')]);
    }

    public function ketentuanEdit()
    {
        return view('pj_susulan.ketentuan.edit', ["title" => env('APP_NAME')]);
    }
    
    public function mahasiswaIndex()
    {
        return view('pj_susulan.mahasiswa', ["title" => env('APP_NAME')]);
    }

    public function penjadwalanIndex()
    {
        return view('pj_susulan.penjadwalan.index', ["title" => env('APP_NAME')]);
    }

    public function penjadwalanForm()
    {
        return view('pj_susulan.penjadwalan.form', ["title" => env('APP_NAME')]);
    }

    public function jadwalIndex()
    {
        return view('pj_susulan.jadwal.index', ["title" => env('APP_NAME')]);
    }

    public function jadwalEdit()
    {
        return view('pj_susulan.jadwal.edit', ["title" => env('APP_NAME')]);
    }

    public function pelanggaran()
    {
        return view('pj_susulan.pelanggaran', ["title" => env('APP_NAME')]);
    }
}
