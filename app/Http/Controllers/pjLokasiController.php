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
    public function dashboard()
    {
        $now = Carbon::now()->toDateString();
        
        $ujian = Ujian::join('matkuls', 'ujians.matkul_id', '=', 'matkuls.id')
        ->join('semesters AS a', 'matkuls.semester_id', '=', 'a.id')
        ->join('praktikums', 'ujians.prak_id', '=', 'praktikums.id')
        ->join('kelas', 'praktikums.kelas_id', '=', 'kelas.id')
        ->join('semesters AS b', 'kelas.semester_id', '=', 'b.id')
        ->join('prodis', 'b.prodi_id', '=', 'prodis.id')
        ->join('amplops', 'amplops.ujian_id', '=', 'ujians.id')
        ->join('baps', 'baps.ujian_id', '=', 'ujians.id')
        ->join('berkas', 'berkas.ujian_id', '=', 'ujians.id');
        
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
            $ujian->where('ujians.ruang', 'BS Kimia')
            ->orWhere('ujians.ruang', 'BS Botani')
            ->orWhere('ujians.ruang', 'BS Fisika');
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
            ->orWhere('ujians.ruang', 'LAB KOM SMI');
        } elseif (Auth::user()->lokasi == 'Online') {
            $ujian->where('ujians.ruang', 'Online');
        }

        if (request(['dbProdi', 'dbSemester', 'dbPraktikum', 'dbKelas', 'dbMatkul', 'dbRuang'])) {
            $ujian->filter(request(['dbProdi', 'dbSemester', 'dbPraktikum', 'dbKelas', 'dbMatkul', 'dbRuang']));
        }

        if (request(['dbTanggal'])) {
            $ujian->filter(request(['dbTanggal']));
        } else {
            $ujian->where('ujians.tanggal', '2022-06-08');
        }
        
        return view('pj_lokasi.dashboard', [
            "dbUjian" => $ujian->get()
        ]);
    }

    public function pengawasIndex()
    {
        $dataTanggalMulai = Master::first();
        $dataTanggalSelesai = Master::first();

        $from = $dataTanggalMulai->periode_mulai;
        $to = $dataTanggalSelesai->periode_akhir;
        
        $pengawas = Pengawas::join('ujians', 'pengawas.ujian_id', '=', 'ujians.id')
        ->join('matkuls', 'ujians.matkul_id', '=', 'matkuls.id')
        ->join('semesters AS a', 'matkuls.semester_id', '=', 'a.id')
        ->join('praktikums', 'ujians.prak_id', '=', 'praktikums.id')
        ->join('kelas', 'praktikums.kelas_id', '=', 'kelas.id')
        ->join('semesters AS b', 'kelas.semester_id', '=', 'b.id')
        ->join('prodis', 'b.prodi_id', '=', 'prodis.id')
        ->select('ujians.*', 'matkuls.*', 'b.*', 'praktikums.*', 'kelas.*', 'prodis.*', 'pengawas.*')
        ->whereBetween('ujians.tanggal', [$from, $to]);

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
            $pengawas->where('ujians.ruang', 'BS Kimia')
            ->orWhere('ujians.ruang', 'BS Botani')
            ->orWhere('ujians.ruang', 'BS Fisika');
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
            ->orWhere('ujians.ruang', 'LAB KOM SMI');
        } elseif (Auth::user()->lokasi == 'Online') {
            $pengawas->where('ujians.ruang', 'Online');
        }

        $pengawas->filter(request(['dbProdi', 'dbSemester', 'dbPraktikum', 'dbKelas', 'dbMatkul', 'dbTanggal', 'dbRuang']));
        return view('pj_lokasi.pengawas.index', [
            "pengawas" => $pengawas->get()
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
            'pns' => 'required',
            'norek' => 'nullable',
            'bank' => 'nullable'
        ]);

        $pengawas = Pengawas::find($id);

        $pengawas->update([
            'nama' => $request->nama,
            'pns' => $request->pns,
            'norek' => $request->norek,
            'bank' => $request->bank
        ]);
        
        $this->Activity(' memperbarui data pengawas ' . $request->nama);
        return redirect()->route('pjLokasi.pengawas.daftar.index')->with('success', 'Data Pengawas berhasil diperbarui!');
    }

    public function absensiIndex()
    {
        $dataTanggalMulai = Master::first();
        $dataTanggalSelesai = Master::first();

        $from = $dataTanggalMulai->periode_mulai;
        $to = $dataTanggalSelesai->periode_akhir;
        
        $pengawas = Pengawas::join('ujians', 'pengawas.ujian_id', '=', 'ujians.id')
        ->join('matkuls', 'ujians.matkul_id', '=', 'matkuls.id')
        ->join('semesters AS a', 'matkuls.semester_id', '=', 'a.id')
        ->join('praktikums', 'ujians.prak_id', '=', 'praktikums.id')
        ->join('kelas', 'praktikums.kelas_id', '=', 'kelas.id')
        ->join('semesters AS b', 'kelas.semester_id', '=', 'b.id')
        ->join('prodis', 'b.prodi_id', '=', 'prodis.id')
        ->select('ujians.*', 'matkuls.*', 'b.*', 'praktikums.*', 'kelas.*', 'prodis.*', 'pengawas.*')
        ->whereBetween('ujians.tanggal', [$from, $to]);

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
            $pengawas->where('ujians.ruang', 'BS Kimia')
            ->orWhere('ujians.ruang', 'BS Botani')
            ->orWhere('ujians.ruang', 'BS Fisika');
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
            ->orWhere('ujians.ruang', 'LAB KOM SMI');
        } elseif (Auth::user()->lokasi == 'Online') {
            $pengawas->where('ujians.ruang', 'Online');
        }

        $pengawas->filter(request(['dbProdi', 'dbMatkul']));
        return view('pj_lokasi.absensi.index', [
            "absensi" => $pengawas->get()
        ]);
    }

    public function absensiForm($id)
    {
        $pengawas = Pengawas::find($id);

        return view('pj_lokasi.absensi.form', [
            "pengawas" => $pengawas
        ]);
    }

    public function soalIndex()
    {
        $dataTanggalMulai = Master::first();
        $dataTanggalSelesai = Master::first();

        $from = $dataTanggalMulai->periode_mulai;
        $to = $dataTanggalSelesai->periode_akhir;

        $ujian = Ujian::join('matkuls', 'ujians.matkul_id', '=', 'matkuls.id')
        ->join('semesters AS a', 'matkuls.semester_id', '=', 'a.id')
        ->join('praktikums', 'ujians.prak_id', '=', 'praktikums.id')
        ->join('kelas', 'praktikums.kelas_id', '=', 'kelas.id')
        ->join('semesters AS b', 'kelas.semester_id', '=', 'b.id')
        ->join('prodis', 'b.prodi_id', '=', 'prodis.id')
        ->join('amplops', 'amplops.ujian_id', '=', 'ujians.id')
        ->join('baps', 'baps.ujian_id', '=', 'ujians.id')
        ->join('berkas', 'berkas.ujian_id', '=', 'ujians.id')
        ->whereBetween('ujians.tanggal', [$from, $to]);

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
            $ujian->where('ujians.ruang', 'BS Kimia')
            ->orWhere('ujians.ruang', 'BS Botani')
            ->orWhere('ujians.ruang', 'BS Fisika');
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
            ->orWhere('ujians.ruang', 'LAB KOM SMI');
        } elseif (Auth::user()->lokasi == 'Online') {
            $ujian->where('ujians.ruang', 'Online');
        }

        $ujian->filter(request(['dbProdi', 'dbSemester', 'dbPraktikum', 'dbKelas', 'dbMatkul', 'dbTanggal', 'dbRuang']));
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
        return view('pj_lokasi.pelanggaran.index');
    }

    public function pelanggaranForm()
    {
        return view('pj_lokasi.pelanggaran.form');
    }

    public function pelanggaranEdit()
    {
        return view('pj_lokasi.pelanggaran.edit');
    }
}
