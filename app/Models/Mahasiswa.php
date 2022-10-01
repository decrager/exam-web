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
        'user_id',
        'nim',
        'nama',
        'email'
    ];

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['dbProdi'] ?? false, function($query, $prodi) {
            return $query->where('prodis.nama_prodi', 'like', '%' . $prodi . '%');
        });
        
        $query->when($filters['dbSemester'] ?? false, function($query, $semester) {
            return $query->where('semesters.semester', 'like', '%' . $semester . '%');
        });

        $query->when($filters['dbKelas'] ?? false, function($query, $kelas) {
            return $query->where('kelas.kelas', 'like', '%' . $kelas . '%');
        });

        $query->when($filters['dbPraktikum'] ?? false, function($query, $praktikum) {
            return $query->where('praktikums.praktikum', 'like', '%' . $praktikum . '%');
        });
    }

    public function Praktikum()
    {
        return $this->belongsTo(Praktikum::class, 'prak_id', 'id');
    }

    public function Kehadiran()
    {
        return $this->hasMany(Kehadiran::class, 'mhs_id', 'id');
    }

    public function Pelanggaran()
    {
        return $this->hasMany(Pelanggaran::class, 'mhs_id', 'id');
    }

    public function Susulan()
    {
        return $this->hasMany(Susulan::class, 'mhs_id', 'id');
    }

    public function User()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
