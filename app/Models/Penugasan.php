<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penugasan extends Model
{
    use HasFactory;
    protected $table = 'penugasans';
    protected $primaryKey = 'id';
    protected $guarded = [];
    protected $fillable = [
        'ujian_id',
        'pengawas_id',
        'presensi',
        'file'
    ];

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['dbProdi'] ?? false, function($query, $prodi) {
            return $query->where('prodis.nama_prodi', 'like', '%' . $prodi . '%');
        });
        
        $query->when($filters['dbSemester'] ?? false, function($query, $semester) {
            return $query->where('b.semester', 'like', '%' . $semester . '%');
        });

        $query->when($filters['dbKelas'] ?? false, function($query, $kelas) {
            return $query->where('kelas.kelas', 'like', '%' . $kelas . '%');
        });

        $query->when($filters['dbPraktikum'] ?? false, function($query, $praktikum) {
            return $query->where('praktikums.praktikum', 'like', '%' . $praktikum . '%');
        });

        $query->when($filters['dbMatkul'] ?? false, function($query, $matkul) {
            return $query->where('matkuls.nama_matkul', 'like', '%' . $matkul . '%');
        });

        $query->when($filters['dbTanggal'] ?? false, function($query, $tanggal) {
            return $query->where('ujians.tanggal', 'like', '%' . $tanggal . '%');
        });

        $query->when($filters['dbRuang'] ?? false, function($query, $ruang) {
            return $query->where('ujians.ruang', 'like', '%' . $ruang . '%');
        });
    }

    public function Pengawas()
    {
        return $this->belongsTo(Pengawas::class, 'pengawas_id', 'id');
    }

    public function Ujian()
    {
        return $this->belongsTo(Ujian::class, 'ujian_id', 'id');
    }
}
