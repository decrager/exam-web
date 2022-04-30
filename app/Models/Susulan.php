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
        'file',
        'status'
    ];
}
