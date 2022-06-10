<?php

namespace App\Exports;
use App\Models\Master;
use App\Models\Penugasan;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;

class PengawasExport extends \PhpOffice\PhpSpreadsheet\Cell\StringValueBinder implements FromCollection, WithHeadings, ShouldAutoSize, WithColumnFormatting
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $dataTanggalMulai = Master::first();
        $dataTanggalSelesai = Master::first();

        $from = date('Y-m-d', strtotime($dataTanggalMulai->periode_mulai));
        $to = date('Y-m-d', strtotime($dataTanggalSelesai->periode_akhir));

        $pengawas = DB::select(DB::raw("SELECT pengawas.nama, pengawas.nik, pengawas.pns, pengawas.bank, pengawas.norek, a.total, ujians.tanggal, prodis.nama_prodi, matkuls.nama_matkul, ujians.ruang
        FROM penugasans
        INNER JOIN pengawas ON penugasans.pengawas_id = pengawas.id
        INNER JOIN ujians ON penugasans.ujian_id = ujians.id
        INNER JOIN matkuls ON ujians.matkul_id = matkuls.id
        INNER JOIN semesters ON matkuls.semester_id = semesters.id
        INNER JOIN prodis ON semesters.prodi_id = prodis.id, 
        (SELECT pengawas.id, COUNT(penugasans.id) AS total
        FROM penugasans INNER JOIN pengawas ON penugasans.pengawas_id = pengawas.id GROUP BY pengawas.id) AS a
        WHERE pengawas.id = a.id
        AND ujians.tanggal BETWEEN '$from' AND '$to'
        ORDER BY  pengawas.nama, pengawas.id ASC"));

        return collect($pengawas);
    }

    public function headings(): array
    {
        return [
            'Nama',
            'NIP/NPI/NIK',
            'Status Kepegawaian',
            'Nama Bank',
            'Nomor Rekening',
            'Total Mengawas',
            'Tanggal',
            'Program Studi',
            'Mata Kuliah',
            'Ruang'
        ];
    }

    public function columnFormats(): array
    {
        return [
            'A' => NumberFormat::FORMAT_TEXT,
            'B' => NumberFormat::FORMAT_NUMBER,
            'C' => NumberFormat::FORMAT_TEXT,
            'D' => NumberFormat::FORMAT_TEXT,
            'E' => NumberFormat::FORMAT_NUMBER
        ];
    }
}
