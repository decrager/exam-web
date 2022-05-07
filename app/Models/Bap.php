<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bap extends Model
{
    use HasFactory;
    protected $table = 'baps';
    protected $primaryKey = 'id';
    protected $guarded = [];
    protected $fillable = [
        'ujian_id',
        'print',
        'pengambilan'
    ];

    public function Ujian()
    {
        return $this->belongsTo(Ujian::class, 'ujian_id', 'id');
    }
}
