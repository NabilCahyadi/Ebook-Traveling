<?php

namespace App\Services;

use App\Models\SiteSetting;

class SettingService
{
    /**
     * Mendapatkan nilai setting berdasarkan key.
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function get(string $key, $default = null)
    {
        $setting = SiteSetting::where('key', $key)->first();

        // Jika setting ditemukan, kembalikan nilainya
        // Jika tidak, kembalikan nilai default
        return $setting ? $setting->value : $default;
    }

    /**
     * Menambah atau update setting.
     *
     * @param string $key
     * @param mixed $value
     * @return bool
     */
    public function set(string $key, $value): bool
    {
        return SiteSetting::updateOrCreate(
            ['key' => $key],
            ['value' => $value]
        );
    }
}
