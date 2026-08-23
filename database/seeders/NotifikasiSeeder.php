<?php

namespace Database\Seeders;

use App\Models\Notifikasi;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NotifikasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Notifikasi::create([
            'jenis_notifikasi' => 'pengingat_pengembalian',
            'waktu' => '07:00:00',
            'status' => true,
        ]);
    }
}
