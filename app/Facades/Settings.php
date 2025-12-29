<?php

namespace App;

use Illuminate\Support\Facades\Facade;
use app\Services\SettingService;

class Settings extends Facade
{
    /**
     * Nama accessor untuk kelas layanan (service).
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'app\Services\SettingService';
    }

    /**
     * Shortcut untuk method SettingService::get()
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public static function get(string $key, $default = null)
    {
        return app(SettingService::class)->get($key, $default);
    }

    /**
     * Shortcut untuk method SettingService::set()
     *
     * @param string $key
     * @param mixed $value
     * @return bool
     */
    public static function set(string $key, $value): bool
    {
        return app(SettingService::class)->set($key, $value);
    }
}
