<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Petugas RM 1',
            'email' => 'petugasrm1@simpera.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'poli_id' => null
        ]);
        User::create([
            'name' => 'Petugas RM 2',
            'email' => 'petugasrm2@simpera.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'poli_id' => null
        ]);
        User::create([
            'name' => 'Petugas RM 3',
            'email' => 'petugasrm3@simpera.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'poli_id' => null
        ]);
        User::create([
            'name' => 'NUR FALAKHIS SHOIMA, M.P.H',
            'email' => 'kepala@puskesmas.com',
            'password' => Hash::make('password'),
            'nip' => '197509112007012022',
            'role' => 'kepala_puskesmas',
            'poli_id' => null,
        ]);
    }
}
