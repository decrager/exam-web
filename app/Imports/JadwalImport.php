<?php

namespace App\Imports;

use App\Models\Bap;
use App\Models\Ujian;
use App\Models\Amplop;
use App\Models\Berkas;
use App\Models\Master;
use App\Models\Matkul;
use App\Models\Semester;
use App\Models\Praktikum;
use GuzzleHttp\Promise\Create;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class JadwalImport implements ToCollection, WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row)
        {
            $master = Master::first();

            $matkul = Matkul::join('semesters', 'matkuls.semester_id', 'semesters.id')
            ->join('prodis', 'semesters.prodi_id', 'prodis.id')
            ->select('matkuls.id')
            ->where('prodis.kode_prodi', $row['kode_prodi'])
            ->where('semesters.semester', $row['semester'])
            ->where('matkuls.kode_matkul', $row['kode_matkul'])
            ->first();

            $prak = Praktikum::join('kelas', 'praktikums.kelas_id', 'kelas.id')
            ->join('semesters', 'kelas.semester_id', 'semesters.id')
            ->join('prodis', 'semesters.prodi_id', 'prodis.id')
            ->select('praktikums.id')
            ->where('prodis.kode_prodi', $row['kode_prodi'])
            ->where('semesters.semester', $row['semester'])
            ->where('kelas.kelas', $row['kelas'])
            ->where('praktikums.praktikum', $row['praktikum'])
            ->first();

            if (empty($matkul)) {
                $cek = 0;
            } else {
                $cek = 1;
            }

            if ($cek == 0) {
                $smt = Semester::join('prodis', 'semesters.prodi_id', 'prodis.id')
                ->select('semesters.id')
                ->where('prodis.kode_prodi', $row['kode_prodi'])
                ->where('semesters.semester', $row['semester'])
                ->first();

                Matkul::create([
                    'semester_id' => $smt->id,
                    'kode_matkul' => $row['kode_matkul'],
                    'nama_matkul' => $row['matkul'],
                    'sks' => $row['sks'],
                    'sks_kul' => $row['sks_kul'],
                    'sks_prak' => $row['sks_prak']
                ]);

                $mks = Matkul::orderBy('id', 'DESC')->take(1)->get();
                foreach ($mks as $mks) {
                    $mk_id = $mks->id;
                }
            } else {
                $mk_id = $matkul->id;
            }

            Ujian::create([
                'prak_id' => $prak->id,
                'matkul_id' => $mk_id,
                'master_id' => '1',
                'kapasitas' => $row['kapasitas'],
                'isuas' => $master->isuas,
                'hari' => $row['hari'],
                'lokasi' => '-',
                'ruang' => $row['ruang'],
                'jam_mulai' => $row['jam_mulai'],
                'jam_selesai' => $row['jam_selesai'],
                'tanggal' => $row['tanggal'],
                'tahun' => $master->thn_ajaran,
                'tipe_mk' => $row['tipe_mk'],
                'software' => '-',
                'susulan' => '0',
                'perbanyak' => '0',
                'kertas' => '0',
                'sesi' => $row['sesi'],
                'pelaksanaan' => $row['pelaksanaan'],
            ]);

            $late = Ujian::orderBy('id', 'DESC')->take(1)->get();
            foreach ($late as $idmatkul) {
                $latest = $idmatkul->id;
            }

            Amplop::create([
                'ujian_id' => $latest,
                'print' => 'Belum',
                'pengambilan' => 'Belum'
            ]);

            Bap::create([
                'ujian_id' => $latest,
                'print' => 'Belum',
                'pengambilan' => 'Belum'
            ]);

            Berkas::create([
                'ujian_id' => $latest,
                'kalibrasi' => 'Belum',
                'verifikasi' => 'Belum',
                'validasi' => 'Belum',
                'fotokopi' => 'Belum',
                'lengkap' => 'Belum',
                'asisten' => 'Belum',
                'serah_terima' => 'Belum',
            ]);
        }
    }

    public function headingRow(): int
    {
        return 2;
    }
}
