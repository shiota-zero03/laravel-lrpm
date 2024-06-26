<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Theme extends Model
{
    use HasFactory;
    protected $table = 'themes';
    protected $primaryKey = 'id';
    protected $fillable = [
        'nama_tema',
        'id_riset'
    ];
}
