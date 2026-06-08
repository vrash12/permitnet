<?php

namespace App\Http\Controllers;

use App\Models\AdminUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $admin = AdminUser::where('email', $request->email)
            ->where('is_active', true)
            ->first();

        if (! $admin || ! Hash::check($request->password, $admin->password)) {
            return back()->with('error', 'Invalid email or password.');
        }

        session([
            'admin_id' => $admin->id,
            'admin_name' => $admin->name,
            'admin_email' => $admin->email,
            'admin_role' => $admin->role,
            'is_logged_in' => true,
        ]);

        return redirect()->route('dashboard');
    }

    public function logout()
    {
        session()->flush();

        return redirect()->route('login')->with('success', 'Logged out successfully.');
    }
}