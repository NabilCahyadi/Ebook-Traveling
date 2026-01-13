<?php

namespace App\Services;

use App\Repositories\Interfaces\CollectionRepositoryInterface;
use Illuminate\Database\Eloquent\Collection as EloquentCollection; // Alias untuk Eloquent Collection
use Illuminate\Support\Facades\Auth;
use App\Models\Collection as CollectionModel; // Alias untuk Model Collection

class CollectionService
{
    protected $collectionRepository;

    public function __construct(CollectionRepositoryInterface $collectionRepository)
    {
        $this->collectionRepository = $collectionRepository;
    }

    /**
     * Mendapatkan koleksi untuk halaman utama.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getHomepageCollections(): EloquentCollection
    {
        // Ambil collections dari repository
        $collections = $this->collectionRepository->getHomepageCollections();

        // 🔥 TAMBAHKAN INI: Pastikan ebooks terload dengan benar
        foreach ($collections as $collection) {
            // Reload ebooks dengan kondisi yang benar
            $collection->load(['ebooks' => function ($query) {
                $query->where('status', 'published')
                    ->limit(10)
                    ->orderBy('created_at', 'desc');
            }]);
        }

        return $collections;
    }

    /**
     * Mendapatkan satu koleksi berdasarkan slug beserta ebook-nya.
     *
     * @param string $slug
     * @param int $limit
     * @return \App\Models\Collection|null
     */
    public function getCollectionWithEbooks(string $slug, int $limit = 10): ?CollectionModel
    {
        $collection = $this->collectionRepository->findBySlug($slug);

        if (!$collection) {
            return null;
        }

        // Load ebooks with limit dan kondisi published
        $collection->load(['ebooks' => function ($query) use ($limit) {
            $query->where('status', 'published')
                ->limit($limit)
                ->orderBy('created_at', 'desc');
        }]);

        return $collection;
    }

    /**
     * Mendapatkan koleksi untuk halaman utama beserta status berlangganan user.
     *
     * @return array
     */
    public function getHomepageCollectionsWithSubscriptionStatus(): array
    {
        // 1. Ambil koleksi dari repository
        $collections = $this->collectionRepository->getHomepageCollections();

        // 2. Tentukan status berlangganan dengan cara yang lebih bersih
        $isSubscribed = false;
        if (Auth::check()) {
            // Panggil method yang sudah ada di model User
            if (Auth::user()->hasActiveSubscription()) {
                $isSubscribed = true;
            }
        }

        // 3. Kembalikan data dalam bentuk array
        return [
            'collections' => $collections,
            'isSubscribed' => $isSubscribed,
        ];
    }

    /**
     * Muat koleksi dengan ebook-ebook yang diperlukan untuk halaman detail.
     *
     * @param \App\Models\Collection $collection
     * @return \App\Models\Collection
     */
    public function getCollectionDetailWithEbooks(CollectionModel $collection): CollectionModel
    {
        // Di sinilah semua data loading terjadi
        $collection->load(['ebooks' => function ($query) {
            $query->where('status', 'published')
                ->with(['creator', 'ratings']) // Load creator dan ratings
                ->orderBy('created_at', 'desc');
        }]);

        return $collection;
    }

    /**
     * Get all collections with pagination
     */
    public function getAllCollections(int $perPage = 10)
    {
        return $this->collectionRepository->getAllPaginated($perPage);
    }

    /**
     * Get collection by ID
     */
    public function getCollectionById(string $id): ?CollectionModel
    {
        return $this->collectionRepository->findById($id);
    }

    /**
     * Create new collection
     */
    public function createCollection(array $data): CollectionModel
    {
        return $this->collectionRepository->create($data);
    }

    /**
     * Update collection
     */
    public function updateCollection(string $id, array $data): bool
    {
        return $this->collectionRepository->update($id, $data);
    }

    /**
     * Delete collection
     */
    public function deleteCollection(string $id): bool
    {
        return $this->collectionRepository->delete($id);
    }

    /**
     * Attach ebooks to collection
     */
    public function attachEbooksToCollection(string $collectionId, array $ebookIds): void
    {
        $this->collectionRepository->attachEbooks($collectionId, $ebookIds);
    }

    /**
     * Detach ebooks from collection
     */
    public function detachEbooksFromCollection(string $collectionId, array $ebookIds): void
    {
        $this->collectionRepository->detachEbooks($collectionId, $ebookIds);
    }

    /**
     * Sync ebooks in collection
     */
    public function syncEbooksInCollection(string $collectionId, array $ebookIds): void
    {
        $this->collectionRepository->syncEbooks($collectionId, $ebookIds);
    }

    /**
     * Update ebook order in collection
     */
    public function updateEbookOrderInCollection(string $collectionId, array $orders): void
    {
        $this->collectionRepository->updateEbookOrder($collectionId, $orders);
    }
}
