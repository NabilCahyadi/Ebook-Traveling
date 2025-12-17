<?php

// app/Repositories/Interfaces/PricingBenefitRepositoryInterface.php

namespace App\Repositories\Interfaces;

interface PricingBenefitRepositoryInterface
{
    public function getAllActiveBenefits();
    public function getAll();
    public function findById($id);
    public function create(array $data);
    public function update($id, array $data);
    public function delete($id);
    public function updateOrder(array $benefitOrders);
    public function toggleStatus($id);
}
