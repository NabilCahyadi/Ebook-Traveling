<?php

namespace App\Http\Middleware;

use App\Models\City;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log; // <-- TAMBAHKAN INI
use Illuminate\Support\Facades\DB; // <-- DAN INI

class RecordDestinationView
{
    public function handle(Request $request, Closure $next)
    {
        // Log 1: Middleware dimulai
        Log::info('--- RecordDestinationView Middleware Started ---');

        // Log 2: Cek apakah request adalah untuk halaman detail kota
        if ($request->route('city')) {
            Log::info('Request is for city detail page.');
            $city = $request->route('city');

            // Log 3: Cek apakah objek yang didapatkan dari route adalah instance dari model City
            if ($city instanceof City) {
                Log::info('City object found from route binding: ' . $city->name . ' (ID: ' . $city->id . ')');

                try {
                    // Log 4: Persiapan melakukan update database
                    Log::info('Attempting to increment views_count for city ID: ' . $city->id);

                    // Log 5: Jalankan query update dan cek hasilnya
                    $affected = DB::table('cities')
                        ->where('id', $city->id)
                        ->increment('views_count');

                    Log::info('Update query executed. Affected rows: ' . $affected);

                    if ($affected > 0) {
                        Log::info('SUCCESS: views_count for city "' . $city->name . '" incremented successfully. New count: ' . $city->fresh()->views_count);
                    } else {
                        Log::error('FAILED: No rows were affected by the update query. This is the core problem!');
                        Log::error('SQL Query: ' . DB::table('cities')->where('id', $city->id)->toSql());
                    }
                } catch (\Exception $e) {
                    // Log 6: Tangkap jika ada exception database
                    Log::error('An exception occurred while updating views_count: ' . $e->getMessage());
                    Log::error('Exception Trace: ' . $e->getTraceAsString());
                }
            } else {
                Log::error('Route model binding for "city" is not a valid City instance.');
            }
        } else {
            Log::info('Request is NOT for city detail page. URL: ' . $request->fullUrl());
        }

        // Log 7: Middleware selesai, lanjut ke request berikutnya
        Log::info('--- RecordDestinationView Middleware Finished ---');

        return $next($request);
    }
}
