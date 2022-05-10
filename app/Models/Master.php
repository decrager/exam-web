<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Master extends Model
{
    use HasFactory;
    protected $table = 'masters';
    protected $primaryKey = 'id';
    protected $guarded = [];
    protected $fillable = [
        'thn_ajaran',
        'periode_mulai',
        'periode_akhir',
        'isuas',
    ];
}
