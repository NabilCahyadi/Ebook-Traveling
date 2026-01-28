<?php

namespace App\Services\WebsiteManagement;

use App\Repositories\WebsiteManagement\SiteSettingRepository;
use App\Models\SystemSetting;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;

class SiteSettingService
{
    protected SiteSettingRepository $repository;
    protected string $cacheKey = 'site_settings';
    protected int $cacheTtl = 3600; // 1 hour

    public function __construct(SiteSettingRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Get all settings
     */
    public function getAllSettings(): Collection
    {
        return Cache::remember($this->cacheKey, $this->cacheTtl, function () {
            return $this->repository->getAll();
        });
    }

    /**
     * Get settings by group
     */
    public function getSettingsByGroup(string $group): Collection
    {
        return $this->repository->getByGroup($group);
    }

    /**
     * Get all settings grouped
     */
    public function getAllSettingsGrouped(): Collection
    {
        return $this->repository->getAllGrouped();
    }

    /**
     * Get setting value
     */
    public function getValue(string $key, $default = null)
    {
        return $this->repository->getValue($key, $default);
    }

    /**
     * Update setting
     */
    public function updateSetting(string $key, $value, ?string $group = null): SystemSetting
    {
        $this->clearCache();
        return $this->repository->updateOrCreate($key, $value, $group);
    }

    /**
     * Bulk update settings
     */
    public function bulkUpdateSettings(array $settings): void
    {
        $this->repository->bulkUpdate($settings);
        $this->clearCache();
    }

    /**
     * Delete setting
     */
    public function deleteSetting(string $key): bool
    {
        $setting = $this->repository->findByKey($key);
        
        if ($setting) {
            $this->clearCache();
            return $this->repository->delete($setting);
        }

        return false;
    }

    /**
     * Clear settings cache
     */
    public function clearCache(): void
    {
        Cache::forget($this->cacheKey);
    }

    /**
     * Get setting groups
     */
    public function getSettingGroups(): array
    {
        return [
            'general' => 'General Settings',
            'site' => 'Site Information',
            'seo' => 'SEO Settings',
            'social' => 'Social Media',
            'email' => 'Email Settings',
            'payment' => 'Payment Settings',
            'appearance' => 'Appearance',
        ];
    }

    /**
     * Get site name
     */
    public function getSiteName(): string
    {
        return $this->getValue('site_name', config('app.name'));
    }

    /**
     * Get site logo
     */
    public function getSiteLogo(): ?string
    {
        return $this->getValue('site_logo');
    }

    /**
     * Get site favicon
     */
    public function getSiteFavicon(): ?string
    {
        return $this->getValue('site_favicon');
    }
}
