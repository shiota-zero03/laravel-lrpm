<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Participant extends Model
{
    use HasFactory;
    protected $table = 'participants';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id_submission',
        'nama',
        'pendidikan',
        'nidn',
        'instansi',
        'jabatan',
        'fakultas',
        'program_studi',
        'id_sinta',
        'tugas',
        'role',
    ];
}
