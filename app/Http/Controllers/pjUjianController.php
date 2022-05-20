<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Bap;
use App\Models\Prodi;
use App\Models\Ujian;
use App\Models\Amplop;
use App\Models\Berkas;
use App\Models\Master;
use App\Models\Susulan;
use App\Models\Pengawas;
use App\Models\Pelanggaran;
use App\Exports\UjianExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Redis;
use function PHPUnit\Framework\isEmpty;

class pjUjianController extends Controller
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
            $ujian = $ujian->get();
        }

        return view('pj_ujian.dashboard', [
            "dbUjian" => $ujian
        ]);
    }

    public function ujianIndex(Request $request)
    {
        $dataTanggalMulai = Master::first();
        $dataTanggalSelesai = Master::first();

        $from = $dataTanggalMulai->periode_mulai;
        $to = $dataTanggalSelesai->periode_akhir;

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
            $ujian->whereBetween('ujians.tanggal', [$from, $to]);

            $ujian = $ujian->get();
        }

        return view('pj_ujian.ujian.index', [
            "jadwal" => $ujian
        ]);
    }

    public function export(){
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
        $berkas->jml_berkas = "0";
        $berkas->save();

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

        return redirect()->route('pjUjian.jadwal.index')->with('success', 'Jadwal berhasil diubah!');
    }

    public function ujianDestroy($id)
    {
        Ujian::find($id)->delete();
        Amplop::where('ujian_id', $id)->delete();
        Bap::where('ujian_id', $id)->delete();
        Berkas::where('ujian_id', $id)->delete();
        Pelanggaran::where('ujian_id', $id)->delete();
        Pengawas::where('ujian_id', $id)->delete();
        return redirect()->route('pjUjian.jadwal.index')->with('success', 'Jadwal sudah dihapus!');
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

        $pengawas = $pengawas->whereBetween('ujians.tanggal', [$from, $to])->get();

        return view('pj_ujian.pengawas.index', [
            "dataPengawas" => $pengawas
        ]);
    }

    public function pengawasEdit($id)
    {
        $pengawas = Pengawas::find($id);

        return view('pj_ujian.pengawas.edit', [
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
            'pns' => $request->pns
        ]);

        return redirect()->route('pjUjian.pengawas.pengawas.index')->with('success', 'Pengawas sudah diperbarui!');
    }

    public function pengawasDestroy($id)
    {
        Pengawas::find($id)->delete();

        return redirect()->route('pjUjian.pengawas.pengawas.index')->with('success', 'Pengawas sudah dihapus!');
    }

    public function penugasanIndex(Request $request)
    {
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
            $ujian = $ujian->get();
        }

        return view('pj_ujian.penugasan.index', [
            "penugasan" => $ujian
        ]);
    }

    public function penugasanForm($id)
    {
        $ujian = Ujian::find($id);

        return view('pj_ujian.penugasan.form', [
            "ujian" => $ujian
        ]);
    }

    public function penugasanCreate(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'pns' => 'required',
            'ujian_id' => 'required'
        ]);

        Pengawas::create($request->all());

        return redirect()->route('pjUjian.pengawas.penugasan.index')->with('success', 'Pengawas berhasil ditambahkan!');
    }

    public function amplop(Request $request)
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
            $ujian = $ujian->get();
        }

        return view('pj_ujian.amplop', [
            "amplop" => $ujian
        ]);
    }

    public function bap(Request $request)
    {
        $now = Carbon::now()->toDateString();

        if (isEmpty()) {
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
            $ujian = $ujian->get();
        }

        return view('pj_ujian.bap', [
            "bap" => $ujian
        ]);
    }

    public function berkas(Request $request)
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
            $ujian = $ujian->get();
        }

        return view('pj_ujian.berkas', [
            "berkas" => $ujian
        ]);
    }

    public function berkasUpdate($id)
    {
        $berkas = Berkas::find($id);
        
        if ($berkas->pengambilan == "Belum") {
            $berkas->update([
                'pengambilan' => 'Sudah'
            ]);
        } else {
            $berkas->update([
                'pengambilan' => 'Belum'
            ]);
        }

        return redirect()->route('pjUjian.kelengkapan.berkas.index')->with('success', 'Status pengambil soal ujian berhasil diubah!');
    }

    public function ttd()
    {
        $tglbln = Carbon::now()->format('d F, Y');
        return view('pj_ujian.ttd', [
            'master' => Master::find(1),
            'tglbln' => $tglbln
        ]);
    }

    public function susulan(Request $request)
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
        $susulan->update([
            'status' => $request->status
        ]);

        if ($request->status == 'Disetujui'){
            $message = "Pengajuan berhasil disetujui!";
        } else {
            $message = "Pengajuan berhasil ditolak!";
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
        $berkas->jml_berkas = "0";
        $berkas->save();

        Susulan::join('mahasiswas', 'susulans.mhs_id', 'mahasiswas.id')
        ->join('praktikums', 'mahasiswas.prak_id', 'praktikums.id')
        ->where('praktikums.id', $request->prak_id)
        ->where('susulans.matkul_id', $request->matkul_id)
        ->update(['status' => 'Terjadwal']);

        return redirect()->route('pjUjian.susulan.penjadwalan.index')->with('success', 'Jadwal ujian susulan baru telah ditambahkan!');
    }

    public function susulanIndex()
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

        return redirect()->route('pjUjian.susulan.susulan.index')->with('success', 'Jadwal ujian susulan berhasil dihapus!');
    }
}
