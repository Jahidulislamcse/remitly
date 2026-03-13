<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthUser
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check() || Auth::user()->role === 'super admin') {
            return redirect()->route('user.login');
        }

        return $next($request);
    }
}