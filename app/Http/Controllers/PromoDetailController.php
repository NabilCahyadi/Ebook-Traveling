<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\PromoService;
use App\Models\City;

class PromoDetailController extends Controller
{
    protected $promoService;

    public function __construct(PromoService $promoService)
    {
        $this->promoService = $promoService;
    }

    /**
     * Menampilkan halaman detail promo.
     */
    public function show($slug)
    {
        // Ambil data promo berdasarkan slug
        $promo = $this->promoService->getPromoBySlug($slug);
        $citiesHeader = City::where('is_active', true)
            ->orderBy('order_index')
            ->orderBy('name')
            ->get();

        // Jika promo tidak ditemukan, tampilkan 404
        if (!$promo) {
            abort(404);
        }

        // Kirim data ke view
        return view('web.promos.detail', compact('promo', 'citiesHeader'));
    }
}
