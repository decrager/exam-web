<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    use HasFactory;
    protected $table = 'kelas';
    protected $primaryKey = 'id';
    protected $guarded = [];
    protected $fillable = [
        'prodi_id',
        'kelas',
        'semester',
        'jml_mhs'
    ];

    public function Praktikum()
    {
        return $this->hasMany(Praktikum::class, 'kelas_id', 'id');
    }

    public function Prodi()
    {
        return $this->belongsTo(Prodi::class, 'prodi_id', 'id');
    }
}