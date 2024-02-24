<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FtiEvaluation extends Model
{
    use HasFactory;
    protected $table = 'fti_evaluations';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id_submission',
        'tipe',
        'q1',
        'k1',
        'q2',
        'k2',
        'q3',
        'k3',
        'q4',
        'k4',
        'q5',
        'k5',
        'q6',
        'k6',
        'q7',
        'k7',
        'total',
        'average',
        'orisinalitas',
        'kualitas_teknikal',
        'metodologi',
        'kejelasan_kalimat',
        'urgensi',
        'last_comment',
        'grade_value',
    ];
}
