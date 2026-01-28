<?php

namespace App\Services\WebsiteManagement;

use App\Repositories\WebsiteManagement\PolicyRepository;
use App\Models\Policy;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Str;

class PolicyService
{
    protected PolicyRepository $repository;

    public function __construct(PolicyRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Get all policies
     */
    public function getAllPolicies(): Collection
    {
        return $this->repository->getAll();
    }

    /**
     * Get all policies paginated
     */
    public function getAllPoliciesPaginated(int $perPage = 15): LengthAwarePaginator
    {
        return $this->repository->getAllPaginated($perPage);
    }

    /**
     * Get active policies
     */
    public function getActivePolicies(): Collection
    {
        return $this->repository->getActive();
    }

    /**
     * Find policy by ID
     */
    public function findById(int $id): ?Policy
    {
        return $this->repository->findById($id);
    }

    /**
     * Find policy by ID or fail
     */
    public function findOrFail(int $id): Policy
    {
        return $this->repository->findOrFail($id);
    }

    /**
     * Find policy by slug
     */
    public function findBySlug(string $slug): ?Policy
    {
        return $this->repository->findBySlug($slug);
    }

    /**
     * Find policy by type
     */
    public function findByType(string $type): ?Policy
    {
        return $this->repository->findByType($type);
    }

    /**
     * Create policy
     */
    public function createPolicy(array $data): Policy
    {
        // Generate slug if not provided
        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['title']);
        }

        // Ensure unique slug
        $data['slug'] = $this->generateUniqueSlug($data['slug']);

        return $this->repository->create($data);
    }

    /**
     * Update policy
     */
    public function updatePolicy(int $id, array $data): bool
    {
        $policy = $this->repository->findOrFail($id);

        // Generate slug if title changed
        if (!empty($data['title']) && empty($data['slug'])) {
            $data['slug'] = Str::slug($data['title']);
        }

        // Ensure unique slug if changed
        if (!empty($data['slug']) && $data['slug'] !== $policy->slug) {
            $data['slug'] = $this->generateUniqueSlug($data['slug'], $id);
        }

        return $this->repository->update($policy, $data);
    }

    /**
     * Delete policy
     */
    public function deletePolicy(int $id): bool
    {
        $policy = $this->repository->findOrFail($id);
        return $this->repository->delete($policy);
    }

    /**
     * Toggle policy status
     */
    public function toggleStatus(int $id): bool
    {
        $policy = $this->repository->findOrFail($id);
        return $this->repository->toggleStatus($policy);
    }

    /**
     * Generate unique slug
     */
    protected function generateUniqueSlug(string $slug, ?int $excludeId = null): string
    {
        $originalSlug = $slug;
        $counter = 1;

        while ($this->repository->slugExists($slug, $excludeId)) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }

    /**
     * Get policy types
     */
    public function getPolicyTypes(): array
    {
        return [
            'privacy-policy' => 'Privacy Policy',
            'terms-of-service' => 'Terms of Service',
            'refund-policy' => 'Refund Policy',
            'cookie-policy' => 'Cookie Policy',
            'disclaimer' => 'Disclaimer',
            'other' => 'Other',
        ];
    }
}
