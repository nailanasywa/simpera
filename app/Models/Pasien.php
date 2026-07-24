<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pasien extends Model
{
    protected $table = 'pasien';

    protected $fillable = [
        'no_rm',
        'nama_pasien',
        'jenis_kelamin',
        'tanggal_lahir',
        'umur',
        'nama_kk',
        'alamat',
        'status_rm'
    ];

    // relasi
    public function kunjungan()
    {
        return $this->hasMany(Kunjungan::class);
    }

    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class);
    }
}
