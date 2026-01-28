<?php

namespace App\Repositories\WebsiteManagement;

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
                ->with('creator')
                ->whereNotNull('published_at') // Tambahkan ini
                ->limit(10)
                ->orderBy('created_at', 'desc');
        }])
            ->select('collections.*') // Juga select collections
            ->active()
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

    public function getAll(): IlluminateCollection
    {
        return Collection::orderBy('order', 'asc')->get();
    }

    public function getAllPaginated(int $perPage = 10)
    {
        return Collection::withCount('ebooks')
            ->orderBy('order', 'asc')
            ->paginate($perPage);
    }

    public function attachEbooks(string $collectionId, array $ebookIds): void
    {
        $collection = Collection::findOrFail($collectionId);
        $collection->ebooks()->attach($ebookIds);
    }

    public function detachEbooks(string $collectionId, array $ebookIds): void
    {
        $collection = Collection::findOrFail($collectionId);
        $collection->ebooks()->detach($ebookIds);
    }

    public function syncEbooks(string $collectionId, array $ebookIds): void
    {
        $collection = Collection::findOrFail($collectionId);
        $collection->ebooks()->sync($ebookIds);
    }

    public function updateEbookOrder(string $collectionId, array $orders): void
    {
        $collection = Collection::findOrFail($collectionId);
        
        foreach ($orders as $ebookId => $order) {
            $collection->ebooks()->updateExistingPivot($ebookId, ['order_index' => $order]);
        }
    }
}
