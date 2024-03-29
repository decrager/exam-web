<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Bap;
use App\Models\Ujian;
use App\Models\Amplop;
use App\Models\Berkas;
use App\Models\Master;
use App\Models\Susulan;
use App\Models\Ketentuan;
use App\Models\Mahasiswa;
use App\Models\Pelanggaran;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\SusulanExport;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;
use function PHPUnit\Framework\isEmpty;
use Illuminate\Support\Facades\Storage;

class pjSusulanController extends Controller
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

        return view('pj_susulan.dashboard', [
            "dbUjian" => $ujian->get()
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
        return view('pj_susulan.ketentuan.form');
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

        $this->Activity(' menambah ketentuan baru');
        return redirect()->route('pjSusulan.ketentuan.index')->with('success', 'Ketentuan baru berhasil ditambahkan!');
    }

    public function ketentuanUpdate(Request $request, $id)
    {
        $request->validate([
            'ketentuan' => 'required'
        ]);

        $ketentuan = Ketentuan::find($id);
        $ketentuan->update($request->all());

        $this->Activity(' memperbarui ketentuan');
        return redirect()->route('pjSusulan.ketentuan.index')->with('success', 'Ketentuan berhasil diperbarui!');
    }

    public function ketentuanDestroy($id)
    {
        Ketentuan::find($id)->delete();
        $this->Activity(' menghapus ketentuan');
        return redirect()->route('pjSusulan.ketentuan.index')->with('success', 'Ketentuan berhasil dihapus!');
    }
    
    public function mahasiswaIndex()
    {
        $mahasiswa = Susulan::orderBy('updated_at', 'DESC')->get();

        return view('pj_susulan.mahasiswa', [
            "mahasiswa" => $mahasiswa,
            "mahasiswas" => $mahasiswa
        ]);
    }

    public function persetujuanForm($id)
    {
        $mahasiswa = Susulan::find($id);

        return view('pj_susulan.persetujuan', ["mahasiswa" => $mahasiswa]);
    }

    public function persetujuanDestroy($id)
    {
        $susulan = Susulan::find($id);
        $mahasiswa = Mahasiswa::find($susulan->mhs_id);
        $destination = 'files/syarat/' . $susulan->file;
        
        if ($destination) {
            Storage::delete($destination);
        }
        Susulan::find($id)->delete();

        $message = "Pengajuan berhasil dihapus!";
        $this->Activity(' menyetujui pengajuan susulan untuk ' . $mahasiswa->nama);
        return redirect()->route('pjSusulan.mahasiswa.index')->with('success', $message);
    }

    public function mahasiswaUpdate(Request $request, $id)
    {
        $susulan = Susulan::find($id);
        $mahasiswa = Mahasiswa::find($susulan->mhs_id);
        $tglbln = Carbon::now()->translatedFormat('d F Y');

        if ($request->status == 'Disetujui'){
            $destination = 'images/ttd/ttdSusulan.png';
            if ($destination) {
                Storage::delete($destination);
            }

            $fileName = 'ttdSusulan.png';
            $folderPath = Storage::path('images/ttd/');
            $image = explode(";base64,", $request->ttd);
            $image_base64 = base64_decode($image[1]);
            
            $file = $folderPath . $fileName;
            file_put_contents($file, $image_base64);

            $data = [
                "susulan" => $susulan,
                "mahasiswa" => $mahasiswa,
                "tglbln" => $tglbln,
                "pj" => Auth::user()->name,
                "ttd" => $fileName
            ];

            $pdf = PDF::loadView('layouts.persetujuan', $data);
            $pdfName = $mahasiswa->nim . $susulan->Matkul->nama_matkul . '_persetujuan_susulan.pdf';
            
            $susulan->timestamps = false;
            $susulan->status = $request->status;
            $susulan->persetujuan = $pdfName;
            $susulan->catatan = $request->catatan;
            $susulan->save();
            // $susulan->update([
            //     'status' => $request->status,
            //     'persetujuan' => $pdfName,
            //     'catatan' => $request->catatan,
            //     'timestamps' => false
            // ]);
            Storage::put('files/pdf/' . $pdfName, $pdf->output());

            $message = "Pengajuan berhasil disetujui!";
            $this->Activity(' menyetujui pengajuan susulan untuk ' . $mahasiswa->nama);
            return redirect()->route('pjSusulan.mahasiswa.index')->with('success', $message);
        } 
        elseif ($request->status == 'Pending') {
            $pdfName = $mahasiswa->nim . $susulan->Matkul->nama_matkul . '_persetujuan_susulan.pdf';
            $destination = 'files/pdf/' . $pdfName;
            if ($destination) {
                Storage::delete($destination);
            }

            $susulan->timestamps = false;
            $susulan->status = $request->status;
            $susulan->persetujuan = null;
            $susulan->catatan = $request->catatan;
            $susulan->save();

            // $susulan->update([
            //     'status' => $request->status,
            //     'persetujuan' => null,
            //     'catatan' => $request->catatan,
            //     'timestamps' => false
            // ]);

            $message = "Pengajuan berhasil dipending!";
            $this->Activity(' menunda pengajuan susulan untuk ' . $mahasiswa->nama);
            return redirect()->route('pjSusulan.mahasiswa.index')->with('success', $message);
        } else {
            $pdfName = $mahasiswa->nim . $susulan->Matkul->nama_matkul . '_persetujuan_susulan.pdf';
            $destination = 'files/pdf/' . $pdfName;
            if ($destination) {
                Storage::delete($destination);
            }

            $susulan->timestamps = false;
            $susulan->status = $request->status;
            $susulan->persetujuan = null;
            $susulan->catatan = $request->catatan;
            $susulan->save();

            // $susulan->update([
            //     'status' => $request->status,
            //     'persetujuan' => null,
            //     'catatan' => $request->catatan,
            //     'timestamps' => false
            // ]);
            $message = "Pengajuan berhasil ditolak!";
            $this->Activity(' menolak pengajuan susulan untuk ' . $mahasiswa->nama);
            return redirect()->route('pjSusulan.mahasiswa.index')->with('success', $message);
        }
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

        $this->Activity(' menambahkan jadwal susulan baru');
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

        $this->Activity(' memperbarui jadwal susulan');
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

        $this->Activity(' menghapus jadwal susulan');
        return redirect()->route('pjSusulan.jadwal.index')->with('success', 'Jadwal ujian susulan berhasil dihapus!');
    }

    public function jadwalIndex()
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

        return view('pj_susulan.jadwal.index', [
            "susulan" => $susulan->get(),
            "susulans" => $susulan->get(),
        ]);
    }

    public function jadwalEdit($id)
    {
        return view('pj_susulan.jadwal.edit', [
            "ujian" => Ujian::find($id)
        ]);
    }

    public function export()
    {
        $this->Activity(' mengeksport data susulan ke excel');
        return Excel::download(new SusulanExport, 'Susulan.xlsx');
    }

    public function pelanggaran()
    {
        return view('pj_susulan.pelanggaran');
    }
}
