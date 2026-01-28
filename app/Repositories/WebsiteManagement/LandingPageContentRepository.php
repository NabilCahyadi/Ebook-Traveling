<?php

namespace App\Repositories\WebsiteManagement;

use App\Models\LandingPageContent;
use Illuminate\Database\Eloquent\Collection;

class LandingPageContentRepository
{
    /**
     * Get all landing page content
     */
    public function getAll(): Collection
    {
        return LandingPageContent::orderBy('section', 'asc')->get();
    }

    /**
     * Get by section
     */
    public function getBySection(string $section): Collection
    {
        return LandingPageContent::where('section', $section)
            ->orderBy('order', 'asc')
            ->get();
    }

    /**
     * Find by ID
     */
    public function findById(int $id): ?LandingPageContent
    {
        return LandingPageContent::find($id);
    }

    /**
     * Find by ID or fail
     */
    public function findOrFail(int $id): LandingPageContent
    {
        return LandingPageContent::findOrFail($id);
    }

    /**
     * Find by key
     */
    public function findByKey(string $key): ?LandingPageContent
    {
        return LandingPageContent::where('key', $key)->first();
    }

    /**
     * Create content
     */
    public function create(array $data): LandingPageContent
    {
        return LandingPageContent::create($data);
    }

    /**
     * Update content
     */
    public function update(LandingPageContent $content, array $data): bool
    {
        return $content->update($data);
    }

    /**
     * Update or create by key
     */
    public function updateOrCreateByKey(string $key, array $data): LandingPageContent
    {
        return LandingPageContent::updateOrCreate(
            ['key' => $key],
            $data
        );
    }

    /**
     * Delete content
     */
    public function delete(LandingPageContent $content): bool
    {
        return $content->delete();
    }

    /**
     * Get grouped by section
     */
    public function getAllGroupedBySection(): Collection
    {
        return LandingPageContent::orderBy('section')
            ->orderBy('order')
            ->get()
            ->groupBy('section');
    }
}
