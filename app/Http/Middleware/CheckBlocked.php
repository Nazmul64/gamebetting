<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckBlocked
{
    /**
     * Handle an incoming request.
     * If user is blocked, redirect them to a blocked notice page.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && Auth::user()->is_blocked) {
            if (!$request->routeIs('logout') && !$request->routeIs('blocked') && !$request->routeIs('blocked.checkin')) {
                // Return json if it's an AJAX request
                if ($request->expectsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Account is blocked. Please contact support.'
                    ], 403);
                }
                return redirect()->route('blocked');
            }
        }

        return $next($request);
    }
}
