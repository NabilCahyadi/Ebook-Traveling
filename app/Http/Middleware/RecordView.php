<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RecordView
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Cek apakah request adalah untuk detail ebook
        if ($request->route('ebook')) {
            $ebook = $request->route('ebook');
            if ($ebook instanceof Ebook) {
                // Simpan view untuk ebook
                $ebook->views()->create([
                    'ip_address' => $request->ip(),
                    'user_agent' => $request->userAgent(),
                    'viewed_at' => now(),
                ]);
            }
        }

        // Cek apakah request adalah untuk detail kota
        if ($request->route('city')) {
            $city = $request->route('city');
            if ($city instanceof City) {
                // Simpan view untuk kota
                $city->views()->create([
                    'ip_address' => $request->ip(),
                    'user_agent' => $request->userAgent(),
                    'viewed_at' => now(),
                ]);
            }
        }

        return $next($request);
    }
}
