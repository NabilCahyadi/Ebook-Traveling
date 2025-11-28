<?php

namespace App\Services;

use App\Repositories\Interfaces\CityRepositoryInterface;

class CityService
{
    protected $cityRepository;

    public function __construct(CityRepositoryInterface $cityRepository)
    {
        $this->cityRepository = $cityRepository;
    }

    public function getAllCities(int $perPage = 10)
    {
        return $this->cityRepository->paginate($perPage);
    }

    public function getCityById(string $id)
    {
        return $this->cityRepository->find($id);
    }

    public function createCity(array $data)
    {
        return $this->cityRepository->create($data);
    }

    public function updateCity(string $id, array $data)
    {
        return $this->cityRepository->update($id, $data);
    }

    public function deleteCity(string $id)
    {
        // For now, allow deletion since city-ebook relationship is not implemented yet
        return $this->cityRepository->delete($id);
    }

    public function getCitiesByCountry(string $country)
    {
        return $this->cityRepository->findByCountry($country);
    }
}
