<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    /**
     * Handle an incoming request.
     * Only allows access if the user is authenticated AND has is_admin = true.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check() || !Auth::user()->is_admin) {
            // Redirect non-admin users to home page with an error
            return redirect('/')->with('error', 'Access denied. Admin only area.');
        }

        return $next($request);
    }
}
