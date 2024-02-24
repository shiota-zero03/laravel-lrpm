<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TemplateDocument extends Model
{
    use HasFactory;
    protected $table = 'template_documents';
    protected $primaryKey = 'id';
    protected $fillable = [
        'nama_template',
        'dokumen_template',
        'cant_delete',
    ];
}
