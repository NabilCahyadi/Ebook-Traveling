<?php
//Fungsinya adalah mengelola data paket langganan itu sendiri (nama, harga, fitur),
// termasuk mengambil data untuk ditampilkan di halaman pricing publik.
namespace App\Services\SubscriptionManagement;

use App\Repositories\Interfaces\SubscriptionPlanRepositoryInterface;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use App\models\SubscriptionPlan;

class SubscriptionPlanService
{
    protected $subscriptionPlanRepository;

    public function __construct(SubscriptionPlanRepositoryInterface $subscriptionPlanRepository)
    {
        $this->subscriptionPlanRepository = $subscriptionPlanRepository;
    }

    /**
     * Get all subscription plans
     */
    public function getAllPlans()
    {
        return $this->subscriptionPlanRepository->getAll();
    }

    /**
     * Mengambil beberapa plan aktif untuk ditampilkan di halaman beranda.
     */
    public function getHomepagePlans(int $limit = 3)
    {
        // Gunakan method yang sudah ada dan benar untuk mengambil data aktif
        // lalu ambil sebanyak 'limit' item
        return $this->getActivePlansForDisplay()->take($limit);
    }

    /**
     * Get paginated subscription plans
     */
    public function getPaginatedPlans(int $perPage = 10)
    {
        return $this->subscriptionPlanRepository->getAllPaginated($perPage);
    }

    /**
     * Get paginated subscription plans by category
     */
    public function getPaginatedPlansByCategory(string $category = 'all', int $perPage = 10)
    {
        return $this->subscriptionPlanRepository->getAllPaginatedByCategory($category, $perPage);
    }

    /**
     * Get active subscription plans
     */
    public function getActivePlans()
    {
        return $this->subscriptionPlanRepository->getActive();
    }

    public function getActivePlansForDisplay()
    {
        // Method ini memanggil method yang sudah ada di Repository
        // untuk mengambil data yang sudah diurutkan
        return $this->subscriptionPlanRepository->getAllActivePlans();
    }

    /**
     * Get subscription plan by ID
     */
    public function getPlanById(string $id)
    {
        return $this->subscriptionPlanRepository->getById($id);
    }

    /**
     * Create a new subscription plan
     */
    public function createPlan(array $data)
    {
        // Process data
        $processedData = $this->processData($data);

        return $this->subscriptionPlanRepository->create($processedData);
    }

    /**
     * Update subscription plan
     */
    public function updatePlan(string $id, array $data)
    {
        // Process data
        $processedData = $this->processData($data);

        return $this->subscriptionPlanRepository->update($id, $processedData);
    }

    /**
     * Delete subscription plan (soft delete)
     */
    public function deletePlan(string $id)
    {
        $plan = $this->getPlanById($id);

        if (!$plan) {
            return false;
        }

        return $plan->delete(); // Soft delete
    }


    /**
     * Mengambil semua plan aktif dan mengelompokkannya berdasarkan kategori.
     */
    public function getPlansGroupedByCategory(): Collection
    {
        // 1. Gunakan method getActivePlans() yang sudah ada dan benar
        $plans = $this->getActivePlansForDisplay();

        // 2. Kelompokkan berdasarkan kategori
        $groupedPlans = $plans->groupBy('category_subscription');

        // 3. Urutkan kategori berdasarkan konstanta dari MODEL
        $sortedCategories = array_keys(SubscriptionPlan::CATEGORIES);
        $orderedGroupedPlans = collect();

        foreach ($sortedCategories as $category) {
            if ($groupedPlans->has($category)) {
                $orderedGroupedPlans->put($category, $groupedPlans->get($category));
            }
        }

        // 4. Kembalikan hasilnya
        return $orderedGroupedPlans; // <-- PASTIKAN BARIS INI ADA
    }

    /**
     * Restore subscription plan
     */
    public function restorePlan(string $id)
    {
        $plan = \App\Models\SubscriptionPlan::onlyTrashed()->find($id);

        if (!$plan) {
            return false;
        }

        return $plan->restore();
    }

    /**
     * Permanently delete subscription plan
     */
    public function forceDeletePlan(string $id)
    {
        $plan = \App\Models\SubscriptionPlan::onlyTrashed()->find($id);

        if (!$plan) {
            return false;
        }

        // Check if plan has active subscriptions
        if ($this->subscriptionPlanRepository->hasActiveSubscriptions($id)) {
            throw new \Exception('Cannot permanently delete plan with active subscriptions');
        }

        return $plan->forceDelete();
    }

    /**
     * Get trashed subscription plans
     */
    public function getTrashedPlans(int $perPage = 10)
    {
        return \App\Models\SubscriptionPlan::onlyTrashed()->orderBy('deleted_at', 'desc')->paginate($perPage);
    }

    /**
     * Process input data
     */
    protected function processData(array $data)
    {
        // Generate slug from name
        if (isset($data['name'])) {
            $data['slug'] = Str::slug($data['name']);
        }

        // Convert features from textarea to array
        if (isset($data['features'])) {
            if (is_string($data['features'])) {
                $data['features'] = array_filter(array_map('trim', explode("\n", $data['features'])));
            }
        } else {
            $data['features'] = [];
        }

        return $data;
    }

    /**
     * Format duration for display
     */
    public function formatDuration(int $days)
    {
        if ($days == 30) {
            return '1 Month';
        } elseif ($days == 180) {
            return '6 Months';
        } elseif ($days == 365) {
            return '1 Year';
        }

        return $days . ' Days';
    }
}
