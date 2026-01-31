<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Use updateOrCreate to prevent Duplicate Entry errors
        User::updateOrCreate(
            ['email' => 'admin@pdrm.gov.my'], // Check if this email exists
            [
                'name' => 'Sjn. Mejar Halim (Admin)',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'no_badan' => 'ADMIN001',
                'no_ic' => '800101-01-1234',
                'no_telefon' => '012-3456789',
                'alamat' => 'Ibu Pejabat Polis Daerah (IPD) Muar, Johor',
                'umur' => 45,
                'pangkat_id' => 1,
                'gambar_profile' => null,
            ]
        );
    }
}