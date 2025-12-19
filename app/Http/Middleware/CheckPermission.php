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
        $user = $request->user();

        // For guest users, check Guest role permissions
        if (!$user) {
            $guestRole = \App\Models\Role::where('slug', 'guest')->first();
            
            if (!$guestRole) {
                return $next($request); // Fallback: allow if Guest role not configured
            }

            // Load permissions
            if (!$guestRole->relationLoaded('permissions')) {
                $guestRole->load('permissions');
            }

            if (!$guestRole->hasPermission($permission)) {
                abort(403, 'Guests do not have permission to access this page. Please login.');
            }

            return $next($request);
        }

        // For logged in users, check permission based on user_type
        $userType = $user->user_type ?? 'member';

        // Admin always has access
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
