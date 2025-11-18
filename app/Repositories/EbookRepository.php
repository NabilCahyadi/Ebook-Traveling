<?php

namespace App\Repositories;

use App\Models\Ebook;
use App\Repositories\Interfaces\EbookRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Str;

class EbookRepository implements EbookRepositoryInterface
{
    /**
     * Get all ebooks with pagination.
     */
    public function getAllPaginated(int $perPage = 15): mixed
    {
        return Ebook::with(['category', 'city'])
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
    }

    /**
     * Get all active ebooks.
     */
    public function getActive(): Collection
    {
        return Ebook::with(['category', 'city'])
            ->where('is_active', true)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    /**
     * Find ebook by ID.
     */
    public function findById(int $id): ?Ebook
    {
        return Ebook::with(['category', 'city', 'sections'])->find($id);
    }

    /**
     * Find ebook by slug.
     */
    public function findBySlug(string $slug): ?Ebook
    {
        return Ebook::with(['category', 'city', 'sections'])
            ->where('slug', $slug)
            ->first();
    }

    /**
     * Create a new ebook.
     */
    public function create(array $data): Ebook
    {
        if (!isset($data['slug']) && isset($data['title'])) {
            $data['slug'] = Str::slug($data['title']);
        }

        return Ebook::create($data);
    }

    /**
     * Update ebook.
     */
    public function update(Ebook $ebook, array $data): bool
    {
        if (isset($data['title']) && !isset($data['slug'])) {
            $data['slug'] = Str::slug($data['title']);
        }

        return $ebook->update($data);
    }

    /**
     * Delete ebook.
     */
    public function delete(Ebook $ebook): bool
    {
        return $ebook->delete();
    }

    /**
     * Get ebooks by category.
     */
    public function getByCategory(int $categoryId): Collection
    {
        return Ebook::with(['category', 'city'])
            ->where('category_id', $categoryId)
            ->where('is_active', true)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    /**
     * Get ebooks by city.
     */
    public function getByCity(int $cityId): Collection
    {
        return Ebook::with(['category', 'city'])
            ->where('city_id', $cityId)
            ->where('is_active', true)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    /**
     * Search ebooks.
     */
    public function search(string $query): Collection
    {
        return Ebook::with(['category', 'city'])
            ->where(function($q) use ($query) {
                $q->where('title', 'like', "%{$query}%")
                  ->orWhere('description', 'like', "%{$query}%");
            })
            ->where('is_active', true)
            ->orderBy('created_at', 'desc')
            ->get();
    }
}
