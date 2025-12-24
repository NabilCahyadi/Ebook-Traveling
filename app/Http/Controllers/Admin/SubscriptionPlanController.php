<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\SubscriptionPlanService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SubscriptionPlanController extends Controller
{
    protected $SubscriptionPlanService;

    public function __construct(SubscriptionPlanService $SubscriptionPlanService)
    {
        $this->SubscriptionPlanService = $SubscriptionPlanService;
    }

    /**
     * Display a listing of subscription plans.
     */
    public function index()
    {
        $plans = $this->SubscriptionPlanService->getPaginatedPlans(5);

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
            'banner_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'name.required' => 'Nama paket berlangganan wajib diisi.',
            'name.max' => 'Nama paket maksimal 255 karakter.',
            'price.required' => 'Harga paket wajib diisi.',
            'price.numeric' => 'Harga harus berupa angka.',
            'price.min' => 'Harga tidak boleh kurang dari 0.',
            'duration_days.required' => 'Durasi berlangganan wajib diisi.',
            'duration_days.integer' => 'Durasi harus berupa angka.',
            'duration_days.min' => 'Durasi minimal 1 hari.',
            'banner_image.image' => 'File harus berupa gambar.',
            'banner_image.mimes' => 'Format gambar harus JPEG, PNG, JPG, atau GIF.',
            'banner_image.max' => 'Ukuran gambar maksimal 2MB.',
        ]);

        // Set is_active
        $validated['is_active'] = $request->has('is_active');

        // Handle banner image upload
        if ($request->hasFile('banner_image')) {
            $image = $request->file('banner_image');
            $filename = 'banner_' . time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('subscription_banners', $filename, 'public');
            $validated['banner_image'] = $path;
        }

        try {
            $this->SubscriptionPlanService->createPlan($validated);

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
        $plan = $this->SubscriptionPlanService->getPlanById($id);

        return view('admin.subscription-plans.show', compact('plan'));
    }

    /**
     * Show the form for editing the specified subscription plan.
     */
    public function edit(string $id)
    {
        $plan = $this->SubscriptionPlanService->getPlanById($id);

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
            'banner_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'name.required' => 'Nama paket berlangganan wajib diisi.',
            'name.max' => 'Nama paket maksimal 255 karakter.',
            'price.required' => 'Harga paket wajib diisi.',
            'price.numeric' => 'Harga harus berupa angka.',
            'price.min' => 'Harga tidak boleh kurang dari 0.',
            'duration_days.required' => 'Durasi berlangganan wajib diisi.',
            'duration_days.integer' => 'Durasi harus berupa angka.',
            'duration_days.min' => 'Durasi minimal 1 hari.',
            'banner_image.image' => 'File harus berupa gambar.',
            'banner_image.mimes' => 'Format gambar harus JPEG, PNG, JPG, atau GIF.',
            'banner_image.max' => 'Ukuran gambar maksimal 2MB.',
        ]);

        // Set is_active
        $validated['is_active'] = $request->has('is_active');

        // Handle banner image upload
        if ($request->hasFile('banner_image')) {
            $plan = $this->SubscriptionPlanService->getPlanById($id);

            // Delete old banner if exists
            if ($plan->banner_image && \Storage::disk('public')->exists($plan->banner_image)) {
                \Storage::disk('public')->delete($plan->banner_image);
            }

            $image = $request->file('banner_image');
            $filename = 'banner_' . time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('subscription_banners', $filename, 'public');
            $validated['banner_image'] = $path;
        }

        try {
            $this->SubscriptionPlanService->updatePlan($id, $validated);

            return redirect()->route('admin.subscription-plans.index')
                ->with('success', 'Subscription plan updated successfully!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to update subscription plan: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified subscription plan (soft delete).
     */
    public function destroy(string $id)
    {
        try {
            $this->SubscriptionPlanService->deletePlan($id);

            return redirect()->route('admin.subscription-plans.index')
                ->with('success', 'Subscription plan moved to trash successfully!');
        } catch (\Exception $e) {
            return redirect()->route('admin.subscription-plans.index')
                ->with('error', $e->getMessage());
        }
    }

    /**
     * Display trashed subscription plans.
     */
    public function trashed()
    {
        try {
            $plans = $this->SubscriptionPlanService->getTrashedPlans(15);
            return view('admin.subscription-plans.trashed', compact('plans'));
        } catch (\Exception $e) {
            return redirect()->route('admin.subscription-plans.index')
                ->with('error', 'Failed to load trashed subscription plans: ' . $e->getMessage());
        }
    }

    /**
     * Restore a soft deleted subscription plan.
     */
    public function restore(string $id)
    {
        try {
            $this->SubscriptionPlanService->restorePlan($id);
            return redirect()->route('admin.subscription-plans.trashed')
                ->with('success', 'Subscription plan restored successfully!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to restore subscription plan: ' . $e->getMessage());
        }
    }

    /**
     * Permanently delete a subscription plan.
     */
    public function forceDelete(string $id)
    {
        try {
            $this->SubscriptionPlanService->forceDeletePlan($id);
            return redirect()->route('admin.subscription-plans.trashed')
                ->with('success', 'Subscription plan permanently deleted!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to permanently delete subscription plan: ' . $e->getMessage());
        }
    }
}
