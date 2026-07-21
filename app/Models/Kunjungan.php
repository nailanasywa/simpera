<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kunjungan extends Model
{
    protected $table = 'kunjungan';

    protected $fillable = [
        'pasien_id',
        'poli_id',
        'jenis_kunjungan',
        'kepesertaan',
        'tanggal_kunjungan',
        'created_by',
    ];

    // relasi
    public function pasien(){
        return $this->belongsTo(Pasien::class);
    }

    public function poli(){
        return $this->belongsTo(Poli::class);
    }

    public function peminjaman(){
        return $this->hasOne(Peminjaman::class);
    }

    public function creator(){
        return $this->belongsTo(User::class, 'created_by');
    }
}
