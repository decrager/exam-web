<?php

namespace App\Imports;

use App\Models\User;
use App\Models\Mahasiswa;
use App\Models\Praktikum;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class MahasiswaImport implements ToCollection, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row)
        {
            User::create([
                'name' => $row['nama'],
                'email' => $row['nim'],
                'password' => Hash::make('12345678'),
                'role' => 'mahasiswa',
                'lokasi' => '-'
            ]);

            $late = User::orderBy('id', 'DESC')->take(1)->get();
            foreach ($late as $iduser) {
                $latest = $iduser->id;
            }

            $prak_id = Praktikum::join('kelas', 'praktikums.kelas_id', 'kelas.id')
            ->join('semesters', 'kelas.semester_id', 'semesters.id')
            ->join('prodis', 'semesters.prodi_id', 'prodis.id')
            ->select('praktikums.id')
            ->where('prodis.kode_prodi', $row['kode_prodi'])
            ->where('semesters.semester', $row['semester'])
            ->where('kelas.kelas', $row['kelas'])
            ->where('praktikums.praktikum', $row['praktikum'])
            ->first();
            
            Mahasiswa::create([
                'nama' => $row['nama'],
                'nim' => $row['nim'],
                'email' => $row['nim'],
                'user_id' => $latest,
                'prak_id' => $prak_id->id
            ]);
        }
    }
}
