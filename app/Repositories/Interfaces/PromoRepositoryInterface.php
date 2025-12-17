<?php

namespace App\Repositories\Interfaces;

interface PromoRepositoryInterface
{
    public function getAll();
    public function getAllPaginated(int $perPage = 10);
    public function getById(string $id);
    public function getByCode(string $code);
    public function getAvailablePromos();

    public function findBySlug($slug);
    public function getBySlug($slug);

    public function create(array $data);
    public function update(string $id, array $data);
    public function delete(string $id);
    public function toggleActive(string $id);
    public function incrementUsage(string $id);
    public function checkUserUsage(string $promoId, string $userId);
    public function getPromoWithConditions(string $id);
    public function getPromoByCodeWithConditions(string $code);
}
