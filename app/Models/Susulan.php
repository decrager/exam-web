<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Susulan extends Model
{
    use HasFactory;
    protected $table = 'susulans';
    protected $primaryKey = 'id';
    protected $guarded = [];
    protected $fillable = [
        'mhs_id',
        'matkul_id',
        'tipe_mk',
        'file',
        'alasan',
        'status',
        'persetujuan',
        'catatan'
    ];

    public function Matkul()
    {
        return $this->belongsTo(Matkul::class, 'matkul_id', "id");
    }

    public function Mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'mhs_id', "id");
    }
}
