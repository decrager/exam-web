<?php

namespace App\Exports;

use App\Models\Pelanggaran;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class KetidakhadiranExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $pelanggaran = Pelanggaran::join('mahasiswas', 'pelanggarans.mhs_id', 'mahasiswas.id')
        ->join('praktikums', 'mahasiswas.prak_id', 'praktikums.id')
        ->join('kelas', 'praktikums.kelas_id', 'kelas.id')
        ->join('semesters', 'kelas.semester_id', 'semesters.id')
        ->join('prodis', 'semesters.prodi_id', 'prodis.id')
        ->join('ujians', 'pelanggarans.ujian_id', 'ujians.id')
        ->join('matkuls', 'ujians.matkul_id', 'matkuls.id')
        ->select('ujians.tanggal', 'prodis.nama_prodi', 'semesters.semester', 'kelas.kelas', 'praktikums.praktikum', 'matkuls.nama_matkul', 'mahasiswas.nama', 'mahasiswas.nim', 'pelanggarans.pelanggaran')
        ->get();

        return $pelanggaran;
    }

    public function headings(): array
    {
        return [
            'Tanggal',
            'Program Studi',
            'Semester',
            'Kelas',
            'Praktikum',
            'Mata Kuliah',
            'Nama',
            'NIM',
            'Alasan Ketidakhadiran',
        ];
    }
}
