<?php

namespace App\Imports;

use App\Models\User;
use App\Models\Pengawas;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PengawasImport implements ToCollection, WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row)
        {
            User::create([
                'name' => $row['nama'],
                'email' => $row['nik'],
                'password' => Hash::make('12345678'),
                'role' => 'pengawas',
                'lokasi' => '-'
            ]);

            $late = User::orderBy('id', 'DESC')->take(1)->get();
            foreach ($late as $iduser) {
                $latest = $iduser->id;
            }

            Pengawas::create([
                'nama' => $row['nama'],
                'nik' => $row['nik'],
                'pns' => $row['pns'],
                'norek' => $row['norek'],
                'bank' => $row['bank'],
                'tlp' => $row['telp'],
                'user_id' => $latest
            ]);
        }
    }

    public function headingRow(): int
    {
        return 2;
    }
}
