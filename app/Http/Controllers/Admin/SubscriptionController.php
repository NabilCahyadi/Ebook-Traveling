<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subscription;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    /**
     * Display a listing of subscriptions.
     */
    public function index(Request $request)
    {
        $query = Subscription::with(['user', 'subscriptionPlan']);

        // Filter by status
        if ($request->has('status') && $request->status !== 'all') {
            if ($request->status === 'active') {
                $query->where('status', 'active')
                    ->where('end_date', '>', now());
            } elseif ($request->status === 'expired') {
                $query->where('status', 'active')
                    ->where('end_date', '<=', now());
            } else {
                $query->where('status', $request->status);
            }
        }

        // Search
        if ($request->has('search')) {
            $search = $request->search;
            $query->whereHas('user', function ($userQuery) use ($search) {
                $userQuery->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Date range filter
        if ($request->has('date_from')) {
            $query->whereDate('start_date', '>=', $request->date_from);
        }
        if ($request->has('date_to')) {
            $query->whereDate('end_date', '<=', $request->date_to);
        }

        $subscriptions = $query->latest()->paginate(15);

        $statuses = ['all', 'active', 'expired', 'cancelled'];

        return view('admin.subscriptions.index', compact('subscriptions', 'statuses'));
    }

    /**
     * Display the specified subscription.
     */
    public function show($id)
    {
        $subscription = Subscription::with(['user', 'subscriptionPlan', 'payment'])
            ->findOrFail($id);

        return view('admin.subscriptions.show', compact('subscription'));
    }
}
