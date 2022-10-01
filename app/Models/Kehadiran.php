<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kehadiran extends Model
{
    use HasFactory;
    protected $table = 'kehadirans';
    protected $primaryKey = 'id';
    protected $guarded = [];
    protected $fillable = [
        'mhs_id',
        'ujian_id',
        'kehadiran'
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
