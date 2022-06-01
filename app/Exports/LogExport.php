<?php

namespace App\Exports;

use App\Models\LogActivities;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class LogExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return LogActivities::select(DB::raw("date_format(created_at, '%d/%m/%Y %H:%i:%s') as tanggal"), 'activity')->latest()->get();
    }

    public function headings(): array
    {
        return [
            'Waktu',
            'Aktivitas'
        ];
    }
}
