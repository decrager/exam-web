<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Bap;
use App\Models\Kelas;
use App\Models\Prodi;
use App\Models\Ujian;
use App\Models\Amplop;
use App\Models\Berkas;
use App\Models\Master;
use App\Models\Matkul;
use App\Models\Susulan;
use App\Models\Pengawas;
use App\Models\Semester;
use Barryvdh\DomPDF\Facade as PDF;
use App\Models\Mahasiswa;
use App\Models\Penugasan;
use App\Exports\LogExport;
use App\Models\Pelanggaran;
use App\Exports\UjianExport;
use Illuminate\Http\Request;
use App\Models\LogActivities;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Redis;
use function PHPUnit\Framework\isEmpty;
use Illuminate\Support\Facades\Storage;

class pjUjianController extends Controller
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

        return view('pj_ujian.dashboard', [
            "dbUjian" => $ujian->get()
        ]);
    }

    public function ujianIndex()
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
        ->whereBetween('ujians.tanggal', [$from, $to])
        ->where('ujians.susulan', '0')
        ->filter(request(['dbProdi', 'dbSemester', 'dbPraktikum', 'dbKelas', 'dbMatkul', 'dbTanggal', 'dbRuang']));

        return view('pj_ujian.ujian.index', [
            "jadwal" => $ujian->get()
        ]);
    }

    public function export()
    {
        $this->Activity(' mengeksport jadwal ujian ke excel');
        return Excel::download(new UjianExport, 'dataujian.xlsx');
    }

    public function ujianForm()
    {
        return view('pj_ujian.ujian.form', ["title" => env('APP_NAME')]);
    }

    public function ujianEdit($id)
    {
        $ujian = Ujian::find($id);
        return view('pj_ujian.ujian.edit', [
            "ujian" => $ujian
        ]);
    }

    public function ujianCreate(Request $request)
    {
        $request->validate([
            'praktikum' => 'required',
            'matkul' => 'required',
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
            'software' => 'nullable',
            'perbanyak' => 'nullable',
            'sesi' => 'required',
            'pelaksanaan' => 'required',
        ]);

        $ujian = new Ujian;
        $ujian->prak_id = $request->praktikum;
        $ujian->matkul_id = $request->matkul;
        $ujian->isuas = $request->isuas;
        $ujian->hari = $request->hari;
        $ujian->lokasi = $request->lokasi;
        $ujian->ruang = $request->ruang;
        $ujian->kapasitas = $request->kapasitas;
        $ujian->jam_mulai = $request->jam_mulai;
        $ujian->jam_selesai = $request->jam_selesai;
        $ujian->tanggal = $request->tanggal;
        $ujian->tahun = $request->tahun;
        $ujian->tipe_mk = $request->tipe_mk;
        $ujian->software = $request->software;
        $ujian->susulan = "0";
        $ujian->perbanyak = $request->perbanyak;
        $ujian->sesi = $request->sesi;
        $ujian->pelaksanaan = $request->pelaksanaan;
        $ujian->save();

        $late = Ujian::orderBy('id', 'DESC')->take(1)->get();
        foreach ($late as $IDUjian) {
            $latest = $IDUjian->id;
        }
        
        $amplop = new Amplop;
        $amplop->ujian_id = $latest;
        $amplop->save();

        $bap = new Bap;
        $bap->ujian_id = $latest;
        $bap->save();

        $berkas = new Berkas;
        $berkas->ujian_id = $latest;
        $berkas->jml = "0";
        $berkas->save();

        $this->Activity(' menambahkan jadwal ujian baru');
        return redirect()->route('pjUjian.jadwal.index')->with('success', 'Jadwal baru telah ditambahkan!');
    }

    public function UjianUpdate(Request $request, $id)
    {
        $request->validate([
            'praktikum' => 'required',
            'matkul' => 'required',
            'isuas' => 'required',
            'hari' => 'required',
            'ruang' => 'nullable',
            'kapasitas' => 'nullable',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required',
            'tanggal' => 'required',
            'tahun' => 'required',
            'tipe_mk' => 'required',
            'sesi' => 'required',
            'pelaksanaan' => 'nullable',
        ]);
        
        $ujian = Ujian::find($id);
        // $ujian['prak_id'] = $request->praktikum;
        $ujian->update([
            'prak_id' => $request->praktikum,
            'matkul_id' => $request->matkul,
            'isuas' => $request->isuas,
            'hari' => $request->hari,
            'ruang' => $request->ruang,
            'kapasitas' => $request->kapasitas,
            'jam_mulai' => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
            'tanggal' => $request->tanggal,
            'tahun' => $request->tahun,
            'tipe_mk' => $request->tipe_mk,
            'sesi' => $request->sesi,
            'susulan' => "0",
            'pelaksanaan' => $request->pelaksanaan,
        ]);

        $this->Activity(' memperbarui jadwal ujian');
        return redirect()->route('pjUjian.jadwal.index')->with('success', 'Jadwal berhasil diubah!');
    }

    public function ujianDestroy($id)
    {
        Ujian::find($id)->delete();
        Amplop::where('ujian_id', $id)->delete();
        Bap::where('ujian_id', $id)->delete();
        Berkas::where('ujian_id', $id)->delete();
        Pelanggaran::where('ujian_id', $id)->delete();
        Penugasan::where('ujian_id', $id)->delete();
        $this->Activity(' menghapus jadwal ujian');
        return redirect()->route('pjUjian.jadwal.index')->with('success', 'Jadwal sudah dihapus!');
    }

    public function pengawasIndex()
    {
        $dataTanggalMulai = Master::first();
        $dataTanggalSelesai = Master::first();

        $from = $dataTanggalMulai->periode_mulai;
        $to = $dataTanggalSelesai->periode_akhir;

        $pengawas = Penugasan::join('pengawas', 'penugasans.pengawas_id', 'pengawas.id')
        ->join('ujians', 'penugasans.ujian_id', 'ujians.id')
        ->join('matkuls', 'ujians.matkul_id', 'matkuls.id')
        ->join('semesters AS a', 'matkuls.semester_id', 'a.id')
        ->join('praktikums', 'ujians.prak_id', 'praktikums.id')
        ->join('kelas', 'praktikums.kelas_id', 'kelas.id')
        ->join('semesters AS b', 'kelas.semester_id', 'b.id')
        ->join('prodis', 'b.prodi_id', 'prodis.id')
        ->select('ujians.*', 'matkuls.*', 'b.*', 'praktikums.*', 'kelas.*', 'prodis.*', 'pengawas.*', 'penugasans.*')
        ->filter(request(['dbProdi', 'dbSemester', 'dbPraktikum', 'dbKelas', 'dbMatkul', 'dbTanggal', 'dbRuang']));

        $pengawas = $pengawas->whereBetween('ujians.tanggal', [$from, $to])->get();
        
        return view('pj_ujian.pengawas.index', [
            "dataPengawas" => $pengawas
        ]);
    }

    public function pengawasEdit($id)
    {
        $penugasan = Penugasan::find($id);
        $selected = Pengawas::find($penugasan->pengawas_id);
        $pengawas = Pengawas::all();

        return view('pj_ujian.pengawas.edit', [
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
        return redirect()->route('pjUjian.pengawas.pengawas.index')->with('success', 'Pengawas sudah diperbarui!');
    }

    public function pengawasDestroy($id)
    {
        $penugasan = Penugasan::find($id);
        $pengawas = Pengawas::find($penugasan->pengawas_id);
        $this->Activity(' menghapus data pengawas ' . $pengawas->nama);
        $penugasan->delete();
        return redirect()->route('pjUjian.pengawas.pengawas.index')->with('success', 'Pengawas sudah dihapus!');
    }

    public function penugasanIndex()
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
        ->whereBetween('ujians.tanggal', [$from, $to])
        ->filter(request(['dbProdi', 'dbSemester', 'dbPraktikum', 'dbKelas', 'dbMatkul', 'dbTanggal', 'dbRuang']));

        return view('pj_ujian.penugasan.index', [
            "penugasan" => $ujian->get()
        ]);
    }

    public function penugasanForm($id)
    {
        $ujian = Ujian::find($id);
        $pengawas = Pengawas::all();

        return view('pj_ujian.penugasan.form', [
            "ujian" => $ujian,
            "pengawas" => $pengawas
        ]);
    }

    public function penugasanCreate(Request $request)
    {
        $request->validate([
            'ujian_id' => 'required',
            'pengawas_id' => 'required'
        ]);

        $penugasan = new Penugasan;
        $penugasan->ujian_id = $request->ujian_id;
        $penugasan->pengawas_id = $request->pengawas_id;
        $penugasan->save();

        $this->Activity(' menugaskan pengawas ' . $request->nama);
        return redirect()->route('pjUjian.pengawas.penugasan.index')->with('success', 'Pengawas berhasil ditambahkan!');
    }

    public function amplop()
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
        ->whereBetween('ujians.tanggal', [$from, $to])
        ->filter(request(['dbProdi', 'dbSemester', 'dbPraktikum', 'dbKelas', 'dbMatkul', 'dbTanggal', 'dbRuang']));

        return view('pj_ujian.amplop', [
            "amplop" => $ujian->get()
        ]);
    }

    public function bap()
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
        ->whereBetween('ujians.tanggal', [$from, $to])
        ->filter(request(['dbProdi', 'dbSemester', 'dbPraktikum', 'dbKelas', 'dbMatkul', 'dbTanggal', 'dbRuang']));

        return view('pj_ujian.bap', [
            "bap" => $ujian->get()
        ]);
    }

    public function berkas()
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
        ->whereBetween('ujians.tanggal', [$from, $to])
        ->filter(request(['dbProdi', 'dbSemester', 'dbPraktikum', 'dbKelas', 'dbMatkul', 'dbTanggal', 'dbRuang']));

        return view('pj_ujian.berkas', [
            "berkas" => $ujian->get()
        ]);
    }

    public function berkasUpdate($id)
    {
        $berkas = Berkas::find($id);
        
        if ($berkas->validasi == "Belum") {
            $berkas->update([
                'validasi' => 'Sudah'
            ]);
            $this->Activity(' memperbarui status Validasi untuk Soal Ujian menjadi Sudah divalidasi');
        } else {
            $berkas->update([
                'validasi' => 'Belum'
            ]);
            $this->Activity(' memperbarui status Validasi untuk Soal Ujian menjadi Belum divalidasi');
        }

        return redirect()->route('pjUjian.kelengkapan.berkas.index')->with('success', 'Status pengambil soal ujian berhasil diubah!');
    }

    public function ttd()
    {
        $tglbln = Carbon::now()->translatedFormat('d F Y');
        return view('pj_ujian.ttd', [
            'master' => Master::find(1),
            'tglbln' => $tglbln
        ]);
    }

    public function susulan()
    {
        $mahasiswa = Susulan::all();

        return view('pj_ujian.susulan', [
            "mahasiswa" => $mahasiswa,
            "mahasiswas" => $mahasiswa
        ]);
    }

    public function susulanUpdate(Request $request, $id)
    {
        $susulan = Susulan::find($id);
        $mahasiswa = Mahasiswa::find($susulan->mhs_id);
        $susulan->update([
            'status' => $request->status
        ]);

        if ($request->status == 'Disetujui'){
            $message = "Pengajuan berhasil disetujui!";
            $this->Activity(' menyetujui pengajuan susulan untuk ' . $mahasiswa->nama);
        } else {
            $message = "Pengajuan berhasil ditolak!";
            $this->Activity(' menolak pengajuan susulan untuk ' . $mahasiswa->nama);
        }

        return redirect()->route('pjUjian.susulan.mahasiswa')->with('success', $message);
    }

    public function pelanggaran()
    {
        return view('pj_ujian.pelanggaran', ["title" => env('APP_NAME')]);
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

        return view('pj_ujian.penjadwalan.index', [
            "jadwal" => $mahasiswa
        ]);
    }

    public function penjadwalanForm(Request $request)
    {
        return view('pj_ujian.penjadwalan.form', [
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

    public function penjadwalanCreate(Request $request)
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
        $amplop->save();

        $bap = new Bap;
        $bap->ujian_id = $latest;
        $bap->save();

        $berkas = new Berkas;
        $berkas->ujian_id = $latest;
        $berkas->jml = "0";
        $berkas->save();

        Susulan::join('mahasiswas', 'susulans.mhs_id', 'mahasiswas.id')
        ->join('praktikums', 'mahasiswas.prak_id', 'praktikums.id')
        ->where('praktikums.id', $request->prak_id)
        ->where('susulans.matkul_id', $request->matkul_id)
        ->update(['status' => 'Terjadwal']);

        $this->Activity(' menambahkan jadwal ujian susulan baru');
        return redirect()->route('pjUjian.susulan.penjadwalan.index')->with('success', 'Jadwal ujian susulan baru telah ditambahkan!');
    }

    public function susulanIndex()
    {
        $dataTanggalMulai = Master::first();
        $dataTanggalSelesai = Master::first();

        $from = $dataTanggalMulai->periode_mulai;
        $to = $dataTanggalSelesai->periode_akhir;

        $susulan = Ujian::join('matkuls', 'ujians.matkul_id', '=', 'matkuls.id')
        ->join('semesters AS a', 'matkuls.semester_id', '=', 'a.id')
        ->join('praktikums', 'ujians.prak_id', '=', 'praktikums.id')
        ->join('kelas', 'praktikums.kelas_id', '=', 'kelas.id')
        ->join('semesters AS b', 'kelas.semester_id', '=', 'b.id')
        ->join('prodis', 'b.prodi_id', '=', 'prodis.id')
        ->join('amplops', 'amplops.ujian_id', '=', 'ujians.id')
        ->join('baps', 'baps.ujian_id', '=', 'ujians.id')
        ->join('berkas', 'berkas.ujian_id', '=', 'ujians.id')
        ->whereBetween('ujians.tanggal', [$from, $to])
        ->where('ujians.susulan', '1')
        ->filter(request(['dbProdi', 'dbSemester', 'dbPraktikum', 'dbKelas', 'dbMatkul', 'dbTanggal', 'dbRuang']));

        $susulans = $susulan;

        return view('pj_ujian.susulan.index', [
            "susulan" => $susulan,
            "susulans" => $susulans,
        ]);
    }

    public function susulanEdit($id)
    {
        return view('pj_ujian.susulan.edit', [
            "ujian" => Ujian::find($id)
        ]);
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

        $this->Activity(' memperbarui jadwal ujian susulan');
        return redirect()->route('pjUjian.susulan.susulan.index')->with('success', 'Jadwal ujian telah berhasil diubah!');
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

        $this->Activity(' memperbarui jadwal ujian susulan');
        return redirect()->route('pjUjian.susulan.susulan.index')->with('success', 'Jadwal ujian susulan berhasil dihapus!');
    }

    public function logActivities()
    {
        $log = LogActivities::Filter(Request(['tanggal']))->latest()->take(300)->get();
        return view('pj_ujian.log', ['activity' => $log]);
    }

    public function logExport()
    {
        $this->Activity(' mengeksport catatan aktivitas ke excel');
        return Excel::download(new LogExport, 'LogActivities.xlsx');
    }

    public function SerahTerima(Request $request)
    {
        DB::beginTransaction();

        $destination1 = 'images/qr/ttd_penyerah.png';
        $destination2 = 'images/qr/ttd_penerima.png';
        if ($destination1 AND $destination2) {
            Storage::delete($destination1);
            Storage::delete($destination2);
        }
        
        $folderPath = public_path('storage/images/qr/');
        $image1 = explode(";base64,", $request->ttd_penyerah);
        $image_base1 = base64_decode($image1[1]);
        $fileName1 = 'ttd_penyerah.png';
        $file1 = $folderPath . $fileName1;
        file_put_contents($file1, $image_base1);

        $image2 = explode(";base64,", $request->ttd_penerima);
        $image_base2 = base64_decode($image2[1]);
        $fileName2 = 'ttd_penerima.png';
        $file2 = $folderPath . $fileName2;
        file_put_contents($file2, $image_base2);

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
        $this->Activity(' melakukan serah terima berkas');
        DB::commit();

        return redirect()->route('pjUjian.kelengkapan.berkas.index')->with('success', 'Berkas Serah Terima berhasil ditanda tangani!');
    }

    public function SerahTerimaDestroy($id)
    {
        DB::beginTransaction();
        $fileName = Berkas::where('ujian_id', $id)->select('file')->first();

        $destination = 'files/pdf/' . $fileName->file;
        if ($destination) {
            Storage::delete($destination);
        }

        Berkas::where('file', $fileName->file)->update([
            'serah_terima' => 'Belum',
            'file' => null
        ]);
        DB::commit();
        
        return redirect()->route('pjUjian.kelengkapan.berkas.index')->with('success', 'Berkas Serah Terima berhasil dihapus!');
    }
}
