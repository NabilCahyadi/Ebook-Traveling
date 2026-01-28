<?php

namespace App\Services;

use App\Repositories\OrderRepository;
use App\Models\Order;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class OrderService
{
    protected OrderRepository $repository;

    public function __construct(OrderRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Get all orders with filters
     */
    public function getAllOrders(array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        return $this->repository->getAllWithFilters($filters, $perPage);
    }

    /**
     * Find order by ID
     */
    public function findById(int $id): ?Order
    {
        return $this->repository->findById($id);
    }

    /**
     * Find order by ID or fail
     */
    public function findOrFail(int $id): Order
    {
        return $this->repository->findOrFail($id);
    }

    /**
     * Find order by order number
     */
    public function findByOrderNumber(string $orderNumber): ?Order
    {
        return $this->repository->findByOrderNumber($orderNumber);
    }

    /**
     * Update order status
     */
    public function updateStatus(int $id, string $status, ?string $notes = null): bool
    {
        $order = $this->repository->findOrFail($id);
        
        $data = ['status' => $status];
        
        if ($notes !== null) {
            $data['notes'] = $notes;
        }

        return $this->repository->update($order, $data);
    }

    /**
     * Get orders by status
     */
    public function getOrdersByStatus(string $status, int $perPage = 15): LengthAwarePaginator
    {
        return $this->repository->getByStatus($status, $perPage);
    }

    /**
     * Get user orders
     */
    public function getUserOrders(int $userId, int $perPage = 10): LengthAwarePaginator
    {
        return $this->repository->getUserOrders($userId, $perPage);
    }

    /**
     * Get order statistics
     */
    public function getStatistics(array $dateRange = []): array
    {
        return $this->repository->getStatistics($dateRange);
    }

    /**
     * Get recent orders
     */
    public function getRecentOrders(int $limit = 10): Collection
    {
        return $this->repository->getRecentOrders($limit);
    }

    /**
     * Get orders for export
     */
    public function getOrdersForExport(array $filters = []): Collection
    {
        return $this->repository->getAllForExport($filters);
    }

    /**
     * Get available statuses
     */
    public function getAvailableStatuses(): array
    {
        return ['all', 'pending', 'processing', 'completed', 'cancelled', 'failed'];
    }

    /**
     * Cancel order
     */
    public function cancelOrder(int $id, ?string $reason = null): bool
    {
        $order = $this->repository->findOrFail($id);

        if (!in_array($order->status, ['pending', 'processing'])) {
            throw new \Exception('Pesanan tidak dapat dibatalkan karena sudah diproses.');
        }

        return $this->repository->update($order, [
            'status' => 'cancelled',
            'notes' => $reason,
            'cancelled_at' => now(),
        ]);
    }

    /**
     * Complete order
     */
    public function completeOrder(int $id): bool
    {
        $order = $this->repository->findOrFail($id);

        return $this->repository->update($order, [
            'status' => 'completed',
            'completed_at' => now(),
        ]);
    }
}
