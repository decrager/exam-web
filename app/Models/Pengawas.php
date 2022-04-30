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
        'ujian_id',
        'nama',
        'pns'
    ];

    public function Ujian()
    {
        return $this->belongsTo(Ujian::class, 'ujian_id', 'id');
    }
}
