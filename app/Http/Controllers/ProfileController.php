<?php

namespace App\Http\Controllers; 

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Pangkat; 
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
    use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{   
    //Show profile page
    // Show Profile Page (For the currently logged-in user)
    public function index()
    {
        // 1. Get the currently authenticated user's ID
        $id = Auth::user()->id;

        // 2. Fetch the user data and include 'pangkat' info
        // We use 'find($id)' instead of 'User()::'
        $user = User::with('pangkat')->findOrFail($id);

        // 3. Determine which view to return based on the user's role
        if ($user->role === 'penyelia') {
            return view('Penyelia.Profile', compact('user'));
        } 
        else {
            // Default to Anggota (User) view
            return view('Users.Profile', compact('user'));
        }
    }

    public function view_edit_form($id)
    {
        // 1. Fetch the user specific to the ID passed
        $user = User::findOrFail($id);

        // 2. SECURITY CHECK: 
        // Ensure the logged-in user matches the ID they are trying to edit
        // (Unless they are an Admin, who can edit anyone)
        if (Auth::user()->role === 'anggota') {
            return view('Users.EditProfile', compact('user'));
        }elseif(Auth::user()->role === 'penyelia'){
            return view('Penyelia.EditProfile', compact('user'));

        }

        // 3. Get ranks (Pangkats) for the dropdown
        $pangkats = Pangkat::all();

        // 4. Return the view
        return view('Users.EditProfile', compact('user', 'pangkats'));
    }

    public function update_profile(Request $request, $id)
    {
        $user = User::findOrFail($id);

        // Validate
        $request->validate([
            'no_telefon' => 'required|string',
            'email'      => 'required|email|unique:users,email,'.$id,
            'alamat'     => 'required|string',
        ]);

        // Update Data
        $user->update([
            'no_telefon' => $request->no_telefon,
            'email'      => $request->email,
            'alamat'     => $request->alamat,
        ]);

        return redirect()->route('Users.Profile')->with('success', 'Profil berjaya dikemaskini.');
    }
    
}