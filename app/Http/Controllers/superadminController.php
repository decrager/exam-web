<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Ujian;
use Illuminate\Http\Request;
use function PHPUnit\Framework\isEmpty;

class superadminController extends Controller
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
            $ujian = $ujian->get();
        }

        return view('pj_labkom.dashboard', [
            "dbUjian" => $ujian
        ]);
    }
}
