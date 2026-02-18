<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'no_badan' => ['required', 'string'],
            'password' => ['required', 'string'],
            'role' => ['required', 'string'],
        ]);

        // === CHANGED: Added 'true' to force the Remember Me token ===
        if (Auth::attempt($credentials, true)) {
            $request->session()->regenerate();
            
            $user = Auth::user();

            //NEW: Password Reminder Logic
            if (Hash::check($user->no_ic, $user->password)) {
                // Flash a warning to the session so the dashboard can display it
                $request->session()->flash('password_reminder', 'Sila tukar kata laluan anda. Anda masih menggunakan No. Kad Pengenalan sebagai kata laluan lalai.');
            }

            // 3. REDIRECTION LOGIC BASED ON DB ROLE
            switch ($user->role) {
                case 'admin':
                    return redirect()->route('Admin.Dashboard');
                
                case 'penyelia':
                    return redirect()->route('Penyelia.Dashboard');
                
                case 'anggota':
                    return redirect()->route('Users.Dashboard');
                
                default:
                    // Fallback for users without a valid role
                    Auth::logout();
                    return back()->withErrors([
                        'no_badan' => 'Peranan pengguna tidak sah.',
                    ]);
            }
        }
        
        // 4. If login fails
        return back()->withErrors([
            'no_badan' => 'Maklumat log masuk tidak sah.',
        ])->onlyInput('no_badan');
    }
   
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}