<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of orders.
     */
    public function index(Request $request)
    {
        $query = Order::with(['user', 'orderItems.ebook']);

        // Filter by status
        if ($request->has('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        // Search
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereHas('user', function ($userQuery) use ($search) {
                    $userQuery->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                })
                    ->orWhere('order_number', 'like', "%{$search}%");
            });
        }

        // Date range filter
        if ($request->has('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->has('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $orders = $query->latest()->paginate(15);

        $statuses = ['all', 'pending', 'processing', 'completed', 'cancelled', 'failed'];

        return view('admin.orders.index', compact('orders', 'statuses'));
    }

    /**
     * Display the specified order.
     */
    public function show($id)
    {
        $order = Order::with(['user', 'orderItems.ebook', 'payment'])->findOrFail($id);

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

        $order = Order::findOrFail($id);
        $order->status = $validated['status'];

        if (isset($validated['notes'])) {
            $order->notes = $validated['notes'];
        }

        $order->save();

        return redirect()->back()->with('success', 'Order status updated successfully.');
    }
}
