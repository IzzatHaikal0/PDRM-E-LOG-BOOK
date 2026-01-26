<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function authenticate(Request $request)
    {
        /*// 1. Validate the input
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // 2. Attempt to log the user in
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // 3. REDIRECTION LOGIC
            // Get the role from the Database (preferred) OR the Form Input
            $role = Auth::user()->role;
            
            // Or if you strictly want to use the dropdown from the form:
            // $role = $request->input('role'); 

            if ($role === 'staff' || $role === 'officer') {
                return redirect()->route('dashboard'); // Goes to Anggota Dashboard
            }

            if ($role === 'admin') {
                return redirect()->route('Dashboard.Admin'); // Goes to Admin Dashboard
            }

            // Default fallback
            return redirect()->route('dashboard');
        }*/

        //DUMMY ROLE LOGIN: If want real authentication, uncomment above and remove below
        $role = $request->input('role');

        if ($role === 'admin') {
            return redirect()->route('Admin.Dashboard');
        }else if($role === 'anggota'){
            return redirect()->route('Users.Dashboard');// remove this line if using real authentication
        }else{
            return redirect()->route('Penyelia.Dashboard');
        }
       

        // 4. If login fails
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }
}