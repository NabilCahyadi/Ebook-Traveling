<?php

namespace App\Repositories\WebsiteManagement;

use App\Models\AboutUsSection;
use Illuminate\Database\Eloquent\Collection;

class AboutUsSectionRepository
{
    /**
     * Get all about us sections
     */
    public function getAll(): Collection
    {
        return AboutUsSection::orderBy('order', 'asc')->get();
    }

    /**
     * Get active sections
     */
    public function getActive(): Collection
    {
        return AboutUsSection::where('is_active', true)
            ->orderBy('order', 'asc')
            ->get();
    }

    /**
     * Find by section key
     */
    public function findByKey(string $key): ?AboutUsSection
    {
        return AboutUsSection::where('section_key', $key)->first();
    }

    /**
     * Find by section key or fail
     */
    public function findByKeyOrFail(string $key): AboutUsSection
    {
        return AboutUsSection::where('section_key', $key)->firstOrFail();
    }

    /**
     * Create section
     */
    public function create(array $data): AboutUsSection
    {
        return AboutUsSection::create($data);
    }

    /**
     * Update section
     */
    public function update(AboutUsSection $section, array $data): bool
    {
        return $section->update($data);
    }

    /**
     * Update by key
     */
    public function updateByKey(string $key, array $data): bool
    {
        return AboutUsSection::where('section_key', $key)->update($data);
    }

    /**
     * Delete section
     */
    public function delete(AboutUsSection $section): bool
    {
        return $section->delete();
    }

    /**
     * Toggle status
     */
    public function toggleStatus(AboutUsSection $section): bool
    {
        return $section->update(['is_active' => !$section->is_active]);
    }
}
