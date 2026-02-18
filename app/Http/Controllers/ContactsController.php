<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Kecemasan;

class ContactsController extends Controller
{
    /** 
    public function index()
    {
        // --- TOGGLE THIS TO FALSE LATER TO USE REAL DATABASE ---
        $testMode = true;

        if ($testMode) {
            // MOCK DATA (For UI Testing)
            $contacts = collect([
                (object)[
                    'id' => 1,
                    'name' => 'Insp. Razak bin Aman',
                    'rank' => 'Inspektor',
                    'position' => 'Ketua Balai (OCS)',
                    'phone' => '0123456789',
                    'department' => 'Pentadbiran'
                ],
                (object)[
                    'id' => 2,
                    'name' => 'Asp. Tiong Kim Seng',
                    'rank' => 'ASP',
                    'position' => 'Pegawai Turus Siasatan',
                    'phone' => '0198765432',
                    'department' => 'JSJ'
                ],
                (object)[
                    'id' => 3,
                    'name' => 'Sjn. Mejar Halim',
                    'rank' => 'Sarjan Mejar',
                    'position' => 'Penyelia MPV',
                    'phone' => '0135559999',
                    'department' => 'Logistik'
                ],
                (object)[
                    'id' => 4,
                    'name' => 'Kpl. Sarah Liyana',
                    'rank' => 'Koperal',
                    'position' => 'Kerani Pentadbiran',
                    'phone' => '0172223333',
                    'department' => 'Pentadbiran'
                ]
            ]);

            $departments = [
            (object)['name' => 'IPD Pekan (Pertanyaan)', 'category' => 'PDRM', 'phone' => '094221222'],
            (object)['name' => 'Bomba & Penyelamat Pekan', 'category' => 'Kecemasan', 'phone' => '094224444'],
            (object)['name' => 'Hospital Pekan', 'category' => 'Kesihatan', 'phone' => '094244333'],
            (object)['name' => 'Angkatan Pertahanan Awam', 'category' => 'Kecemasan', 'phone' => '069512345'],
            (object)['name' => 'Majlis Perbandaran Pekan', 'category' => 'MPP', 'phone' => '094211077'],
        ];

        } else {
            // REAL DATABASE QUERY
            // Fetch users who are officers/supervisors, excluding the current user
            $contacts = User::where('role', '!=', 'staff') // Adjust query based on your needs
                ->where('id', '!=', Auth::id())
                ->orderBy('name')
                ->get();

        
            $departments = [];
        }

        return view('Users.Contacts', compact('contacts', 'departments'));
    }*/

    public function index()
    {
        $kecemasans = Kecemasan::orderBy('name', 'asc')->get();
        $contact_penyelia = User::where('role', 'penyelia')->get();
        
        return view('Users.Contacts', compact('kecemasans', 'contact_penyelia')); 
    }
}