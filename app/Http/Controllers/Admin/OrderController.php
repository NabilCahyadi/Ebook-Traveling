<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\OrderService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    protected OrderService $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    /**
     * Display a listing of orders.
     */
    public function index(Request $request)
    {
        $filters = [
            'status' => $request->get('status'),
            'search' => $request->get('search'),
            'date_from' => $request->get('date_from'),
            'date_to' => $request->get('date_to'),
        ];

        $orders = $this->orderService->getAllOrders($filters, 15);
        $statuses = $this->orderService->getAvailableStatuses();

        return view('admin.orders.index', compact('orders', 'statuses'));
    }

    /**
     * Display the specified order.
     */
    public function show($id)
    {
        $order = $this->orderService->findOrFail($id);

        return view('admin.orders.show', compact('order'));
    }

    /**
     * Update order status.
     */
    public function updateStatus(Request $request, $id)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,processing,completed,cancelled,failed',
            'notes' => 'nullable|string|max:500'
        ]);

        $this->orderService->updateStatus($id, $validated['status'], $validated['notes'] ?? null);

        return redirect()->back()->with('success', 'Order status updated successfully.');
    }
}
