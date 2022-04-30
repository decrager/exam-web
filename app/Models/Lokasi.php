<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lokasi extends Model
{
    use HasFactory;
    protected $table = 'lokasis';
    protected $primaryKey = 'id';
    protected $guarded = [];
    protected $fillable = [
        'lokasi',
    ];

    public function Ujian()
    {
        return $this->hasOne(Ujian::class, 'lokasi_id', 'id');
    }

    public function Pengguna()
    {
        return $this->hasMany(Pengguna::class, 'lokasi_id', 'id');
    }
}
