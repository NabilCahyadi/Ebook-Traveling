<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class StartAdminSession
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Change session cookie name for admin routes before session starts
        $sessionConfig = config('session');
        $sessionConfig['cookie'] = 'meatmap_admin_session';
        config(['session' => $sessionConfig]);
        
        return $next($request);
    }
}
