<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuperiorResearch extends Model
{
    use HasFactory;
    protected $table = 'superior_research';
    protected $primaryKey = 'id';
    protected $fillable = [
        'nama_riset'
    ];
}
