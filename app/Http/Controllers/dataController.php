<?php

namespace App\Http\Controllers;

use App\Models\Ujian;
use App\Models\Mahasiswa;
use App\Models\User;
use Illuminate\Http\Request;
use function PHPUnit\Framework\isEmpty;

class dataController extends Controller
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

        return view('user_data.dashboard', [
            "title" => env('APP_NAME'),
            "ujian" => $ujian
        ]);
    }

    public function mahasiswaIndex(Request $request)
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

        return view('user_data.mahasiswa.index', [
            "title" => env('APP_NAME'),
            "mahasiswa" => $mahasiswa
        ]);
    }

    public function mahasiswaForm()
    {
        return view('user_data.mahasiswa.form', ["title" => env('APP_NAME')]);
    }

    public function mahasiswaEdit()
    {
        return view('user_data.mahasiswa.edit', ["title" => env('APP_NAME')]);
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

        return view('user_data.bap', [
            "title" => env('APP_NAME'),
            "bap" => $ujian
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

        return view('user_data.amplop', [
            "title" => env('APP_NAME'),
            "amplop" => $ujian
        ]);
    }

    public function penggunaIndex()
    {
        $pengguna = User::all();

        return view('user_data.pengguna.index', [
            "title" => env('APP_NAME'),
            "pengguna"
        ]);
    }

    public function penggunaForm()
    {
        return view('user_data.pengguna.form', ["title" => env('APP_NAME')]);
    }

    public function penggunaEdit()
    {
        return view('user_data.pengguna.edit', ["title" => env('APP_NAME')]);
    }

    public function pelanggaran()
    {
        return view('user_data.pelanggaran', ["title" => env('APP_NAME')]);
    }
}
