<?php

namespace App\Services\WebsiteManagement;

use App\Repositories\WebsiteManagement\LandingPageContentRepository;
use App\Models\LandingPageContent;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Storage;

class LandingPageContentService
{
    protected LandingPageContentRepository $repository;

    public function __construct(LandingPageContentRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Get all landing page content
     */
    public function getAllContent(): Collection
    {
        return $this->repository->getAll();
    }

    /**
     * Get content by section
     */
    public function getContentBySection(string $section): Collection
    {
        return $this->repository->getBySection($section);
    }

    /**
     * Get all content grouped by section
     */
    public function getAllGroupedBySection(): Collection
    {
        return $this->repository->getAllGroupedBySection();
    }

    /**
     * Find content by ID
     */
    public function findById(int $id): ?LandingPageContent
    {
        return $this->repository->findById($id);
    }

    /**
     * Find content by ID or fail
     */
    public function findOrFail(int $id): LandingPageContent
    {
        return $this->repository->findOrFail($id);
    }

    /**
     * Find content by key
     */
    public function findByKey(string $key): ?LandingPageContent
    {
        return $this->repository->findByKey($key);
    }

    /**
     * Create content
     */
    public function createContent(array $data): LandingPageContent
    {
        // Handle image upload
        if (isset($data['image']) && $data['image']) {
            $data['image'] = $data['image']->store('landing-page', 'public');
        }

        return $this->repository->create($data);
    }

    /**
     * Update content
     */
    public function updateContent(int $id, array $data): bool
    {
        $content = $this->repository->findOrFail($id);

        // Handle image upload
        if (isset($data['image']) && $data['image']) {
            // Delete old image
            if ($content->image) {
                Storage::disk('public')->delete($content->image);
            }
            $data['image'] = $data['image']->store('landing-page', 'public');
        }

        return $this->repository->update($content, $data);
    }

    /**
     * Update or create by key
     */
    public function updateOrCreateByKey(string $key, array $data): LandingPageContent
    {
        $existing = $this->repository->findByKey($key);

        // Handle image upload
        if (isset($data['image']) && $data['image']) {
            if ($existing && $existing->image) {
                Storage::disk('public')->delete($existing->image);
            }
            $data['image'] = $data['image']->store('landing-page', 'public');
        }

        return $this->repository->updateOrCreateByKey($key, $data);
    }

    /**
     * Delete content
     */
    public function deleteContent(int $id): bool
    {
        $content = $this->repository->findOrFail($id);

        // Delete associated image
        if ($content->image) {
            Storage::disk('public')->delete($content->image);
        }

        return $this->repository->delete($content);
    }

    /**
     * Get available sections
     */
    public function getAvailableSections(): array
    {
        return [
            'hero' => 'Hero Section',
            'features' => 'Features Section',
            'about' => 'About Section',
            'cta' => 'Call to Action',
            'testimonials' => 'Testimonials',
            'footer' => 'Footer',
        ];
    }
}
