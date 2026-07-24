<?php

namespace App\Models;

use App\Models\User;

use Illuminate\Database\Eloquent\Model;

class Poli extends Model
{
    protected $table = 'polis';

    // relasi
    public function users()
    {
        return $this->hasMany(User::class);
    }

    protected $fillable = [
        'nama_poli',
        'email'
    ];
}
