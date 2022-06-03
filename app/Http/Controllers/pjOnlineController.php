<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Ujian;
use App\Models\Master;
use Illuminate\Http\Request;
use function PHPUnit\Framework\isEmpty;

class pjOnlineController extends Controller
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

        return view('pj_online.dashboard', [
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
        ->where('ujians.pelaksanaan', 'like', '%Online%')
        ->orWhere('ujians.ruang', 'like', '%Online%')
        ->filter(request(['dbProdi', 'dbSemester', 'dbPraktikum', 'dbKelas', 'dbMatkul', 'dbTanggal', 'dbRuang']));

        return view('pj_online.ujian', [
            'ujian' => $ujian->get(),
            'ujians' => $ujian->get()
        ]);
    }

    public function pelanggaranIndex()
    {
        $dataPelanggaran = Pelanggaran::orderBy('created_at', 'desc')->get();
        $dataTanggalMulai = Master::first();
        $dataTanggalSelesai = Master::first();

        $from = $dataTanggalMulai->periode_mulai;
        $to = $dataTanggalSelesai->periode_akhir;

        $period = new DatePeriod( new DateTime($from), new DateInterval('P1D'), new DateTime($to));
        $dbData = [];

        foreach($period as $date){
            $range[$date->format("Y-m-d")] = 0;
        };

        $data = Pelanggaran::join('ujians', 'pelanggarans.ujian_id', 'ujians.id')
            ->selectRaw('tanggal, count(pelanggarans.id) as total_pelanggaran')
            ->whereDate('tanggal', '>=', date($from).' 00:00:00')
            ->whereDate('tanggal', '<=', date($to).' 00:00:00')
            ->groupBy('tanggal')
            ->get();

        foreach($data as $val){
            $dbData[$val->tanggal] = $val->total_pelanggaran;
        }

        $data = array_replace($range, $dbData);
        $label =  array_keys($data);
        $data = array_values($data);
        
        // return view('pj_online.pelanggaran.index', [
        //     'label' => $label,
        //     'data' => $data
        //   ], compact(['dataPelanggaran']));
    }

    public function pelanggaranForm()
    {
        return view('pj_online.pelanggaran.form', ["title" => env('APP_NAME')]);
    }

    public function pelanggaranEdit()
    {
        return view('pj_online.pelanggaran.edit', ["title" => env('APP_NAME')]);
    }
}
