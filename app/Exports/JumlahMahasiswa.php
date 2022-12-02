<?php

namespace App\Exports;

use App\Models\Praktikum;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class JumlahMahasiswa implements FromCollection, WithHeadings, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $prak = Praktikum::join('kelas', 'praktikums.kelas_id', 'kelas.id')
        ->join('semesters', 'kelas.semester_id', 'semesters.id')
        ->join('prodis', 'semesters.prodi_id', 'prodis.id')
        ->join('mahasiswas', 'mahasiswas.prak_id', 'praktikums.id')
        ->groupBy('prodis.kode_prodi', 'prodis.nama_prodi', 'semesters.semester', 'kelas.kelas', 'praktikums.praktikum')
        ->selectRaw('prodis.kode_prodi, prodis.nama_prodi, semesters.semester, kelas.kelas, praktikums.praktikum, count(mahasiswas.id) AS jml_mhs')
        ->get();

        return $prak;
    }

    public function headings(): array
    {
        return [
            'Kode Program Studi',
            'Program Studi',
            'Semester',
            'Kelas',
            'Praktikum',
            'Jumlah'
        ];
    }
}
