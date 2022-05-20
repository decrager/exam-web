<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Ujian;
use App\Models\Pengawas;
use App\Models\Master;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use function PHPUnit\Framework\isEmpty;

class pjLokasiController extends Controller
{
    public function dashboard(Request $request)
    {
        $now = Carbon::now()->toDateString();
        
        if (isEmpty($request)) {
            $ujian = Ujian::join('matkuls', 'ujians.matkul_id', '=', 'matkuls.id')
            ->join('semesters AS a', 'matkuls.semester_id', '=', 'a.id')
            ->join('praktikums', 'ujians.prak_id', '=', 'praktikums.id')
            ->join('kelas', 'praktikums.kelas_id', '=', 'kelas.id')
            ->join('semesters AS b', 'kelas.semester_id', '=', 'b.id')
            ->join('prodis', 'b.prodi_id', '=', 'prodis.id')
            ->join('amplops', 'amplops.ujian_id', '=', 'ujians.id')
            ->join('baps', 'baps.ujian_id', '=', 'ujians.id')
            ->join('berkas', 'berkas.ujian_id', '=', 'ujians.id');

        } else {
            $prodi = $request->prodi;
            $semester = $request->semester;
            $matkul = $request->matkul;
            $kelas = $request->kelas;
            $praktikum = $request->praktikum;
            $tanggal = $request->tanggal;
            $ruang = $request->ruang;

            $ujian = $this->filter($prodi, $semester, $matkul, $kelas, $praktikum, $tanggal, $ruang);
        }

        if (Auth::user()->lokasi == 'CA & Lab Kom') {
            $ujian->where('ujians.ruang', 'CA B01')
            ->orWhere('ujians.ruang', 'CA B02')
            ->orWhere('ujians.ruang', 'CA B03')
            ->orWhere('ujians.ruang', 'CA B04')
            ->orWhere('ujians.ruang', 'CA B05')
            ->orWhere('ujians.ruang', 'CA B06')
            ->orWhere('ujians.ruang', 'CA B07')
            ->orWhere('ujians.ruang', 'CA B08')
            ->orWhere('ujians.ruang', 'CA KOM 1')
            ->orWhere('ujians.ruang', 'CA KOM 2');
        } elseif (Auth::user()->lokasi == 'CB & Lab Kom') {
            $ujian->where('ujians.ruang', 'CB B01')
            ->orWhere('ujians.ruang', 'CB B02')
            ->orWhere('ujians.ruang', 'CB B03')
            ->orWhere('ujians.ruang', 'CB B04')
            ->orWhere('ujians.ruang', 'CB KOM 1')
            ->orWhere('ujians.ruang', 'CB KOM 2')
            ->orWhere('ujians.ruang', 'CB KOM 3')
            ->orWhere('ujians.ruang', 'CB KOM 4')
            ->orWhere('ujians.ruang', 'CB KOM 5')
            ->orWhere('ujians.ruang', 'CB PEMROGRAMAN')
            ->orWhere('ujians.ruang', 'CB K 70-1');
        } elseif (Auth::user()->lokasi == 'BS B01-06') {
            $ujian->where('ujians.ruang', 'BS B01')
            ->orWhere('ujians.ruang', 'BS B02')
            ->orWhere('ujians.ruang', 'BS B03')
            ->orWhere('ujians.ruang', 'BS B04')
            ->orWhere('ujians.ruang', 'BS B05')
            ->orWhere('ujians.ruang', 'BS B06');
        } elseif (Auth::user()->lokasi == 'BS B07-10') {
            $ujian->where('ujians.ruang', 'BS B07')
            ->orWhere('ujians.ruang', 'BS B08')
            ->orWhere('ujians.ruang', 'BS B09')
            ->orWhere('ujians.ruang', 'BS B10');
        } elseif (Auth::user()->lokasi == 'BS KIMBOTFIS') {
            $ujian->where('ujians.ruang', 'BS KIMIA')
            ->orWhere('ujians.ruang', 'BS BOTANI')
            ->orWhere('ujians.ruang', 'BS FISIKA');
        } elseif (Auth::user()->lokasi == 'BS P01-03') {
            $ujian->where('ujians.ruang', 'BS P01')
            ->orWhere('ujians.ruang', 'BS P02')
            ->orWhere('ujians.ruang', 'BS P03');
        } elseif (Auth::user()->lokasi == 'Sukabumi') {
            $ujian->where('ujians.ruang', 'GAK 01')
            ->orWhere('ujians.ruang', 'GAK 02')
            ->orWhere('ujians.ruang', 'GAK 03')
            ->orWhere('ujians.ruang', 'GAK 04')
            ->orWhere('ujians.ruang', 'GAK 05')
            ->orWhere('ujians.ruang', 'GAK 06')
            ->orWhere('ujians.ruang', 'GAK 07')
            ->orWhere('ujians.ruang', 'Lab SKBMI');
        } elseif (Auth::user()->lokasi == 'Online') {
            $ujian->where('ujians.ruang', 'Online');
        }
        
        return view('pj_lokasi.dashboard', [
            "dbUjian" => $ujian->get()
        ]);
    }

