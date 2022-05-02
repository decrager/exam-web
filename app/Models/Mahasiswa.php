<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    use HasFactory;
    protected $table = 'mahasiswas';
    protected $primaryKey = 'id';
    protected $guarded = [];
    protected $fillable = [
        'prak_id',
        'nim',
        'nama',
        'email',
    ];

    public function Praktikum()
    {
        return $this->belongsTo(Praktikum::class, 'prak_id', 'id');
    }

    public function Pelanggaran()
    {
        return $this->hasMany(Pelanggaran::class, 'mhs_id', 'id');
    }

    public function Susulan()
    {
        return $this->hasMany(Susulan::class, 'mhs_id', 'id');
    }
}
