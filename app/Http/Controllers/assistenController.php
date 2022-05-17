<?php

namespace App\Http\Controllers;

use App\Models\Berkas;
use App\Models\Ujian;
use Carbon\Carbon;
use Illuminate\Http\Request;
use function PHPUnit\Framework\isEmpty;

class assistenController extends Controller
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

        return view('assisten.dashboard', ["ujian" => $ujian]);
    }
    
    public function berkas(Request $request)
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

        return view('assisten.berkas', [
            "berkas" => $ujian
        ]);
    }

    public function berkasUpdate($id)
    {
        $berkas = Berkas::find($id);

        if ($berkas->asisten == 'Belum')
        {
            $berkas->update(['asisten' => 'Sudah']);
        } else {
            $berkas->update(['asisten' => 'Belum']);
        }

        return redirect()->route('assisten.berkas')->with('success', 'Status Asisten Berkas berhasil diubah!');
    }

    public function pelanggaran()
    {
        return view('assisten.pelanggaran', ["title" => env('APP_NAME')]);
    }
}
