<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\PasswordReset;
use App\Models\User;

class PasswordResetController extends Controller
{
    // 1. Show the "Forgot Password" form
    public function requestForm()
    {
        return view('auth.forgot-password');
    }

    // 2. Send the reset link via Email
    public function sendResetLink(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink($request->only('email'));

        if ($status === Password::RESET_LINK_SENT) {
            return back()->with('success', 'Pautan tetapan semula kata laluan telah dihantar ke emel anda.');
        }

        return back()->withErrors(['email' => 'Kami tidak dapat mencari pengguna dengan alamat emel tersebut.']);
    }

    // 3. Show the "Reset Password" form (from the email link)
    public function resetForm(Request $request, $token)
    {
        return view('auth.reset-password', ['token' => $token, 'email' => $request->email]);
    }

    // 4. Actually update the password in the database
    public function updatePassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->save();
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return redirect('/')->with('success', 'Kata laluan anda berjaya ditukar! Sila log masuk.');
        }

        return back()->withErrors(['email' => 'Token tidak sah atau emel tidak sepadan.']);
    }
}