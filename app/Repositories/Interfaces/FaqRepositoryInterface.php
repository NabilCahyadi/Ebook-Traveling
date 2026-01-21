<?php

// app/Repositories/Interfaces/FaqRepositoryInterface.php

namespace App\Repositories\Interfaces;

interface FaqRepositoryInterface
{
    public function getActiveByCategory(string $category);
    public function getAllByCategory(string $category, $perPage = 10);
    public function findById(string $id);
    public function create(array $data);
    public function update(string $id, array $data);
    public function delete(string $id);
    public function toggleStatus(string $id);
    public function updateOrder(array $orders);
    public function bulkDelete(array $ids);
}
