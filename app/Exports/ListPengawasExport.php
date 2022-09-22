<?php

namespace App\Exports;

use Carbon\Carbon;
use App\Models\Ruangan;
use App\Models\Penugasan;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Cell\StringValueBinder;
use Maatwebsite\Excel\Concerns\Exportable;

class ListPengawasExport extends \PhpOffice\PhpSpreadsheet\Cell\StringValueBinder implements FromQuery, WithHeadings, ShouldAutoSize
{
    use Exportable;

    public function __construct(string $lokasi)
    {
        $this->lokasi = $lokasi;
    }

    public function query()
    {
        // $now = Carbon::now()->toDateString();
        $now = "2022-06-08";

        $pengawas = Penugasan::join('pengawas', 'penugasans.pengawas_id', 'pengawas.id')
        ->join('ujians', 'penugasans.ujian_id', '=', 'ujians.id')
        ->join('matkuls', 'ujians.matkul_id', '=', 'matkuls.id')
        ->join('semesters AS a', 'matkuls.semester_id', '=', 'a.id')
        ->join('praktikums', 'ujians.prak_id', '=', 'praktikums.id')
        ->join('kelas', 'praktikums.kelas_id', '=', 'kelas.id')
        ->join('semesters AS b', 'kelas.semester_id', '=', 'b.id')
        ->join('prodis', 'b.prodi_id', '=', 'prodis.id')
        ->join('masters', 'ujians.master_id', '=', 'masters.id')
        ->where('ujians.tanggal', $now)
        ->where(function ($query) {
            $tot1 = count(Ruangan::groupBy('lokasi')->selectRaw('count(lokasi) as lokasi')->get());
            $lokasi = Ruangan::groupBy('lokasi')->select('lokasi')->get();
            for ($i = 0; $i < $tot1; $i++) {
                if ($this->lokasi == $lokasi[$i]->lokasi) {
                    $ruangan = Ruangan::select('ruangan')->where('lokasi', $lokasi[$i]->lokasi)->get();
                    $tot2 = count($ruangan);
                    $query->where('ujians.ruang', $ruangan[0]->ruangan);
                    for ($j = 0; $j < $tot2; $j++) {
                        $query->orWhere('ujians.ruang', $ruangan[$j]->ruangan);
                    }
                }
            }
        });

        $pengawas->selectRaw('prodis.nama_prodi, matkuls.kode_matkul, matkuls.nama_matkul, ujians.jam_mulai, ujians.jam_selesai, ujians.ruang, kelas.kelas, praktikums.praktikum, prodis.kode_prodi, pengawas.nama')
        ->get();

        return $pengawas;
    }

    public function headings(): array
    {
        return [
            'Program Studi',
            'Kode Mata Kuliah',
            'Nama Mata Kuliah',
            'Jam Mulai',
            'Jam Selesai',
            'Kode Ruang',
            'Kelas',
            'Kelompok',
            'Kode PK',
            'Nama Pengawas',
        ];
    }
}
