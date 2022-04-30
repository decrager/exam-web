<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Praktikum extends Model
{
    use HasFactory;
    protected $table = 'praktikums';
    protected $primaryKey = 'id';
    protected $guarded = [];
    protected $fillable = [
        'kelas_id',
        'praktikum',
        'jml_mhs'
    ];

    public function Mahasiswa()
    {
        return $this->hasMany(Mahasiswa::class, 'prak_id', 'id');
    }

    public function Kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id', 'id');
    }
}
