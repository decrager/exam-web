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
        'semester_id',
        'kelas',
        'jml_mhs'
    ];

    public function Praktikum()
    {
        return $this->hasMany(Praktikum::class, 'kelas_id', 'id');
    }

    public function Semester()
    {
        return $this->belongsTo(Semester::class, 'semester_id', 'id');
    }
}