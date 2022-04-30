<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ketentuan extends Model
{
    use HasFactory;
    protected $table = 'ketentuans';
    protected $primaryKey = 'id';
    protected $guarded = [];
    protected $fillable = [
        'ketentuan'
    ];
}
