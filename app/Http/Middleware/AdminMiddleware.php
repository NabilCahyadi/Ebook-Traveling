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
     * Check if user has permission to access management panel.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            return redirect()->route('admin.login')->with('error', 'Please login first.');
        }

        $user = Auth::user();

        // Admin always has full access (bypass permission check)
        if (isset($user->user_type) && $user->user_type === 'admin') {
            return $next($request);
        }

        // Check if user has 'panel.access' permission
        if (method_exists($user, 'hasPermission')) {
            if ($user->hasPermission('panel.access')) {
                return $next($request);
            }
        }

        // Fallback: Check roles relationship for admin role
        if (method_exists($user, 'roles') && $user->roles()->where('name', 'admin')->exists()) {
            return $next($request);
        }

        // Not authorized - logout and redirect
        Auth::logout();
        
        return redirect()->route('admin.login')
            ->with('error', 'You do not have permission to access the management panel. Please contact administrator.');
    }
}
