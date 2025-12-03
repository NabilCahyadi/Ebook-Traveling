<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\SubscriptionPlanService;
use Illuminate\Http\Request;

class SubscriptionPlanController extends Controller
{
    protected $subscriptionPlanService;

    public function __construct(SubscriptionPlanService $subscriptionPlanService)
    {
        $this->subscriptionPlanService = $subscriptionPlanService;
    }

    /**
     * Display a listing of subscription plans.
     */
    public function index()
    {
        $plans = $this->subscriptionPlanService->getPaginatedPlans(5);

        return view('admin.subscription-plans.index', compact('plans'));
    }

    /**
     * Show the form for creating a new subscription plan.
     */
    public function create()
    {
        return view('admin.subscription-plans.create');
    }

    /**
     * Store a newly created subscription plan.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'duration_days' => 'required|integer|min:1',
            'features' => 'nullable|string',
        ]);

        // Set is_active
        $validated['is_active'] = $request->has('is_active');

        try {
            $this->subscriptionPlanService->createPlan($validated);

            return redirect()->route('admin.subscription-plans.index')
                ->with('success', 'Subscription plan created successfully!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to create subscription plan: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified subscription plan.
     */
    public function show(string $id)
    {
        $plan = $this->subscriptionPlanService->getPlanById($id);

        return view('admin.subscription-plans.show', compact('plan'));
    }

    /**
     * Show the form for editing the specified subscription plan.
     */
    public function edit(string $id)
    {
        $plan = $this->subscriptionPlanService->getPlanById($id);

        return view('admin.subscription-plans.edit', compact('plan'));
    }

    /**
     * Update the specified subscription plan.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'duration_days' => 'required|integer|min:1',
            'features' => 'nullable|string',
        ]);

        // Set is_active
        $validated['is_active'] = $request->has('is_active');

        try {
            $this->subscriptionPlanService->updatePlan($id, $validated);

            return redirect()->route('admin.subscription-plans.index')
                ->with('success', 'Subscription plan updated successfully!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to update subscription plan: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified subscription plan.
     */
    public function destroy(string $id)
    {
        try {
            $this->subscriptionPlanService->deletePlan($id);

            return redirect()->route('admin.subscription-plans.index')
                ->with('success', 'Subscription plan deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->route('admin.subscription-plans.index')
                ->with('error', $e->getMessage());
        }
    }
}
