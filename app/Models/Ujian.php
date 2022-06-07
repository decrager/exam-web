<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ujian extends Model
{
    use HasFactory;
    protected $table = 'ujians';
    protected $primaryKey = 'id';
    protected $guarded = ['master_id'];
    protected $fillable = [
        'prak_id',
        'matkul_id',
        'kapasitas',
        'isuas',
        'hari',
        'lokasi',
        'ruang',
        'jam_mulai',
        'jam_selesai',
        'tanggal',
        'tahun',
        'tipe_mk',
        'software',
        'susulan',
        'perbanyak',
        'kertas',
        'sesi',
        'pelaksanaan'
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

    public function Matkul()
    {
        return $this->belongsTo(Matkul::class, 'matkul_id', 'id');
    }

    public function Praktikum()
    {
        return $this->belongsTo(Praktikum::class, 'prak_id', 'id');
    }

    public function Pelanggaran()
    {
        return $this->hasMany(Pelanggaran::class, 'ujian_id', 'id');
    }

    public function Amplop()
    {
        return $this->hasOne(Amplop::class, 'ujian_id', 'id');
    }

    public function Berkas()
    {
        return $this->hasOne(Berkas::class, 'ujian_id', 'id');
    }

    public function Bap()
    {
        return $this->hasOne(Bap::class, 'ujian_id', 'id');
    }

    public function Penugasan()
    {
        return $this->hasMany(Penugasan::class, 'ujian_id', 'id');
    }

    public function Master()
    {
        return $this->belongsTo(Master::class, 'master_id', 'id');
    }
}
