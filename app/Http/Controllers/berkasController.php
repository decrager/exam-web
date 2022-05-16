<?php

namespace App\Http\Controllers;

use App\Models\Bap;
use App\Models\Ujian;
use App\Models\Amplop;
use App\Models\Berkas;
use App\Models\Master;
use App\Models\Matkul;
use App\Models\Mahasiswa;
use Carbon\Carbon;
use Illuminate\Http\Request;
use function PHPUnit\Framework\isEmpty;

class berkasController extends Controller
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

        return view('berkas.dashboard', [
            "ujian" => $ujian
        ]);
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
            $ujian->get();
        }

        return view('berkas.amplop', [
            "amplop" => $ujian
        ]);
    }

    public function amplopUpdate($id)
    {
        $amplop = Amplop::find($id);

        if ($amplop->pengambilan == 'Belum')
        {
            $amplop->update(['pengambilan' => 'Sudah']);
        } else {
            $amplop->update(['pengambilan' => 'Belum']);
        }

        return redirect()->route('berkas.kelengkapan.amplop')->with('success', 'Status pengambilan Amplop berhasil diubah!');
    }

    public function bap(Request $request)
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

        return view('berkas.bap', [
            "bap" => $ujian
        ]);
    }

    public function bapUpdate($id)
    {
        $bap = Bap::find($id);

        if ($bap->pengambilan == 'Belum')
        {
            $bap->update(['pengambilan' => 'Sudah']);
        } else {
            $bap->update(['pengambilan' => 'Belum']);
        }

        return redirect()->route('berkas.kelengkapan.bap')->with('success', 'Status pengambilan BAP berhasil diubah!');
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
            $ujian->get();
        }

        return view('berkas.berkas', [
            "berkas" => $ujian
        ]);
    }

    public function berkasFotokopi($id)
    {
        $berkas = Berkas::find($id);

        if ($berkas->fotokopi == 'Belum')
        {
            $berkas->update(['fotokopi' => 'Sudah difotokopi']);
        } elseif ($berkas->fotokopi == 'Sudah difotokopi') {
            $berkas->update(['fotokopi' => 'Sudah']);    
        } else {
            $berkas->update(['fotokopi' => 'Belum']);
        }

        return redirect()->route('berkas.kelengkapan.berkas')->with('success', 'Status Fotokopi Berkas berhasil diubah!');
    }

    public function berkasLengkap($id)
    {
        $berkas = Berkas::find($id);

        if ($berkas->lengkap == 'Belum')
        {
            $berkas->update(['lengkap' => 'Sudah']);
        } else {
            $berkas->update(['lengkap' => 'Belum']);
        }

        return redirect()->route('berkas.kelengkapan.berkas')->with('success', 'Status Kelengkapan Berkas berhasil diubah!');
    }

    public function berkasSerahTerima($id)
    {
        $berkas = Berkas::find($id);

        if ($berkas->serah_terima == 'Belum')
        {
            $berkas->update(['serah_terima' => 'Sudah']);
        } else {
            $berkas->update(['serah_terima' => 'Belum']);
        }

        return redirect()->route('berkas.kelengkapan.berkas')->with('success', 'Status Serah Terima Berkas berhasil diubah!');
    }

    public function soal(Request $request)
    {
        $now = Carbon::now()->toDateString();

        $ujian = Ujian::join('matkuls', 'ujians.matkul_id', '=', 'matkuls.id')
        ->join('semesters AS a', 'matkuls.semester_id', '=', 'a.id')
        ->join('praktikums', 'ujians.prak_id', '=', 'praktikums.id')
        ->join('kelas', 'praktikums.kelas_id', '=', 'kelas.id')
        ->join('semesters AS b', 'kelas.semester_id', '=', 'b.id')
        ->join('prodis', 'b.prodi_id', '=', 'prodis.id')
        ->selectRaw('ujians.tanggal, prodis.nama_prodi, b.semester, matkuls.nama_matkul, ujians.tipe_mk, ujians.perbanyak, count(kelas.jml_mhs) * 3 + SUM(kelas.jml_mhs) AS jumlah')
        ->groupBy('ujians.tanggal', 'ujians.tipe_mk', 'ujians.perbanyak', 'prodis.nama_prodi', 'b.semester', 'matkuls.nama_matkul')
        ->get();

        return view('berkas.soal', [
            "soal" => $ujian
        ]);
    }

    public function pelanggaran()
    {
        return view('berkas.pelanggaran', ["title" => env('APP_NAME')]);
    }
}