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
            ->whereHas('user') // Only get subscriptions with existing users
            ->whereHas('plan') // Only get subscriptions with existing plans
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

        // Get per_page value (multiples of 15: 15, 30, 45, 60)
        $perPage = $request->input('per_page', 15);
        $allowedPerPage = [15, 30, 45, 60];
        if (!in_array((int)$perPage, $allowedPerPage)) {
            $perPage = 15;
        }

        $subscriptions = $query->paginate($perPage);

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
        $query = Subscription::with(['user', 'plan', 'payment'])
            ->orderBy('created_at', 'desc');

        // Apply same filters as index
        if ($request->filled('type')) {
            if ($request->type === 'manual') {
                $query->whereNull('payment_id');
            } elseif ($request->type === 'payment_gateway') {
                $query->whereNotNull('payment_id');
            }
        }

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

        if ($request->filled('start_date')) {
            $query->whereDate('start_date', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->whereDate('start_date', '<=', $request->end_date);
        }

        $subscriptions = $query->get();

        // Generate CSV
        $filename = 'payment_history_' . date('Y-m-d_His') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($subscriptions) {
            $file = fopen('php://output', 'w');
            
            // Add BOM for UTF-8
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            
            // Add header row
            fputcsv($file, [
                'CODE',
                'USER',
                'EMAIL',
                'PLAN',
                'TYPE',
                'PERIOD',
                'STATUS',
                'AMOUNT',
                'START DATE',
                'END DATE',
                'CREATED AT'
            ]);

            // Add data rows
            foreach ($subscriptions as $subscription) {
                $type = $subscription->payment_id ? 'Payment Gateway' : 'Manual';
                
                $status = $subscription->status;
                if ($subscription->status === 'active' && $subscription->end_date < now()) {
                    $status = 'Expired';
                }
                
                $period = '';
                if ($subscription->plan) {
                    $days = $subscription->plan->duration_days;
                    if ($days == 30) {
                        $period = '1 Month';
                    } elseif ($days == 180) {
                        $period = '6 Months';
                    } elseif ($days == 365) {
                        $period = '1 Year';
                    } else {
                        $period = $days . ' Days';
                    }
                }

                fputcsv($file, [
                    $subscription->subscription_code ?? '-',
                    $subscription->user->name ?? '-',
                    $subscription->user->email ?? '-',
                    $subscription->plan->name ?? '-',
                    $type,
                    $period,
                    ucfirst($status),
                    'Rp ' . number_format($subscription->total_amount, 0, ',', '.'),
                    $subscription->start_date ? $subscription->start_date->format('d M Y') : '-',
                    $subscription->end_date ? $subscription->end_date->format('d M Y') : '-',
                    $subscription->created_at->format('d M Y H:i'),
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Print payment receipt as PDF
     */
    public function print($id)
    {
        $subscription = Subscription::with(['user', 'plan', 'payment'])->findOrFail($id);
        
        // Only allow printing for paid subscriptions
        if ($subscription->status !== 'active' || !$subscription->end_date->isFuture()) {
            abort(403, 'Only paid subscriptions can be printed');
        }

        return view('admin.subscription-history.print', compact('subscription'));
    }
}
