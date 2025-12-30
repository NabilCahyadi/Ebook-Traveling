<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\Request;

class SiteSettingController extends Controller
{
    /**
     * Display and edit all site settings in one page.
     */
    public function index()
    {
        $settings = SiteSetting::all()->keyBy('key');
        return view('admin.site-settings.index', compact('settings'));
    }

    /**
     * Update all site settings at once.
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'settings' => 'required|array',
            'settings.*.key' => 'required|string',
            'settings.*.value' => 'nullable|string',
            'settings.*.type' => 'required|string|in:text,email,phone,textarea',
        ], [
            'settings.required' => 'Data settings wajib diisi.',
            'settings.array' => 'Format data settings tidak valid.',
            'settings.*.key.required' => 'Key setting wajib diisi.',
            'settings.*.value.string' => 'Value setting harus berupa teks.',
            'settings.*.type.required' => 'Tipe setting wajib diisi.',
            'settings.*.type.in' => 'Tipe setting tidak valid.',
        ]);

        try {
            foreach ($validated['settings'] as $settingData) {
                SiteSetting::updateOrCreate(
                    ['key' => $settingData['key']],
                    [
                        'value' => $settingData['value'] ?? '',
                        'type' => $settingData['type']
                    ]
                );
            }

            // Clear cache if you're using cache
            // Cache::forget('site_settings');

            return redirect()->route('admin.site-settings.index')
                ->with('success', 'Site settings berhasil diupdate.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal mengupdate site settings: ' . $e->getMessage());
        }
    }

    /**
     * Create a new setting.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'key' => 'required|string|max:100|unique:site_settings,key',
            'value' => 'nullable|string',
            'type' => 'required|string|in:text,email,phone,textarea',
        ], [
            'key.required' => 'Key setting wajib diisi.',
            'key.unique' => 'Key setting sudah ada.',
            'key.max' => 'Key setting maksimal 100 karakter.',
            'type.required' => 'Tipe setting wajib diisi.',
            'type.in' => 'Tipe setting tidak valid.',
        ]);

        try {
            SiteSetting::create($validated);

            return redirect()->route('admin.site-settings.index')
                ->with('success', 'Setting baru berhasil ditambahkan.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal menambahkan setting: ' . $e->getMessage());
        }
    }

    /**
     * Delete a setting.
     */
    public function destroy($id)
    {
        try {
            $setting = SiteSetting::findOrFail($id);
            $setting->delete();

            return redirect()->route('admin.site-settings.index')
                ->with('success', 'Setting berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menghapus setting: ' . $e->getMessage());
        }
    }
}
