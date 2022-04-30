<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ujian extends Model
{
    use HasFactory;
    protected $table = 'ujians';
    protected $primaryKey = 'id';
    protected $guarded = [];
    protected $fillable = [
        'matkul_id',
        'lokasi_id',
        'hari',
        'jam_mulai',
        'jam_selesai',
        'tanggal',
        'tahun',
        'tipe_mk',
        'software',
        'susulan',
        'perbanyak',
        'sesi',
    ];

    public function Matkul()
    {
        return $this->belongsTo(Matkul::class, 'matkul_id', 'id');
    }

    public function Pelanggaran()
    {
        return $this->hasMany(Pelanggaran::class, 'ujian_id', 'id');
    }

    public function Amplop()
    {
        return $this->hasOne(Amplop::class, 'ujian_id', 'id');
    }

    public function Berkas()
    {
        return $this->hasOne(Berkas::class, 'ujian_id', 'id');
    }

    public function Bap()
    {
        return $this->hasOne(Bap::class, 'ujian_id', 'id');
    }

    public function Pengawas()
    {
        return $this->hasOne(Pengawas::class, 'ujian_id', 'id');
    }

    public function Lokasi()
    {
        return $this->belongsTo(Lokasi::class, 'lokasi_id', 'id');
    }
}
