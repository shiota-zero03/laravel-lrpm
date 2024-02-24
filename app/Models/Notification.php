<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;
    protected $table = 'notifications';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id_jenis',
        'jenis_notifikasi',
        'judul_notifikasi',
        'text_notifikasi',
        'to_role',
        'to_id',
        'read_status',
    ];
}
