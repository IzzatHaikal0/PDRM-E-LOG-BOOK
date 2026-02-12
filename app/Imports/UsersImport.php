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
    * Map Excel row to Database Model
    */
    public function model(array $row)
    {
        // 1. Find Pangkat ID based on the name in Excel (e.g., "Sarjan")
        // Assumes your Pangkat table has a 'pangkat_name' column
        $pangkat = Pangkat::where('pangkat_name', 'LIKE', '%' . $row['pangkat'] . '%')->first();

        return new User([
            'name'       => $row['nama_penuh'],
            'no_ic'      => $row['no_kad_pengenalan'],
            'no_badan'   => $row['no_badan'],
            'no_telefon' => $row['no_telefon'],
            'role'       => strtolower($row['peranan']), // admin, penyelia, anggota
            'pangkat_id' => $pangkat ? $pangkat->id : null, // Assign ID if found, else null
            'password'   => Hash::make($row['no_kad_pengenalan']), // Password = IC
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