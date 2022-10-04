<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Ujian;
use App\Models\Master;
use Illuminate\Http\Request;
use function PHPUnit\Framework\isEmpty;

class pjLabkomController extends Controller
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

        return view('pj_labkom.dashboard', [
            "dbUjian" => $ujian->get()
        ]);
    }

    public function ujian()
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
        ->filter(request(['dbProdi', 'dbSemester', 'dbPraktikum', 'dbKelas', 'dbMatkul', 'dbTanggal', 'dbRuang']))
        ->where(function($ujian) {
            $ujian->where('ujians.ruang', 'like', '%KOM%')
            ->orWhere('ujians.ruang', 'like', '%PEMROGRAMAN%')
            ->orWhere('ujians.ruang', 'like', '% K %');
        });

        return view('pj_labkom.ujian', [
            'ujian' => $ujian->get(),
            'ujians' => $ujian->get(),
    ]);
    }
}
