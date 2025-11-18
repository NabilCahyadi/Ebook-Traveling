<?php

namespace App\Repositories\Interfaces;

use App\Models\Ebook;
use Illuminate\Database\Eloquent\Collection;

interface EbookRepositoryInterface
{
    /**
     * Get all ebooks with pagination.
     */
    public function getAllPaginated(int $perPage = 15): mixed;

    /**
     * Get all active ebooks.
     */
    public function getActive(): Collection;

    /**
     * Find ebook by ID.
     */
    public function findById(int $id): ?Ebook;

    /**
     * Find ebook by slug.
     */
    public function findBySlug(string $slug): ?Ebook;

    /**
     * Create a new ebook.
     */
    public function create(array $data): Ebook;

    /**
     * Update ebook.
     */
    public function update(Ebook $ebook, array $data): bool;

    /**
     * Delete ebook.
     */
    public function delete(Ebook $ebook): bool;

    /**
     * Get ebooks by category.
     */
    public function getByCategory(int $categoryId): Collection;

    /**
     * Get ebooks by city.
     */
    public function getByCity(int $cityId): Collection;

    /**
     * Search ebooks.
     */
    public function search(string $query): Collection;
}
