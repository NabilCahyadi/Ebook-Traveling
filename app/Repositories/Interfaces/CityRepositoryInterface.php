<?php

namespace App\Repositories\Interfaces;

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
}