    public function pengawasIndex(Request $request)
    {
        $dataTanggalMulai = Master::first();
        $dataTanggalSelesai = Master::first();

        $from = $dataTanggalMulai->periode_mulai;
        $to = $dataTanggalSelesai->periode_akhir;
        
        if (isEmpty($request)) {
            $pengawas = Pengawas::join('ujians', 'pengawas.ujian_id', '=', 'ujians.id')
            ->join('matkuls', 'ujians.matkul_id', '=', 'matkuls.id')
            ->join('semesters AS a', 'matkuls.semester_id', '=', 'a.id')
            ->join('praktikums', 'ujians.prak_id', '=', 'praktikums.id')
            ->join('kelas', 'praktikums.kelas_id', '=', 'kelas.id')
            ->join('semesters AS b', 'kelas.semester_id', '=', 'b.id')
            ->join('prodis', 'b.prodi_id', '=', 'prodis.id')
            ->whereBetween('ujians.tanggal', [$from, $to]);
        } else {
            $pengawas = Pengawas::join('ujians', 'pengawas.ujian_id', '=', 'ujians.id')
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
        }

        if (Auth::user()->lokasi == 'CA & Lab Kom') {
            $pengawas->where('ujians.ruang', 'CA B01')
            ->orWhere('ujians.ruang', 'CA B02')
            ->orWhere('ujians.ruang', 'CA B03')
            ->orWhere('ujians.ruang', 'CA B04')
            ->orWhere('ujians.ruang', 'CA B05')
            ->orWhere('ujians.ruang', 'CA B06')
            ->orWhere('ujians.ruang', 'CA B07')
            ->orWhere('ujians.ruang', 'CA B08')
            ->orWhere('ujians.ruang', 'CA KOM 1')
            ->orWhere('ujians.ruang', 'CA KOM 2');
        } elseif (Auth::user()->lokasi == 'CB & Lab Kom') {
            $pengawas->where('ujians.ruang', 'CB B01')
            ->orWhere('ujians.ruang', 'CB B02')
            ->orWhere('ujians.ruang', 'CB B03')
            ->orWhere('ujians.ruang', 'CB B04')
            ->orWhere('ujians.ruang', 'CB KOM 1')
            ->orWhere('ujians.ruang', 'CB KOM 2')
            ->orWhere('ujians.ruang', 'CB KOM 3')
            ->orWhere('ujians.ruang', 'CB KOM 4')
            ->orWhere('ujians.ruang', 'CB KOM 5')
            ->orWhere('ujians.ruang', 'CB PEMROGRAMAN')
            ->orWhere('ujians.ruang', 'CB K 70-1');
        } elseif (Auth::user()->lokasi == 'BS B01-06') {
            $pengawas->where('ujians.ruang', 'BS B01')
            ->orWhere('ujians.ruang', 'BS B02')
            ->orWhere('ujians.ruang', 'BS B03')
            ->orWhere('ujians.ruang', 'BS B04')
            ->orWhere('ujians.ruang', 'BS B05')
            ->orWhere('ujians.ruang', 'BS B06');
        } elseif (Auth::user()->lokasi == 'BS B07-10') {
            $pengawas->where('ujians.ruang', 'BS B07')
            ->orWhere('ujians.ruang', 'BS B08')
            ->orWhere('ujians.ruang', 'BS B09')
            ->orWhere('ujians.ruang', 'BS B10');
        } elseif (Auth::user()->lokasi == 'BS KIMBOTFIS') {
            $pengawas->where('ujians.ruang', 'BS KIMIA')
            ->orWhere('ujians.ruang', 'BS BOTANI')
            ->orWhere('ujians.ruang', 'BS FISIKA');
        } elseif (Auth::user()->lokasi == 'BS P01-03') {
            $pengawas->where('ujians.ruang', 'BS P01')
            ->orWhere('ujians.ruang', 'BS P02')
            ->orWhere('ujians.ruang', 'BS P03');
        } elseif (Auth::user()->lokasi == 'Sukabumi') {
            $pengawas->where('ujians.ruang', 'GAK 01')
            ->orWhere('ujians.ruang', 'GAK 02')
            ->orWhere('ujians.ruang', 'GAK 03')
            ->orWhere('ujians.ruang', 'GAK 04')
            ->orWhere('ujians.ruang', 'GAK 05')
            ->orWhere('ujians.ruang', 'GAK 06')
            ->orWhere('ujians.ruang', 'GAK 07')
            ->orWhere('ujians.ruang', 'Lab SKBMI');
        } elseif (Auth::user()->lokasi == 'Online') {
            $pengawas->where('ujians.ruang', 'Online');
        }
        
        $pengawas = $pengawas->get();

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
        $now = Carbon::now()->toDateString();
        if (isEmpty($request)) {
            $pengawas = Pengawas::join('ujians', 'pengawas.ujian_id', '=', 'ujians.id')
            ->join('matkuls', 'ujians.matkul_id', '=', 'matkuls.id')
            ->join('semesters AS a', 'matkuls.semester_id', '=', 'a.id')
            ->join('praktikums', 'ujians.prak_id', '=', 'praktikums.id')
            ->join('kelas', 'praktikums.kelas_id', '=', 'kelas.id')
            ->join('semesters AS b', 'kelas.semester_id', '=', 'b.id')
            ->join('prodis', 'b.prodi_id', '=', 'prodis.id');
        } else {
            $pengawas = Pengawas::join('ujians', 'pengawas.ujian_id', '=', 'ujians.id')
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
        }

        if (Auth::user()->lokasi == 'CA & Lab Kom') {
            $pengawas->where('ujians.ruang', 'CA B01')
            ->orWhere('ujians.ruang', 'CA B02')
            ->orWhere('ujians.ruang', 'CA B03')
            ->orWhere('ujians.ruang', 'CA B04')
            ->orWhere('ujians.ruang', 'CA B05')
            ->orWhere('ujians.ruang', 'CA B06')
            ->orWhere('ujians.ruang', 'CA B07')
            ->orWhere('ujians.ruang', 'CA B08')
            ->orWhere('ujians.ruang', 'CA KOM 1')
            ->orWhere('ujians.ruang', 'CA KOM 2');
        } elseif (Auth::user()->lokasi == 'CB & Lab Kom') {
            $pengawas->where('ujians.ruang', 'CB B01')
            ->orWhere('ujians.ruang', 'CB B02')
            ->orWhere('ujians.ruang', 'CB B03')
            ->orWhere('ujians.ruang', 'CB B04')
            ->orWhere('ujians.ruang', 'CB KOM 1')
            ->orWhere('ujians.ruang', 'CB KOM 2')
            ->orWhere('ujians.ruang', 'CB KOM 3')
            ->orWhere('ujians.ruang', 'CB KOM 4')
            ->orWhere('ujians.ruang', 'CB KOM 5')
            ->orWhere('ujians.ruang', 'CB PEMROGRAMAN')
            ->orWhere('ujians.ruang', 'CB K 70-1');
        } elseif (Auth::user()->lokasi == 'BS B01-06') {
            $pengawas->where('ujians.ruang', 'BS B01')
            ->orWhere('ujians.ruang', 'BS B02')
            ->orWhere('ujians.ruang', 'BS B03')
            ->orWhere('ujians.ruang', 'BS B04')
            ->orWhere('ujians.ruang', 'BS B05')
            ->orWhere('ujians.ruang', 'BS B06');
        } elseif (Auth::user()->lokasi == 'BS B07-10') {
            $pengawas->where('ujians.ruang', 'BS B07')
            ->orWhere('ujians.ruang', 'BS B08')
            ->orWhere('ujians.ruang', 'BS B09')
            ->orWhere('ujians.ruang', 'BS B10');
        } elseif (Auth::user()->lokasi == 'BS KIMBOTFIS') {
            $pengawas->where('ujians.ruang', 'BS KIMIA')
            ->orWhere('ujians.ruang', 'BS BOTANI')
            ->orWhere('ujians.ruang', 'BS FISIKA');
        } elseif (Auth::user()->lokasi == 'BS P01-03') {
            $pengawas->where('ujians.ruang', 'BS P01')
            ->orWhere('ujians.ruang', 'BS P02')
            ->orWhere('ujians.ruang', 'BS P03');
        } elseif (Auth::user()->lokasi == 'Sukabumi') {
            $pengawas->where('ujians.ruang', 'GAK 01')
            ->orWhere('ujians.ruang', 'GAK 02')
            ->orWhere('ujians.ruang', 'GAK 03')
            ->orWhere('ujians.ruang', 'GAK 04')
            ->orWhere('ujians.ruang', 'GAK 05')
            ->orWhere('ujians.ruang', 'GAK 06')
            ->orWhere('ujians.ruang', 'GAK 07')
            ->orWhere('ujians.ruang', 'Lab SKBMI');
        } elseif (Auth::user()->lokasi == 'Online') {
            $pengawas->where('ujians.ruang', 'Online');
        }

        $pengawas = $pengawas->get();
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
            $ujian = Ujian::join('matkuls', 'ujians.matkul_id', '=', 'matkuls.id')
            ->join('semesters AS a', 'matkuls.semester_id', '=', 'a.id')
            ->join('praktikums', 'ujians.prak_id', '=', 'praktikums.id')
            ->join('kelas', 'praktikums.kelas_id', '=', 'kelas.id')
            ->join('semesters AS b', 'kelas.semester_id', '=', 'b.id')
            ->join('prodis', 'b.prodi_id', '=', 'prodis.id')
            ->join('amplops', 'amplops.ujian_id', '=', 'ujians.id')
            ->join('baps', 'baps.ujian_id', '=', 'ujians.id')
            ->join('berkas', 'berkas.ujian_id', '=', 'ujians.id');
        } else {
            $prodi = $request->prodi;
            $semester = $request->semester;
            $matkul = $request->matkul;
            $kelas = $request->kelas;
            $praktikum = $request->praktikum;
            $tanggal = $request->tanggal;
            $ruang = $request->ruang;

            $ujian = $this->filter($prodi, $semester, $matkul, $kelas, $praktikum, $tanggal, $ruang);
        }

