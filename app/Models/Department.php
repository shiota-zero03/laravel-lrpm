<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;
    protected $table = 'departments';
    protected $primaryKey = 'id';
    protected $fillable = [
        'nama_prodi',
        'id_fakultas'
    ];
}
