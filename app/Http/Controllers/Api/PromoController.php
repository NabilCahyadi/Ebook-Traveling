<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\PromoService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PromoController extends Controller
{
    protected $promoService;

    public function __construct(PromoService $promoService)
    {
        $this->promoService = $promoService;
    }

    /**
     * Apply promo code to calculate discount.
     * 
     * POST /api/apply-promo
     * Body: {
     *   "promo_code": "WELCOME50",
     *   "subscription_type": "Premium",
     *   "price": 19.99
     * }
     */
    public function applyPromo(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'promo_code' => 'required|string',
            'subscription_type' => 'required|string',
            'price' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        // Get authenticated user ID
        $userId = auth()->id();

        if (!$userId) {
            return response()->json([
                'success' => false,
                'message' => 'User must be authenticated to use promo'
            ], 401);
        }

        $result = $this->promoService->applyPromo(
            $request->promo_code,
            $userId,
            $request->subscription_type,
            $request->price
        );

        $statusCode = $result['success'] ? 200 : 400;

        return response()->json($result, $statusCode);
    }

    /**
     * Get available promos (public endpoint).
     * 
     * GET /api/promos/available
     */
    public function getAvailablePromos()
    {
        try {
            $promos = \App\Models\Promo::available()
                ->select('id', 'name', 'code', 'description', 'type', 'value', 'end_date')
                ->whereNotNull('code') // Only show promos with codes
                ->get();

            return response()->json([
                'success' => true,
                'data' => $promos
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch available promos'
            ], 500);
        }
    }
}