        if (Auth::user()->lokasi == 'CA & Lab Kom') {
            $ujian->where('ujians.ruang', 'CA B01')
            ->orWhere('ujians.ruang', 'CA B02')
            ->orWhere('ujians.ruang', 'CA B03')
            ->orWhere('ujians.ruang', 'CA B04')
            ->orWhere('ujians.ruang', 'CA B05')
            ->orWhere('ujians.ruang', 'CA B06')
            ->orWhere('ujians.ruang', 'CA B07')
            ->orWhere('ujians.ruang', 'CA B08')
            ->orWhere('ujians.ruang', 'CA KOM 1')
            ->orWhere('ujians.ruang', 'CA KOM 2');
        } elseif (Auth::user()->lokasi == 'CB & Lab Kom') {
            $ujian->where('ujians.ruang', 'CB B01')
            ->orWhere('ujians.ruang', 'CB B02')
            ->orWhere('ujians.ruang', 'CB B03')
            ->orWhere('ujians.ruang', 'CB B04')
            ->orWhere('ujians.ruang', 'CB KOM 1')
            ->orWhere('ujians.ruang', 'CB KOM 2')
            ->orWhere('ujians.ruang', 'CB KOM 3')
            ->orWhere('ujians.ruang', 'CB KOM 4')
            ->orWhere('ujians.ruang', 'CB KOM 5')
            ->orWhere('ujians.ruang', 'CB PEMROGRAMAN')
            ->orWhere('ujians.ruang', 'CB K 70-1');
        } elseif (Auth::user()->lokasi == 'BS B01-06') {
            $ujian->where('ujians.ruang', 'BS B01')
            ->orWhere('ujians.ruang', 'BS B02')
            ->orWhere('ujians.ruang', 'BS B03')
            ->orWhere('ujians.ruang', 'BS B04')
            ->orWhere('ujians.ruang', 'BS B05')
            ->orWhere('ujians.ruang', 'BS B06');
        } elseif (Auth::user()->lokasi == 'BS B07-10') {
            $ujian->where('ujians.ruang', 'BS B07')
            ->orWhere('ujians.ruang', 'BS B08')
            ->orWhere('ujians.ruang', 'BS B09')
            ->orWhere('ujians.ruang', 'BS B10');
        } elseif (Auth::user()->lokasi == 'BS KIMBOTFIS') {
            $ujian->where('ujians.ruang', 'BS KIMIA')
            ->orWhere('ujians.ruang', 'BS BOTANI')
            ->orWhere('ujians.ruang', 'BS FISIKA');
        } elseif (Auth::user()->lokasi == 'BS P01-03') {
            $ujian->where('ujians.ruang', 'BS P01')
            ->orWhere('ujians.ruang', 'BS P02')
            ->orWhere('ujians.ruang', 'BS P03');
        } elseif (Auth::user()->lokasi == 'Sukabumi') {
            $ujian->where('ujians.ruang', 'GAK 01')
            ->orWhere('ujians.ruang', 'GAK 02')
            ->orWhere('ujians.ruang', 'GAK 03')
            ->orWhere('ujians.ruang', 'GAK 04')
            ->orWhere('ujians.ruang', 'GAK 05')
            ->orWhere('ujians.ruang', 'GAK 06')
            ->orWhere('ujians.ruang', 'GAK 07')
            ->orWhere('ujians.ruang', 'Lab SKBMI');
        } elseif (Auth::user()->lokasi == 'Online') {
            $ujian->where('ujians.ruang', 'Online');
        }

        return view('pj_lokasi.soal.index', [
            "berkas" => $ujian->get()
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
