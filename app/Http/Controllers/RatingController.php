<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rating;

class RatingController extends Controller
{
    /**
     * Menyimpan rating dan review baru untuk e-book.
     */
    public function store(Request $request)
    {
        // 1. Validasi data yang dikirim dari form
        $validated = $request->validate([
            'ebook_id' => 'required|exists:ebooks,id',
            'rating'   => 'required|integer|min:1|max:5',
            'review_text' => 'nullable|string', // Gunakan nama kolom yang benar
        ]);

        // 2. Cek apakah user sudah login dan premium
        // Middleware 'auth' sudah menjamin user login, tapi kita cek status premium
        if (!auth()->user()->hasActiveSubscription()) {
            return redirect()->route('pricing')
                ->with('error', 'Fitur ini hanya tersedia untuk pengguna Premium.');
        }

        // 3. Cek apakah user sudah pernah memberi rating untuk e-book ini
        $existingRating = Rating::where('user_id', auth()->id())
            ->where('ebook_id', $validated['ebook_id'])
            ->first();

        if ($existingRating) {
            // 4a. Jika sudah ada, update rating yang lama
            $existingRating->update($request->only('rating', 'review_text'));
        } else {
            // 4b. Jika belum ada, buat rating baru
            Rating::create([
                'user_id'    => auth()->id(),
                'ebook_id'   => $validated['ebook_id'],
                'rating'     => $validated['rating'],
                'review_text' => $validated['review_text'],
            ]);
        }
        
        // 5. Redirect kembali dengan pesan sukses
        return redirect()->back()
            ->with('success', 'You\'re welcome! Your rating and review have been successfully submitted!');
    }
}
