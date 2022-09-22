<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Kelas;
use App\Models\Prodi;
use App\Models\Ujian;
use App\Models\Berkas;
use App\Models\Master;
use App\Models\Matkul;
use App\Models\Ruangan;
use App\Models\Pengawas;
use App\Models\Semester;
use App\Models\Penugasan;
use App\Models\Pelanggaran;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use function PHPUnit\Framework\isEmpty;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class pjLokasiController extends Controller
{
    public function dashboard()
    {
        $now = "2022-06-08";
        
        $ujian = Ujian::join('matkuls', 'ujians.matkul_id', '=', 'matkuls.id')
        ->join('semesters AS a', 'matkuls.semester_id', '=', 'a.id')
        ->join('praktikums', 'ujians.prak_id', '=', 'praktikums.id')
        ->join('kelas', 'praktikums.kelas_id', '=', 'kelas.id')
        ->join('semesters AS b', 'kelas.semester_id', '=', 'b.id')
        ->join('prodis', 'b.prodi_id', '=', 'prodis.id')
        ->join('amplops', 'amplops.ujian_id', '=', 'ujians.id')
        ->join('baps', 'baps.ujian_id', '=', 'ujians.id')
        ->join('berkas', 'berkas.ujian_id', '=', 'ujians.id');
        
        $ujian->where(function($ujian) {
            $tot1 = count(Ruangan::groupBy('lokasi')->selectRaw('count(lokasi) as lokasi')->get());
            $lokasi = Ruangan::groupBy('lokasi')->select('lokasi')->get();
            for ($i = 0; $i < $tot1; $i++) {
                if (Auth::user()->lokasi == $lokasi[$i]->lokasi) {
                    $ruangan = Ruangan::select('ruangan')->where('lokasi', $lokasi[$i]->lokasi)->get();
                    $tot2 = count($ruangan);
                    $ujian->where('ujians.ruang', $ruangan[0]->ruangan);
                    for ($j = 0; $j < $tot2; $j++) {
                        $ujian->orWhere('ujians.ruang', $ruangan[$j]->ruangan);
                    }
                }
            }
        });

        if (request(['dbProdi', 'dbSemester', 'dbPraktikum', 'dbKelas', 'dbMatkul', 'dbRuang'])) {
            $ujian->filter(request(['dbProdi', 'dbSemester', 'dbPraktikum', 'dbKelas', 'dbMatkul', 'dbRuang']));
        } else if (request(['dbProdi', 'dbSemester', 'dbPraktikum', 'dbKelas', 'dbMatkul', 'dbRuang', 'dbTanggal'])) {
            $ujian->filter(request(['dbProdi', 'dbSemester', 'dbPraktikum', 'dbKelas', 'dbMatkul', 'dbRuang', 'dbTanggal']));
        } else {
            $ujian->where('ujians.tanggal', $now);
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

        $pengawas->where(function($pengawas) {
            $tot1 = count(Ruangan::groupBy('lokasi')->selectRaw('count(lokasi) as lokasi')->get());
            $lokasi = Ruangan::groupBy('lokasi')->select('lokasi')->get();
            for ($i = 0; $i < $tot1; $i++) {
                if (Auth::user()->lokasi == $lokasi[$i]->lokasi) {
                    $ruangan = Ruangan::select('ruangan')->where('lokasi', $lokasi[$i]->lokasi)->get();
                    $tot2 = count($ruangan);
                    $pengawas->where('ujians.ruang', $ruangan[0]->ruangan);
                    for ($j = 0; $j < $tot2; $j++) {
                        $pengawas->orWhere('ujians.ruang', $ruangan[$j]->ruangan);
                    }
                }
            }
        });

        $pengawas->filter(request(['dbProdi', 'dbSemester', 'dbPraktikum', 'dbKelas', 'dbMatkul', 'dbTanggal', 'dbRuang']));
        Session::put('url', request()->fullUrl());
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
        if (session('url')) {
            return redirect(session('url'))->with('success', 'Data Pengawas berhasil diperbarui!');
        }
        return redirect()->route('pjLokasi.pengawas.daftar.index')->with('success', 'Data Pengawas berhasil diperbarui!');
    }

    public function absensiIndex()
    {
        $dataTanggalMulai = Master::first();
        $dataTanggalSelesai = Master::first();

        $from = $dataTanggalMulai->periode_mulai;
        $to = $dataTanggalSelesai->periode_akhir;

        $now = "2022-06-08";

        $pengawas = Penugasan::join('pengawas', 'penugasans.pengawas_id', 'pengawas.id')
        ->join('ujians', 'penugasans.ujian_id', '=', 'ujians.id')
        ->join('matkuls', 'ujians.matkul_id', '=', 'matkuls.id')
        ->join('semesters AS a', 'matkuls.semester_id', '=', 'a.id')
        ->join('praktikums', 'ujians.prak_id', '=', 'praktikums.id')
        ->join('kelas', 'praktikums.kelas_id', '=', 'kelas.id')
        ->join('semesters AS b', 'kelas.semester_id', '=', 'b.id')
        ->join('prodis', 'b.prodi_id', '=', 'prodis.id')
        ->select('ujians.*', 'matkuls.*', 'b.*', 'praktikums.*', 'kelas.*', 'prodis.*', 'pengawas.*', 'penugasans.*');
        // ->whereBetween('ujians.tanggal', [$from, $to]);

        $pengawas->where(function($pengawas) {
            $tot1 = count(Ruangan::groupBy('lokasi')->selectRaw('count(lokasi) as lokasi')->get());
            $lokasi = Ruangan::groupBy('lokasi')->select('lokasi')->get();
            for ($i = 0; $i < $tot1; $i++) {
                if (Auth::user()->lokasi == $lokasi[$i]->lokasi) {
                    $ruangan = Ruangan::select('ruangan')->where('lokasi', $lokasi[$i]->lokasi)->get();
                    $tot2 = count($ruangan);
                    $pengawas->where('ujians.ruang', $ruangan[0]->ruangan);
                    for ($j = 0; $j < $tot2; $j++) {
                        $pengawas->orWhere('ujians.ruang', $ruangan[$j]->ruangan);
                    }
                }
            }
        });

        $hari = Carbon::now()->translatedFormat('l');

        if (request(['dbTanggal'])) {
            $pengawas->filter(request(['dbTanggal']));
        } else {
            $pengawas->where('ujians.tanggal', $now);
        }

        $pengawas->filter(request(['dbProdi', 'dbMatkul']));
        Session::put('url', request()->fullUrl());
        return view('pj_lokasi.absensi.index', [
            "absensi" => $pengawas->get(),
            "hari" => $hari
        ]);
    }

    public function absensiForm($id)
    {
        $pengawas = Penugasan::find($id);
        $qrcode =  QrCode::size(500)->generate('http://mindysvipb.xyz/presensi/' . $pengawas->id);
        return view('pj_lokasi.absensi.form', [
            "pengawas" => $pengawas,
            "qrCode" => $qrcode
        ]);
    }

    public function absensiExport()
    {
        $jam = Carbon::now()->format('H:i');
        $hari = Carbon::now()->translatedFormat('l');
        return view('pj_lokasi.absensi.export', compact(['jam', 'hari']));
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
        $destination = 'images/ttd/' . $penugasan->presensi;
        if ($destination) {
            Storage::delete($destination);
        }

        $folderPath = 'images/ttd/';
        $image = explode(";base64,", $request->ttd);
        $image_type = explode("image/", $image[0]);
        $image_type_png = $image_type[1];
        $image_base64 = base64_decode($image[1]);
        
        $fileName = uniqid() . '.'.$image_type_png;
        $file = $folderPath . $fileName;
        Storage::put($file, $image_base64);

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
        $destination = 'images/ttd/' . $penugasan->presensi;
        if ($destination) {
            Storage::delete($destination);
        }
        $penugasan->update([
            'presensi' => null
        ]);
        $this->Activity(' menghapus kehadiran pengawas ' . $pengawas->nama);
        if (session('url')) {
            return redirect(session('url'))->with('success', 'Kehadiran dihapus!');
        }
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

        $tot1 = count(Ruangan::groupBy('lokasi')->selectRaw('count(lokasi) as lokasi')->get());
        $lokasi = Ruangan::groupBy('lokasi')->select('lokasi')->get();
        for ($i = 0; $i < $tot1; $i++) {
            if (Auth::user()->lokasi == $lokasi[$i]->lokasi) {
                $ruangan = Ruangan::select('ruangan')->where('lokasi', $lokasi[$i]->lokasi)->get();
                $tot2 = count($ruangan);
                $ujian->where('ujians.ruang', $ruangan[0]->ruangan);
                for ($j = 0; $j < $tot2; $j++) {
                    $ujian->orWhere('ujians.ruang', $ruangan[$j]->ruangan);
                }
            }
        }

        $ujian->filter(request(['dbProdi', 'dbSemester', 'dbPraktikum', 'dbKelas', 'dbMatkul', 'dbTanggal', 'dbRuang']));
        Session::put('url', request()->fullUrl());
        return view('pj_lokasi.soal.index', [
            "berkas" => $ujian->get()
        ]);
    }

    public function soalForm()
    {
        $tglbln = Carbon::now()->translatedFormat('d F Y');
        $tglblnthn = Carbon::now()->format('d/m/Y');
        $hari = Carbon::now()->translatedFormat('l');
        $jam = Carbon::now()->format('H:i');

        return view('pj_lokasi.soal.form', [
            'master' => Master::find(1),
            'tglbln' => $tglbln,
            'tglblnthn' => $tglblnthn,
            'hari' => $hari,
            'jam' => $jam
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

    public function pdf(Request $request)
    {
        $now = $request->tanggal;
        $tgl = strtotime($now);
        $hari = date('l', $tgl);

        $pengawas = Pengawas::join('penugasans', 'penugasans.pengawas_id', 'pengawas.id')
        ->join('ujians', 'penugasans.ujian_id', '=', 'ujians.id')
        ->join('matkuls', 'ujians.matkul_id', '=', 'matkuls.id')
        ->join('semesters AS a', 'matkuls.semester_id', '=', 'a.id')
        ->join('praktikums', 'ujians.prak_id', '=', 'praktikums.id')
        ->join('kelas', 'praktikums.kelas_id', '=', 'kelas.id')
        ->join('semesters AS b', 'kelas.semester_id', '=', 'b.id')
        ->join('prodis', 'b.prodi_id', '=', 'prodis.id')
        ->select('ujians.*', 'matkuls.*', 'b.*', 'praktikums.*', 'kelas.*', 'prodis.*', 'penugasans.*', 'pengawas.*')
        ->where('ujians.tanggal', $now)
        ->where('penugasans.presensi', '!=', null);

        $penugasan = Penugasan::join('ujians', 'penugasans.ujian_id', 'ujians.id')
        ->where('ujians.tanggal', $now)
        ->where('penugasans.presensi', '!=', null);

        if ($hari == 'Friday') {
            if ($request->sesi == "1") {
                $pengawas->where('ujians.jam_mulai', '8');
                $penugasan->where('ujians.jam_mulai', '8');
            } elseif ($request->sesi == "2") {
                $pengawas->where('ujians.jam_mulai', '14');
                $penugasan->where('ujians.jam_mulai', '14');
            }
        } else {
            if ($request->sesi == "1") {
                $pengawas->where('ujians.jam_mulai', '8');
                $penugasan->where('ujians.jam_mulai', '8');
            } elseif ($request->sesi == "2") {
                $pengawas->where('ujians.jam_mulai', '10.3');
                $penugasan->where('ujians.jam_mulai', '10.3');
            } elseif ($request->sesi == "3") {
                $pengawas->where('ujians.jam_mulai', '13.15');
                $penugasan->where('ujians.jam_mulai', '13.15');
            }
        }

        $penugasan->where(function($query) {
            $tot1 = count(Ruangan::groupBy('lokasi')->selectRaw('count(lokasi) as lokasi')->get());
            $lokasi = Ruangan::groupBy('lokasi')->select('lokasi')->get();
            for ($i = 0; $i < $tot1; $i++) {
            if (Auth::user()->lokasi == $lokasi[$i]->lokasi) {
                $ruangan = Ruangan::select('ruangan')->where('lokasi', $lokasi[$i]->lokasi)->get();
                $tot2 = count($ruangan);
                $query->where('ujians.ruang', $ruangan[0]->ruangan);
                for ($j = 0; $j < $tot2; $j++) {
                    $query->orWhere('ujians.ruang', $ruangan[$j]->ruangan);
                }
            }
        }
        });

        $pengawas->where(function($query) {
            $tot1 = count(Ruangan::groupBy('lokasi')->selectRaw('count(lokasi) as lokasi')->get());
            $lokasi = Ruangan::groupBy('lokasi')->select('lokasi')->get();
            for ($i = 0; $i < $tot1; $i++) {
            if (Auth::user()->lokasi == $lokasi[$i]->lokasi) {
                $ruangan = Ruangan::select('ruangan')->where('lokasi', $lokasi[$i]->lokasi)->get();
                $tot2 = count($ruangan);
                $query->where('ujians.ruang', $ruangan[0]->ruangan);
                for ($j = 0; $j < $tot2; $j++) {
                    $query->orWhere('ujians.ruang', $ruangan[$j]->ruangan);
                }
            }
        }
        })->get();

        $master = Master::find(1);
        $tglbln = Carbon::now()->translatedFormat('d F Y');
        $nama = Auth::user()->name;
        $lokasi = Auth::user()->lokasi;
        $tbt = Carbon::now()->format('d/m/Y');

        $fileName = Auth::user()->email . '_ttd_pjLoc.png';

        if ($request->ttd) {
            $destination = 'images/ttd/' . Auth::user()->email . '_ttd_pjLoc.png';
            if ($destination) {
                Storage::delete($destination);
            }
    
            $folderPath = Storage::path('images/ttd/');
            $image = explode(";base64,", $request->ttd);
            $image_base64 = base64_decode($image[1]);
            
            $file = $folderPath . $fileName;
            file_put_contents($file, $image_base64);
        }
        
        $data = [
            'pengawas' => $pengawas->get(),
            'master' => $master,
            'tglbln' => $tglbln,
            'nama' => $nama,
            'lokasi' => $lokasi,
            'tbt' => $tbt,
            'time' => $request->pukul,
            'ttd' => $fileName
        ];

        $pdf = PDF::loadView('layouts.presence', $data);
        // return $pdf->stream();
        $pdfName = time(). '_pengawas.pdf';
        $penugasan->update(['file' => $pdfName]);
        Storage::put('files/pdf/' . $pdfName, $pdf->output());
        
        $this->Activity(' melakukan submit data kehadiran pengawas');
        if (session('url')) {
            return redirect(session('url'))->with('success', 'Berhasil menyerahkan data kehadiran pengawas!');
        }
        return redirect()->route('pjLokasi.pengawas.absensi.index')->with('success', 'Berhasil menyerahkan data kehadiran pengawas!');
    }

    public function pdfDestroy($id)
    {
        $penugasan = Penugasan::where('id', $id)->select('file')->first();

        $destination = 'files/pdf/' . $penugasan->file;
        if ($destination) {
            Storage::delete($destination);
        }

        Penugasan::where('file', $penugasan->file)->update(['file' => null]);
        $this->Activity(' menghapus data kehadiran pengawas');
        if (session('url')) {
            return redirect(session('url'))->with('success', 'Berhasil menghapus data kehadiran pengawas!');
        }
        return redirect()->route('pjLokasi.pengawas.absensi.index')->with('success', 'Berhasil menghapus data kehadiran pengawas!');
    }

    public function SerahTerima(Request $request)
    {
        $destination1 = 'images/ttd/ttd_penyerah.png';
        $destination2 = 'images/ttd/ttd_penerima.png';
        if ($destination1 AND $destination2) {
            Storage::delete($destination1);
            Storage::delete($destination2);
        }
        
        $folderPath = 'images/ttd/';
        $image1 = explode(";base64,", $request->ttd_penyerah);
        $image_base1 = base64_decode($image1[1]);
        $fileName1 = 'ttd_penyerah.png';
        $file1 = $folderPath . $fileName1;
        Storage::put($file1, $image_base1);

        $image2 = explode(";base64,", $request->ttd_penerima);
        $image_base2 = base64_decode($image2[1]);
        $fileName2 = 'ttd_penerima.png';
        $file2 = $folderPath . $fileName2;
        Storage::put($file2, $image_base2);
        
        DB::beginTransaction();

        $kelas = array();
        for ($i = 0; $i < count($request->kelas); $i++) {
            $kelas[] = Kelas::where('id', $request->kelas[$i])->select('kelas')->first();
        }

        $prodi = Prodi::where('id', $request->prodi)->select('nama_prodi')->first();
        $semester = Semester::where('id', $request->semester)->select('semester')->first();
        $matkul = Matkul::where('id', $request->ttdMatkul)->select('nama_matkul')->first();
        $listKelas = Kelas::where('semester_id', $request->semester)->select('kelas')->get();

        $data = [
            'master' => Master::find(1),
            'thn_ajaran' => $request->thn_ajaran,
            'nama_prodi' => $prodi->nama_prodi,
            'semester' =>$semester->semester,
            'matkul' => $matkul->nama_matkul,
            'kelas' => $kelas,
            'hari' => $request->hari,
            'jam' => $request->jam,
            'tanggal' => $request->tanggal,
            'tglbln' => $request->tglbln,
            'jml_berkas' => $request->jml_berkas,
            'nama_serah' => $request->nama_serah,
            'nama_terima' => $request->nama_terima,
            'ttd_penyerah' => $fileName1,
            'ttd_penerima' => $fileName2,
            'listKelas' => $listKelas
        ];

        $pdf = PDF::loadView('layouts.serah', $data);
        $pdfName = time(). '_Serah_Terima.pdf';
        // return $pdf->stream('serah_terima.pdf');
        Storage::put('files/pdf/' . $pdfName, $pdf->output());

        for ($i = 0; $i < count($request->kelas); $i++) {
            Berkas::join('ujians', 'berkas.ujian_id', 'ujians.id')
            ->join('praktikums', 'ujians.prak_id', 'praktikums.id')
            ->join('kelas', 'praktikums.kelas_id', 'kelas.id')
            ->join('matkuls', 'ujians.matkul_id', 'matkuls.id')
            ->where('kelas.id', $request->kelas[$i])
            ->where('matkuls.id', $request->ttdMatkul)
            ->update([
                'serah_terima' => 'Sudah',
                'file' => $pdfName
            ]);
        }
        $this->Activity(' melakukan serah terima berkas untuk matkul ' . $matkul->nama_matkul);
        DB::commit();

        if (session('url')) {
            return redirect(session('url'))->with('success', 'Berkas Serah Terima berhasil ditanda tangani!');
        }
        return redirect()->route('pjLokasi.soal.index')->with('success', 'Berkas Serah Terima berhasil ditanda tangani!');
    }

    public function SerahTerimaDestroy($id)
    {
        DB::beginTransaction();
        $fileName = Berkas::where('ujian_id', $id)->select('file')->first();
        $matkul = Ujian::where('id', $id)->first();

        $destination = 'files/pdf/' . $fileName->file;
        if ($destination) {
            Storage::delete($destination);
        }

        Berkas::where('file', $fileName->file)->update([
            'serah_terima' => 'Belum',
            'file' => null
        ]);
        $this->Activity(' menghapus serah terima berkas untuk mata kuliah ' . $matkul->Matkul->nama_matkul);
        DB::commit();
        
        if (session('url')) {
            return redirect(session('url'))->with('success', 'Berkas Serah Terima berhasil dihapus!');
        }
        return redirect()->route('pjLokasi.soal.index')->with('success', 'Berkas Serah Terima berhasil dihapus!');
    }
}