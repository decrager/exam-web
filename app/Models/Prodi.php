<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prodi extends Model
{
    use HasFactory;
    protected $table = 'prodis';
    protected $primaryKey = 'id';
    protected $guarded = [];
    protected $fillable = [
        'nama_prodi',
        'kode_prodi'
    ];

    public function Kelas()
    {
        return $this->hasMany(Kelas::class, 'prodi_id', 'id');
    }
}
