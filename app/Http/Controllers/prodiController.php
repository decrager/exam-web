<?php

namespace App\Http\Controllers;

use App\Models\Ujian;
use App\Models\Pengawas;
use App\Models\Master;
use App\Exports\UjianExport;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use function PHPUnit\Framework\isEmpty;

class prodiController extends Controller
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

        return view('prodi.dashboard', [
            "ujian" => $ujian
        ]);
    }

    public function ujianIndex(Request $request)
    {
        $dataTanggalMulai = Master::first();
        $dataTanggalSelesai = Master::first();

        $from = $dataTanggalMulai->periode_mulai;
        $to = $dataTanggalSelesai->periode_akhir;

        $ujian = Ujian::join('matkuls', 'ujians.matkul_id', 'matkuls.id')
        ->join('semesters AS a', 'matkuls.semester_id', 'a.id')
        ->join('praktikums', 'ujians.prak_id', 'praktikums.id')
        ->join('kelas', 'praktikums.kelas_id', 'kelas.id')
        ->join('semesters AS b', 'kelas.semester_id', 'b.id')
        ->join('prodis', 'b.prodi_id', 'prodis.id')
        ->join('amplops', 'amplops.ujian_id', 'ujians.id')
        ->join('baps', 'baps.ujian_id', 'ujians.id')
        ->join('berkas', 'berkas.ujian_id', 'ujians.id')
        ->selectRaw('prodis.nama_prodi, b.semester, ujians.matkul_id, matkuls.nama_matkul, ujians.tipe_mk, ujians.lokasi, ujians.perbanyak, ujians.software, count(ujians.id) AS total')
        ->groupBy('prodis.nama_prodi', 'b.semester', 'ujians.matkul_id', 'matkuls.nama_matkul', 'ujians.tipe_mk', 'ujians.lokasi', 'ujians.perbanyak', 'ujians.software')
        ->whereBetween('ujians.tanggal', [$from, $to])->get();

        return view('prodi.ujian.index', [
            "ujian" => $ujian,
        ]);
    }

    public function ujianEdit(Request $request)
    {
        return view('prodi.ujian.edit', [
            "prodi" => $request->prodi,
            "semester" => $request->semester,
            "matkul_id" => $request->matkul_id,
            "matkul" => $request->matkul,
            "tipe_mk" => $request->tipe_mk
        ]);
    }

    public function export(){
        return Excel::download(new UjianExport, 'dataujian.xlsx');
    }

    public function UjianUpdate(Request $request, $id)
    {
        $request->validate([
            'lokasi' => 'nullable',
            'software' => 'nullable',
            'perbanyak' => 'nullable'
        ]);
        
        $ujian = Ujian::where('matkul_id', $id);

        $ujian->update([
            'lokasi' => $request->lokasi,
            'software' => $request->software,
            'perbanyak' => $request->perbanyak
        ]);

        return redirect()->route('prodi.jadwal.index')->with('success', 'Detail Jadwal berhasil ditambah!');
    }

    public function pengawasList(Request $request)
    {
        $dataTanggalMulai = Master::first();
        $dataTanggalSelesai = Master::first();

        $from = $dataTanggalMulai->periode_mulai;
        $to = $dataTanggalSelesai->periode_akhir;

        if (isEmpty($request)) {
            $pengawas = Pengawas::all()->whereBetween('ujians.tanggal', [$from, $to]);
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

            $pengawas->whereBetween('ujians.tanggal', [$from, $to])->get();
        }

        return view('prodi.daftar_pengawas', [
            "pengawas" => $pengawas
        ]);
    }

    public function penugasanIndex(Request $request)
    {
        $dataTanggalMulai = Master::first();
        $dataTanggalSelesai = Master::first();

        $from = $dataTanggalMulai->periode_mulai;
        $to = $dataTanggalSelesai->periode_akhir;

        if (isEmpty($request)) {
            $ujian = Ujian::all()->whereBetween('ujians.tanggal', [$from, $to]);
        } else {
            $prodi = $request->prodi;
            $semester = $request->semester;
            $matkul = $request->matkul;
            $kelas = $request->kelas;
            $praktikum = $request->praktikum;
            $tanggal = $request->tanggal;
            $ruang = $request->ruang;

            $ujian = $this->filter($prodi, $semester, $matkul, $kelas, $praktikum, $tanggal, $ruang);
            $ujian->whereBetween('ujians.tanggal', [$from, $to])->get();
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
