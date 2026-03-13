<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class DeviceRestrictionMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();
        
        // ১. লগইন না থাকলে ছেড়ে দাও (লগইন পেজ দেখার জন্য)
        if (!$user) {
            return $next($request);
        }

        // =========================================================
        // ✅ লজিক ১: এডমিন চেকিং (সব ডিভাইসে অনুমতি পাবে)
        // =========================================================
        $role = strtolower(trim($user->role ?? ''));
        
        // is_super 1 হতে পারে বা রোল 'admin'/'super admin' হতে পারে
        if (
            $user->is_super == 1 || 
            $user->is_super === '1' || 
            $role === 'admin' || 
            $role === 'super admin'
        ) {
            return $next($request); // এডমিন হলে সোজা ড্যাশবোর্ডে যাও
        }

        // =========================================================
        // ✅ লজিক ২: সাধারণ ইউজারদের চেকিং
        // =========================================================
        
        $userAgent = $request->header('User-Agent');
        $appHeader = $request->header('X-Requested-With');

        // ক) এন্ড্রয়েড অ্যাপ ইউজার (Android App User)
        // লজিক: এন্ড্রয়েড ডিভাইস হতে হবে + আমাদের অ্যাপের হেডার থাকতে হবে
        if (stripos($userAgent, 'Android') !== false && $appHeader === 'com.webviewgold.myappname') {
            return $next($request); // অ্যাপ ইউজার, যেতে দাও
        }

        // খ) আইফোন ইউজার (iOS User)
        // লজিক: আইফোন হলে ছেড়ে দাও (কারণ master.blade.php এর JS তাদের আটকাবে যদি PWA না হয়)
        if (preg_match('/iPad|iPhone|iPod/', $userAgent)) {
            return $next($request);
        }

        // =========================================================
        // ⛔ লজিক ৩: বাকি সব ব্লক (PC, Mobile Browser, etc.)
        // =========================================================
        
        // এডমিনও না, অ্যাপও না, আইফোনও না -> তারমানে সে ব্রাউজার (পিসি বা এন্ড্রয়েড) দিয়ে এসেছে
        return redirect()->route('app.only');
    }
}