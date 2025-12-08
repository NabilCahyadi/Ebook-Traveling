<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class IsPremiumUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Cek apakah user sudah login
        if (!Auth::check()) {
            // Jika belum, arahkan ke halaman login dengan pesan
            return redirect()->route('login')->with('error', 'You must be logged in to access this content.');
        }

        // 2. Cek apakah user memiliki langganan aktif
        // (Saya asumsikan Anda sudah punya method `hasActiveSubscription()` di model User)
        if (!Auth::user()->hasActiveSubscription()) {
            // Jika tidak premium, arahkan ke halaman pricing
            return redirect()->route('pricing')->with('error', 'This content is for premium subscribers only.');
        }

        // 3. Jika semua lolos, lanjutkan request
        return $next($request);
    }
}
