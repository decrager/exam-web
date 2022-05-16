<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Ujian;
use App\Models\Master;
use App\Models\Matkul;
use App\Models\Susulan;
use App\Models\Pengawas;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use function PHPUnit\Framework\isEmpty;

class supervisorController extends Controller
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
        
        return view('supervisor.dashboard', [
            "ujian" => $ujian
        ]);
    }

    public function ujian(Request $request)
    {
        $dataTanggalMulai = Master::first();
        $dataTanggalSelesai = Master::first();

        $from = $dataTanggalMulai->periode_mulai;
        $to = $dataTanggalSelesai->periode_akhir;

        if (isEmpty($request)) {
            $ujian = Ujian::where('susulan', '0')->get();
        } else {
            $prodi = $request->prodi;
            $semester = $request->semester;
            $matkul = $request->matkul;
            $kelas = $request->kelas;
            $praktikum = $request->praktikum;
            $tanggal = $request->tanggal;
            $ruang = $request->ruang;

            $ujian = $this->filter($prodi, $semester, $matkul, $kelas, $praktikum, $tanggal, $ruang);
            $ujian->where('susulan', '0')->whereBetween('ujians.tanggal', [$from, $to])->get();
        }

        return view('supervisor.ujian', [
            "ujian" => $ujian
        ]);
    }

    public function susulan(Request $request)
    {
        $dataTanggalMulai = Master::first();
        $dataTanggalSelesai = Master::first();

        $from = $dataTanggalMulai->periode_mulai;
        $to = $dataTanggalSelesai->periode_akhir;

        if (isEmpty($request)) {
            $ujian = Ujian::where('susulan', '1')->get();
        } else {
            $prodi = $request->prodi;
            $semester = $request->semester;
            $matkul = $request->matkul;
            $kelas = $request->kelas;
            $praktikum = $request->praktikum;
            $tanggal = $request->tanggal;
            $ruang = $request->ruang;

            $ujian = $this->filter($prodi, $semester, $matkul, $kelas, $praktikum, $tanggal, $ruang);
            $ujian->where('susulan', '1')->whereBetween('ujians.tanggal', [$from, $to])->get();
        }

        return view('supervisor.susulan', ['ujian' => $ujian]);
    }

    public function mhs_susulan()
    {
        $mahasiswa = Susulan::all();

        return view('supervisor.mhs_susulan', [
            "mahasiswa" => $mahasiswa,
            "mahasiswas" => $mahasiswa
        ]);
    }

    public function pengawas(Request $request)
    {
        if (isEmpty($request)) {
            $pengawas = Pengawas::all();
        } else {
            $pengawas = Ujian::join('ujians', 'pengawas.ujian_id', '=', 'ujians.id')
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

            $pengawas->get();
        }
        
        return view('supervisor.pengawas', [
            "pengawas" => $pengawas
        ]);
    }

    public function mahasiswa(Request $request)
    {
        if (isEmpty($request))
        {
            $mahasiswa = Mahasiswa::all();
        } else {
            $mahasiswa = Mahasiswa::join('praktikums', 'ujians.prak_id', '=', 'praktikums.id')
            ->join('kelas', 'praktikums.kelas_id', '=', 'kelas.id')
            ->join('semesters', 'kelas.semester_id', '=', 'semesters.id')
            ->join('prodis', 'semesters.prodi_id', '=', 'prodis.id');

            if ($request->prodi) {
                $mahasiswa->where('prodis.nama_prodi', 'like', '%' . $request->prodi . '%');
                if ($request->semester) {
                    $mahasiswa->where('semesters.semester', 'like', '%' . $request->semester . '%');
                    if ($request->kelas) {
                        $mahasiswa->where('kelas.kelas', 'like', '%' . $request->kelas . '%');
                        if ($request->praktikum) {
                            $mahasiswa->where('praktikums.praktikum', 'like', '%' . $request->praktikum . '%');
                        }
                    }
                }
            }

            $mahasiswa->get();
        }

        return view('supervisor.mahasiswa', [
            "mahasiswa" => $mahasiswa
        ]);
    }

    public function matkul(Request $request)
    {
        $ujian = Ujian::join('matkuls', 'ujians.matkul_id', '=', 'matkuls.id')
        ->join('semesters AS a', 'matkuls.semester_id', '=', 'a.id')
        ->join('praktikums', 'ujians.prak_id', '=', 'praktikums.id')
        ->join('kelas', 'praktikums.kelas_id', '=', 'kelas.id')
        ->join('semesters AS b', 'kelas.semester_id', '=', 'b.id')
        ->join('prodis', 'b.prodi_id', '=', 'prodis.id')
        ->selectRaw('ujians.tanggal, prodis.nama_prodi, b.semester, matkuls.nama_matkul, ujians.tipe_mk, ujians.perbanyak, count(kelas.jml_mhs) * 3 + SUM(kelas.jml_mhs) AS jumlah')
        ->groupBy('ujians.tanggal', 'ujians.tipe_mk', 'ujians.perbanyak', 'prodis.nama_prodi', 'b.semester', 'matkuls.nama_matkul')
        ->get();

        return view('supervisor.matkul', [
            "matkul" => $ujian
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

        return view('supervisor.amplop', [
            "amplop" => $ujian
        ]);
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
        
        return view('supervisor.bap', [
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
            $ujian->get();
        }

        return view('supervisor.berkas', [
            "berkas" => $ujian
        ]);
    }

    public function pengguna()
    {
        $pengguna = User::all()->where('role', '!=', 'mahasiswa');
        return view('supervisor.pengguna', [
            "pengguna" => $pengguna
        ]);
    }

    public function pelanggaran()
    {
        return view('supervisor.pelanggaran', ["title" => env('APP_NAME')]);
    }
}
