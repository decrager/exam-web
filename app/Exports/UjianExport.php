<?php

namespace App\Exports;

use App\Models\Ujian;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UjianExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $dataTanggalMulai = Master::first();
        $dataTanggalSelesai = Master::first();

        $from = $dataTanggalMulai->periode_mulai;
        $to = $dataTanggalSelesai->periode_akhir;

        $test = Ujian::join('matkuls', 'ujians.matkul_id', '=', 'matkuls.id')
        ->join('semesters AS a', 'matkuls.semester_id', '=', 'a.id')
        ->join('praktikums', 'ujians.prak_id', '=', 'praktikums.id')
        ->join('kelas', 'praktikums.kelas_id', '=', 'kelas.id')
        ->join('semesters AS b', 'kelas.semester_id', '=', 'b.id')
        ->join('prodis', 'b.prodi_id', '=', 'prodis.id')
        ->join('masters', 'ujians.master_id', '=', 'masters.id')
        ->select('masters.thn_ajaran', 'masters.smt_akademik', 'matkuls.kode_matkul', 'matkuls.nama_matkul', 'matkuls.sks', 'matkuls.sks_kul', 'matkuls.sks_prak', DB::raw("date_format(ujians.tanggal, '%d/%m/%Y') as tanggal"), 'ujians.jam_mulai', 'ujians.jam_selesai', 'ujians.ruang', 'ujians.kapasitas', 'masters.isuas', 'ujians.tipe_mk', 'kelas.kelas','praktikums.praktikum', 'prodis.kode_prodi')
        ->whereBetween('ujians.tanggal', [$from, $to])
        ->get();
    }

    public function headings(): array
    {
        return [
            'Tahun Akademik',
            'Semester Akademik',
            'Kode Mata Kuliah',
            'Nama Mata Kuliah',
            'SKS',
            'SKS Kuliah',
            'SKS Praktikum',
            'Tanggal',
            'Jam Mulai',
            'Jam Selesai',
            'Kode Ruang',
            'Kapasitas Ujian',
            'IsUAS',
            'Tipe MK',
            'Kelas Paralel',
            'Kelompok',
            'Kode PK'
        ];
    }
}
