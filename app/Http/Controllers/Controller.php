<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Models\Prodi;
use App\Models\Kelas;
use App\Models\Praktikum;
use App\Models\Matkul;
use App\Models\Ujian;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function filter($prodi, $semester, $matkul, $kelas, $praktikum, $tanggal, $ruang)
    {
        $ujian = Ujian::join('matkuls', 'ujians.matkul_id', '=', 'matkuls.id')
            ->join('semesters AS a', 'matkuls.semester_id', '=', 'a.id')
            ->join('praktikums', 'ujians.prak_id', '=', 'praktikums.id')
            ->join('kelas', 'praktikums.kelas_id', '=', 'kelas.id')
            ->join('semesters AS b', 'kelas.semester_id', '=', 'b.id')
            ->join('prodis', 'b.prodi_id', '=', 'prodis.id')
            ->join('amplops', 'amplops.ujian_id', '=', 'ujians.id')
            ->join('baps', 'baps.ujian_id', '=', 'ujians.id')
            ->join('berkas', 'berkas.ujian_id', '=', 'ujians.id');

        if ($prodi) {
            $ujian->where('prodis.nama_prodi', 'like', '%' . $prodi . '%');
            if ($semester) {
                $ujian->where('b.semester', 'like', '%' . $semester . '%');
                if ($kelas) {
                    $ujian->where('kelas.kelas', 'like', '%' . $kelas . '%');
                    if ($praktikum) {
                        $ujian->where('praktikums.praktikum', 'like', '%' . $praktikum . '%');
                    }
                }
                if ($matkul) {
                    $ujian->where('matkuls.nama_matkul', 'like', '%' . $matkul . '%');
                }
            }
        }

        if ($tanggal) {
            $ujian->where('tanggal', 'like', '%' . $tanggal . '%');
        }

        if ($ruang) {
            $ujian->where('ruang', 'like', '%' . $ruang . '%');
        }

        return $ujian;
    }
}
