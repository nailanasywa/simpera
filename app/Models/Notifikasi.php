<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notifikasi extends Model
{
    protected $table = 'notifikasi';

    protected $fillable = [
        'jenis_notifikasi',
        'waktu',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];
}
