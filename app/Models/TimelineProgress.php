<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TimelineProgress extends Model
{
    use HasFactory;
    protected $table = 'timeline_progress';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id_submission',
        'judul_progress',
        'text_progress',
        'status_progress',
    ];
}
