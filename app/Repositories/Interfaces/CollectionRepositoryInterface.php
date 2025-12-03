<?php

namespace App\Repositories\Interfaces;

use Illuminate\Support\Collection;

interface CollectionRepositoryInterface
{
    public function getHomepageCollections(): Collection;
    public function findById(string $id);
    public function findBySlug(string $slug);
    public function create(array $data);
    public function update(string $id, array $data);
    public function delete(string $id);
}
