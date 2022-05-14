<?php

namespace App\Exports;

use App\Models\Ujian;
use Maatwebsite\Excel\Concerns\FromCollection;

class UjianExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Ujian::all();
    }

    public function headings(): array
    {
        return [
            'No',
            'Tanggal',
            'Program Studi',
            'Semester',
            'Kelas',
            'Praktikum',
            'Mata Kuliah',
            'Lokasi',
            'Kode Ruang',
            'Jam Mulai',
            'Jam Selesai',
        ];
    }
}
