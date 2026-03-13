<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Throwable;

class TrackUserVisit
{
    public function handle(Request $request, Closure $next)
    {
        try {
            if (
                $request->path() === 'up' ||
                $request->is('storage/*') ||
                $request->is('build/*')
            ) {
                return $next($request);
            }

            if ($request->isMethod('get')) {

                $visitorId = auth()->id() ?? $request->ip();

                $cacheKey = 'visit_30min_' . md5($visitorId);

                if (! Cache::has($cacheKey)) {

                    Cache::put($cacheKey, true, now()->addMinutes(30));

                    DB::table('user_visits')->insert([
                        'user_id'    => auth()->id(),
                        'ip'         => $request->ip(),
                        'created_at' => now()->addHours(6), 
                        'updated_at' => now()->addHours(6), 
                    ]);
                }
            }

        } catch (Throwable $e) {
            report($e);
        }

        return $next($request);
    }
}