<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Ujian;
use App\Models\Matkul;
use App\Models\Master;
use App\Models\Susulan;
use App\Models\Ketentuan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class mahasiswaController extends Controller
{
    public function dashboard()
    {
        $dataTanggalMulai = Master::first();
        $dataTanggalSelesai = Master::first();

        $from = $dataTanggalMulai->periode_mulai;
        $to = $dataTanggalSelesai->periode_akhir;
        
        $ketentuan = Ketentuan::all();
        $prak = Auth::user()->Mahasiswa->Praktikum->id;
        $ujian = Ujian::join('matkuls', 'ujians.matkul_id', 'matkuls.id')
            ->join('semesters AS a', 'matkuls.semester_id', 'a.id')
            ->join('praktikums', 'ujians.prak_id', 'praktikums.id')
            ->join('kelas', 'praktikums.kelas_id', 'kelas.id')
            ->join('semesters AS b', 'kelas.semester_id', 'b.id')
            ->join('prodis', 'b.prodi_id', 'prodis.id')
            ->where('praktikums.id', $prak)
            ->whereBetween('ujians.tanggal', [$from, $to])->get();

        return view('mahasiswa.dashboard', [
            "ketentuan" => $ketentuan,
            "ujian" => $ujian,
            "ujian1" => $ujian
        ]);
    }

    public function ujian()
    {
        $dataTanggalMulai = Master::first();
        $dataTanggalSelesai = Master::first();

        $from = $dataTanggalMulai->periode_mulai;
        $to = $dataTanggalSelesai->periode_akhir;

        $prak = Auth::user()->Mahasiswa->Praktikum->id;
        $susulan = Ujian::join('matkuls', 'ujians.matkul_id', 'matkuls.id')
        ->join('semesters AS a', 'matkuls.semester_id', 'a.id')
        ->join('praktikums', 'ujians.prak_id', 'praktikums.id')
        ->join('kelas', 'praktikums.kelas_id', 'kelas.id')
        ->join('semesters AS b', 'kelas.semester_id', 'b.id')
        ->join('prodis', 'b.prodi_id', 'prodis.id')
        ->where('praktikums.id', $prak)
        ->where('ujians.susulan', '1')
        ->whereBetween('ujians.tanggal', [$from, $to])
        ->get();

        $detail = $susulan;

        return view('mahasiswa.ujian', [
            "susulan" => $susulan,
            "detail" => $detail
        ]);
    }

    public function pengajuanIndex()
    {
        $mhs = Auth::user()->Mahasiswa->id;
        $pengajuan = Susulan::join('mahasiswas', 'susulans.mhs_id', 'mahasiswas.id')
        ->join('matkuls', 'susulans.matkul_id', 'matkuls.id')
        ->select('matkuls.*', 'susulans.*')
        ->where('susulans.mhs_id', $mhs)
        ->get();

        return view('mahasiswa.pengajuan.index', [
            "susulan" => $pengajuan
        ]);
    }

    public function pengajuanForm()
    {
        $smt = Auth::user()->Mahasiswa->Praktikum->Kelas->Semester->id;
        $prodi = Auth::user()->Mahasiswa->Praktikum->Kelas->Semester->Prodi->id;
        $matkul = Matkul::join('semesters', 'matkuls.semester_id', 'semesters.id')
            ->join('prodis', 'semesters.prodi_id', 'prodis.id')
            ->select('matkuls.id', 'matkuls.nama_matkul')
            ->where('semesters.id', $smt)
            ->where('prodis.id', $prodi)
            ->get();

        return view('mahasiswa.pengajuan.form', [
            "matkul" => $matkul
        ]);
    }

    public function pengajuanCreate(Request $request)
    {
        $request->validate([
            'matkul_id' => 'required',
            'tipe_mk' => 'required',
            'file' => 'required|max:2048'
        ]);

        $file = $request->file('file');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $file->storeAs('files/syarat', $fileName);
        // Storage::put('files/syarat/' . $fileName, $file);

        $susulan = new Susulan;
        $susulan->mhs_id = Auth::user()->Mahasiswa->id;
        $susulan->matkul_id = $request->matkul_id;
        $susulan->tipe_mk = $request->tipe_mk;
        $susulan->file = $fileName;
        $susulan->status = "Belum";
        $susulan->save();

        $matkul = Matkul::find($request->matkul_id);
        $this->Activity(' mengajukan susulan untuk Mata Kuliah ' . $matkul->nama_matkul);
        return redirect()->route('mahasiswa.susulan.pengajuan.index')->with('success', 'Ujian susulan telah diajukan!');
    }

    public function pengajuanUpdate(Request $request, $id)
    {
        $susulan = Susulan::find($id);

        $request->validate([
            'matkul_id' => 'required',
            'tipe_mk' => 'required',
            'file' => 'required|max:2048'
        ]);

        $file = $request->file('file');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $file->storeAs('files/syarat', $fileName);
        // Storage::put('files/syarat/' . $fileName, $file);

        $destination = 'files/syarat/' . $susulan->file;
        if ($destination) {
            Storage::delete($destination);
        }

        $susulan->update([
            'matkul_id' => $request->matkul_id,
            'tipe_mk' => $request->tipe_mk,
            'file' => $fileName
        ]);

        $matkul = Matkul::find($request->matkul_id);
        $this->Activity(' memperbarui pengajuan susulan untuk Mata Kuliah ' . $matkul->nama_matkul);
        return redirect()->route('mahasiswa.susulan.pengajuan.index')->with('success', 'Pengajuan susulan berhasil diubah!');
    }

    public function pengajuanDestroy($id)
    {
        $susulan = Susulan::find($id);
        $matkul = Matkul::find($susulan->matkul_id);
        $this->Activity(' menghapus pengajuan susulan untuk Mata Kuliah ' . $matkul->nama_matkul);
        $destination = 'files/syarat/' . $susulan->file;
        
        if ($destination) {
            Storage::delete($destination);
        }
        Susulan::find($id)->delete();

        return redirect()->route('mahasiswa.susulan.pengajuan.index')->with('success', 'Pengajuan susulan berhasil dihapus!');
    }

    public function pengajuanEdit($id)
    {
        $smt = Auth::user()->Mahasiswa->Praktikum->Kelas->Semester->id;
        $prodi = Auth::user()->Mahasiswa->Praktikum->Kelas->Semester->Prodi->id;
        $matkul = Matkul::join('semesters', 'matkuls.semester_id', 'semesters.id')
            ->join('prodis', 'semesters.prodi_id', 'prodis.id')
            ->select('matkuls.id', 'matkuls.nama_matkul')
            ->where('semesters.id', $smt)
            ->where('prodis.id', $prodi)
            ->get();

        $pengajuan = Susulan::join('mahasiswas', 'susulans.mhs_id', 'mahasiswas.id')
        ->join('matkuls', 'susulans.matkul_id', 'matkuls.id')
        ->select('susulans.id', 'matkuls.nama_matkul', 'susulans.tipe_mk', 'susulans.file', 'susulans.status', 'susulans.matkul_id')
        ->find($id)
        ->get();

        return view('mahasiswa.pengajuan.edit', [
            "pengajuan" => $pengajuan,
            "matkul" => $matkul
        ]);
    }
}
