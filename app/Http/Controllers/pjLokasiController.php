<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Ujian;
use App\Models\Pengawas;
use App\Models\Master;
use Illuminate\Http\Request;
use function PHPUnit\Framework\isEmpty;

class pjLokasiController extends Controller
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
        
        return view('pj_lokasi.dashboard', [
            "ujian" => $ujian
        ]);
    }

    public function pengawasIndex(Request $request)
    {
        if (isEmpty($request)) {
            $pengawas = Pengawas::all();
        } else {
            $pengawas = Ujian::join('ujians', 'pengawas.ujian_id', '=', 'ujians.id')
                ->join('matkuls', 'ujians.matkul_id', '=', 'matkuls.id')
                ->join('semesters AS a', 'matkuls.semester_id', '=', 'a.id')
                ->join('praktikums', 'ujians.prak_id', '=', 'praktikums.id')
                ->join('kelas', 'praktikums.kelas_id', '=', 'kelas.id')
                ->join('semesters AS b', 'kelas.semester_id', '=', 'b.id')
                ->join('prodis', 'b.prodi_id', '=', 'prodis.id');

            if ($request->prodi) {
                $pengawas->where('prodis.nama_prodi', 'like', '%' . $request->prodi . '%');
                if ($request->semester) {
                    $pengawas->where('b.semester', 'like', '%' . $request->semester . '%');
                    if ($request->kelas) {
                        $pengawas->where('kelas.kelas', 'like', '%' . $request->kelas . '%');
                        if ($request->praktikum) {
                            $pengawas->where('praktikums.praktikum', 'like', '%' . $request->praktikum . '%');
                        }
                    }
                    if ($request->matkul) {
                        $pengawas->where('matkuls.nama_matkul', 'like', '%' . $request->matkul . '%');
                    }
                }
            }

            if ($request->tanggal) {
                $pengawas->where('tanggal', 'like', '%' . $request->tanggal . '%');
            }

            if ($request->ruang) {
                $pengawas->where('ruang', 'like', '%' . $request->ruang . '%');
            }

            $pengawas->get();
        }

        return view('pj_lokasi.pengawas.index', [
            "pengawas" => $pengawas
        ]);
    }

    public function pengawasEdit($id)
    {
        $pengawas = Pengawas::find($id);

        return view('pj_lokasi.pengawas.edit', [
            "pengawas" => $pengawas
        ]);
    }

    public function pengawasUpdate(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required',
            'pns' => 'required'
        ]);

        $pengawas = Pengawas::find($id);

        $pengawas->update([
            'nama' => $request->nama,
            'pns' => $request->pns,
        ]);
        
        return redirect()->route('pjLokasi.pengawas.daftar.index')->with('success', 'Data Pengawas berhasil diperbarui!');
    }

    public function absensiIndex(Request $request)
    {
        if (isEmpty($request)) {
            $pengawas = Pengawas::all();
        } else {
            $pengawas = Ujian::join('ujians', 'pengawas.ujian_id', '=', 'ujians.id')
                ->join('matkuls', 'ujians.matkul_id', '=', 'matkuls.id')
                ->join('semesters AS a', 'matkuls.semester_id', '=', 'a.id')
                ->join('praktikums', 'ujians.prak_id', '=', 'praktikums.id')
                ->join('kelas', 'praktikums.kelas_id', '=', 'kelas.id')
                ->join('semesters AS b', 'kelas.semester_id', '=', 'b.id')
                ->join('prodis', 'b.prodi_id', '=', 'prodis.id');

            if ($request->prodi) {
                $pengawas->where('prodis.nama_prodi', 'like', '%' . $request->prodi . '%');
                if ($request->semester) {
                    $pengawas->where('b.semester', 'like', '%' . $request->semester . '%');
                    if ($request->kelas) {
                        $pengawas->where('kelas.kelas', 'like', '%' . $request->kelas . '%');
                        if ($request->praktikum) {
                            $pengawas->where('praktikums.praktikum', 'like', '%' . $request->praktikum . '%');
                        }
                    }
                    if ($request->matkul) {
                        $pengawas->where('matkuls.nama_matkul', 'like', '%' . $request->matkul . '%');
                    }
                }
            }

            if ($request->tanggal) {
                $pengawas->where('tanggal', 'like', '%' . $request->tanggal . '%');
            }

            if ($request->ruang) {
                $pengawas->where('ruang', 'like', '%' . $request->ruang . '%');
            }

            $pengawas->get();
        }

        return view('pj_lokasi.absensi.index', [
            "absensi" => $pengawas
        ]);
    }

    public function absensiForm($id)
    {
        $pengawas = Pengawas::find($id);

        return view('pj_lokasi.absensi.form', [
            "pengawas" => $pengawas
        ]);
    }

    public function soalIndex(Request $request)
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

        return view('pj_lokasi.soal.index', [
            "berkas" => $ujian
        ]);
    }

    public function soalForm()
    {
        $tglbln = Carbon::now()->format('d F, Y');
        return view('pj_lokasi.soal.form', [
            'master' => Master::find(1),
            'tglbln' => $tglbln
        ]);
    }

    public function pelanggaranIndex()
    {
        return view('pj_lokasi.pelanggaran.index', ["title" => env('APP_NAME')]);
    }

    public function pelanggaranForm()
    {
        return view('pj_lokasi.pelanggaran.form', ["title" => env('APP_NAME')]);
    }

    public function pelanggaranEdit()
    {
        return view('pj_lokasi.pelanggaran.edit', ["title" => env('APP_NAME')]);
    }
}
