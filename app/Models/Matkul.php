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
        'semester_id',
        'kode_matkul',
        'nama_matkul'
    ];

    public function Semester()
    {
        return $this->belongsTo(Semester::class, 'semester_id', 'id');
    }

    public function Ujian()
    {
        return $this->hasMany(Ujian::class, 'matkul_id', 'id');
    }

    public function Susulan()
    {
        return $this->hasMany(Susulan::class, 'matkul_id', 'id');
    }
}
