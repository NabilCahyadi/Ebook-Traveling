<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\SubscriptionService;
use App\Services\MayarService;
use App\Exports\SubscriptionsExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ManualSubscriptionController extends Controller
{
    protected $subscriptionService;
    protected $mayarService;

    public function __construct(
        SubscriptionService $subscriptionService,
        MayarService $mayarService
    ) {
        $this->subscriptionService = $subscriptionService;
        $this->mayarService = $mayarService;
    }

    /**
     * Redirect to create form (default page for manual subscriptions)
     */
    public function index()
    {
        return redirect()->route('admin.manual-subscriptions.create');
    }

    /**
     * Show the form for creating a new subscription
     */
    public function create()
    {
        $plans = $this->subscriptionService->getActivePlans();
        $users = $this->subscriptionService->getAllUsers();

        return view('admin.manual-subscriptions.create', compact('plans', 'users'));
    }

    /**
     * Store a newly created subscription
     * 
     * Logic:
     * - If user has active subscription with SAME category_subscription: extend/accumulate
     * - If user has active subscription with DIFFERENT category_subscription: replace (extend will handle this)
     * - If no active subscription: create new one
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'subscription_plan_id' => 'required|exists:subscription_plans,id',
            'quantity' => 'required|integer|min:1|max:12',
        ]);

        try {
            // Check if user already has active subscription
            $existingSubscription = $this->subscriptionService->getUserActiveSubscription($validated['user_id']);

            if ($existingSubscription) {
                // User has active subscription - use extend logic which handles category comparison
                $this->subscriptionService->extendSubscriptionByPlan(
                    $existingSubscription->id,
                    $validated['subscription_plan_id'],
                    $validated['quantity']
                );

                // Get plans to check if category is same or different for message
                $existingPlan = $existingSubscription->plan;
                $newPlan = \App\Models\SubscriptionPlan::find($validated['subscription_plan_id']);
                
                $isSameCategory = $existingPlan && $newPlan && 
                    $existingPlan->category_subscription === $newPlan->category_subscription;

                if ($isSameCategory) {
                    return redirect()->route('admin.manual-subscriptions.create')
                        ->with('success', 'Subscription extended successfully! New duration added to existing subscription (same category: ' . ucfirst($newPlan->category_subscription) . ').');
                } else {
                    return redirect()->route('admin.manual-subscriptions.create')
                        ->with('success', 'Subscription replaced successfully! Old subscription replaced with new plan (different category: ' . ucfirst($existingPlan->category_subscription ?? 'N/A') . ' → ' . ucfirst($newPlan->category_subscription) . ').');
                }
            }

            // No existing subscription - create new one
            $this->subscriptionService->createManualSubscription($validated);

            return redirect()->route('admin.manual-subscriptions.create')
                ->with('success', 'Manual subscription created successfully!');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified subscription
     */
    public function show(string $id)
    {
        try {
            $subscription = $this->subscriptionService->getSubscriptionById($id);

            if (!$subscription) {
                return redirect()->route('admin.manual-subscriptions.index')
                    ->with('error', 'Subscription not found.');
            }

            return view('admin.manual-subscriptions.show', compact('subscription'));
        } catch (\Exception $e) {
            return redirect()->route('admin.manual-subscriptions.index')
                ->with('error', $e->getMessage());
        }
    }

    /**
     * Show the form for extending subscription
     */
    public function extend(string $id)
    {
        try {
            $subscription = $this->subscriptionService->getSubscriptionById($id);

            if (!$subscription) {
                return redirect()->route('admin.manual-subscriptions.index')
                    ->with('error', 'Subscription not found.');
            }

            $plans = $this->subscriptionService->getActivePlans();
            return view('admin.manual-subscriptions.extend', compact('subscription', 'plans'));
        } catch (\Exception $e) {
            return redirect()->route('admin.manual-subscriptions.index')
                ->with('error', $e->getMessage());
        }
    }

    /**
     * Process subscription extension
     */
    public function processExtend(Request $request, string $id)
    {
        $validated = $request->validate([
            'subscription_plan_id' => 'required|exists:subscription_plans,id',
            'quantity' => 'required|integer|min:1|max:12',
        ]);

        try {
            $this->subscriptionService->extendSubscriptionByPlan($id, $validated['subscription_plan_id'], $validated['quantity']);

            return redirect()->route('admin.manual-subscriptions.show', $id)
                ->with('success', 'Subscription extended successfully!');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }

    /**
     * Cancel subscription
     */
    public function cancel(string $id)
    {
        try {
            $this->subscriptionService->cancelSubscription($id);

            return redirect()->route('admin.manual-subscriptions.index')
                ->with('success', 'Subscription cancelled successfully!');
        } catch (\Exception $e) {
            return back()
                ->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified subscription
     */
    public function destroy(string $id)
    {
        try {
            $this->subscriptionService->deleteSubscription($id);

            return redirect()->route('admin.manual-subscriptions.index')
                ->with('success', 'Subscription deleted successfully!');
        } catch (\Exception $e) {
            return back()
                ->with('error', $e->getMessage());
        }
    }

    /**
     * Show payment link generation form
     */
    public function showPaymentLinkForm()
    {
        $plans = $this->subscriptionService->getActivePlans();
        $users = $this->subscriptionService->getAllUsers();

        return view('admin.manual-subscriptions.payment-link', compact('plans', 'users'));
    }

    /**
     * Generate payment link
     */
    public function generatePaymentLink(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'plan_id' => 'required|exists:subscription_plans,id',
            'notes' => 'nullable|string|max:500',
        ]);

        try {
            // Check if user already has active subscription
            $existingSubscription = $this->subscriptionService->getUserActiveSubscription($validated['user_id']);

            if ($existingSubscription) {
                return back()
                    ->withInput()
                    ->with('error', 'User already has an active subscription. Please cancel or wait for it to expire first.');
            }

            // Get user and plan
            $user = \App\Models\User::findOrFail($validated['user_id']);
            $plan = \App\Models\SubscriptionPlan::findOrFail($validated['plan_id']);

            // Generate payment link via Mayar
            $paymentLink = $this->mayarService->generatePaymentLink(
                $user,
                $plan,
                $validated['notes'] ?? null
            );

            return redirect()->route('admin.manual-subscriptions.payment-link.show', $paymentLink->id)
                ->with('success', 'Payment link generated successfully!');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Failed to generate payment link: ' . $e->getMessage());
        }
    }

    /**
     * Show payment link details
     */
    public function showPaymentLink(string $id)
    {
        try {
            $paymentLink = \App\Models\PaymentLink::with(['user', 'plan'])->findOrFail($id);

            return view('admin.manual-subscriptions.payment-link-detail', compact('paymentLink'));
        } catch (\Exception $e) {
            return redirect()->route('admin.manual-subscriptions.index')
                ->with('error', 'Payment link not found.');
        }
    }

    /**
     * List all payment links
     */
    public function paymentLinks(Request $request)
    {
        $search = $request->get('search');

        $query = \App\Models\PaymentLink::with(['user', 'plan']);

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('invoice_number', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($q2) use ($search) {
                        $q2->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    });
            });
        }

        $paymentLinks = $query->orderBy('created_at', 'desc')->paginate(15);

        return view('admin.manual-subscriptions.payment-links-list', compact('paymentLinks', 'search'));
    }

    /**
     * Search users for autocomplete (AJAX)
     * Filter out admin users
     */
    public function searchUsers(Request $request)
    {
        $search = $request->get('q', '');

        if (strlen($search) < 2) {
            return response()->json([]);
        }

        // Get admin role IDs
        $adminRoleIds = \App\Models\Role::where('name', 'admin')
            ->orWhere('name', 'super_admin')
            ->pluck('id');

        // Get user IDs that have admin role
        $adminUserIds = \App\Models\UserRole::whereIn('role_id', $adminRoleIds)
            ->pluck('user_id');

        // Search users excluding admins
        $users = \App\Models\User::where(function ($query) use ($search) {
            $query->where('name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%");
        })
            ->whereNotIn('id', $adminUserIds)
            ->limit(10)
            ->get(['id', 'name', 'email']);

        return response()->json($users);
    }

    /**
     * Export subscriptions to Excel.
     */
    public function export(Request $request)
    {
        $filters = [
            'search' => $request->get('search'),
            'status' => $request->get('status'),
            'subscription_type' => $request->get('subscription_type'),
            'date_from' => $request->get('date_from'),
            'date_to' => $request->get('date_to'),
        ];

        $filename = 'subscriptions_' . now()->format('Y-m-d_His') . '.xlsx';
        
        return Excel::download(new SubscriptionsExport($filters), $filename);
    }
}
