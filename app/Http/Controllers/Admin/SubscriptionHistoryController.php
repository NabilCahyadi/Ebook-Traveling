<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subscription;
use Illuminate\Http\Request;

class SubscriptionHistoryController extends Controller
{
    /**
     * Display payment history with filtering
     */
    public function index(Request $request)
    {
        $query = Subscription::with(['user', 'plan', 'payment'])
            ->orderBy('created_at', 'desc');

        // Filter by type (manual or payment_gateway)
        if ($request->filled('type')) {
            if ($request->type === 'manual') {
                $query->whereNull('payment_id');
            } elseif ($request->type === 'payment_gateway') {
                $query->whereNotNull('payment_id');
            }
        }

        // Filter by status (paid, failed, expired, cancelled, pending)
        if ($request->filled('status')) {
            if ($request->status === 'paid') {
                $query->where('status', 'active');
            } elseif ($request->status === 'expired') {
                $query->where('status', 'active')
                    ->where('end_date', '<', now());
            } else {
                $query->where('status', $request->status);
            }
        }

        // Search by user name, email, or subscription code
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('subscription_code', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($userQuery) use ($search) {
                        $userQuery->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    });
            });
        }

        // Filter by date range
        if ($request->filled('start_date')) {
            $query->whereDate('start_date', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->whereDate('start_date', '<=', $request->end_date);
        }

        $subscriptions = $query->paginate(15);

        // Calculate statistics
        $stats = [
            'total' => Subscription::count(),
            'manual' => Subscription::whereNull('payment_id')->count(),
            'payment_gateway' => Subscription::whereNotNull('payment_id')->count(),
            'active' => Subscription::where('status', 'active')->count(),
            'total_revenue' => Subscription::sum('total_amount'),
        ];

        return view('admin.subscription-history.index', compact('subscriptions', 'stats'));
    }

    /**
     * Display the specified subscription detail
     */
    public function show(string $id)
    {
        $subscription = Subscription::with(['user', 'plan', 'payment'])
            ->findOrFail($id);

        return view('admin.subscription-history.show', compact('subscription'));
    }

    /**
     * Export subscription history
     */
    public function export(Request $request)
    {
        // This can be implemented later for CSV/Excel export
        // For now, return back with message
        return back()->with('info', 'Export feature will be available soon.');
    }
}
