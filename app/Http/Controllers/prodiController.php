<?php

namespace App\Http\Controllers;

use App\Models\Prodi;
use App\Models\Ujian;
use App\Models\Berkas;
use App\Models\Master;
use App\Models\Matkul;
use App\Models\Pengawas;
use App\Models\Penugasan;
use App\Exports\ProdiExport;
use App\Exports\UjianExport;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use function PHPUnit\Framework\isEmpty;
use Illuminate\Support\Facades\Session;

class prodiController extends Controller
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
        ->join('berkas', 'berkas.ujian_id', '=', 'ujians.id')
        ->where('ujians.tanggal', $now);

        if (Auth::user()->name == 'Komunikasi') {
            $ujian->where('prodis.kode_prodi', 'A');
        } elseif (Auth::user()->name == 'Ekowisata') {
            $ujian->where('prodis.kode_prodi', 'B');
        } elseif (Auth::user()->name == 'Manajemen Informatika') {
            $ujian->where('prodis.kode_prodi', 'C');
        } elseif (Auth::user()->name == 'Teknik Komputer') {
            $ujian->where('prodis.kode_prodi', 'D');
        } elseif (Auth::user()->name == 'Supervisor Jaminan Mutu Pangan') {
            $ujian->where('prodis.kode_prodi', 'E');
        } elseif (Auth::user()->name == 'Manajemen Industri Jasa Makanan dan Gizi') {
            $ujian->where('prodis.kode_prodi', 'F');
        } elseif (Auth::user()->name == 'Teknologi Industri Benih') {
            $ujian->where('prodis.kode_prodi', 'G');
        } elseif (Auth::user()->name == 'Teknologi Produksi dan Manajemen Perikanan Budidaya') {
            $ujian->where('prodis.kode_prodi', 'H');
        } elseif (Auth::user()->name == 'Teknologi dan Manajemen Ternak') {
            $ujian->where('prodis.kode_prodi', 'I');
        } elseif (Auth::user()->name == 'Manajemen Agribisnis') {
            $ujian->where('prodis.kode_prodi', 'J');
        } elseif (Auth::user()->name == 'Manajemen Industri') {
            $ujian->where('prodis.kode_prodi', 'K');
        } elseif (Auth::user()->name == 'Analisis Kimia') {
            $ujian->where('prodis.kode_prodi', 'L');
        } elseif (Auth::user()->name == 'Teknik dan Manajemen Lingkungan') {
            $ujian->where('prodis.kode_prodi', 'M');
        } elseif (Auth::user()->name == 'Akuntansi') {
            $ujian->where('prodis.kode_prodi', 'N');
        } elseif (Auth::user()->name == 'Paramedik Veteriner') {
            $ujian->where('prodis.kode_prodi', 'P');
        } elseif (Auth::user()->name == 'Teknologi Produksi dan Manajemen Perebunan') {
            $ujian->where('prodis.kode_prodi', 'T');
        } elseif (Auth::user()->name == 'Teknologi Produksi dan Pengembangan Masyarakat Pertanian') {
            $ujian->where('prodis.kode_prodi', 'W');
        }

        return view('prodi.dashboard', [
            "dbUjian" => $ujian->get()
        ]);
    }

    public function jadwal()
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
        ->filter(request(['dbSemester', 'dbPraktikum', 'dbKelas', 'dbMatkul', 'dbTanggal', 'dbRuang']));

        $matkul = Matkul::join('semesters', 'matkuls.semester_id', 'semesters.id')
        ->join('prodis', 'semesters.prodi_id', 'prodis.id');

        if (Auth::user()->name == 'Komunikasi') {
            $ujian->where('prodis.kode_prodi', 'A');
            $matkul->where('prodis.kode_prodi', 'A');
        } elseif (Auth::user()->name == 'Ekowisata') {
            $ujian->where('prodis.kode_prodi', 'B');
            $matkul->where('prodis.kode_prodi', 'B');
        } elseif (Auth::user()->name == 'Manajemen Informatika') {
            $ujian->where('prodis.kode_prodi', 'C');
            $matkul->where('prodis.kode_prodi', 'C');
        } elseif (Auth::user()->name == 'Teknik Komputer') {
            $ujian->where('prodis.kode_prodi', 'D');
            $matkul->where('prodis.kode_prodi', 'D');
        } elseif (Auth::user()->name == 'Supervisor Jaminan Mutu Pangan') {
            $ujian->where('prodis.kode_prodi', 'E');
            $matkul->where('prodis.kode_prodi', 'E');
        } elseif (Auth::user()->name == 'Manajemen Industri Jasa Makanan dan Gizi') {
            $ujian->where('prodis.kode_prodi', 'F');
            $matkul->where('prodis.kode_prodi', 'F');
        } elseif (Auth::user()->name == 'Teknologi Industri Benih') {
            $ujian->where('prodis.kode_prodi', 'G');
            $matkul->where('prodis.kode_prodi', 'G');
        } elseif (Auth::user()->name == 'Teknologi Produksi dan Manajemen Perikanan Budidaya') {
            $ujian->where('prodis.kode_prodi', 'H');
            $matkul->where('prodis.kode_prodi', 'H');
        } elseif (Auth::user()->name == 'Teknologi dan Manajemen Ternak') {
            $ujian->where('prodis.kode_prodi', 'I');
            $matkul->where('prodis.kode_prodi', 'I');
        } elseif (Auth::user()->name == 'Manajemen Agribisnis') {
            $ujian->where('prodis.kode_prodi', 'J');
            $matkul->where('prodis.kode_prodi', 'J');
        } elseif (Auth::user()->name == 'Manajemen Industri') {
            $ujian->where('prodis.kode_prodi', 'K');
            $matkul->where('prodis.kode_prodi', 'K');
        } elseif (Auth::user()->name == 'Analisis Kimia') {
            $ujian->where('prodis.kode_prodi', 'L');
            $matkul->where('prodis.kode_prodi', 'L');
        } elseif (Auth::user()->name == 'Teknik dan Manajemen Lingkungan') {
            $ujian->where('prodis.kode_prodi', 'M');
            $matkul->where('prodis.kode_prodi', 'M');
        } elseif (Auth::user()->name == 'Akuntansi') {
            $ujian->where('prodis.kode_prodi', 'N');
            $matkul->where('prodis.kode_prodi', 'N');
        } elseif (Auth::user()->name == 'Paramedik Veteriner') {
            $ujian->where('prodis.kode_prodi', 'P');
            $matkul->where('prodis.kode_prodi', 'P');
        } elseif (Auth::user()->name == 'Teknologi Produksi dan Manajemen Perebunan') {
            $ujian->where('prodis.kode_prodi', 'T');
            $matkul->where('prodis.kode_prodi', 'T');
        } elseif (Auth::user()->name == 'Teknologi Produksi dan Pengembangan Masyarakat Pertanian') {
            $ujian->where('prodis.kode_prodi', 'W');
            $matkul->where('prodis.kode_prodi', 'W');
        }

        Session::put('url', request()->fullUrl());
        return view('prodi.jadwal', [
            "ujian" => $ujian->get(),
            "matkuls" => $matkul->get()
        ]);
    }

    public function ujianIndex()
    {
        $dataTanggalMulai = Master::first();
        $dataTanggalSelesai = Master::first();

        $from = $dataTanggalMulai->periode_mulai;
        $to = $dataTanggalSelesai->periode_akhir;

        $ujian = Ujian::join('matkuls', 'ujians.matkul_id', 'matkuls.id')
        ->join('semesters AS a', 'matkuls.semester_id', 'a.id')
        ->join('praktikums', 'ujians.prak_id', 'praktikums.id')
        ->join('kelas', 'praktikums.kelas_id', 'kelas.id')
        ->join('semesters AS b', 'kelas.semester_id', 'b.id')
        ->join('prodis', 'b.prodi_id', 'prodis.id')
        ->join('amplops', 'amplops.ujian_id', 'ujians.id')
        ->join('baps', 'baps.ujian_id', 'ujians.id')
        ->join('berkas', 'berkas.ujian_id', 'ujians.id')
        ->selectRaw('ujians.tanggal, prodis.nama_prodi, b.semester, ujians.matkul_id, matkuls.nama_matkul, ujians.tipe_mk, ujians.lokasi, ujians.perbanyak, ujians.kertas, ujians.software, count(ujians.id) AS total')
        ->groupBy('ujians.tanggal', 'prodis.nama_prodi', 'b.semester', 'ujians.matkul_id', 'matkuls.nama_matkul', 'ujians.tipe_mk', 'ujians.lokasi', 'ujians.perbanyak', 'ujians.kertas', 'ujians.software');

        if (Auth::user()->name == 'Komunikasi') {
            $ujian->where('prodis.kode_prodi', 'A');
        } elseif (Auth::user()->name == 'Ekowisata') {
            $ujian->where('prodis.kode_prodi', 'B');
        } elseif (Auth::user()->name == 'Manajemen Informatika') {
            $ujian->where('prodis.kode_prodi', 'C');
        } elseif (Auth::user()->name == 'Teknik Komputer') {
            $ujian->where('prodis.kode_prodi', 'D');
        } elseif (Auth::user()->name == 'Supervisor Jaminan Mutu Pangan') {
            $ujian->where('prodis.kode_prodi', 'E');
        } elseif (Auth::user()->name == 'Manajemen Industri Jasa Makanan dan Gizi') {
            $ujian->where('prodis.kode_prodi', 'F');
        } elseif (Auth::user()->name == 'Teknologi Industri Benih') {
            $ujian->where('prodis.kode_prodi', 'G');
        } elseif (Auth::user()->name == 'Teknologi Produksi dan Manajemen Perikanan Budidaya') {
            $ujian->where('prodis.kode_prodi', 'H');
        } elseif (Auth::user()->name == 'Teknologi dan Manajemen Ternak') {
            $ujian->where('prodis.kode_prodi', 'I');
        } elseif (Auth::user()->name == 'Manajemen Agribisnis') {
            $ujian->where('prodis.kode_prodi', 'J');
        } elseif (Auth::user()->name == 'Manajemen Industri') {
            $ujian->where('prodis.kode_prodi', 'K');
        } elseif (Auth::user()->name == 'Analisis Kimia') {
            $ujian->where('prodis.kode_prodi', 'L');
        } elseif (Auth::user()->name == 'Teknik dan Manajemen Lingkungan') {
            $ujian->where('prodis.kode_prodi', 'M');
        } elseif (Auth::user()->name == 'Akuntansi') {
            $ujian->where('prodis.kode_prodi', 'N');
        } elseif (Auth::user()->name == 'Paramedik Veteriner') {
            $ujian->where('prodis.kode_prodi', 'P');
        } elseif (Auth::user()->name == 'Teknologi Produksi dan Manajemen Perebunan') {
            $ujian->where('prodis.kode_prodi', 'T');
        } elseif (Auth::user()->name == 'Teknologi Produksi dan Pengembangan Masyarakat Pertanian') {
            $ujian->where('prodis.kode_prodi', 'W');
        }

        Session::put('url', request()->fullUrl());
        return view('prodi.ujian.index', [
            "ujian" => $ujian->whereBetween('ujians.tanggal', [$from, $to])->get()
        ]);
    }

    public function ujianEdit(Request $request)
    {
        return view('prodi.ujian.edit', [
            "prodi" => $request->prodi,
            "semester" => $request->semester,
            "matkul_id" => $request->matkul_id,
            "matkul" => $request->matkul,
            "tipe_mk" => $request->tipe_mk,
            "lokasi" => $request->lokasi,
            "perbanyak" => $request->perbanyak,
            "kertas" => $request->kertas,
            "software" => $request->software
        ]);
    }

    public function export(){
        $this->Activity(' mengeksport jadwal ujian ke excel');
        return Excel::download(new ProdiExport, 'dataujian.xlsx');
    }

    public function UjianUpdate(Request $request, $id)
    {
        $request->validate([
            'lokasi' => 'nullable',
            'software' => 'nullable',
            'perbanyak' => 'nullable',
            'kertas' => 'nullable'
        ]);
        
        $ujian = Ujian::where('matkul_id', $id);

        $ujian->update([
            'lokasi' => $request->lokasi,
            'software' => $request->software,
            'perbanyak' => $request->perbanyak,
            'kertas' => $request->kertas
        ]);

        $this->Activity(' memperbarui jadwal ujian');
        if (session('url')) {
            return redirect(session('url'))->with('success', 'Detail Jadwal berhasil ditambah!');
        }
        return redirect()->route('prodi.jadwal.index')->with('success', 'Detail Jadwal berhasil ditambah!');
    }

    public function pengawasList()
    {
        $dataTanggalMulai = Master::first();
        $dataTanggalSelesai = Master::first();

        $from = $dataTanggalMulai->periode_mulai;
        $to = $dataTanggalSelesai->periode_akhir;

        $pengawas = Penugasan::join('pengawas', 'penugasans.pengawas_id', 'pengawas.id')
        ->join('ujians', 'penugasans.ujian_id', '=', 'ujians.id')
        ->join('matkuls', 'ujians.matkul_id', '=', 'matkuls.id')
        ->join('semesters AS a', 'matkuls.semester_id', '=', 'a.id')
        ->join('praktikums', 'ujians.prak_id', '=', 'praktikums.id')
        ->join('kelas', 'praktikums.kelas_id', '=', 'kelas.id')
        ->join('semesters AS b', 'kelas.semester_id', '=', 'b.id')
        ->join('prodis', 'b.prodi_id', '=', 'prodis.id')
        ->select('ujians.*', 'matkuls.*', 'b.*', 'praktikums.*', 'kelas.*', 'prodis.*', 'pengawas.*', 'penugasans.*')
        ->whereBetween('ujians.tanggal', [$from, $to])
        ->filter(request(['dbProdi', 'dbSemester', 'dbPraktikum', 'dbKelas', 'dbMatkul', 'dbTanggal', 'dbRuang']));

        $matkul = Matkul::join('semesters', 'matkuls.semester_id', 'semesters.id')
        ->join('prodis', 'semesters.prodi_id', 'prodis.id');

        if (Auth::user()->name == 'Komunikasi') {
            $pengawas->where('prodis.kode_prodi', 'A');
            $matkul->where('prodis.kode_prodi', 'A');
        } elseif (Auth::user()->name == 'Ekowisata') {
            $pengawas->where('prodis.kode_prodi', 'B');
            $matkul->where('prodis.kode_prodi', 'B');
        } elseif (Auth::user()->name == 'Manajemen Informatika') {
            $pengawas->where('prodis.kode_prodi', 'C');
            $matkul->where('prodis.kode_prodi', 'C');
        } elseif (Auth::user()->name == 'Teknik Komputer') {
            $pengawas->where('prodis.kode_prodi', 'D');
            $matkul->where('prodis.kode_prodi', 'D');
        } elseif (Auth::user()->name == 'Supervisor Jaminan Mutu Pangan') {
            $pengawas->where('prodis.kode_prodi', 'E');
            $matkul->where('prodis.kode_prodi', 'E');
        } elseif (Auth::user()->name == 'Manajemen Industri Jasa Makanan dan Gizi') {
            $pengawas->where('prodis.kode_prodi', 'F');
            $matkul->where('prodis.kode_prodi', 'F');
        } elseif (Auth::user()->name == 'Teknologi Industri Benih') {
            $pengawas->where('prodis.kode_prodi', 'G');
            $matkul->where('prodis.kode_prodi', 'G');
        } elseif (Auth::user()->name == 'Teknologi Produksi dan Manajemen Perikanan Budidaya') {
            $pengawas->where('prodis.kode_prodi', 'H');
            $matkul->where('prodis.kode_prodi', 'H');
        } elseif (Auth::user()->name == 'Teknologi dan Manajemen Ternak') {
            $pengawas->where('prodis.kode_prodi', 'I');
            $matkul->where('prodis.kode_prodi', 'I');
        } elseif (Auth::user()->name == 'Manajemen Agribisnis') {
            $pengawas->where('prodis.kode_prodi', 'J');
            $matkul->where('prodis.kode_prodi', 'J');
        } elseif (Auth::user()->name == 'Manajemen Industri') {
            $pengawas->where('prodis.kode_prodi', 'K');
            $matkul->where('prodis.kode_prodi', 'K');
        } elseif (Auth::user()->name == 'Analisis Kimia') {
            $pengawas->where('prodis.kode_prodi', 'L');
            $matkul->where('prodis.kode_prodi', 'L');
        } elseif (Auth::user()->name == 'Teknik dan Manajemen Lingkungan') {
            $pengawas->where('prodis.kode_prodi', 'M');
            $matkul->where('prodis.kode_prodi', 'M');
        } elseif (Auth::user()->name == 'Akuntansi') {
            $pengawas->where('prodis.kode_prodi', 'N');
            $matkul->where('prodis.kode_prodi', 'N');
        } elseif (Auth::user()->name == 'Paramedik Veteriner') {
            $pengawas->where('prodis.kode_prodi', 'P');
            $matkul->where('prodis.kode_prodi', 'P');
        } elseif (Auth::user()->name == 'Teknologi Produksi dan Manajemen Perebunan') {
            $pengawas->where('prodis.kode_prodi', 'T');
            $matkul->where('prodis.kode_prodi', 'T');
        } elseif (Auth::user()->name == 'Teknologi Produksi dan Pengembangan Masyarakat Pertanian') {
            $pengawas->where('prodis.kode_prodi', 'W');
            $matkul->where('prodis.kode_prodi', 'W');
        }

        Session::put('url', request()->fullUrl());
        return view('prodi.daftar_pengawas', [
            "pengawas" => $pengawas->get(),
            "matkuls" => $matkul->get()
        ]);
    }

    public function penugasanIndex()
    {
        $dataTanggalMulai = Master::first();
        $dataTanggalSelesai = Master::first();

        $from = $dataTanggalMulai->periode_mulai;
        $to = $dataTanggalSelesai->periode_akhir;

        $now = Carbon::now()->toDateString();

        $ujian = Ujian::join('matkuls', 'ujians.matkul_id', '=', 'matkuls.id')
        ->join('semesters AS a', 'matkuls.semester_id', '=', 'a.id')
        ->join('praktikums', 'ujians.prak_id', '=', 'praktikums.id')
        ->join('kelas', 'praktikums.kelas_id', '=', 'kelas.id')
        ->join('semesters AS b', 'kelas.semester_id', '=', 'b.id')
        ->join('prodis', 'b.prodi_id', '=', 'prodis.id')
        ->join('amplops', 'amplops.ujian_id', '=', 'ujians.id')
        ->join('baps', 'baps.ujian_id', '=', 'ujians.id')
        ->join('berkas', 'berkas.ujian_id', '=', 'ujians.id')
        ->select('matkuls.*', 'b.*', 'praktikums.*', 'kelas.*', 'prodis.*', 'ujians.*')
        // ->doesntHave('Penugasan')
        ->whereBetween('ujians.tanggal', [$from, $to])
        // ->where('ujians.tanggal', $now)
        ->filter(request(['dbSemester', 'dbPraktikum', 'dbKelas', 'dbMatkul', 'dbTanggal', 'dbRuang']));

        $matkul = Matkul::join('semesters', 'matkuls.semester_id', 'semesters.id')
        ->join('prodis', 'semesters.prodi_id', 'prodis.id');

        if (Auth::user()->name == 'Komunikasi') {
            $ujian->where('prodis.kode_prodi', 'A');
            $matkul->where('prodis.kode_prodi', 'A');
        } elseif (Auth::user()->name == 'Ekowisata') {
            $ujian->where('prodis.kode_prodi', 'B');
            $matkul->where('prodis.kode_prodi', 'B');
        } elseif (Auth::user()->name == 'Manajemen Informatika') {
            $ujian->where('prodis.kode_prodi', 'C');
            $matkul->where('prodis.kode_prodi', 'C');
        } elseif (Auth::user()->name == 'Teknik Komputer') {
            $ujian->where('prodis.kode_prodi', 'D');
            $matkul->where('prodis.kode_prodi', 'D');
        } elseif (Auth::user()->name == 'Supervisor Jaminan Mutu Pangan') {
            $ujian->where('prodis.kode_prodi', 'E');
            $matkul->where('prodis.kode_prodi', 'E');
        } elseif (Auth::user()->name == 'Manajemen Industri Jasa Makanan dan Gizi') {
            $ujian->where('prodis.kode_prodi', 'F');
            $matkul->where('prodis.kode_prodi', 'F');
        } elseif (Auth::user()->name == 'Teknologi Industri Benih') {
            $ujian->where('prodis.kode_prodi', 'G');
            $matkul->where('prodis.kode_prodi', 'G');
        } elseif (Auth::user()->name == 'Teknologi Produksi dan Manajemen Perikanan Budidaya') {
            $ujian->where('prodis.kode_prodi', 'H');
            $matkul->where('prodis.kode_prodi', 'H');
        } elseif (Auth::user()->name == 'Teknologi dan Manajemen Ternak') {
            $ujian->where('prodis.kode_prodi', 'I');
            $matkul->where('prodis.kode_prodi', 'I');
        } elseif (Auth::user()->name == 'Manajemen Agribisnis') {
            $ujian->where('prodis.kode_prodi', 'J');
            $matkul->where('prodis.kode_prodi', 'J');
        } elseif (Auth::user()->name == 'Manajemen Industri') {
            $ujian->where('prodis.kode_prodi', 'K');
            $matkul->where('prodis.kode_prodi', 'K');
        } elseif (Auth::user()->name == 'Analisis Kimia') {
            $ujian->where('prodis.kode_prodi', 'L');
            $matkul->where('prodis.kode_prodi', 'L');
        } elseif (Auth::user()->name == 'Teknik dan Manajemen Lingkungan') {
            $ujian->where('prodis.kode_prodi', 'M');
            $matkul->where('prodis.kode_prodi', 'M');
        } elseif (Auth::user()->name == 'Akuntansi') {
            $ujian->where('prodis.kode_prodi', 'N');
            $matkul->where('prodis.kode_prodi', 'N');
        } elseif (Auth::user()->name == 'Paramedik Veteriner') {
            $ujian->where('prodis.kode_prodi', 'P');
            $matkul->where('prodis.kode_prodi', 'P');
        } elseif (Auth::user()->name == 'Teknologi Produksi dan Manajemen Perebunan') {
            $ujian->where('prodis.kode_prodi', 'T');
            $matkul->where('prodis.kode_prodi', 'T');
        } elseif (Auth::user()->name == 'Teknologi Produksi dan Pengembangan Masyarakat Pertanian') {
            $ujian->where('prodis.kode_prodi', 'W');
            $matkul->where('prodis.kode_prodi', 'W');
        }

        Session::put('url', request()->fullUrl());
        return view('prodi.penugasan.index', [
            "ujian" => $ujian->get(),
            "matkuls" => $matkul->get()
        ]);
    }

    public function penugasanForm($id)
    {
        $ujian = Ujian::find($id);
        $pengawas = Pengawas::all();

        return view('prodi.penugasan.form', [
            "ujian" => $ujian,
            "pengawas" => $pengawas
        ]);
    }

    public function penugasanEdit($id)
    {
        $penugasan = Penugasan::find($id);
        $ujian = ujian::find($penugasan->ujian_id);
        $selected = Pengawas::find($penugasan->pengawas_id);
        $pengawas = Pengawas::all();

        return view('prodi.penugasan.edit', [
            "penugasan" => $penugasan,
            "pengawas" => $pengawas,
            "selected" => $selected,
            "ujian" => $ujian
        ]);
    }

    public function pengawasCreate(Request $request)
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
        if (session('url')) {
            return redirect(session('url'))->with('success', 'Pengawas berhasil ditambahkan!');
        }
        return redirect()->route('prodi.pengawas.penugasan.index')->with('success', 'Pengawas berhasil ditambahkan!');
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
        if (session('url')) {
            return redirect(session('url'))->with('success', 'Pengawas sudah diperbarui!');
        }
        return redirect()->route('prodi.pengawas.list')->with('success', 'Pengawas sudah diperbarui!');
    }

    public function pengawasDestroy($id)
    {
        $penugasan = Penugasan::find($id);
        $pengawas = Pengawas::find($penugasan->pengawas_id);
        $this->Activity(' menghapus data pengawas ' . $pengawas->nama);
        $penugasan->delete();
        if (session('url')) {
            return redirect(session('url'))->with('success', 'Pengawas sudah dihapus!');
        }
        return redirect()->route('prodi.pengawas.list')->with('success', 'Pengawas sudah dihapus!');
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
        ->filter(request(['dbSemester', 'dbPraktikum', 'dbKelas', 'dbMatkul', 'dbTanggal', 'dbRuang']));

        $matkul = Matkul::join('semesters', 'matkuls.semester_id', 'semesters.id')
        ->join('prodis', 'semesters.prodi_id', 'prodis.id');

        if (Auth::user()->name == 'Komunikasi') {
            $ujian->where('prodis.kode_prodi', 'A');
            $matkul->where('prodis.kode_prodi', 'A');
        } elseif (Auth::user()->name == 'Ekowisata') {
            $ujian->where('prodis.kode_prodi', 'B');
            $matkul->where('prodis.kode_prodi', 'B');
        } elseif (Auth::user()->name == 'Manajemen Informatika') {
            $ujian->where('prodis.kode_prodi', 'C');
            $matkul->where('prodis.kode_prodi', 'C');
        } elseif (Auth::user()->name == 'Teknik Komputer') {
            $ujian->where('prodis.kode_prodi', 'D');
            $matkul->where('prodis.kode_prodi', 'D');
        } elseif (Auth::user()->name == 'Supervisor Jaminan Mutu Pangan') {
            $ujian->where('prodis.kode_prodi', 'E');
            $matkul->where('prodis.kode_prodi', 'E');
        } elseif (Auth::user()->name == 'Manajemen Industri Jasa Makanan dan Gizi') {
            $ujian->where('prodis.kode_prodi', 'F');
            $matkul->where('prodis.kode_prodi', 'F');
        } elseif (Auth::user()->name == 'Teknologi Industri Benih') {
            $ujian->where('prodis.kode_prodi', 'G');
            $matkul->where('prodis.kode_prodi', 'G');
        } elseif (Auth::user()->name == 'Teknologi Produksi dan Manajemen Perikanan Budidaya') {
            $ujian->where('prodis.kode_prodi', 'H');
            $matkul->where('prodis.kode_prodi', 'H');
        } elseif (Auth::user()->name == 'Teknologi dan Manajemen Ternak') {
            $ujian->where('prodis.kode_prodi', 'I');
            $matkul->where('prodis.kode_prodi', 'I');
        } elseif (Auth::user()->name == 'Manajemen Agribisnis') {
            $ujian->where('prodis.kode_prodi', 'J');
            $matkul->where('prodis.kode_prodi', 'J');
        } elseif (Auth::user()->name == 'Manajemen Industri') {
            $ujian->where('prodis.kode_prodi', 'K');
            $matkul->where('prodis.kode_prodi', 'K');
        } elseif (Auth::user()->name == 'Analisis Kimia') {
            $ujian->where('prodis.kode_prodi', 'L');
            $matkul->where('prodis.kode_prodi', 'L');
        } elseif (Auth::user()->name == 'Teknik dan Manajemen Lingkungan') {
            $ujian->where('prodis.kode_prodi', 'M');
            $matkul->where('prodis.kode_prodi', 'M');
        } elseif (Auth::user()->name == 'Akuntansi') {
            $ujian->where('prodis.kode_prodi', 'N');
            $matkul->where('prodis.kode_prodi', 'N');
        } elseif (Auth::user()->name == 'Paramedik Veteriner') {
            $ujian->where('prodis.kode_prodi', 'P');
            $matkul->where('prodis.kode_prodi', 'P');
        } elseif (Auth::user()->name == 'Teknologi Produksi dan Manajemen Perebunan') {
            $ujian->where('prodis.kode_prodi', 'T');
            $matkul->where('prodis.kode_prodi', 'T');
        } elseif (Auth::user()->name == 'Teknologi Produksi dan Pengembangan Masyarakat Pertanian') {
            $ujian->where('prodis.kode_prodi', 'W');
            $matkul->where('prodis.kode_prodi', 'W');
        }

        Session::put('url', request()->fullUrl());
        return view('prodi.berkas', [
            "berkas" => $ujian->whereBetween('ujians.tanggal', [$from, $to])->get(),
            "matkuls" => $matkul->get()
        ]);
    }

    public function berkasUpdate($id)
    {
        $berkas = Berkas::find($id);

        if ($berkas->verifikasi == 'Belum') {
            $berkas->update(['verifikasi' => 'Sudah']);
            $this->Activity(' memperbarui status Verifikasi pada Soal Ujian menjadi Sudah diverifikasi');
        } else {
            $berkas->update(['verifikasi' => 'Belum']);
            $this->Activity(' memperbarui status Verifikasi pada Soal Ujian menjadi Belum diverifikasi');
        }

        if (session('url')) {
            return redirect(session('url'))->with('success', 'Status Verifikasi Soal Ujian berhasil diubah!');
        }
        return redirect()->route('prodi.berkas')->with('success', 'Status Verifikasi Soal Ujian berhasil diubah!');
    }

    public function kalibrasi($id)
    {
        $berkas = Berkas::find($id);

        if ($berkas->kalibrasi == 'Belum') {
            $berkas->update(['kalibrasi' => 'Sudah']);
            $this->Activity(' memperbarui status Kalibrasi pada Soal Ujian menjadi Sudah dikalibrasi');
        } else {
            $berkas->update(['kalibrasi' => 'Belum']);
            $this->Activity(' memperbarui status Kalibrasi pada Soal Ujian menjadi Belum dikalibrasi');
        }

        if (session('url')) {
            return redirect(session('url'))->with('success', 'Status Kalibrasi Soal Ujian berhasil diubah!');
        }
        return redirect()->route('prodi.berkas')->with('success', 'Status Kalibrasi Soal Ujian berhasil diubah!');
    }

    public function pelanggaran()
    {
        return view('prodi.pelanggaran');
    }
}
