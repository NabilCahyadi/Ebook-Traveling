<?php

namespace App\Repositories;

use App\Models\Order;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Carbon\Carbon;

class OrderRepository
{
    /**
     * Get all orders with filters
     */
    public function getAllWithFilters(array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        $query = Order::with(['user', 'orderItems.ebook']);

        // Filter by status
        if (!empty($filters['status']) && $filters['status'] !== 'all') {
            $query->where('status', $filters['status']);
        }

        // Search
        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->whereHas('user', function ($userQuery) use ($search) {
                    $userQuery->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                })
                    ->orWhere('order_number', 'like', "%{$search}%");
            });
        }

        // Date range filter
        if (!empty($filters['date_from'])) {
            $query->whereDate('created_at', '>=', $filters['date_from']);
        }
        if (!empty($filters['date_to'])) {
            $query->whereDate('created_at', '<=', $filters['date_to']);
        }

        return $query->latest()->paginate($perPage);
    }

    /**
     * Find order by ID
     */
    public function findById(int $id): ?Order
    {
        return Order::with(['user', 'orderItems.ebook', 'payment'])->find($id);
    }

    /**
     * Find order by ID or fail
     */
    public function findOrFail(int $id): Order
    {
        return Order::with(['user', 'orderItems.ebook', 'payment'])->findOrFail($id);
    }

    /**
     * Find order by order number
     */
    public function findByOrderNumber(string $orderNumber): ?Order
    {
        return Order::with(['user', 'orderItems.ebook', 'payment'])
            ->where('order_number', $orderNumber)
            ->first();
    }

    /**
     * Create order
     */
    public function create(array $data): Order
    {
        return Order::create($data);
    }

    /**
     * Update order
     */
    public function update(Order $order, array $data): bool
    {
        return $order->update($data);
    }

    /**
     * Delete order
     */
    public function delete(Order $order): bool
    {
        return $order->delete();
    }

    /**
     * Get orders by status
     */
    public function getByStatus(string $status, int $perPage = 15): LengthAwarePaginator
    {
        return Order::with(['user', 'orderItems.ebook'])
            ->where('status', $status)
            ->latest()
            ->paginate($perPage);
    }

    /**
     * Get user orders
     */
    public function getUserOrders(int $userId, int $perPage = 10): LengthAwarePaginator
    {
        return Order::with(['orderItems.ebook', 'payment'])
            ->where('user_id', $userId)
            ->latest()
            ->paginate($perPage);
    }

    /**
     * Get order statistics
     */
    public function getStatistics(array $dateRange = []): array
    {
        $query = Order::query();

        if (!empty($dateRange['from'])) {
            $query->whereDate('created_at', '>=', $dateRange['from']);
        }
        if (!empty($dateRange['to'])) {
            $query->whereDate('created_at', '<=', $dateRange['to']);
        }

        return [
            'total' => (clone $query)->count(),
            'pending' => (clone $query)->where('status', 'pending')->count(),
            'processing' => (clone $query)->where('status', 'processing')->count(),
            'completed' => (clone $query)->where('status', 'completed')->count(),
            'cancelled' => (clone $query)->where('status', 'cancelled')->count(),
            'failed' => (clone $query)->where('status', 'failed')->count(),
            'total_revenue' => (clone $query)->where('status', 'completed')->sum('total_amount'),
        ];
    }

    /**
     * Get recent orders
     */
    public function getRecentOrders(int $limit = 10): Collection
    {
        return Order::with(['user', 'orderItems.ebook'])
            ->latest()
            ->limit($limit)
            ->get();
    }

    /**
     * Get orders for export
     */
    public function getAllForExport(array $filters = []): Collection
    {
        $query = Order::with(['user', 'orderItems.ebook', 'payment']);

        if (!empty($filters['status']) && $filters['status'] !== 'all') {
            $query->where('status', $filters['status']);
        }

        if (!empty($filters['date_from'])) {
            $query->whereDate('created_at', '>=', $filters['date_from']);
        }

        if (!empty($filters['date_to'])) {
            $query->whereDate('created_at', '<=', $filters['date_to']);
        }

        return $query->latest()->get();
    }
}
