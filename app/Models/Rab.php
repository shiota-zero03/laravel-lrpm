<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rab extends Model
{
    use HasFactory;
    protected $table = 'rabs';
    protected $primaryKey = 'id';
    protected $fillable = [
        'nama_item'
    ];
}
