<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\PromoService;

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

        // Jika promo tidak ditemukan, tampilkan 404
        if (!$promo) {
            abort(404);
        }

        // Kirim data ke view
        return view('web.promos.detail', compact('promo'));
    }
}
