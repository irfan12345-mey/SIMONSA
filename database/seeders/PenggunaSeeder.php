<?php

namespace Database\Seeders;

use App\Models\Pengguna;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class PenggunaSeeder extends Seeder
{
    public function run(): void
    {
        Pengguna::updateOrCreate(
            ['username' => 'farhan'],
            [
                'nama'        => 'Muhammad Farhan Irfani',
                'password'    => Hash::make('admin123'),
                'role'        => 'admin',
                'status_akun' => 'aktif',
            ]
        );

        Pengguna::updateOrCreate(
            ['username' => 'rifal'],
            [
                'nama'        => 'Rifal Khairul Falah',
                'password'    => Hash::make('admin123'),
                'role'        => 'admin',
                'status_akun' => 'aktif',
            ]
        );
    }
}
