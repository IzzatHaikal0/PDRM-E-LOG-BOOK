<?php

namespace App\Http\Controllers; // <--- FIXED TYPO (Added 's')

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Pangkat; 
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
//use Illuminate\Support\Facades\Mail; 
//use App\Mail\UserWelcomeMail;        

class RegistrationController extends Controller
{

    public function showForm()
    {
        // 1. Get all ranks from the 'pangkats' table
        $pangkats = Pangkat::all(); 
        
        // 2. Return the view and pass the data using 'compact'
        return view('Admin.Registration', compact('pangkats'));
    }

    // 2. Handle Manual Registration Submission
    public function storeManual(Request $request)
    {
        // A. Validation
        $validator = Validator::make($request->all(), [
            'name'          => 'required|string|max:255',
            'role'          => 'required|in:admin,penyelia,anggota',
            'pangkat_id'    => 'required|exists:pangkats,id',
            'no_badan'      => 'required|string|unique:users,no_badan',
            'no_ic'         => 'required|string|unique:users,no_ic',
            'no_telefon'    => 'required|string',
            'email'         => 'required|email',
        ], [
            'no_badan.unique' => 'Nombor badan ini telah didaftarkan.',
            'no_ic.unique'    => 'No. Kad Pengenalan ini telah wujud.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('tab', 'manual');
        }

        // B. Create User
        // Note: No random password generation needed anymore.
        $user = User::create([
            'name'           => $request->name,
            'email'          => $request->email,
            'role'           => $request->role, 
            'no_badan'       => $request->no_badan,
            'no_ic'          => $request->no_ic,
            'no_telefon'     => $request->no_telefon,
            'pangkat_id'     => $request->pangkat_id,
            // UPDATE: Use 'no_ic' as the default password
            'password'       => Hash::make($request->no_ic),
        ]);

        // C. Redirect
        // Removed email logic block. Updated success message to inform admin about the default password.
        return redirect()->route('Admin.Registration')
            ->with('success', 'Anggota berjaya didaftarkan. Kata laluan adalah No. Kad Pengenalan pengguna.');
    }

    // Add this function inside your RegistrationController class
    public function listUsers()
    {
        // 1. Fetch Users with their Pangkat (Eager Loading)
        // We paginate by 10 per page
        $users = User::with('pangkat')->latest()->paginate(10);

        // 2. Calculate Stats dynamically
        // We use whereHas to check the related 'pangkat' table
        $statsData = [
            'inspektor' => User::whereHas('pangkat', function($q) {
                $q->where('pangkat_name', 'LIKE', '%Inspektor%');
            })->count(),

            'sarjan'    => User::whereHas('pangkat', function($q) {
                $q->where('pangkat_name', 'LIKE', '%Sarjan%');
            })->count(),

            'koperal'   => User::whereHas('pangkat', function($q) {
                 // Exact match to avoid counting "Lans Koperal" twice
                $q->where('pangkat_name', 'Koperal (Kpl)');
            })->count(),

            'low_rank'  => User::whereHas('pangkat', function($q) {
                $q->where('pangkat_name', 'LIKE', '%Konstabel%')
                  ->orWhere('pangkat_name', 'LIKE', '%Lans%');
            })->count(),
        ];

        return view('Admin.ListAnggota', compact('users', 'statsData'));
    }

    // 3. Show Edit Form (Fetch User & Pangkats)
    public function edit($id)
    {
        // Find the user by ID or fail with 404
        $user = User::findOrFail($id);
        
        // Get all ranks for the dropdown
        $pangkats = Pangkat::all();

        return view('Admin.EditUser', compact('user', 'pangkats'));
    }

    // 4. Handle Update Submission
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        // Validation (Notice 'unique' ignores the current user ID)
        $validator = Validator::make($request->all(), [
            'name'          => 'required|string|max:255',
            'role'          => 'required|in:admin,penyelia,anggota',
            'pangkat_id'    => 'required|exists:pangkats,id',
            'no_badan'      => 'required|string|unique:users,no_badan,' . $user->id,
            'no_ic'         => 'required|string|unique:users,no_ic,' . $user->id,
            'no_telefon'    => 'required|string',
            'email'         => 'required|email|unique:users,email,' . $user->id,
            'alamat'        => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Update User Data
        $user->update([
            'name'       => $request->name,
            'email'      => $request->email,
            'role'       => $request->role,
            'no_badan'   => $request->no_badan,
            'no_ic'      => $request->no_ic,
            'no_telefon' => $request->no_telefon,
            'alamat'     => $request->address, // Map form 'address' to db 'alamat'
            'pangkat_id' => $request->pangkat_id,
        ]);

        return redirect()->route('Admin.ListAnggota')
            ->with('success', 'Maklumat anggota berjaya dikemaskini!');
    }

    //soft delete users
    public function softdelete(Request $request, $id)
    {
        // 1. Find the user
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->back()->with('success', 'Pengguna berjaya dipadam. Data masih ada dalam pangkalan data.');
    }
}