<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Matkul extends Model
{
    use HasFactory;
    protected $table = 'matkuls';
    protected $primaryKey = 'id';
    protected $guarded = [];
    protected $fillable = [
        'prak_id',
        'kode_matkul',
        'nama_matkul',
        'semester'
    ];

    public function Praktikum()
    {
        return $this->belongsTo(Praktikum::class, 'prak_id', 'id');
    }

    public function Ujian()
    {
        return $this->hasMany(Ujian::class, 'matkul_id', 'id');
    }
}
