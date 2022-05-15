<?php

namespace App\Http\Controllers;

use App\Models\Ujian;
use App\Models\Pengawas;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use function PHPUnit\Framework\isEmpty;

class prodiController extends Controller
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

        return view('prodi.dashboard', [
            "ujian" => $ujian
        ]);
    }

    public function ujianIndex(Request $request)
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

        return view('prodi.ujian.index', [
            "ujian" => $ujian,
        ]);
    }

    public function ujianEdit($id)
    {
        return view('prodi.ujian.edit', [
            "ujian" => Ujian::find($id)
        ]);
    }

    public function UjianUpdate(Request $request, $id)
    {
        $request->validate([
            'lokasi' => 'nullable',
            'ruang' => 'nullable',
            'software' => 'nullable',
            'perbanyak' => 'nullable'
        ]);
        
        $ujian = Ujian::find($id);
        // $ujian['prak_id'] = $request->praktikum;
        $ujian->update([
            'lokasi' => $request->lokasi,
            'ruang' => $request->ruang,
            'software' => $request->software,
            'perbanyak' => $request->perbanyak
        ]);

        return redirect()->route('prodi.jadwal.index')->with('success', 'Jadwal berhasil diubah!');
    }

    public function pengawasList(Request $request)
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

        return view('prodi.daftar_pengawas', [
            "pengawas" => $pengawas
        ]);
    }

    public function penugasanIndex(Request $request)
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

        return view('prodi.penugasan.index', [
            "ujian" => $ujian
        ]);
    }

    public function penugasanForm($id)
    {
        return view('prodi.penugasan.form', [
            "ujian" => Ujian::find($id)
        ]);
    }

    public function penugasanEdit($id)
    {
        return view('prodi.penugasan.edit', [
            "pengawas" => Pengawas::find($id)
        ]);
    }

    public function pengawasCreate(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'pns' => 'required',
            'ujian_id' => 'required'
        ]);

        Pengawas::create($request->all());

        return redirect()->route('prodi.pengawas.penugasan.index')->with('success', 'Pengawas berhasil ditambahkan!');
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
            'pns' => $request->pns
        ]);

        return redirect()->route('prodi.pengawas.list')->with('success', 'Pengawas sudah diperbarui!');
    }

    public function pengawasDestroy($id)
    {
        Pengawas::find($id)->delete();
        return redirect()->route('prodi.pengawas.list')->with('success', 'Pengawas sudah dihapus!');
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

        return view('prodi.berkas', [
            "berkas" => $ujian
        ]);
    }

    public function pelanggaran()
    {
        return view('prodi.pelanggaran', ["title" => env('APP_NAME')]);
    }
}
