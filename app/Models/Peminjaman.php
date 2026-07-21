<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    protected $table = 'peminjaman';

    protected $fillable = [
        'pasien_id',
        'kunjungan_id',
        'permintaan_peminjaman_id',
        'jenis_peminjaman',
        'tanggal_pinjam',
        'tanggal_jatuh_tempo',
        'tanggal_kembali',
        'jumlah_hari_terlambat',
        'status_peminjaman',
    ];

    protected $casts = [
        'tanggal_pinjam'        => 'datetime',
        'tanggal_kembali'       => 'datetime',
        'tanggal_jatuh_tempo'   => 'datetime',
    ];

    // relasi
    public function pasien(){
        return $this->belongsTo(Pasien::class);
    }
    public function kunjungan(){
        return $this->belongsTo(Kunjungan::class);
    }
    public function permintaan(){
        return $this->belongsTo(PermintaanPeminjaman::class, 'permintaan_peminjaman_id');
    }
}
