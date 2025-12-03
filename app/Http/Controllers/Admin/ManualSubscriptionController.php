<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\SubscriptionService;
use App\Services\MayarService;
use Illuminate\Http\Request;

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
     * Display a listing of subscriptions
     */
    public function index(Request $request)
    {
        $search = $request->get('search');

        if ($search) {
            $subscriptions = $this->subscriptionService->searchSubscriptions($search, 5);
        } else {
            $subscriptions = $this->subscriptionService->getAllSubscriptions(5);
        }

        return view('admin.manual-subscriptions.index', compact('subscriptions', 'search'));
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
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'subscription_plan_id' => 'required|exists:subscription_plans,id',
        ]);

        try {
            // Check if user already has active subscription
            $existingSubscription = $this->subscriptionService->getUserActiveSubscription($validated['user_id']);

            if ($existingSubscription) {
                return back()
                    ->withInput()
                    ->with('error', 'User already has an active subscription. Please cancel or wait for it to expire first.');
            }

            $this->subscriptionService->createManualSubscription($validated);

            return redirect()->route('admin.manual-subscriptions.index')
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

            return view('admin.manual-subscriptions.extend', compact('subscription'));
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
            'days' => 'required|integer|min:1|max:365',
        ]);

        try {
            $this->subscriptionService->extendSubscription($id, $validated['days']);

            return redirect()->route('admin.manual-subscriptions.show', $id)
                ->with('success', 'Subscription extended successfully for ' . $validated['days'] . ' days!');
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
}
