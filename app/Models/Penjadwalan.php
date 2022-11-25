<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penjadwalan extends Model
{
    use HasFactory;
    protected $table = 'penjadwalans';
    protected $primaryKey = 'id';
    protected $guarded = [];
    protected $fillable = [
        'ujian_id',
        'mhs_id',
    ];

    public function Mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'mhs_id', 'id');
    }

    public function Ujian()
    {
        return $this->belongsTo(Ujian::class, 'ujian_id', 'id');
    }
}
