<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckAdminPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  $permission  The permission name to check
     */
    public function handle(Request $request, Closure $next, string $permission): Response
    {
        // Check if admin is authenticated
        if (!auth('admin')->check()) {
            abort(403, 'Anda harus login sebagai admin.');
        }

        $admin = auth('admin')->user();

        // Superadmin has all permissions
        if ($admin->isSuperAdmin()) {
            return $next($request);
        }

        // Check if admin has the required permission
        if (!$admin->hasPermission($permission)) {
            abort(403, 'Anda tidak memiliki permission untuk mengakses halaman ini.');
        }

        return $next($request);
    }
}
