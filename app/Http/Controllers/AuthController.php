<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function showAdminLogin()
    {
        return view('auth.admin.login');

    }

    public function adminLogin(Request $request)
    {
        $request->validate([
            'phone' => 'required',
            'password' => 'required'
        ]);

        $user = \App\Models\User::where('phone', $request->phone)->first();

        if (!$user) {
            return back()->withErrors([
                'phone' => 'Invalid phone or password'
            ]);
        }

        if ($user->role !== 'super admin') {
            return redirect()->route('admin.login')->withErrors([
                'phone' => 'You are not allowed to login here.'
            ]);
        }


        if (Auth::attempt([
            'phone' => $request->phone,
            'password' => $request->password
        ])) {
            $request->session()->regenerate();
            return redirect()->route('super.admin.dashboard');
        }

        return back()->withErrors([
            'phone' => 'Invalid phone or password'
        ]);
    }

    public function userLogin(Request $request)
    {
        $request->validate([
            'phone' => 'required',
            'password' => 'required'
        ]);

        $user = \App\Models\User::where('phone', $request->phone)->first();

        if (!$user) {
            return back()->withErrors([
                'phone' => 'Invalid phone or password'
            ]);
        }

        if ($user->role === 'super admin') {
            return redirect()->route('user.login')->withErrors([
                'phone' => 'You are not allowed to login here.'
            ]);
        }

        if (Auth::attempt([
            'phone' => $request->phone,
            'password' => $request->password
        ])) {
            $request->session()->regenerate();
            return redirect()->route('user.index');
        }

        return back()->withErrors([
            'phone' => 'Invalid phone or password'
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('user.login');
    }

    public function adminLogout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }
}