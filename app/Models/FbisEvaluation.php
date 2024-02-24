<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FbisEvaluation extends Model
{
    use HasFactory;
    protected $table = 'fbis_evaluations';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id_submission',
        'tipe',

        'qa1',
        'sa1',
        'qa2',
        'sa2',
        'qa3',
        'sa3',
        'qa4',
        'sa4',

        'qb1',
        'sb1',
        'qb2',
        'sb2',
        'qb3',
        'sb3',

        'qc1',
        'sc1',
        'qc2',
        'sc2',
        'qc3',
        'sc3',
        'qc4',
        'sc4',

        'qd1',
        'sd1',
        'qd2',
        'sd2',
        'qd3',
        'sd3',
        'qd4',
        'sd4',
        'qd5',
        'sd5',

        'qe1',
        'se1',
        'qe2',
        'se2',

        'qf1',
        'sf1',
        'qf2',
        'sf2',

        'qg1',
        'sg1',

        'qh1',
        'sh1',
        'qh2',
        'sh2',
        'qh3',
        'sh3',
        'qh4',
        'sh4',

        'total',
        'average',

        'last_comment',
        'grade_value',
    ];
}
