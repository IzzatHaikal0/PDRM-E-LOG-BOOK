<?php

namespace App\Http\Controllers; // <--- FIXED TYPO (Added 's')

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Pangkat; 
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail; 
use App\Mail\UserWelcomeMail;        

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
            'email'         => 'required|email|unique:users,email',
            'alamat'        => 'nullable|string',
        ], [
            'no_badan.unique' => 'Nombor badan ini telah didaftarkan.',
            'no_ic.unique'    => 'No. Kad Pengenalan ini telah wujud.',
            'email.unique'    => 'Alamat emel ini telah digunakan.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('tab', 'manual');
        }

        // B. Generate Random Password
        $randomPassword = Str::random(12); 

        // C. Create User
        $user = User::create([
            'name'           => $request->name,
            'email'          => $request->email,
            'role'           => $request->role, 
            'no_badan'       => $request->no_badan,
            'no_ic'          => $request->no_ic,
            'no_telefon'     => $request->no_telefon,
            'alamat'         => $request->address, 
            'pangkat_id'     => $request->pangkat_id,
            'password'       => Hash::make($randomPassword),
        ]);

        // D. Send Email
        try {
            Mail::to($user->email)->send(new UserWelcomeMail($user, $randomPassword));
        } catch (\Exception $e) {
            // Optional: Log error if email fails, but don't stop the registration process
            // \Log::error('Email failed: ' . $e->getMessage());
        }

        // E. Redirect
        return redirect()->route('Admin.Registration')
            ->with('success', 'Anggota berjaya didaftarkan dan emel telah dihantar! Kata laluan sementara: ' . $randomPassword);
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
}