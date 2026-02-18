<?php

namespace App\Imports;

use App\Models\User;
use App\Models\Pangkat;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class UsersImport implements ToModel, WithHeadingRow, WithValidation
{
    /**
     * Intercept and fix Excel's broken formatting BEFORE validation happens
     */
    public function prepareForValidation($data, $index)
    {
        // 1. Fix IC Number (Malaysian ICs are exactly 12 digits)
        if (!empty($data['no_kad_pengenalan'])) {
            // Strip any accidental spaces or dashes the user might have typed
            $cleanIc = preg_replace('/[^0-9]/', '', $data['no_kad_pengenalan']);
            
            // If Excel stripped the 0 (making it 11 digits), this str_pad forces it back to 12 digits by adding a '0' to the front.
            $data['no_kad_pengenalan'] = str_pad($cleanIc, 12, '0', STR_PAD_LEFT);
        }

        // 2. Fix Phone Number (Must start with '0')
        if (!empty($data['no_telefon'])) {
            $cleanPhone = preg_replace('/[^0-9]/', '', $data['no_telefon']);
            
            // If the phone number doesn't start with a '0', add it back
            if (!empty($cleanPhone) && !str_starts_with($cleanPhone, '0')) {
                $data['no_telefon'] = '0' . $cleanPhone;
            } else {
                $data['no_telefon'] = $cleanPhone;
            }
        }

        return $data;
    }

    /**
    * Map Excel row to Database Model
    */
    public function model(array $row)
    {
        // 1. Find Pangkat ID based on the name in Excel (e.g., "Sarjan")
        $pangkat = Pangkat::where('pangkat_name', 'LIKE', '%' . $row['pangkat'] . '%')->first();

        return new User([
            'name'       => $row['nama_penuh'],
            // The $row data here is now the PERFECTLY FIXED data from prepareForValidation!
            'no_ic'      => $row['no_kad_pengenalan'], 
            'no_badan'   => $row['no_badan'],
            'no_telefon' => $row['no_telefon'],
            'role'       => strtolower($row['peranan']),
            'pangkat_id' => $pangkat ? $pangkat->id : null,
            // The password will also use the fixed 12-digit IC with the '0' included
            'password'   => Hash::make($row['no_kad_pengenalan']), 
        ]);
    }

    /**
     * Rules to validate the Excel data
     */
    public function rules(): array
    {
        return [
            'nama_penuh'        => 'required',
            'no_kad_pengenalan' => 'required|unique:users,no_ic',
            'no_badan'          => 'required|unique:users,no_badan',
            'peranan'           => 'required|in:admin,penyelia,anggota',
        ];
    }
}