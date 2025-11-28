<?php

namespace App\Repositories;

use App\Models\City;
use App\Repositories\Interfaces\CityRepositoryInterface;

class CityRepository implements CityRepositoryInterface
{
    protected $model;

    public function __construct(City $model)
    {
        $this->model = $model;
    }

    public function all()
    {
        return $this->model->all();
    }

    public function paginate(int $perPage = 15)
    {
        return $this->model->paginate($perPage);
    }

    public function find(string $id)
    {
        return $this->model->findOrFail($id);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update(string $id, array $data)
    {
        $city = $this->find($id);
        $city->update($data);
        return $city;
    }

    public function delete(string $id)
    {
        $city = $this->find($id);
        return $city->delete();
    }

    public function withCount(string $relation)
    {
        return $this->model->withCount($relation);
    }

    public function findByCountry(string $country)
    {
        return $this->model->where('country', $country)->get();
    }
}
