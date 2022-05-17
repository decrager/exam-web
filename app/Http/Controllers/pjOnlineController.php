<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Ujian;
use App\Models\Master;
use Illuminate\Http\Request;
use function PHPUnit\Framework\isEmpty;

class pjOnlineController extends Controller
{
    public function dashboard(Request $request)
    {
        $now = Carbon::now()->toDateString();

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
        $dataTanggalMulai = Master::first();
        $dataTanggalSelesai = Master::first();

        $from = $dataTanggalMulai->periode_mulai;
        $to = $dataTanggalSelesai->periode_akhir;

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
            
            $ujian = $this->filter($prodi, $semester, $matkul, $kelas, $praktikum, $tanggal, $ruang);
            $ujian->where('ujians.pelaksanaan', 'like', '%Online%')->whereBetween('ujians.tanggal', [$from, $to])->get();
        }

        return view('pj_online.ujian', [
            'ujian' => $ujian,
            'ujians' => $ujian
        ]);
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
