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
    public function index(Request $request)
    {
        $category = $request->get('category', 'all');
        $plans = $this->subscriptionPlanService->getPaginatedPlansByCategory($category, 10);
        $activeCategory = $category;

        return view('admin.subscription-plans.index', compact('plans', 'activeCategory'));
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
        // Validate category and value
        $request->validate([
            'category_subscription' => 'required|in:harian,mingguan,bulanan,tahunan',
            'duration_value' => 'required|integer|min:1',
        ]);

        // Apply category-specific max limits
        $categoryLimits = [
            'harian' => 7,
            'mingguan' => 4,
            'bulanan' => 12,
            'tahunan' => 999,
        ];

        $category = $request->input('category_subscription');
        $maxValue = $categoryLimits[$category];

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'category_subscription' => 'required|in:harian,mingguan,bulanan,tahunan',
            'duration_value' => "required|integer|min:1|max:$maxValue",
            'duration_days' => 'required|integer|min:1',
            'features' => 'nullable|string',
            'button_text' => 'nullable|string|max:100',
            'mayar_payment_link' => 'nullable|url|max:500',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ], [
            'name.required' => 'Nama paket berlangganan wajib diisi.',
            'name.max' => 'Nama paket maksimal 255 karakter.',
            'price.required' => 'Harga paket wajib diisi.',
            'price.numeric' => 'Harga harus berupa angka.',
            'price.min' => 'Harga tidak boleh kurang dari 0.',
            'category_subscription.required' => 'Kategori durasi wajib dipilih.',
            'category_subscription.in' => 'Kategori durasi tidak valid.',
            'duration_value.required' => 'Nilai durasi wajib diisi.',
            'duration_value.integer' => 'Nilai durasi harus berupa angka.',
            'duration_value.min' => 'Nilai durasi minimal 1.',
            'duration_value.max' => "Nilai durasi maksimal $maxValue untuk kategori $category.",
            'duration_days.required' => 'Total hari berlangganan wajib diisi.',
            'duration_days.integer' => 'Total hari harus berupa angka.',
            'duration_days.min' => 'Total hari minimal 1 hari.',
            'button_text.max' => 'Teks button maksimal 100 karakter.',
            'mayar_payment_link.url' => 'Link Mayar harus berupa URL yang valid.',
            'mayar_payment_link.max' => 'Link Mayar maksimal 500 karakter.',
            'cover_image.image' => 'File harus berupa gambar.',
            'cover_image.mimes' => 'Format gambar harus JPEG, PNG, JPG, GIF, atau WEBP.',
            'cover_image.max' => 'Ukuran gambar maksimal 2MB.',
        ]);

        // Set is_active
        $validated['is_active'] = $request->has('is_active');

        // Set features to null (features input removed from create form)
        $validated['features'] = null;

        // Handle banner image upload
        if ($request->hasFile('cover_image')) {
            $image = $request->file('cover_image');
            $filename = 'banner_' . time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('subscription_banners', $filename, 'public');
            $validated['cover_image'] = $path;
        }

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

        // Calculate duration_value from duration_days if category exists
        $durationValue = null;
        if ($plan->category_subscription && $plan->duration_days) {
            $multipliers = [
                'harian' => 1,
                'mingguan' => 7,
                'bulanan' => 30,
                'tahunan' => 365,
            ];
            
            $multiplier = $multipliers[$plan->category_subscription] ?? 1;
            $durationValue = round($plan->duration_days / $multiplier);
        }

        return view('admin.subscription-plans.edit', compact('plan', 'durationValue'));
    }

    /**
     * Update the specified subscription plan.
     */
    public function update(Request $request, string $id)
    {
        // Validate category and value
        $request->validate([
            'category_subscription' => 'required|in:harian,mingguan,bulanan,tahunan',
            'duration_value' => 'required|integer|min:1',
        ]);

        // Apply category-specific max limits
        $categoryLimits = [
            'harian' => 7,
            'mingguan' => 4,
            'bulanan' => 12,
            'tahunan' => 999,
        ];

        $category = $request->input('category_subscription');
        $maxValue = $categoryLimits[$category];

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'category_subscription' => 'required|in:harian,mingguan,bulanan,tahunan',
            'duration_value' => "required|integer|min:1|max:$maxValue",
            'duration_days' => 'required|integer|min:1',
            'features' => 'nullable|string',
            'button_text' => 'nullable|string|max:100',
            'mayar_payment_link' => 'nullable|url|max:500',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ], [
            'name.required' => 'Nama paket berlangganan wajib diisi.',
            'name.max' => 'Nama paket maksimal 255 karakter.',
            'price.required' => 'Harga paket wajib diisi.',
            'price.numeric' => 'Harga harus berupa angka.',
            'price.min' => 'Harga tidak boleh kurang dari 0.',
            'category_subscription.required' => 'Kategori durasi wajib dipilih.',
            'category_subscription.in' => 'Kategori durasi tidak valid.',
            'duration_value.required' => 'Nilai durasi wajib diisi.',
            'duration_value.integer' => 'Nilai durasi harus berupa angka.',
            'duration_value.min' => 'Nilai durasi minimal 1.',
            'duration_value.max' => "Nilai durasi maksimal $maxValue untuk kategori $category.",
            'duration_days.required' => 'Total hari berlangganan wajib diisi.',
            'duration_days.integer' => 'Total hari harus berupa angka.',
            'duration_days.min' => 'Total hari minimal 1 hari.',
            'button_text.max' => 'Teks button maksimal 100 karakter.',
            'mayar_payment_link.url' => 'Link Mayar harus berupa URL yang valid.',
            'mayar_payment_link.max' => 'Link Mayar maksimal 500 karakter.',
            'cover_image.image' => 'File harus berupa gambar.',
            'cover_image.mimes' => 'Format gambar harus JPEG, PNG, JPG, GIF, atau WEBP.',
            'cover_image.max' => 'Ukuran gambar maksimal 2MB.',
        ]);

        // Set is_active
        $validated['is_active'] = $request->has('is_active');

        // Handle banner image upload
        if ($request->hasFile('cover_image')) {
            $plan = $this->subscriptionPlanService->getPlanById($id);

            // Delete old banner if exists
            if ($plan->cover_image && \Storage::disk('public')->exists($plan->cover_image)) {
                \Storage::disk('public')->delete($plan->cover_image);
            }

            $image = $request->file('cover_image');
            $filename = 'banner_' . time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('subscription_banners', $filename, 'public');
            $validated['cover_image'] = $path;
        }

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
     * Remove the specified subscription plan (soft delete).
     */
    public function destroy(string $id)
    {
        try {
            $this->subscriptionPlanService->deletePlan($id);

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
            $plans = $this->subscriptionPlanService->getTrashedPlans(15);
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
            $this->subscriptionPlanService->restorePlan($id);
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
            $this->subscriptionPlanService->forceDeletePlan($id);
            return redirect()->route('admin.subscription-plans.trashed')
                ->with('success', 'Subscription plan permanently deleted!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to permanently delete subscription plan: ' . $e->getMessage());
        }
    }
}
