<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PermintaanPeminjaman extends Model
{
    protected $table = 'permintaan_peminjaman';

    protected $fillable = [
        'pasien_id',
        'user_id',
        'keperluan',
        'tanggal_permintaan',
        'status_approval',
        'tanggal_approval',
        'approved_by',
    ];

    // relasi
    public function pasien() {
        return $this->belongsTo(Pasien::class);
    }
    public function peminjaman(){
        return $this->hasOne(Peminjaman::class, 'permintaan_peminjaman_id');
    }
    public function user() {
        return $this->belongsTo(User::class);
    }
}
