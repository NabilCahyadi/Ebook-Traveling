<?php

namespace App\Repositories\Interfaces;

use Illuminate\Support\Collection;

interface CollectionRepositoryInterface
{
    public function getHomepageCollections(): Collection;
    public function getAll();
    public function getAllPaginated(int $perPage = 10);
    public function findById(string $id);
    public function findBySlug(string $slug);
    public function create(array $data);
    public function update(string $id, array $data);
    public function delete(string $id);
    public function attachEbooks(string $collectionId, array $ebookIds);
    public function detachEbooks(string $collectionId, array $ebookIds);
    public function syncEbooks(string $collectionId, array $ebookIds);
    public function updateEbookOrder(string $collectionId, array $orders);
}
