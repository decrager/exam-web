<?php

namespace App\Http\Controllers;

use App\Models\Bap;
use App\Models\Ujian;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\DB;
use App\Models\Kehadiran;
use App\Models\Mahasiswa;
use App\Models\Master;
use App\Models\Pelanggaran;
use App\Models\Pengawas;
use App\Models\Penugasan;
use App\Models\Susulan;
use App\Models\User;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class pengawasController extends Controller
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
        
        if (request(['dbProdi', 'dbSemester', 'dbPraktikum', 'dbKelas', 'dbMatkul', 'dbRuang'])) {
            $ujian->filter(request(['dbProdi', 'dbSemester', 'dbPraktikum', 'dbKelas', 'dbMatkul', 'dbRuang']));
        }

        if (request(['dbTanggal'])) {
            $ujian->filter(request(['dbTanggal']));
        } else {
            $ujian->where('ujians.tanggal', $now);
        }

        return view('assisten.dashboard', ["dbUjian" => $ujian->get()]);
    }

    public function absensiIndex()
    {
        $user_id = Auth::user()->id;
        $ujian = Ujian::join('matkuls', 'ujians.matkul_id', 'matkuls.id')
        ->join('semesters AS a', 'matkuls.semester_id', 'a.id')
        ->join('praktikums', 'ujians.prak_id', 'praktikums.id')
        ->join('kelas', 'praktikums.kelas_id', 'kelas.id')
        ->join('semesters AS b', 'kelas.semester_id', 'b.id')
        ->join('prodis', 'b.prodi_id', 'prodis.id')
        ->join('penugasans', 'ujians.id', 'penugasans.ujian_id')
        ->join('pengawas', 'penugasans.pengawas_id', 'pengawas.id')
        ->join('baps', 'ujians.id', 'baps.ujian_id')
        ->select('pengawas.*', 'penugasans.*', 'prodis.*', 'b.*', 'kelas.*', 'praktikums.*', 'matkuls.*', 'baps.kehadiran', 'ujians.*')
        ->where('pengawas.user_id', $user_id)
        ->orderBy('ujians.tanggal', 'ASC')
        ->get();

        return view('pengawas.absensi.index', ["jadwal" => $ujian]);
    }

    public function absensiForm($id)
    {
        $ujian = Ujian::find($id);
        $now = Carbon::now()->toDateString();

        $dip = $ujian->Matkul->Semester->Prodi->kode_prodi;

        if ($dip == 'DIP') {
            $mahasiswa = Mahasiswa::join('penjadwalans', 'mahasiswas.id', 'penjadwalans.mhs_id')
            ->join('ujians', 'penjadwalans.ujian_id', 'ujians.id')
            ->select('mahasiswas.nim', 'mahasiswas.nama', 'mahasiswas.id')
            ->where('ujians.id', $ujian->id)
            ->orderBy('mahasiswas.nim', 'ASC')
            ->get();

            $kehadiran = Mahasiswa::join('penjadwalans', 'mahasiswas.id', 'penjadwalans.mhs_id')
            ->join('ujians', 'penjadwalans.ujian_id', 'ujians.id')
            ->join('kehadirans', 'mahasiswas.id', 'kehadirans.mhs_id')
            ->select('mahasiswas.nim', 'mahasiswas.nama', 'mahasiswas.id','kehadirans.kehadiran')
            ->where('kehadirans.ujian_id', $ujian->id)
            ->orderBy('mahasiswas.nim', 'ASC')
            ->distinct()
            ->get();

        } else {
            $mahasiswa = Mahasiswa::join('praktikums', 'mahasiswas.prak_id', 'praktikums.id')
            ->join('ujians', 'praktikums.id', 'ujians.prak_id')
            ->select('mahasiswas.nim', 'mahasiswas.nama', 'mahasiswas.id')
            ->where('ujians.id', $ujian->id)
            ->orderBy('mahasiswas.nim', 'ASC')
            ->get();

            $kehadiran = Mahasiswa::join('praktikums', 'mahasiswas.prak_id', 'praktikums.id')
            ->join('ujians', 'praktikums.id', 'ujians.prak_id')
            ->join('kehadirans', 'mahasiswas.id', 'kehadirans.mhs_id')
            ->select('mahasiswas.nim', 'mahasiswas.nama', 'mahasiswas.id','kehadirans.kehadiran')
            ->where('kehadirans.ujian_id', $ujian->id)
            ->orderBy('mahasiswas.nim', 'ASC')
            ->distinct()
            ->get();
        }

        if (count($kehadiran) >= 1) {
            return view('pengawas.absensi.edit', [
                'ujian' => $ujian,
                'mahasiswas' => $kehadiran,
                'now' => $now
            ]);
        } else {
            return view('pengawas.absensi.form', [
                'ujian' => $ujian,
                'mahasiswas' => $mahasiswa,
                'now' => $now
            ]);
        }
    }

    public function absensiCreate(Request $request)
    {
        for ($i = 0; $i < count($request->mhs_id); $i++) {
            $absen = new Kehadiran;
            $absen->mhs_id = $request->mhs_id[$i];
            $absen->ujian_id = $request->ujian_id;
            $absen->kehadiran = $request->kehadiran[$i];
            $absen->save();
        }

        return back()->with('success', 'Absensi berhasil disimpan');
    }

    public function absensiUpdate(Request $request)
    {
        for ($i = 0; $i < count($request->mhs_id); $i++) {
            Kehadiran::where('mhs_id', $request->mhs_id[$i])
            ->where('ujian_id', $request->ujian_id)
            ->update([
                'kehadiran' => $request->kehadiran[$i]
            ]);
        }

        return back()->with('success', 'Absensi berhasil disimpan');
    }

    public function absensiTtd($id)
    {
        $ujian = Ujian::find($id);

        return view('pengawas.absensi.ttd', [
            "ujian" => $ujian
        ]);
    }

    public function absensiExport(Request $request)
    {
        DB::beginTransaction();

        $ujian = Ujian::find($request->ujian_id);
        $dip = $ujian->Matkul->Semester->Prodi->kode_prodi;

        if ($dip == 'DIP') {
            $kehadiran = Mahasiswa::join('penjadwalans', 'mahasiswas.id', 'penjadwalans.mhs_id')
            ->join('ujians', 'penjadwalans.ujian_id', 'ujians.id')
            ->join('kehadirans', 'mahasiswas.id', 'kehadirans.mhs_id')
            ->select('mahasiswas.nim', 'mahasiswas.nama', 'mahasiswas.id','kehadirans.kehadiran')
            ->where('kehadirans.ujian_id', $request->ujian_id)
            ->orderBy('mahasiswas.nim', 'ASC')
            ->distinct()
            ->get();
            
        } else {
            $kehadiran = Mahasiswa::join('praktikums', 'mahasiswas.prak_id', 'praktikums.id')
            ->join('ujians', 'praktikums.id', 'ujians.prak_id')
            ->join('kehadirans', 'mahasiswas.id', 'kehadirans.mhs_id')
            ->select('mahasiswas.nim', 'mahasiswas.nama', 'mahasiswas.id','kehadirans.kehadiran')
            ->where('kehadirans.ujian_id', $request->ujian_id)
            ->orderBy('mahasiswas.nim', 'ASC')
            ->distinct()
            ->get();
        }

        $destination1 = 'images/ttd/ttd_pengawas1.png';
        $destination2 = 'images/ttd/ttd_pengawas2.png';
        if ($destination1 OR $destination2) {
            Storage::delete($destination1);
            Storage::delete($destination2);
        }
        
        $folderPath = Storage::path('images/ttd/');
        $image1 = explode(";base64,", $request->ttd1);
        $image_base1 = base64_decode($image1[1]);
        $fileName1 = 'ttd_pengawas1.png';
        $file1 = $folderPath . $fileName1;
        file_put_contents($file1, $image_base1);

        if ($request->ttd2) {
            $image2 = explode(";base64,", $request->ttd2);
            $image_base2 = base64_decode($image2[1]);
            $fileName2 = 'ttd_pengawas2.png';
            $file2 = $folderPath . $fileName2;
            file_put_contents($file2, $image_base2);
            $pengawas2 = $request->pengawas2;
        } else {
            $fileName2 = "0";
            $pengawas2 = "0";
        }

        $data = [
            'ujian' => $ujian,
            'mahasiswas' => $kehadiran,
            'master' => Master::find(1),
            'pengawas1' => $request->pengawas1,
            'pengawas2' => $pengawas2,
            'ttd1' => $fileName1,
            'ttd2' => $fileName2
        ];

        $pdf = PDF::loadView('layouts.kehadiran', $data);
        // return $pdf->stream();
        $pdfName = 'kehadiran_' . $ujian->tanggal . '_' . $ujian->Matkul->nama_matkul . '-' . $ujian->Matkul->Semester->Prodi->nama_prodi . '(' . $ujian->Praktikum->Kelas->kelas . $ujian->Praktikum->praktikum . ')' . '.pdf';
        
        $destination3 = 'files/kehadiran/' . $pdfName;
        if ($destination3) {
            Storage::delete($destination3);
        }

        Bap::find($request->ujian_id)->update(['kehadiran' => $pdfName]);
        Storage::put('files/kehadiran/' . $pdfName, $pdf->output());
        DB::commit();

        $user_id = Auth::user()->id;
        $ujian = Ujian::join('matkuls', 'ujians.matkul_id', 'matkuls.id')
        ->join('semesters AS a', 'matkuls.semester_id', 'a.id')
        ->join('praktikums', 'ujians.prak_id', 'praktikums.id')
        ->join('kelas', 'praktikums.kelas_id', 'kelas.id')
        ->join('semesters AS b', 'kelas.semester_id', 'b.id')
        ->join('prodis', 'b.prodi_id', 'prodis.id')
        ->join('penugasans', 'ujians.id', 'penugasans.ujian_id')
        ->join('pengawas', 'penugasans.pengawas_id', 'pengawas.id')
        ->join('baps', 'ujians.id', 'baps.ujian_id')
        ->select('pengawas.*', 'penugasans.*', 'prodis.*', 'b.*', 'kelas.*', 'praktikums.*', 'matkuls.*', 'baps.kehadiran', 'ujians.*')
        ->where('pengawas.user_id', $user_id)
        ->orderBy('ujians.tanggal', 'ASC')
        ->get();

        return view('pengawas.absensi.index', ["jadwal" => $ujian])->with('success', 'Kehadiran Mahasiswa berhasil ditandatangani');
    }

    public function profile()
    {
        $user_id = Auth::user()->id;
        return view('pengawas.profile', [
            'profil' => User::find($user_id)
        ]);
    }
    
    public function profileUpdate(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'nik' => 'required',
            'email' => 'required',
            'pns' => 'required',
            'bank' => 'required',
            'norek' => 'required',
            'tlp' => 'required',
        ]);

        Pengawas::find($request->pengawas_id)->update([
            'user_id' => $request->user_id,
            'nama' => $request->nama,
            'nik' => $request->nik,
            'pns' => $request->pns,
            'norek' => $request->norek,
            'bank' => $request->bank,
            'tlp' => $request->tlp,
        ]);

        User::find($request->user_id)->update([
            'name' => $request->nama,
            'email' => $request->email,
        ]);

        return back()->with('success', 'Profil Pengawas berhasil diperbarui');
    }

    public function pelanggaranIndex()
    {
        return view('pengawas.pelanggaran.index');
    }

    public function pelanggaranForm()
    {
        return view('pengawas.pelanggaran.form',[
            'ujians' => Ujian::all(),
            'mahasiswas' => Mahasiswa::all()
        ]);
    }

    public function pelanggaranEdit(Pelanggaran $pelanggaran)
    {
        return view('pengawas.pelanggaran.edit', [
            'pelanggarans' => $pelanggaran,
            'ujians' => Ujian::all(),
            'mahasiswas' => Mahasiswa::all()
        ]);
    }

    public function pelanggaranCreate(Request $request)
    {
        $validatedData = $request->validate([
            'ujian_id' => 'required',
            'mhs_id' => 'required',
            'pelanggaran' => 'required',
        ]);
  
        Pelanggaran::create($validatedData);
        $mahasiswa = Mahasiswa::find($request->mhs_id);
        $this->Activity(' menambahkan data pelanggaran untuk ' . $mahasiswa->nama);
        return redirect('/pengawas/ketidakhadiran/index')->with('success', 'Data ketidakhadiran berhasil ditambah');
    }

    public function pelanggaranUpdate(Request $request, Pelanggaran $pelanggaran)
    {
        $validatedData = $request->validate([
            'ujian_id' => 'required',
            'mhs_id' => 'required',
            'pelanggaran' => 'required',
        ]);


        Pelanggaran::where('id', $pelanggaran->id)
        ->update($validatedData);
        $mahasiswa = Mahasiswa::find($request->mhs_id);
        $this->Activity(' memperbarui data pelanggaran untuk ' . $mahasiswa->nama);
        return redirect('/pengawas/ketidakhadiran/index')->with('success', 'Data ketidakhadiran berhasil diperbarui');
    }

    public function pelanggaranDestroy(Pelanggaran $pelanggaran)
    {
        $mahasiswa = Mahasiswa::find($pelanggaran->mhs_id);
        $this->Activity(' menghapus data pelanggaran untuk ' . $mahasiswa->nama);
        Pelanggaran::destroy($pelanggaran->id);
        return redirect('/pengawas/ketidakhadiran/index')->with('success', 'Data ketidakhadiran berhasil dihapus');
    }
}
