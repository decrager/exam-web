<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Berkas extends Model
{
    use HasFactory;
    protected $table = 'berkas';
    protected $primaryKey = 'id';
    protected $guarded = [];
    protected $fillable = [
        'ujian_id',
        'jml_berkas',
        'pengambilan',
        'fotokopi',
        'lengkap',
        'asisten',
        'serah_terima',
        'ttd_penerima',
        'ttd_penyerah'
    ];

    public function Ujian()
    {
        return $this->belongsTo(Berkas::class, 'ujian_id', 'id');
    }
}
