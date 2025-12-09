<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SystemSettingsController extends Controller
{
    /**
     * Update system setting
     */
    public function update(Request $request)
    {
        $request->validate([
            'key' => 'required|string',
            'value' => 'required|string'
        ]);

        try {
            DB::table('system_settings')
                ->where('key', $request->key)
                ->update([
                    'value' => $request->value,
                    'updated_at' => now()
                ]);

            return response()->json([
                'success' => true,
                'message' => 'Setting updated successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update setting: ' . $e->getMessage()
            ], 500);
        }
    }
}
