<?php

namespace App\Repositories\Interfaces;
use Illuminate\Support\Collection;

interface CityRepositoryInterface
{
    public function all();

    public function paginate(int $perPage = 15);

    public function find(string $id);

    public function create(array $data);

    public function update(string $id, array $data);

    public function delete(string $id);

    public function withCount(string $relation);

    public function findByCountry(string $country);

    public function getPopularCities(int $limit = 10): Collection;
    public function getAllCities(int $perPage = 15);
    public function findBySlug(string $slug); 
    public function incrementViews(string $id): bool;
}
