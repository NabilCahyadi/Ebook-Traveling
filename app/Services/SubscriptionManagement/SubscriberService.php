<?php
// Service ini untuk mengelola data subscriber/pelanggan 
// (misalnya daftar pengguna yang berlangganan). Ini untuk keperluan admin, 
//bukan untuk menampilkan pricing di halaman publik.
namespace App\Services\SubscriptionManagement;

use App\Repositories\Interfaces\SubscriberRepositoryInterface;
use App\Repositories\Interfaces\RoleRepositoryInterface;
use App\Repositories\Interfaces\SubscriptionPlanRepositoryInterface;

class SubscriberService
{
    protected $subscriberRepository;
    protected $roleRepository;
    protected $subscriptionPlanRepository;

    public function __construct(
        SubscriberRepositoryInterface $subscriberRepository,
        RoleRepositoryInterface $roleRepository,
        SubscriptionPlanRepositoryInterface $subscriptionPlanRepository
    ) {
        $this->subscriberRepository = $subscriberRepository;
        $this->roleRepository = $roleRepository;
        $this->subscriptionPlanRepository = $subscriptionPlanRepository;
    }

    /**
     * Get filtered subscribers with pagination
     */
    public function getFilteredSubscribers(array $filters, int $perPage = 15)
    {
        return $this->subscriberRepository->getFilteredSubscribers($filters, $perPage);
    }

    /**
     * Get all roles for filter dropdown
     */
    public function getAllRoles()
    {
        return $this->roleRepository->getAll();
    }

    /**
     * Get all subscription plans for filter dropdown
     */
    public function getAllSubscriptionPlans()
    {
        return $this->subscriptionPlanRepository->getAll();
    }
}
