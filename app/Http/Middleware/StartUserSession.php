<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class StartUserSession
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Change session cookie name for user routes before session starts
        $sessionConfig = config('session');
        $sessionConfig['cookie'] = 'meatmap_user_session';
        config(['session' => $sessionConfig]);
        
        return $next($request);
    }
}
