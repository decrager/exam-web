<?php

namespace App\Exports;
use App\Models\Master;
use App\Models\Penugasan;
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

        $from = $dataTanggalMulai->periode_mulai;
        $to = $dataTanggalSelesai->periode_akhir;

        $pengawas = Penugasan::join('pengawas', 'penugasans.pengawas_id', 'pengawas.id')
        ->join('ujians', 'penugasans.ujian_id', 'ujians.id')
        ->groupBy('pengawas.nama', 'pengawas.nik', 'pengawas.pns', 'pengawas.bank', 'pengawas.norek')
        ->whereBetween('ujians.tanggal', [$from, $to])
        ->selectRaw('pengawas.nama, pengawas.nik, pengawas.pns, pengawas.bank, pengawas.norek, count(*) as total')
        ->get();

        return $pengawas;
    }

    public function headings(): array
    {
        return [
            'Nama',
            'NIP/NPI/NIK',
            'Status Kepegawaian',
            'Nama Bank',
            'Nomor Rekening',
            'Total Mengawas'
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
