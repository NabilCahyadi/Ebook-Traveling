<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PromoRequest;
use App\Services\PromoService;
use Illuminate\Http\Request;

class PromoController extends Controller
{
    protected $promoService;

    public function __construct(PromoService $promoService)
    {
        $this->promoService = $promoService;
    }

    /**
     * Display a listing of promos.
     */
    public function index(Request $request)
    {
        $promos = $this->promoService->getAllPromos($request->get('per_page', 15));

        return view('admin.promos.index', compact('promos'));
    }

    /**
     * Show the form for creating a new promo.
     */
    public function create()
    {
        $subscriptionPlans = \App\Models\SubscriptionPlan::where('is_active', true)
            ->orderBy('name')
            ->get();

        return view('admin.promos.create', compact('subscriptionPlans'));
    }

    /**
     * Store a newly created promo in storage.
     */
    public function store(PromoRequest $request)
    {
        try {
            $this->promoService->createPromo($request->validated());

            return redirect()
                ->route('admin.promos.index')
                ->with('success', 'Promo created successfully');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Failed to create promo: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified promo.
     */
    public function edit($id)
    {
        $promo = $this->promoService->getPromoById($id);
        $subscriptionPlans = \App\Models\SubscriptionPlan::where('is_active', true)
            ->orderBy('name')
            ->get();

        return view('admin.promos.edit', compact('promo', 'subscriptionPlans'));
    }

    /**
     * Update the specified promo in storage.
     */
    public function update(PromoRequest $request, string $id)
    {
        try {
            $this->promoService->updatePromo($id, $request->validated());

            return redirect()
                ->route('admin.promos.index')
                ->with('success', 'Promo updated successfully');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Failed to update promo: ' . $e->getMessage());
        }
    }

    /**
     * Toggle promo active status.
     */
    public function toggleActive(string $id)
    {
        try {
            $promo = $this->promoService->toggleActive($id);

            return response()->json([
                'success' => true,
                'message' => 'Promo status updated',
                'is_active' => $promo->is_active
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update status: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified promo from storage.
     */
    public function destroy(string $id)
    {
        try {
            $this->promoService->deletePromo($id);

            return redirect()
                ->route('admin.promos.index')
                ->with('success', 'Promo deleted successfully');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Failed to delete promo: ' . $e->getMessage());
        }
    }
}
