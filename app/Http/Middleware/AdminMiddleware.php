<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please login first.');
        }

        // Check if user has admin access
        $user = Auth::user();
        
        // Check user_type field first (primary method)
        if (isset($user->user_type) && $user->user_type === 'admin') {
            return $next($request);
        }
        
        // Fallback: Check roles relationship (if exists)
        if (method_exists($user, 'roles') && $user->roles()->where('name', 'admin')->exists()) {
            return $next($request);
        }

        // Not authorized
        abort(403, 'Unauthorized access. Admin only.');
    }
}
