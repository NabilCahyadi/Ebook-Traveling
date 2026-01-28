<?php

namespace App\Services\WebsiteManagement;

use App\Repositories\WebsiteManagement\AboutUsSectionRepository;
use App\Models\AboutUsSection;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Storage;

class AboutUsSectionService
{
    protected AboutUsSectionRepository $repository;

    public function __construct(AboutUsSectionRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Get all sections
     */
    public function getAllSections(): Collection
    {
        return $this->repository->getAll();
    }

    /**
     * Get active sections
     */
    public function getActiveSections(): Collection
    {
        return $this->repository->getActive();
    }

    /**
     * Find section by key
     */
    public function findByKey(string $key): ?AboutUsSection
    {
        return $this->repository->findByKey($key);
    }

    /**
     * Find section by key or fail
     */
    public function findByKeyOrFail(string $key): AboutUsSection
    {
        return $this->repository->findByKeyOrFail($key);
    }

    /**
     * Update section
     */
    public function updateSection(string $key, array $data): bool
    {
        $section = $this->repository->findByKeyOrFail($key);
        
        // Handle image upload if present
        if (isset($data['image']) && $data['image']) {
            // Delete old image if exists
            if ($section->image) {
                Storage::disk('public')->delete($section->image);
            }
            $data['image'] = $data['image']->store('about-us', 'public');
        }

        return $this->repository->update($section, $data);
    }

    /**
     * Toggle section status
     */
    public function toggleStatus(string $key): bool
    {
        $section = $this->repository->findByKeyOrFail($key);
        return $this->repository->toggleStatus($section);
    }

    /**
     * Delete section image
     */
    public function deleteImage(string $key): bool
    {
        $section = $this->repository->findByKeyOrFail($key);
        
        if ($section->image) {
            Storage::disk('public')->delete($section->image);
            return $this->repository->update($section, ['image' => null]);
        }

        return true;
    }
}
