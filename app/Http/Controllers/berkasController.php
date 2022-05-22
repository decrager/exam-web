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
            $ujian->where('ujians.tanggal', '2022-06-08');
        }

        return view('berkas.dashboard', [
            "dbUjian" => $ujian->get()
        ]);
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

        return view('berkas.amplop', [
            "amplop" => $ujian->get()
        ]);
    }

    public function amplopUpdate($id)
    {
        $amplop = Amplop::find($id);

        if ($amplop->pengambilan == 'Belum')
        {
            $amplop->update(['pengambilan' => 'Sudah']);
            $this->Activity(' memperbarui status Pengambilan pada Amplop menjadi Sudah diambil');
        } else {
            $amplop->update(['pengambilan' => 'Belum']);
            $this->Activity(' memperbarui status Pengambilan pada Amplop menjadi Belum diambil');
        }

        return redirect()->route('berkas.kelengkapan.amplop')->with('success', 'Status pengambilan Amplop berhasil diubah!');
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

        return view('berkas.bap', [
            "bap" => $ujian->get()
        ]);
    }

    public function bapUpdate($id)
    {
        $bap = Bap::find($id);

        if ($bap->pengambilan == 'Belum')
        {
            $bap->update(['pengambilan' => 'Sudah']);
            $this->Activity(' memperbarui status Pengambilan pada BAP menjadi Sudah diambil');
        } else {
            $bap->update(['pengambilan' => 'Belum']);
            $this->Activity(' memperbarui status Pengambilan pada BAP menjadi Belum diambil');
        }

        return redirect()->route('berkas.kelengkapan.bap')->with('success', 'Status pengambilan BAP berhasil diubah!');
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

        return view('berkas.berkas', [
            "berkas" => $ujian->get()
        ]);
    }

    public function berkasFotokopi($id)
    {
        $berkas = Berkas::find($id);

        if ($berkas->fotokopi == 'Belum')
        {
            $berkas->update(['fotokopi' => 'Sudah difotokopi']);
            $this->Activity(' memperbarui status Fotokopi pada Soal Ujian menjadi Sudah difotokopi');
        } elseif ($berkas->fotokopi == 'Sudah difotokopi') {
            $berkas->update(['fotokopi' => 'Sudah']);    
            $this->Activity(' memperbarui status Fotokopi pada Soal Ujian menjadi Sudah diambil');
        } else {
            $berkas->update(['fotokopi' => 'Belum']);
            $this->Activity(' memperbarui status Fotokopi pada Soal Ujian menjadi Belum difotokopi');
        }

        return redirect()->route('berkas.kelengkapan.berkas.index')->with('success', 'Status Fotokopi Berkas berhasil diubah!');
    }

    public function berkasLengkap($id)
    {
        $berkas = Berkas::find($id);

        if ($berkas->lengkap == 'Belum')
        {
            $berkas->update(['lengkap' => 'Sudah']);
            $this->Activity(' memperbarui status Lengkap pada Soal Ujian menjadi Sudah lengkap');
        } else {
            $berkas->update(['lengkap' => 'Belum']);
            $this->Activity(' memperbarui status Lengkap pada Soal Ujian menjadi Belum lengkap');
        }

        return redirect()->route('berkas.kelengkapan.berkas.index')->with('success', 'Status Kelengkapan Berkas berhasil diubah!');
    }

    public function berkasSerahTerima($id)
    {
        $berkas = Berkas::find($id);

        if ($berkas->serah_terima == 'Belum')
        {
            $berkas->update(['serah_terima' => 'Sudah']);
            $this->Activity(' memperbarui status Serah Terima pada Soal Ujian menjadi Sudah diserahkan');
        } else {
            $berkas->update(['serah_terima' => 'Belum']);
            $this->Activity(' memperbarui status Serah Terima pada Soal Ujian menjadi Belum diserahkan');
        }

        return redirect()->route('berkas.kelengkapan.berkas.index')->with('success', 'Status Serah Terima Berkas berhasil diubah!');
    }

    public function ttd()
    {
        $tglbln = Carbon::now()->format('d F, Y');

        return view('berkas.ttd', [
            'master' => Master::find(1),
            'tglbln' => $tglbln
        ]);
    }

    public function soal()
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
        ->selectRaw('ujians.tanggal, prodis.nama_prodi, b.semester, matkuls.nama_matkul, ujians.tipe_mk, ujians.perbanyak, count(kelas.jml_mhs) * 6 + SUM(kelas.jml_mhs) AS jumlah')
        ->groupBy('ujians.tanggal', 'ujians.tipe_mk', 'ujians.perbanyak', 'prodis.nama_prodi', 'b.semester', 'matkuls.nama_matkul')
        ->whereBetween('ujians.tanggal', [$from, $to])
        ->filter(request(['dbProdi', 'dbSemester', 'dbMatkul']))
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