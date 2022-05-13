<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use function PHPUnit\Framework\isEmpty;

class assistenController extends Controller
{
    public function dashboard()
    {
        return view('assisten.dashboard', ["title" => env('APP_NAME')]);
    }
    
    public function berkas(Request $request)
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

        return view('assisten.berkas', [
            "title" => env('APP_NAME'),
            "berkas" => $ujian
        ]);
    }

    public function pelanggaran()
    {
        return view('assisten.pelanggaran', ["title" => env('APP_NAME')]);
    }
}
