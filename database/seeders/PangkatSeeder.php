<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PangkatSeeder extends Seeder
{
    public function run(): void
    {
        $pangkats = [
            ['pangkat_name' => 'Admin'],
            ['pangkat_name' => 'Konstabel (Konst)'],
            ['pangkat_name' => 'Lans Koperal (L/Kpl)'],
            ['pangkat_name' => 'Koperal (Kpl)'],
            ['pangkat_name' => 'Sarjan (Sjn)'],
            ['pangkat_name' => 'Sub-Inspektor (SI)'],
            ['pangkat_name' => 'Inspektor (Insp)'],
            ['pangkat_name' => 'Asisten Superintendan Polis (ASP)'],
            ['pangkat_name' => 'Deputi Superintendan Polis (DSP)'],
        ];

        DB::table('pangkats')->insert($pangkats);
    }
}