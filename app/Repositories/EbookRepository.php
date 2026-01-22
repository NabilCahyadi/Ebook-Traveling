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
    public function getAllPaginated(
        int $perPage = 15,
        string $sortBy = 'created_at',
        string $sortOrder = 'desc',
        ?string $search = null,
        ?string $status = null,
        ?string $categoryId = null,
        ?string $cityId = null,
        ?string $statusExclude = null
    ): mixed {
        $query = Ebook::with(['category', 'city', 'creator']);

        // Apply search filter - search in title, description, and creator name
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'LIKE', "%{$search}%")
                    ->orWhere('description', 'LIKE', "%{$search}%")
                    ->orWhereHas('creator', function ($creatorQuery) use ($search) {
                        $creatorQuery->where('name', 'LIKE', "%{$search}%");
                    });
            });
        }

        // Apply status filter
        if ($status) {
            $query->where('status', $status);
        }

        // Exclude specific status (e.g., exclude archived from main index)
        if ($statusExclude) {
            $query->where('status', '!=', $statusExclude);
        }

        // Apply category filter
        if ($categoryId) {
            $query->whereHas('categories', function ($q) use ($categoryId) {
                $q->where('categories.id', $categoryId);
            });
        }

        // Apply city filter
        if ($cityId) {
            if ($cityId === 'null') {
                $query->whereNull('city_id');
            } else {
                $query->where('city_id', $cityId);
            }
        }

        // Priority sorting: draft first, published middle, unpublished last
        return $query->orderByRaw("CASE 
            WHEN status = 'draft' THEN 1 
            WHEN status = 'published' THEN 2 
            WHEN status = 'unpublished' THEN 3 
            ELSE 4 
        END")
        ->orderBy($sortBy, $sortOrder)
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
    public function findById(string $id): ?Ebook
    {
        return Ebook::with(['category', 'city', 'creator'])->find($id);
    }

        /**
         * Find ebook by slug.
         */
        public function findBySlug(string $slug): ?Ebook
        {
            return Ebook::with(['category', 'city', 'creator'])
                ->where('slug', $slug)
                ->first();
        }

    /**
     * Create a new ebook.
     * Slug akan di-generate otomatis oleh Model Ebook dengan unique index
     */
    public function create(array $data): Ebook
    {
        // Hapus slug manual, biarkan model yang handle dengan boot() method
        // untuk memastikan unique slug dengan index
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
    public function getByCategory(string $categoryId): Collection
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
    public function getByCity(string $cityId): Collection
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
            ->where(function ($q) use ($query) {
                $q->where('title', 'like', "%{$query}%")
                    ->orWhere('description', 'like', "%{$query}%");
            })
            ->where('is_active', true)
            ->orderBy('created_at', 'desc')
            ->get();
    }
}
