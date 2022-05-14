<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Master extends Model
{
    use HasFactory;
    protected $table = 'masters';
    protected $primaryKey = 'id';
    protected $guarded = [];
    protected $fillable = [
        'thn_ajaran',
        'smt_akademik',
        'periode_mulai',
        'periode_akhir',
        'isuas',
    ];

    public function Ujian()
    {
        return $this->hasMany(Ujian::class, 'master_id', 'id');
    }
}
