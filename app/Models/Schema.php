<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schema extends Model
{
    use HasFactory;
    protected $table = 'schemas';
    protected $primaryKey = 'id';
    protected $fillable = [
        'nama_skema',
        'max_dana_pkm',
        'max_dana_penelitian'
    ];
}
