<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RabSubmission extends Model
{
    use HasFactory;
    protected $table = 'rab_submissions';
    protected $primaryKey = 'id';
    protected $fillable = [
        'nama_item',
        'id_submission',
        'harga',
        'volume',
        'total',
    ];
}
