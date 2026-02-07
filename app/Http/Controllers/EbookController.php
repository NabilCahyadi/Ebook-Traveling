<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ebook;
use App\Models\Rating;
use App\Models\EbookRating;
use App\Models\City;

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

        // ============================================================
        // TRACKING VIEW: Hanya hitung 1 view per user per 1 jam
        // ============================================================
        // Untuk user yang login: tracking by user ID
        // Untuk guest: tracking by session ID (per device)

        $ebookId = $ebook->id;
        $now = now();

        if (auth()->check()) {
            // User yang login: track by user ID
            $userId = auth()->id();
            $sessionKey = "viewed_ebook_{$ebookId}_user_{$userId}";
            $trackingType = "authenticated_user";
        } else {
            // Guest user: track by session ID
            $sessionId = session()->getId();
            $sessionKey = "viewed_ebook_{$ebookId}_guest_{$sessionId}";
            $trackingType = "guest_user";
        }

        // Ambil waktu view terakhir dari session
        $lastViewTime = session()->get($sessionKey);

        // === DEBUG LOGGING ===
        \Log::info("📖 [VIEW TRACKING] Started", [
            'ebook_id' => $ebookId,
            'ebook_title' => $ebook->title,
            'tracking_type' => $trackingType,
            'session_key' => $sessionKey,
            'last_view_time' => $lastViewTime ? $lastViewTime->toDateTimeString() : null,
            'now' => $now->toDateTimeString(),
            'current_view_count' => $ebook->view_count,
            'session_id' => session()->getId(),
        ]);

        // Jika belum ada di session atau sudah lebih dari 60 menit
        $shouldIncrement = false;
        $minutesElapsed = 0;

        if ($lastViewTime === null) {
            $shouldIncrement = true;
            \Log::info("📖 [VIEW TRACKING] Reason: First view - no session data found");
        } else {
            $minutesElapsed = $now->diffInMinutes($lastViewTime);
            if ($minutesElapsed >= 60) {
                $shouldIncrement = true;
                \Log::info("📖 [VIEW TRACKING] Reason: 1 hour passed - can count again", [
                    'minutes_elapsed' => $minutesElapsed,
                ]);
            } else {
                \Log::info("📖 [VIEW TRACKING] Reason: Within 1 hour - skip counting", [
                    'minutes_elapsed' => $minutesElapsed,
                    'minutes_remaining' => (60 - $minutesElapsed),
                ]);
            }
        }

        if ($shouldIncrement) {
            try {
                // Increment view_count di database
                $ebook->increment('view_count');

                // Refresh untuk mendapatkan nilai terbaru
                $ebook->refresh();

                \Log::info("✅ [VIEW TRACKING] View count incremented", [
                    'ebook_id' => $ebookId,
                    'ebook_title' => $ebook->title,
                    'new_view_count' => $ebook->view_count,
                    'session_key' => $sessionKey,
                ]);

                // Simpan waktu view sekarang ke session (berlaku 1 jam)
                session()->put($sessionKey, $now);
                session()->save(); // Force save session

                \Log::info("💾 [VIEW TRACKING] Session updated", [
                    'session_key' => $sessionKey,
                    'saved_time' => $now->toDateTimeString(),
                ]);
            } catch (\Exception $e) {
                \Log::error("❌ [VIEW TRACKING] Error during increment", [
                    'ebook_id' => $ebookId,
                    'error_message' => $e->getMessage(),
                    'error_trace' => $e->getTraceAsString(),
                ]);
            }
        }
        // ============================================================

        // Cek apakah user yang login sudah pernah memberi rating
        $hasReviewed = false;
        if (auth()->check()) {
            $hasReviewed = Rating::where('user_id', auth()->id())
                ->where('ebook_id', $ebook->id)
                ->exists();
        }

        // Cek apakah user yang login sudah pernah membaca ebook ini
        $hasRead = false;
        if (auth()->check()) {
            $hasRead = \App\Models\UserReading::where('user_id', auth()->id())
                ->where('ebook_id', $ebook->id)
                ->exists();
        }

        $isSaved = false;
        if (auth()->check()) {
            $isSaved = auth()->user()->savedBooks()
                ->where('ebook_id', $ebook->id)
                ->exists();
        }

        $citiesHeader = City::where('is_active', true)
            ->orderBy('order_index')
            ->orderBy('name')
            ->get();

        return view('ebooks-detail', compact('ebook', 'ratings', 'ratingDistribution', 'hasReviewed', 'hasRead', 'isSaved', 'citiesHeader'));
    }

    public function toggleSaved(Request $request, string $id)
    {
        if (!auth()->check()) {
            return response()->json(['success' => false, 'message' => 'Login required'], 401);
        }

        $user = auth()->user();
        Ebook::findOrFail($id);

        $exists = $user->savedBooks()->where('ebook_id', $id)->exists();

        if ($exists) {
            $user->savedBooks()->detach($id);
        } else {
            $user->savedBooks()->attach($id);
        }

        return response()->json(['success' => true]);
    }
}
