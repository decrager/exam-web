<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Semester extends Model
{
    use HasFactory;
    protected $table = 'semesters';
    protected $primaryKey = 'id';
    protected $guarded = [];
    protected $fillable = [
        'prodi_id',
        'semester',
    ];

    public function Kelas()
    {
        return $this->hasMany(Kelas::class, 'semester_id', 'id');
    }

    public function Prodi()
    {
        return $this->belongsTo(Prodi::class, 'prodi_id', 'id');
    }
}
