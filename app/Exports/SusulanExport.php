<?php

namespace App\Exports;

use App\Models\Susulan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SusulanExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $susulan = Susulan::join('mahasiswas', 'susulans.mhs_id', 'mahasiswas.id')
        ->join('praktikums', 'mahasiswas.prak_id', 'praktikums.id')
        ->join('kelas', 'praktikums.kelas_id', 'kelas.id')
        ->join('semesters AS a', 'kelas.semester_id', 'a.id')
        ->join('matkuls', 'susulans.matkul_id', 'matkuls.id')
        ->join('semesters AS b', 'matkuls.semester_id', 'b.id')
        ->join('prodis', 'b.prodi_id', 'prodis.id')
        ->selectRaw('prodis.nama_prodi, b.semester, matkuls.nama_matkul, kelas.kelas, praktikums.praktikum, mahasiswas.nama, mahasiswas.nim, susulans.status, susulans.catatan, DATE_FORMAT(susulans.created_at, "%d-%m-%Y"), DATE_FORMAT(susulans.created_at, "%H:%i:%s")')
        ->get();

        return $susulan;
    }

    public function headings(): array
    {
        return [
            'Program Studi',
            'Semester',
            'Mata Kuliah',
            'Kelas',
            'Praktikum',
            'Nama Mahasiswa',
            'NIM',
            'Status',
            'Catatan',
            'Tanggal Upload',
            'Jam Upload'
        ];
    }
}
