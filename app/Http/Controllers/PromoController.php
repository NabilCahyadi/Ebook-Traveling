<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\PromoService;
use App\Models\Promo;

class PromoController extends Controller
{
    protected $promoService;

    public function __construct(PromoService $promoService)
    {
        $this->promoService = $promoService;
    }

    public function index()
    {
        $promos = $this->promoService->getActivePromosForDisplay();
        return view('promo', compact('promos'));
    }

    public function showDetail($slug)
    {
        try {
            $promo = $this->promoService->getPromoBySlug($slug);

            if (!$promo) {
                return redirect()->route('promo')->with('error', 'Promo tidak ditemukan');
            }

            return view('components.promos.detail', compact('promo'));
        } catch (\Exception $e) {
            return redirect()->route('promo')->with('error', 'Terjadi kesalahan saat memuat detail promo');
        }
    }

    public function show(Promo $promo)
    {
        return view('components.promos.detail', compact('promo'));
    }
}
