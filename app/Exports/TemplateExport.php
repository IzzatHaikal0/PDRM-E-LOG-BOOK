<?php

namespace App\Exports;

use App\Models\Pangkat;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;

class TemplateExport implements FromArray, WithHeadings, WithEvents
{
    public function array(): array
    {
        // Sample data row to guide the user
        return [
            ['Ali Bin Abu', '880101015555', 'RF12345', '0123456789', 'Sarjan (Sjn)', 'anggota']
        ];
    }

    public function headings(): array
    {
        // Exact headers from your screenshot
        return ['nama_penuh', 'no_kad_pengenalan', 'no_badan', 'no_telefon', 'pangkat', 'peranan'];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                
                // 1. GET PANGKAT LIST FROM DB
                // This pulls "Admin", "Konstabel (Konst)", "Sarjan (Sjn)" etc.
                $pangkats = Pangkat::pluck('pangkat_name')->toArray();
                
                // Format for Excel Validation list: "Item1,Item2,Item3"
                $pangkatList = '"' . implode(',', $pangkats) . '"';

                // 2. APPLY DROPDOWN TO COLUMN E (Pangkat)
                // We apply this from Row 2 down to Row 1000
                $validation = $event->sheet->getCell('E2')->getDataValidation();
                $validation->setType(DataValidation::TYPE_LIST);
                $validation->setErrorStyle(DataValidation::STYLE_STOP); // Block invalid values
                $validation->setAllowBlank(false);
                $validation->setShowInputMessage(true);
                $validation->setShowErrorMessage(true);
                $validation->setShowDropDown(true);
                $validation->setErrorTitle('Pangkat Tidak Sah');
                $validation->setError('Sila pilih pangkat daripada senarai dropdown sahaja.');
                $validation->setFormula1($pangkatList);

                // Clone this rule to rows E2 through E1000
                for ($i = 3; $i <= 1000; $i++) {
                    $event->sheet->getCell("E$i")->setDataValidation(clone $validation);
                }
                
                // 3. APPLY DROPDOWN TO COLUMN F (Peranan)
                $roles = '"admin,penyelia,anggota"';
                $roleValidation = $event->sheet->getCell('F2')->getDataValidation();
                $roleValidation->setType(DataValidation::TYPE_LIST);
                $roleValidation->setErrorStyle(DataValidation::STYLE_STOP);
                $roleValidation->setShowDropDown(true);
                $roleValidation->setFormula1($roles);
                
                for ($i = 3; $i <= 1000; $i++) {
                    $event->sheet->getCell("F$i")->setDataValidation(clone $roleValidation);
                }

                // 4. Auto-size columns for better visibility
                foreach (range('A', 'F') as $columnID) {
                    $event->sheet->getColumnDimension($columnID)->setAutoSize(true);
                }
            },
        ];
    }
}