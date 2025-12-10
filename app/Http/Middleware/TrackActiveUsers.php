<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class TrackActiveUsers
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $sessionId = $request->session()->getId();

        // Update or insert the session in the database
        \Illuminate\Support\Facades\DB::table('active_users')->updateOrInsert(
            ['id' => $sessionId],
            ['last_activity' => now()]
        );

        // 2% chance to prune expired sessions
        if (rand(1, 100) <= 2) {
            \Illuminate\Support\Facades\DB::table('active_users')
                ->where('last_activity', '<', now()->subMinutes(5))
                ->delete();
        }

        return $next($request);
    }
}
