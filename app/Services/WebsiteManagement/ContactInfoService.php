<?php

namespace App\Services\WebsiteManagement;

use App\Repositories\WebsiteManagement\ContactInfoRepository;
use App\Models\ContactInfo;
use Illuminate\Database\Eloquent\Collection;

class ContactInfoService
{
    protected ContactInfoRepository $repository;

    public function __construct(ContactInfoRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Get all contact info
     */
    public function getAllContactInfo(): Collection
    {
        return $this->repository->getAll();
    }

    /**
     * Get active contact info
     */
    public function getActiveContactInfo(): Collection
    {
        return $this->repository->getActive();
    }

    /**
     * Find contact info by ID
     */
    public function findById(int $id): ?ContactInfo
    {
        return $this->repository->findById($id);
    }

    /**
     * Find contact info by ID or fail
     */
    public function findOrFail(int $id): ContactInfo
    {
        return $this->repository->findOrFail($id);
    }

    /**
     * Create contact info
     */
    public function createContactInfo(array $data): ContactInfo
    {
        return $this->repository->create($data);
    }

    /**
     * Update contact info
     */
    public function updateContactInfo(int $id, array $data): bool
    {
        $contactInfo = $this->repository->findOrFail($id);
        return $this->repository->update($contactInfo, $data);
    }

    /**
     * Delete contact info
     */
    public function deleteContactInfo(int $id): bool
    {
        $contactInfo = $this->repository->findOrFail($id);
        return $this->repository->delete($contactInfo);
    }

    /**
     * Toggle contact info status
     */
    public function toggleStatus(int $id): bool
    {
        $contactInfo = $this->repository->findOrFail($id);
        return $this->repository->toggleStatus($contactInfo);
    }

    /**
     * Update or create by type
     */
    public function updateOrCreateByType(string $type, array $data): ContactInfo
    {
        return $this->repository->updateOrCreateByType($type, $data);
    }

    /**
     * Get contact info types
     */
    public function getContactTypes(): array
    {
        return [
            'email' => 'Email',
            'phone' => 'Phone',
            'whatsapp' => 'WhatsApp',
            'address' => 'Address',
            'facebook' => 'Facebook',
            'instagram' => 'Instagram',
            'twitter' => 'Twitter',
            'youtube' => 'YouTube',
            'linkedin' => 'LinkedIn',
        ];
    }
}
