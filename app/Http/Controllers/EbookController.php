<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ebook;
use App\Models\Rating;
use App\Models\EbookRating;

class EbookController extends Controller
{

    /**
     * Menampilkan detail satu e-book berdasarkan slug.
     */
    // Di EbookController.php
    public function show($slug)
    {
        // Mendapatkan data ebook - hanya yang published
        $ebook = Ebook::where('slug', $slug)
                     ->where('status', 'published')
                     ->firstOrFail();

        // Mendapatkan rating yang sudah disetujui dengan pagination (3 per halaman)
        $ratings = EbookRating::where('ebook_id', $ebook->id)
            ->where('is_approved', 1)
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(3);

        // Menghitung distribusi rating
        $ratingDistribution = EbookRating::where('ebook_id', $ebook->id)
            ->where('is_approved', 1)
            ->selectRaw('rating, count(*) as count')
            ->groupBy('rating')
            ->pluck('count', 'rating')
            ->toArray();

        // Memastikan semua index 1-5 ada di array
        for ($i = 1; $i <= 5; $i++) {
            if (!isset($ratingDistribution[$i])) {
                $ratingDistribution[$i] = 0;
            }
        }

        // Mengambil ratings dengan pagination maksimal 3 per halaman
        $ratings = Rating::with('user')
            ->where('ebook_id', $ebook->id)
            ->orderBy('created_at', 'desc')
            ->paginate(3);

        // Ambil semua rating untuk ditampilkan
        $ratings = $ebook->ratings()->latest()->paginate(3);

        // TAMBAHKAN BARIS INI: Tambah 1 ke view_count
        $ebook->increment('view_count');

        // Cek apakah user yang login sudah pernah memberi rating
        $hasReviewed = false;
        if (auth()->check()) {
            $hasReviewed = Rating::where('user_id', auth()->id())
                ->where('ebook_id', $ebook->id)
                ->exists();
        }

        return view('ebooks-detail', compact('ebook', 'ratings', 'ratingDistribution', 'hasReviewed'));
    }
}
