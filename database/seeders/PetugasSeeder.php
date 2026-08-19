<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class PetugasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Petugas 1',
            'email' => 'petugas1@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'petugas_poli',
            'poli_id' => 1,
        ]);

        User::create([
            'name' => 'Petugas 2',
            'email' => 'petugas2@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'petugas_poli',
            'poli_id' => 2,
        ]);

        User::create([
            'name' => 'Petugas 3',
            'email' => 'petugas3@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'petugas_poli',
            'poli_id' => 3,
        ]);
    }
}
