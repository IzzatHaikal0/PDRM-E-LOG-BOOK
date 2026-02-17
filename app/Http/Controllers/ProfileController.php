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
use Illuminate\Validation\Rules\Password;

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
        elseif($user->role === 'anggota') {
            // Default to Anggota (User) view
            return view('Users.Profile', compact('user'));
        }
        else{
            return view('admin.profile', compact('user'));
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

        }elseif(Auth::user()->role === 'admin'){
            return view('Admin.EditProfile', compact('user'));
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

        if (Auth::user()->role === 'anggota') {
            return redirect()->route('Users.Profile')->with('success', 'Profil berjaya dikemaskini.');
        }elseif(Auth::user()->role === 'penyelia'){
            return redirect()->route('Penyelia.Profile')->with('success', 'Profil berjaya dikemaskini.');
        }elseif(Auth::user()->role === 'admin'){
            return redirect()->route('admin.profile')->with('success', 'Profil berjaya dikemaskini.');
        }
    }

    public function update_photo(Request $request, $id)
    {
        $user = User::findOrFail($id);

        // 1. Validation
        $request->validate([
            // Ensure input name matches the form input name="photo"
            'photo' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            
            // 2. Delete Old Photo (Fix: Check the actual column name)
            if ($user->gambar_profile && \Storage::disk('public')->exists($user->gambar_profile)) {
                \Storage::disk('public')->delete($user->gambar_profile);
            }

            // 3. Store New Photo
            // This stores in storage/app/public/profile_photos
            $path = $request->file('photo')->store('profile_photos', 'public');

            // 4. Update Database
            $user->gambar_profile = $path;
            $user->save(); // <--- YOU MISSED THIS CRITICAL LINE
        }

        return redirect()->back()->with('success', 'Gambar profil berjaya dikemaskini!');
    }

    public function updatePassword(Request $request)
    {
        // 1. Capture the validated array here
        $validated = $request->validate([
            'current_password' => 'required|current_password',
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        // 2. Use the array variable '$validated'
        $request->user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()->back()->with('success', 'Kata laluan berjaya ditukar!');
    }
    
}