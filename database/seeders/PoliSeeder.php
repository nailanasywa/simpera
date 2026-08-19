<?php

namespace Database\Seeders;

use App\Models\Poli;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PoliSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $polis = [
            [
                'nama_poli' => 'Poli Gigi',
                'email' => 'nasywasafira34@gmail.com',
            ],
            [
                'nama_poli' => 'Poli Umum',
                'email' => 'nailanasywa010@gmail.com',
            ],
            [
                'nama_poli' => 'Poli Paru',
                'email' => 'indosat8319@gmail.com',
            ],
        ];

        foreach ($polis as $poli) {
            Poli::updateOrCreate(
                ['email' => $poli['email']],
                $poli
            );
        }
    }
}
