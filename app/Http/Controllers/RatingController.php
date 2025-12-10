<?php

namespace App\Http\Controllers;

use App\Services\RatingService;
use Illuminate\Http\Request;


class RatingController extends Controller
{
    protected $ratingService;

    public function __construct(RatingService $ratingService)
    {
        $this->ratingService = $ratingService;
        // Baris 16 ada di bawah, ini yang menyebabkan error
        // $this->middleware('auth');
    }

    /**
     * Menyimpan rating dan review baru untuk e-book.
     */
    public function store(Request $request)
    {
        // 1. Validasi data yang dikirim dari form
        $validated = $request->validate([
            'ebook_id' => 'required|exists:ebooks,id',
            'rating'   => 'required|integer|min:1|max:5',
            'review_text' => 'nullable|string',
        ]);

        // 2. Panggil service untuk memproses logika bisnis
        // auth()->id() sekarang akan aman karena middleware sudah dijalankan di route
        $result = $this->ratingService->submitRating($validated, auth()->id());

        // 3. Redirect berdasarkan hasil dari service
        if ($result['success']) {
            return redirect()->back()->with('success', $result['message']);
        } else {
            if (isset($result['redirect_route'])) {
                return redirect()->route($result['redirect_route'])->with('error', $result['message']);
            }
            return redirect()->back()->with('error', $result['message']);
        }
    }
}
