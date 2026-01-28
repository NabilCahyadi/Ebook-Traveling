<?php

namespace App\Repositories\WebsiteManagement;

use App\Models\Policy;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class PolicyRepository
{
    /**
     * Get all policies
     */
    public function getAll(): Collection
    {
        return Policy::orderBy('order', 'asc')->get();
    }

    /**
     * Get all policies with pagination
     */
    public function getAllPaginated(int $perPage = 15): LengthAwarePaginator
    {
        return Policy::orderBy('order', 'asc')->paginate($perPage);
    }

    /**
     * Get active policies
     */
    public function getActive(): Collection
    {
        return Policy::where('is_active', true)
            ->orderBy('order', 'asc')
            ->get();
    }

    /**
     * Find by ID
     */
    public function findById(int $id): ?Policy
    {
        return Policy::find($id);
    }

    /**
     * Find by ID or fail
     */
    public function findOrFail(int $id): Policy
    {
        return Policy::findOrFail($id);
    }

    /**
     * Find by slug
     */
    public function findBySlug(string $slug): ?Policy
    {
        return Policy::where('slug', $slug)->first();
    }

    /**
     * Find by type
     */
    public function findByType(string $type): ?Policy
    {
        return Policy::where('type', $type)->first();
    }

    /**
     * Create policy
     */
    public function create(array $data): Policy
    {
        return Policy::create($data);
    }

    /**
     * Update policy
     */
    public function update(Policy $policy, array $data): bool
    {
        return $policy->update($data);
    }

    /**
     * Delete policy
     */
    public function delete(Policy $policy): bool
    {
        return $policy->delete();
    }

    /**
     * Toggle status
     */
    public function toggleStatus(Policy $policy): bool
    {
        return $policy->update(['is_active' => !$policy->is_active]);
    }

    /**
     * Check if slug exists
     */
    public function slugExists(string $slug, ?int $excludeId = null): bool
    {
        return Policy::where('slug', $slug)
            ->when($excludeId, fn($q) => $q->where('id', '!=', $excludeId))
            ->exists();
    }
}
