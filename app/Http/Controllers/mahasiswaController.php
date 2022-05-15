<?php

namespace App\Http\Controllers;

use App\Models\Ketentuan;
use App\Models\Matkul;
use App\Models\Susulan;
use App\Models\Ujian;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class mahasiswaController extends Controller
{
    public function dashboard()
    {
        $ketentuan = Ketentuan::all();
        $prak = Auth::user()->Mahasiswa->Praktikum->id;
        $ujian = Ujian::join('matkuls', 'ujians.matkul_id', 'matkuls.id')
            ->join('semesters AS a', 'matkuls.semester_id', 'a.id')
            ->join('praktikums', 'ujians.prak_id', 'praktikums.id')
            ->join('kelas', 'praktikums.kelas_id', 'kelas.id')
            ->join('semesters AS b', 'kelas.semester_id', 'b.id')
            ->join('prodis', 'b.prodi_id', 'prodis.id')
            ->where('praktikums.id', $prak)->get();
        $ujian1 = $ujian;

        return view('mahasiswa.dashboard', [
            "ketentuan" => $ketentuan,
            "ujian" => $ujian,
            "ujian1" => $ujian1
        ]);
    }

    public function ujian()
    {
        $prak = Auth::user()->Mahasiswa->Praktikum->id;
        $susulan = Ujian::join('matkuls', 'ujians.matkul_id', 'matkuls.id')
        ->join('semesters AS a', 'matkuls.semester_id', 'a.id')
        ->join('praktikums', 'ujians.prak_id', 'praktikums.id')
        ->join('kelas', 'praktikums.kelas_id', 'kelas.id')
        ->join('semesters AS b', 'kelas.semester_id', 'b.id')
        ->join('prodis', 'b.prodi_id', 'prodis.id')
        ->where('praktikums.id', $prak)
        ->where('ujians.susulan', '1')
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
        ->select('matkuls.nama_matkul', 'susulans.tipe_mk', 'susulans.file', 'susulans.status', 'susulans.id')
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
            'file' => 'required|file|max:3072'
        ]);

        $file = $request->file('file');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $file->storeAs('files/syarat', $fileName);

        $susulan = new Susulan;
        $susulan->mhs_id = Auth::user()->Mahasiswa->id;
        $susulan->matkul_id = $request->matkul_id;
        $susulan->tipe_mk = $request->tipe_mk;
        $susulan->file = $fileName;
        $susulan->status = "Belum";
        $susulan->save();

        return redirect()->route('mahasiswa.susulan.pengajuan.index')->with('success', 'Ujian susulan telah diajukan!');
    }

    public function pengajuanUpdate(Request $request, $id)
    {
        $susulan = Susulan::find($id);

        $request->validate([
            'matkul_id' => 'required',
            'tipe_mk' => 'required',
            'file' => 'required|file|max:3072'
        ]);

        $file = $request->file('file');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $file->storeAs('files/syarat', $fileName);

        $destination = 'files/syarat/' . $susulan->file;
        if ($destination) {
            Storage::delete($destination);
        }

        $susulan->update([
            'matkul_id' => $request->matkul_id,
            'tipe_mk' => $request->tipe_mk,
            'file' => $fileName
        ]);

        return redirect()->route('mahasiswa.susulan.pengajuan.index')->with('success', 'Pengajuan susulan berhasil diubah!');
    }

    public function pengajuanDestroy($id)
    {
        $susulan = Susulan::find($id);
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
