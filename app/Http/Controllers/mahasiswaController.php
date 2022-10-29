<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Ujian;
use App\Models\Matkul;
use App\Models\Master;
use App\Models\Susulan;
use App\Models\Ketentuan;
use App\Models\Pelanggaran;
use App\Models\Praktikum;
use App\Models\Mahasiswa;
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
            "susulan" => $pengajuan,
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
            ->where('prodis.id', $prodi);
        
        $mhs_id = Auth::user()->Mahasiswa->id;
        
        $pelanggaran = Pelanggaran::join('ujians', 'pelanggarans.ujian_id', 'ujians.id')
        ->where('mhs_id', $mhs_id)
        ->where('pelanggaran', '!=', 'Sakit')
        ->where('pelanggaran', '!=', 'Izin')
        ->select('matkul_id')
        ->get();

        $tertolak = Susulan::where('mhs_id', $mhs_id)
        ->where('status', 'Ditolak')
        ->select('matkul_id')
        ->get();

        $count1 = count($pelanggaran);
        $count2 = count($tertolak);
        
        if ($count1 >= 1) {
            for ($i = 0; $i < $count1; $i++) {
                $matkul->where('matkuls.id', '!=', $pelanggaran[$i]->matkul_id);
            }
        }

        if ($count2 >= 1) {
            for ($j = 0; $j < $count2; $j++) {
                $matkul->where('matkuls.id', '!=', $tertolak[$j]->matkul_id);
            }
        }

        return view('mahasiswa.pengajuan.form', [
            "matkul" => $matkul->get()
        ]);
    }

    public function pengajuanCreate(Request $request)
    {
        $request->validate([
            'matkul_id' => 'required',
            'tipe_mk' => 'required',
            'file' => 'required|max:2048',
            'alasan' => 'required'
        ]);

        $file = $request->file('file');
        $fileName = time() . '_BuktiPersetujuan';
        $file->storeAs('files/syarat', $fileName);
        // Storage::put('files/syarat/' . $fileName, $file);

        $susulan = new Susulan;
        $susulan->mhs_id = Auth::user()->Mahasiswa->id;
        $susulan->matkul_id = $request->matkul_id;
        $susulan->tipe_mk = $request->tipe_mk;
        $susulan->file = $fileName;
        $susulan->alasan = $request->alasan;
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
            'file' => 'required|max:2048',
            'alasan' => 'required'
        ]);

        $file = $request->file('file');
        $fileName = time() . '_BuktiPersetujuan';
        $file->storeAs('files/syarat', $fileName);
        // Storage::put('files/syarat/' . $fileName, $file);

        $destination = 'files/syarat/' . $susulan->file;
        if ($destination) {
            Storage::delete($destination);
        }

        $susulan->update([
            'matkul_id' => $request->matkul_id,
            'tipe_mk' => $request->tipe_mk,
            'file' => $fileName,
            'alasan' => $request->alasan
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
            ->where('prodis.id', $prodi);
        
        $mhs_id = Auth::user()->Mahasiswa->id;
        
        $pelanggaran = Pelanggaran::join('ujians', 'pelanggarans.ujian_id', 'ujians.id')
        ->where('mhs_id', $mhs_id)
        ->where('pelanggaran', '!=', 'Sakit')
        ->where('pelanggaran', '!=', 'Izin')
        ->where('pelanggaran', '!=', 'Tanpa Keterangan')
        ->select('matkul_id')
        ->get();

        $tertolak = Susulan::where('mhs_id', $mhs_id)
        ->where('status', 'Ditolak')
        ->select('matkul_id')
        ->get();

        $count1 = count($pelanggaran);
        $count2 = count($tertolak);
        
        if ($count1 >= 1) {
            for ($i = 0; $i < $count1; $i++) {
                $matkul->where('matkuls.id', '!=', $pelanggaran[$i]->matkul_id);
            }
        }

        if ($count2 >= 1) {
            for ($j = 0; $j < $count2; $j++) {
                $matkul->where('matkuls.id', '!=', $tertolak[$j]->matkul_id);
            }
        }

        $pengajuan = Susulan::find($id);

        return view('mahasiswa.pengajuan.edit', [
            "pengajuan" => $pengajuan,
            "matkul" => $matkul->get()
        ]);
    }

    public function profile()
    {
        $user_id = Auth::user()->id;

        $profile = User::join('mahasiswas', 'users.id', 'mahasiswas.user_id')
        ->join('praktikums', 'mahasiswas.prak_id', 'praktikums.id')
        ->join('kelas', 'praktikums.kelas_id', 'kelas.id')
        ->join('semesters', 'kelas.semester_id', 'semesters.id')
        ->join('prodis', 'semesters.prodi_id', 'prodis.id')
        ->select('prodis.*', 'semesters.*', 'kelas.*', 'praktikums.*', 'users.*', 'mahasiswas.*')
        ->where('mahasiswas.user_id', $user_id)
        ->first();

        return view('mahasiswa.profile', [
            'profil' => $profile
        ]);
    }

    public function profileUpdate(Request $request)
    {
        $request->validate([
            'prodi' => 'required',
            'semester' => 'required',
            'kelas' => 'required',
            'praktikum' => 'required',
            'nama' => 'required',
            'email' => 'required',
            'nim' => 'required'
        ]);
        
        $user_id = Auth::user()->id;

        $prak_id = Praktikum::join('kelas', 'praktikums.kelas_id', 'kelas.id')
        ->join('semesters', 'kelas.semester_id', 'semesters.id')
        ->join('prodis', 'semesters.prodi_id', 'prodis.id')
        ->select('praktikums.id')
        ->where('prodis.nama_prodi', $request->prodi)
        ->where('semesters.semester', $request->semester)
        ->where('kelas.kelas', $request->kelas)
        ->where('praktikums.praktikum', $request->praktikum)
        ->first();

        User::find($user_id)->update([
            'name' => $request->nama,
            'email' => $request->email
        ]);

        Mahasiswa::find($request->mhs_id)->update([
            'nama' => $request->nama,
            'nim' => $request->nim,
            'email' => $request->email,
            'prak_id' => $prak_id->id
        ]);

        return back()->with('success', 'Profil Mahasiswa berhasil diperbarui');
    }
}
