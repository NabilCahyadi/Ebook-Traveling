<?php

namespace App\Repositories;

use App\Models\Collection;
use App\Repositories\Interfaces\CollectionRepositoryInterface;
use Illuminate\Support\Collection as IlluminateCollection;

class CollectionRepository implements CollectionRepositoryInterface
{
    public function getHomepageCollections(): IlluminateCollection
    {
        return Collection::with(['ebooks' => function ($query) {
            $query->select('ebooks.*') // Select semua kolom ebook
                ->where('status', 'published')
                ->with('creator.user')
                ->whereNotNull('published_at') // Tambahkan ini
                ->limit(10)
                ->orderBy('created_at', 'desc');
        }])
            ->select('collections.*') // Juga select collections
            ->active()
            ->homepage()
            ->ordered()
            ->get();
    }

    public function findById(string $id): ?Collection
    {
        return Collection::with('ebooks')->find($id);
    }

    public function findBySlug(string $slug): ?Collection
    {
        return Collection::with(['ebooks' => function ($query) {
            $query->where('status', 'published');
        }])->where('slug', $slug)->first();
    }

    public function create(array $data): Collection
    {
        return Collection::create($data);
    }

    public function update(string $id, array $data): bool
    {
        $collection = Collection::find($id);
        return $collection ? $collection->update($data) : false;
    }

    public function delete(string $id): bool
    {
        return Collection::destroy($id);
    }
}
