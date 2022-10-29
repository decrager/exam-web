<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengawas extends Model
{
    use HasFactory;
    protected $table = 'pengawas';
    protected $primaryKey = 'id';
    protected $guarded = [];
    protected $fillable = [
        'user_id',
        'nama',
        'nik',
        'pns',
        'norek',
        'bank',
        'tlp'
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

    public function Penugasan()
    {
        return $this->hasMany(Penugasan::class, 'pengawas_id', 'id');
    }

    public function User()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}