<?php

namespace App\Exports;

use App\Models\Ujian;
use App\Models\Master;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ProdiExport implements FromCollection, WithHeadings, ShouldAutoSize
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
        
        $ujian = Ujian::join('matkuls', 'ujians.matkul_id', '=', 'matkuls.id')
        ->join('semesters AS a', 'matkuls.semester_id', '=', 'a.id')
        ->join('praktikums', 'ujians.prak_id', '=', 'praktikums.id')
        ->join('kelas', 'praktikums.kelas_id', '=', 'kelas.id')
        ->join('semesters AS b', 'kelas.semester_id', '=', 'b.id')
        ->join('prodis', 'b.prodi_id', '=', 'prodis.id')
        ->join('masters', 'ujians.master_id', '=', 'masters.id')
        ->select('masters.thn_ajaran', 'masters.smt_akademik', 'matkuls.kode_matkul', 'matkuls.nama_matkul', 'matkuls.sks', 'matkuls.sks_kul', 'matkuls.sks_prak', DB::raw("date_format(ujians.tanggal, '%d/%m/%Y') as tanggal"), 'ujians.jam_mulai', 'ujians.jam_selesai', 'ujians.ruang', 'ujians.kapasitas', 'masters.isuas', 'ujians.tipe_mk', 'kelas.kelas','praktikums.praktikum', 'prodis.kode_prodi')
        ->whereBetween('ujians.tanggal', [$from, $to]);

        if (Auth::user()->name == 'Komunikasi') {
            $ujian->where('prodis.kode_prodi', 'A');
        } elseif (Auth::user()->name == 'Ekowisata') {
            $ujian->where('prodis.kode_prodi', 'B');
        } elseif (Auth::user()->name == 'Manajemen Informatika') {
            $ujian->where('prodis.kode_prodi', 'C');
        } elseif (Auth::user()->name == 'Teknik Komputer') {
            $ujian->where('prodis.kode_prodi', 'D');
        } elseif (Auth::user()->name == 'Supervisor Jaminan Mutu Pangan') {
            $ujian->where('prodis.kode_prodi', 'E');
        } elseif (Auth::user()->name == 'Manajemen Industri Jasa Makanan dan Gizi') {
            $ujian->where('prodis.kode_prodi', 'F');
        } elseif (Auth::user()->name == 'Teknologi Industri Benih') {
            $ujian->where('prodis.kode_prodi', 'G');
        } elseif (Auth::user()->name == 'Teknologi Produksi dan Manajemen Perikanan Budidaya') {
            $ujian->where('prodis.kode_prodi', 'H');
        } elseif (Auth::user()->name == 'Teknologi dan Manajemen Ternak') {
            $ujian->where('prodis.kode_prodi', 'I');
        } elseif (Auth::user()->name == 'Manajemen Agribisnis') {
            $ujian->where('prodis.kode_prodi', 'J');
        } elseif (Auth::user()->name == 'Manajemen Industri') {
            $ujian->where('prodis.kode_prodi', 'K');
        } elseif (Auth::user()->name == 'Analisis Kimia') {
            $ujian->where('prodis.kode_prodi', 'L');
        } elseif (Auth::user()->name == 'Teknik dan Manajemen Lingkungan') {
            $ujian->where('prodis.kode_prodi', 'M');
        } elseif (Auth::user()->name == 'Akuntansi') {
            $ujian->where('prodis.kode_prodi', 'N');
        } elseif (Auth::user()->name == 'Paramedik Veteriner') {
            $ujian->where('prodis.kode_prodi', 'P');
        } elseif (Auth::user()->name == 'Teknologi Produksi dan Manajemen Perebunan') {
            $ujian->where('prodis.kode_prodi', 'T');
        } elseif (Auth::user()->name == 'Teknologi Produksi dan Pengembangan Masyarakat Pertanian') {
            $ujian->where('prodis.kode_prodi', 'W');
        }

        return $ujian->get();
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
