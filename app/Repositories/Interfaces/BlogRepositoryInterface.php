<?php

namespace App\Repositories\Interfaces;

interface BlogRepositoryInterface
{
    public function getAll();

    public function getAllPaginated(int $perPage = 10);

    public function getPublished(int $perPage = 10);

    public function getById(string $id);

    public function getBySlug(string $slug);

    public function create(array $data);

    public function update(string $id, array $data);

    public function delete(string $id);

    public function incrementViewCount(string $id);

    public function getLatestPublished(int $limit = 4);
}
