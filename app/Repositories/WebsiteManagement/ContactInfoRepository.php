<?php

namespace App\Repositories\WebsiteManagement;

use App\Models\ContactInfo;
use Illuminate\Database\Eloquent\Collection;

class ContactInfoRepository
{
    /**
     * Get all contact info
     */
    public function getAll(): Collection
    {
        return ContactInfo::orderBy('order', 'asc')->get();
    }

    /**
     * Get active contact info
     */
    public function getActive(): Collection
    {
        return ContactInfo::where('is_active', true)
            ->orderBy('order', 'asc')
            ->get();
    }

    /**
     * Find by ID
     */
    public function findById(int $id): ?ContactInfo
    {
        return ContactInfo::find($id);
    }

    /**
     * Find by ID or fail
     */
    public function findOrFail(int $id): ContactInfo
    {
        return ContactInfo::findOrFail($id);
    }

    /**
     * Find by type
     */
    public function findByType(string $type): ?ContactInfo
    {
        return ContactInfo::where('type', $type)->first();
    }

    /**
     * Create contact info
     */
    public function create(array $data): ContactInfo
    {
        return ContactInfo::create($data);
    }

    /**
     * Update contact info
     */
    public function update(ContactInfo $contactInfo, array $data): bool
    {
        return $contactInfo->update($data);
    }

    /**
     * Delete contact info
     */
    public function delete(ContactInfo $contactInfo): bool
    {
        return $contactInfo->delete();
    }

    /**
     * Toggle status
     */
    public function toggleStatus(ContactInfo $contactInfo): bool
    {
        return $contactInfo->update(['is_active' => !$contactInfo->is_active]);
    }

    /**
     * Update or create by type
     */
    public function updateOrCreateByType(string $type, array $data): ContactInfo
    {
        return ContactInfo::updateOrCreate(
            ['type' => $type],
            $data
        );
    }
}
