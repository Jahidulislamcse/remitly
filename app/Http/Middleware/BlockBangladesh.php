<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Stevebauman\Location\Facades\Location;
use Symfony\Component\HttpFoundation\Response;
use App\Models\GeneralSetting;

class BlockBangladesh
{
    public function handle(Request $request, Closure $next): Response
    {
        $setting = GeneralSetting::first();

        if (!$setting || !$setting->block_bd_vpn) {
            return $next($request);
        }

        $ip = $request->ip();

        $position = Location::get($ip);

        if (!$position || $position->countryCode === 'BD') {
            return response()->view('bdblocked', [], 403);
        }

        $vpnInfo = null;
        try {
            $response = Http::get("http://ip-api.com/json/{$ip}?fields=status,message,isp,org,hosting,proxy");
            if ($response->successful()) {
                $vpnInfo = $response->json();
            }
        } catch (\Exception $e) {
        }

        if (
            $vpnInfo &&
            isset($vpnInfo['hosting']) &&
            ($vpnInfo['hosting'] === true || ($vpnInfo['proxy'] ?? false) === true)
        ) {
            return response()->view('vpnblocked', [], 403);
        }

        return $next($request);
    }
}