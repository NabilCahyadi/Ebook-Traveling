<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  $permission
     */
    public function handle(Request $request, Closure $next, string $permission): Response
    {
        // Check admin guard first (for admin panel routes)
        if (auth('admin')->check()) {
            $admin = auth('admin')->user();
            
            // Check if admin has permission
            if (!$admin->hasPermission($permission)) {
                abort(403, 'You do not have permission to access this page.');
            }
            
            return $next($request);
        }
        
        // Check regular user guard (for front-end routes)
        $user = $request->user();

        // For guest users (not logged in)
        if (!$user) {
            // Guest doesn't have role in database, deny access to protected routes
            abort(403, 'Please login to access this page.');
        }

        // For logged in users, check permission based on user_type
        $userType = $user->user_type ?? 'member';

        // Admin user type always has access (if they login via user guard)
        if ($userType === 'admin') {
            return $next($request);
        }

        // Get role by user_type
        $role = \App\Models\Role::where('slug', $userType)
            ->with('permissions')
            ->first();

        if (!$role) {
            abort(403, 'Your user role is not configured properly.');
        }

        if (!$role->hasPermission($permission)) {
            abort(403, 'You do not have permission to access this page.');
        }

        return $next($request);
    }
}
