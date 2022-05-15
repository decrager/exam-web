<?php

namespace App\Http\Controllers;

use App\Models\Ujian;
use App\Models\Pengawas;
use App\Models\Mahasiswa;
use App\Models\Matkul;
use App\Models\User;
use Illuminate\Http\Request;
use function PHPUnit\Framework\isEmpty;

class supervisorController extends Controller
{
    public function dashboard(Request $request)
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
            $ujian->get();
        }
        
        return view('supervisor.dashboard', [
            "ujian" => $ujian
        ]);
    }

    public function ujian(Request $request)
    {
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
            $ujian->where('susulan', '0')->get();
        }

        return view('supervisor.ujian', [
            "ujian" => $ujian
        ]);
    }

    public function susulan(Request $request)
    {
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
            $ujian->where('susulan', '1')->get();
        }

        return view('supervisor.susulan', ["title" => env('APP_NAME')]);
    }

    public function mhs_susulan()
    {
        return view('supervisor.mhs_susulan', ["title" => env('APP_NAME')]);
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

        return view('supervisor.matkul', [
            "ujian" => $ujian
        ]);
    }

    public function amplop(Request $request)
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
            $ujian->get();
        }

        return view('supervisor.amplop', [
            "amplop" => $ujian
        ]);
    }

    public function bap(Request $request)
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
            $ujian->get();
        }
        
        return view('supervisor.bap', [
            "bap" => $ujian
        ]);
    }

    public function berkas(Request $request)
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
            $ujian->get();
        }

        return view('supervisor.berkas', [
            "berkas" => $ujian
        ]);
    }

    public function pengguna()
    {
        $pengguna = User::all();
        return view('supervisor.pengguna', [
            "pengguna" => $pengguna
        ]);
    }

    public function pelanggaran()
    {
        return view('supervisor.pelanggaran', ["title" => env('APP_NAME')]);
    }
}
