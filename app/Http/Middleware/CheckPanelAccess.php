<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPanelAccess
{
    /**
     * Handle an incoming request.
     * Middleware untuk proteksi akses ke panel (user biasa dengan permission dinamis)
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is logged in
        if (!auth()->check()) {
            return redirect()->route('panel.login')
                ->with('error', 'Please login to access the panel.');
        }

        $user = auth()->user();

        // Check if user has panel access (via role permissions)
        if (!$user->hasPermission('panel.access')) {
            abort(403, 'You do not have access to this panel. Please contact administrator.');
        }

        return $next($request);
    }
}
