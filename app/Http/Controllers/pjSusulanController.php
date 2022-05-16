<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Bap;
use App\Models\Ujian;
use App\Models\Amplop;
use App\Models\Berkas;
use App\Models\Susulan;
use App\Models\Master;
use App\Models\Ketentuan;
use App\Models\Pelanggaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use function PHPUnit\Framework\isEmpty;

class pjSusulanController extends Controller
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

        return view('pj_susulan.dashboard', [
            "ujian" => $ujian
        ]);
    }

    public function ketentuanIndex()
    {
        $ketentuan = Ketentuan::all();

        return view('pj_susulan.ketentuan.index', [
            "ketentuan" => $ketentuan
        ]);
    }

    public function ketentuanForm()
    {
        return view('pj_susulan.ketentuan.form', ["title" => env('APP_NAME')]);
    }

    public function ketentuanEdit($id)
    {
        $ketentuan = Ketentuan::find($id);

        return view('pj_susulan.ketentuan.edit', [
            "ketentuan" => $ketentuan
        ]);
    }

    public function ketentuanCreate(Request $request)
    {
        $request->validate([
            'ketentuan' => 'required'
        ]);

        $ketentuan = new Ketentuan;
        $ketentuan->ketentuan = $request->ketentuan;
        $ketentuan->save();

        return redirect()->route('pjSusulan.ketentuan.index')->with('success', 'Ketentuan baru berhasil ditambahkan!');
    }

    public function ketentuanUpdate(Request $request, $id)
    {
        $request->validate([
            'ketentuan' => 'required'
        ]);

        $ketentuan = Ketentuan::find($id);
        $ketentuan->update($request->all());

        return redirect()->route('pjSusulan.ketentuan.index')->with('success', 'Ketentuan berhasil diperbarui!');
    }

    public function ketentuanDestroy($id)
    {
        Ketentuan::find($id)->delete();
        return redirect()->route('pjSusulan.ketentuan.index')->with('success', 'Ketentuan berhasil dihapus!');
    }
    
    public function mahasiswaIndex()
    {
        $mahasiswa = Susulan::all();

        return view('pj_susulan.mahasiswa', [
            "mahasiswa" => $mahasiswa,
            "mahasiswas" => $mahasiswa
        ]);
    }

    public function mahasiswaUpdate(Request $request, $id)
    {
        $susulan = Susulan::find($id);
        $susulan->update([
            'status' => $request->status
        ]);

        if ($request->status == 'Disetujui'){
            $message = "Pengajuan berhasil disetujui!";
        } else {
            $message = "Pengajuan berhasil ditolak!";
        }

        return redirect()->route('pjSusulan.mahasiswa.index')->with('success', $message);
    }

    public function penjadwalanIndex()
    {
        $mahasiswa = Susulan::join('mahasiswas', 'susulans.mhs_id', 'mahasiswas.id')
        ->join('praktikums', 'mahasiswas.prak_id', 'praktikums.id')
        ->join('kelas', 'praktikums.kelas_id', 'kelas.id')
        ->join('semesters AS a', 'kelas.semester_id', 'a.id')
        ->join('matkuls', 'susulans.matkul_id', 'matkuls.id')
        ->join('semesters AS b', 'matkuls.semester_id', 'b.id')
        ->join('prodis', 'b.prodi_id', 'prodis.id')
        ->selectRaw('mahasiswas.prak_id, prodis.nama_prodi, b.semester, b.prodi_id, kelas.kelas, kelas.semester_id, praktikums.praktikum, praktikums.kelas_id, matkuls.nama_matkul, susulans.tipe_mk, susulans.matkul_id, count(susulans.mhs_id) as total_mhs')
        ->groupBy('mahasiswas.prak_id', 'prodis.nama_prodi', 'b.semester', 'b.prodi_id', 'kelas.kelas', 'kelas.semester_id', 'praktikums.praktikum', 'praktikums.kelas_id', 'matkuls.nama_matkul', 'susulans.tipe_mk', 'susulans.matkul_id')
        ->where('susulans.status', '=', 'Disetujui')
        ->get();

        return view('pj_susulan.penjadwalan.index', [
            "jadwal" => $mahasiswa
        ]);
    }

    public function penjadwalanForm(Request $request)
    {
        return view('pj_susulan.penjadwalan.form', [
            "prodi_id" => $request->prodi_id,
            "semester_id" => $request->semester_id,
            "kelas_id" => $request->kelas_id,
            "praktikum_id" => $request->praktikum_id,
            "matkul_id" => $request->matkul_id,
            "tipe_mk" => $request->tipe_mk,
            "nama_prodi" => $request->nama_prodi,
            "semester" => $request->semester,
            "kelas" => $request->kelas,
            "praktikum" => $request->praktikum,
            "nama_matkul" => $request->nama_matkul
        ]);
    }

    public function jadwalCreate(Request $request)
    {
        $request->validate([
            'prak_id' => 'required',
            'matkul_id' => 'required',
            'isuas' => 'required',
            'hari' => 'required',
            'lokasi' => 'nullable',
            'ruang' => 'nullable',
            'kapasitas' => 'nullable',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required',
            'tanggal' => 'required',
            'tahun' => 'required',
            'tipe_mk' => 'required',
            'software' => 'required',
            'perbanyak' => 'required',
            'sesi' => 'required',
            'pelaksanaan' => 'required',
        ]);

        $jadwal = new Ujian;
        $jadwal->prak_id = $request->prak_id;
        $jadwal->matkul_id = $request->matkul_id;
        $jadwal->isuas = $request->isuas;
        $jadwal->hari = $request->hari;
        $jadwal->lokasi = $request->lokasi;
        $jadwal->ruang = $request->ruang;
        $jadwal->kapasitas = $request->kapasitas;
        $jadwal->jam_mulai = $request->jam_mulai;
        $jadwal->jam_selesai = $request->jam_selesai;
        $jadwal->tanggal = $request->tanggal;
        $jadwal->tahun = $request->tahun;
        $jadwal->tipe_mk = $request->tipe_mk;
        $jadwal->software = $request->software;
        $jadwal->susulan = "1";
        $jadwal->perbanyak = $request->perbanyak;
        $jadwal->sesi = $request->sesi;
        $jadwal->pelaksanaan = $request->pelaksanaan;
        $jadwal->save();

        $late = Ujian::orderBy('id', 'DESC')->take(1)->get();
        foreach ($late as $IDUjian) {
            $latest = $IDUjian->id;
        }
        
        $amplop = new Amplop;
        $amplop->ujian_id = $latest;
        $amplop->print = "Belum";
        $amplop->pengambilan = "Belum";
        $amplop->save();

        $bap = new Bap;
        $bap->ujian_id = $latest;
        $bap->print = "Belum";
        $bap->pengambilan = "Belum";
        $bap->save();

        $berkas = new Berkas;
        $berkas->ujian_id = $latest;
        $berkas->jml_berkas = "0";
        $berkas->pengambilan = "Belum";
        $berkas->fotokopi = "Belum";
        $berkas->lengkap = "Belum";
        $berkas->asisten = "Belum";
        $berkas->serah_terima = "Belum";
        $berkas->save();

        Susulan::join('mahasiswas', 'susulans.mhs_id', 'mahasiswas.id')
        ->join('praktikums', 'mahasiswas.prak_id', 'praktikums.id')
        ->where('praktikums.id', $request->prak_id)
        ->where('susulans.matkul_id', $request->matkul_id)
        ->update(['status' => 'Terjadwal']);

        return redirect()->route('pjSusulan.penjadwalan.index')->with('success', 'Jadwal ujian susulan baru telah ditambahkan!');
    }

    public function jadwalUpdate(Request $request, $id)
    {
        $request->validate([
            'prak_id' => 'required',
            'matkul_id' => 'required',
            'isuas' => 'required',
            'hari' => 'required',
            'lokasi' => 'nullable',
            'ruang' => 'nullable',
            'kapasitas' => 'nullable',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required',
            'tanggal' => 'required',
            'tahun' => 'required',
            'tipe_mk' => 'required',
            'software' => 'required',
            'perbanyak' => 'required',
            'sesi' => 'required',
            'pelaksanaan' => 'required',
        ]);

        $jadwal = Ujian::find($id);
        $jadwal->update([
            'hari' => $request->hari,
            'lokasi' => $request->lokasi,
            'ruang' => $request->ruang,
            'kapasitas' => $request->kapasitas,
            'jam_mulai' => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
            'tanggal' => $request->tanggal,
            'software' => $request->software,
            'perbanyak' => $request->perbanyak,
            'sesi' => $request->sesi,
            'pelaksanaan' => $request->pelaksanaan
        ]);

        return redirect()->route('pjSusulan.jadwal.index')->with('success', 'Jadwal ujian telah berhasil diubah!');
    }

    public function jadwalDestroy(Request $request, $id)
    {
        Ujian::find($id)->delete();
        Susulan::join('mahasiswas', 'susulans.mhs_id', 'mahasiswas.id')
        ->join('praktikums', 'mahasiswas.prak_id', 'praktikums.id')
        ->where('praktikums.id', $request->prak_id)
        ->where('susulans.matkul_id', $request->matkul_id)
        ->delete();

        Amplop::where('ujian_id', $id)->delete();
        Bap::where('ujian_id', $id)->delete();
        Berkas::where('ujian_id', $id)->delete();
        Pelanggaran::where('ujian_id', $id)->delete();

        return redirect()->route('pjSusulan.jadwal.index')->with('success', 'Jadwal ujian susulan berhasil dihapus!');
    }

    public function jadwalIndex()
    {
        $susulan = Ujian::join('matkuls', 'ujians.matkul_id', 'matkuls.id')
        ->join('semesters AS a', 'matkuls.semester_id', 'a.id')
        ->join('praktikums', 'ujians.prak_id', 'praktikums.id')
        ->join('kelas', 'praktikums.kelas_id', 'kelas.id')
        ->join('semesters AS b', 'kelas.semester_id', 'b.id')
        ->join('prodis', 'b.prodi_id', 'prodis.id')
        ->select('b.*', 'matkuls.*', 'prodis.*', 'praktikums.*', 'kelas.*', 'ujians.*')
        ->where('ujians.susulan', '=', '1')
        ->get();

        $susulans = $susulan;

        return view('pj_susulan.jadwal.index', [
            "susulan" => $susulan,
            "susulans" => $susulans,
        ]);
    }

    public function jadwalEdit($id)
    {
        return view('pj_susulan.jadwal.edit', [
            "ujian" => Ujian::find($id)
        ]);
    }

    public function pelanggaran()
    {
        return view('pj_susulan.pelanggaran', ["title" => env('APP_NAME')]);
    }
}
