<?php

namespace App\Repositories\WebsiteManagement;

use App\Models\SystemSetting;
use Illuminate\Database\Eloquent\Collection;

class SiteSettingRepository
{
    /**
     * Get all settings
     */
    public function getAll(): Collection
    {
        return SystemSetting::orderBy('group')->orderBy('key')->get();
    }

    /**
     * Get settings by group
     */
    public function getByGroup(string $group): Collection
    {
        return SystemSetting::where('group', $group)->get();
    }

    /**
     * Find by key
     */
    public function findByKey(string $key): ?SystemSetting
    {
        return SystemSetting::where('key', $key)->first();
    }

    /**
     * Get value by key
     */
    public function getValue(string $key, $default = null)
    {
        $setting = $this->findByKey($key);
        return $setting ? $setting->value : $default;
    }

    /**
     * Update or create setting
     */
    public function updateOrCreate(string $key, $value, ?string $group = null): SystemSetting
    {
        return SystemSetting::updateOrCreate(
            ['key' => $key],
            [
                'value' => $value,
                'group' => $group ?? 'general',
            ]
        );
    }

    /**
     * Update setting
     */
    public function update(SystemSetting $setting, array $data): bool
    {
        return $setting->update($data);
    }

    /**
     * Delete setting
     */
    public function delete(SystemSetting $setting): bool
    {
        return $setting->delete();
    }

    /**
     * Get all grouped
     */
    public function getAllGrouped(): Collection
    {
        return SystemSetting::orderBy('key')
            ->get()
            ->groupBy('group');
    }

    /**
     * Bulk update settings
     */
    public function bulkUpdate(array $settings): void
    {
        foreach ($settings as $key => $value) {
            SystemSetting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }
    }
}
