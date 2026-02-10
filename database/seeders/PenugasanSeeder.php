<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PenugasanSeeder extends Seeder
{
    public function run(): void
    {
        // Use insert for bulk data to be faster
        DB::table('penugasan')->insert([
            ['name' => 'Pos Pengawal'],
            ['name' => 'Rondaan MPV'],
            ['name' => 'Rondaan URB'],
            ['name' => 'Bit / Pondok Polis'],
            ['name' => 'Tugas Pejabat'],
            ['name' => 'Operasi Khas'],
            ['name' => 'Latihan / Kursus'],
            ['name' => 'Kaunter Pertanyaan / Kaunter Aduan'],
            ['name' => 'Bilik Penjara'],
            ['name' => 'Bilik Senjata'],
            ['name' => 'Bilik Siasatan'],
            ['name' => 'Bilik Kawalan / Bilik Operasi'],
            ['name' => 'Pejabat Pentadbiran'],
            ['name' => 'Lain-lain'],
        ]);
    }
}