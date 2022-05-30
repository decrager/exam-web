<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Ujian;
use App\Models\Master;
use App\Models\Pengawas;
use App\Models\Penugasan;
use App\Models\Pelanggaran;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\Auth;
use function PHPUnit\Framework\isEmpty;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

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
            ->orWhere('ujians.ruang', 'BS P03')
            ->orWhere('ujians.ruang', 'HPT');
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
        
        $pengawas = Penugasan::join('pengawas', 'penugasans.pengawas_id', 'pengawas.id')
        ->join('ujians', 'penugasans.ujian_id', '=', 'ujians.id')
        ->join('matkuls', 'ujians.matkul_id', '=', 'matkuls.id')
        ->join('semesters AS a', 'matkuls.semester_id', '=', 'a.id')
        ->join('praktikums', 'ujians.prak_id', '=', 'praktikums.id')
        ->join('kelas', 'praktikums.kelas_id', '=', 'kelas.id')
        ->join('semesters AS b', 'kelas.semester_id', '=', 'b.id')
        ->join('prodis', 'b.prodi_id', '=', 'prodis.id')
        ->select('ujians.*', 'matkuls.*', 'b.*', 'praktikums.*', 'kelas.*', 'prodis.*', 'pengawas.*', 'penugasans.*')
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
            ->orWhere('ujians.ruang', 'BS P03')
            ->orWhere('ujians.ruang', 'HPT');
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
        $penugasan = Penugasan::find($id);
        $selected = Pengawas::find($penugasan->pengawas_id);
        $pengawas = Pengawas::all();

        return view('pj_lokasi.pengawas.edit', [
            "penugasan" => $penugasan,
            "pengawas" => $pengawas,
            "selected" => $selected
        ]);
    }

    public function pengawasUpdate(Request $request, $id)
    {
        $request->validate([
            'pengawas_id' => 'required'
        ]);

        $pengawas = Penugasan::find($id);
        $pengawas->update([
            'pengawas_id' => $request->pengawas_id
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

        $now = Carbon::now()->toDateString();

        $pengawas = Penugasan::join('pengawas', 'penugasans.pengawas_id', 'pengawas.id')
        ->join('ujians', 'penugasans.ujian_id', '=', 'ujians.id')
        ->join('matkuls', 'ujians.matkul_id', '=', 'matkuls.id')
        ->join('semesters AS a', 'matkuls.semester_id', '=', 'a.id')
        ->join('praktikums', 'ujians.prak_id', '=', 'praktikums.id')
        ->join('kelas', 'praktikums.kelas_id', '=', 'kelas.id')
        ->join('semesters AS b', 'kelas.semester_id', '=', 'b.id')
        ->join('prodis', 'b.prodi_id', '=', 'prodis.id')
        ->select('ujians.*', 'matkuls.*', 'b.*', 'praktikums.*', 'kelas.*', 'prodis.*', 'pengawas.*', 'penugasans.*')
        ->where('ujians.tanggal', '2022-06-08');

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
            ->orWhere('ujians.ruang', 'BS P03')
            ->orWhere('ujians.ruang', 'HPT');
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
        $pengawas = Penugasan::find($id);
        $qrcode =  QrCode::size(500)->generate('http://127.0.0.1:8000/presensi/' . $pengawas->id);
        return view('pj_lokasi.absensi.form', [
            "pengawas" => $pengawas,
            "qrCode" => $qrcode
        ]);
    }

    public function presence($id)
    {
        $pengawas = Penugasan::find($id);
        return view('presence', ['pengawas' => $pengawas]);
    }

    public function presenceUpdate(Request $request, $id)
    {
        $request->validate([
            'presensi' => 'nullable',
            'ttd' => 'required'
        ]);

        $penugasan = Penugasan::find($id);
        $pengawas = Pengawas::find($penugasan->pengawas_id);
        $destination = 'images/qr/' . $penugasan->presensi;
        if ($destination) {
            Storage::delete($destination);
        }

        $folderPath = Storage::path('images/qr/');
        $image = explode(";base64,", $request->ttd);
        $image_type = explode("image/", $image[0]);
        $image_type_png = $image_type[1];
        $image_base64 = base64_decode($image[1]);
        
        $fileName = uniqid() . '.'.$image_type_png;
        $file = $folderPath . $fileName;
        file_put_contents($file, $image_base64);

        $penugasan->update([
            'presensi' => $fileName
        ]);

        $this->PublicActivity($pengawas->nama . ' menandatangi kehadiran pengawas');
        return redirect()->route('presensi.hadir')->with('success', 'Kehadiran Tersimpan!');
    }

    public function presenceDestroy($id)
    {
        $penugasan = Penugasan::find($id);
        $pengawas = Pengawas::find($penugasan->pengawas_id);
        $destination = 'images/qr/' . $penugasan->presensi;
        if ($destination) {
            Storage::delete($destination);
        }
        $penugasan->update([
            'presensi' => null
        ]);
        $this->Activity(' menghapus kehadiran pengawas ' . $pengawas->nama);
        return redirect()->route('pjLokasi.pengawas.absensi.index')->with('success', 'Kehadiran dihapus!');
    }

    public function hadir()
    {
        return view('done');
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
            ->orWhere('ujians.ruang', 'BS P03')
            ->orWhere('ujians.ruang', 'HPT');
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

    public function pdf()
    {
        $dataTanggalMulai = Master::first();
        $dataTanggalSelesai = Master::first();

        $from = $dataTanggalMulai->periode_mulai;
        $to = $dataTanggalSelesai->periode_akhir;

        $now = Carbon::now()->toDateString();

        $pengawas = Pengawas::join('penugasans', 'penugasans.pengawas_id', 'pengawas.id')
        ->join('ujians', 'penugasans.ujian_id', '=', 'ujians.id')
        ->join('matkuls', 'ujians.matkul_id', '=', 'matkuls.id')
        ->join('semesters AS a', 'matkuls.semester_id', '=', 'a.id')
        ->join('praktikums', 'ujians.prak_id', '=', 'praktikums.id')
        ->join('kelas', 'praktikums.kelas_id', '=', 'kelas.id')
        ->join('semesters AS b', 'kelas.semester_id', '=', 'b.id')
        ->join('prodis', 'b.prodi_id', '=', 'prodis.id')
        ->select('ujians.*', 'matkuls.*', 'b.*', 'praktikums.*', 'kelas.*', 'prodis.*', 'penugasans.*', 'pengawas.*')
        ->where('ujians.tanggal', '2022-06-08');

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
            ->orWhere('ujians.ruang', 'BS P03')
            ->orWhere('ujians.ruang', 'HPT');
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

        $master = Master::find(1);
        $tglbln = Carbon::now()->format('d F Y');
        $nama = Auth::user()->name;
        $lokasi = Auth::user()->lokasi;
        $tbt = Carbon::now()->format('d/m/Y');
        $time = Carbon::now()->format('H:i');

        $pengawas = $pengawas->get();
        $data = [
            'pengawas' => $pengawas,
            'master' => $master,
            'tglbln' => $tglbln,
            'nama' => $nama,
            'lokasi' => $lokasi,
            'tbt' => $tbt,
            'time' => $time
        ];

        $pdf = PDF::loadView('layouts.presence', $data);

        return $pdf->stream('presensi.pdf');
    }
}
