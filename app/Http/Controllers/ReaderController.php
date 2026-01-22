<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ebook;
use App\Models\UserReading;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;

class ReaderController extends Controller
{
    /**
     * Tampilkan halaman reader untuk ebook tertentu.
     */
    public function show($slug)
    {
        $ebook = Ebook::where('slug', $slug)->firstOrFail();

        $reading = UserReading::firstOrNew([
            'user_id' => Auth::id(),
            'ebook_id' => $ebook->id,
        ]);

        // ✅ Ambil halaman dari URL atau database
        $urlPage = (int) request()->query('page', 0);
        $startPage = $urlPage > 0
            ? $urlPage
            : ($reading->last_page ?? 1);

        // ✅ TAMBAHKAN INI: Redirect jika tidak ada ?page=
        if ($urlPage === 0 && $reading->last_page) {
            return redirect()->route('user.ebook.read', ['slug' => $slug, 'page' => $reading->last_page]);
        }

        // Simpan jika baru dibuat
        if (!$reading->exists) {
            $reading->fill([
                'last_page' => $startPage,
                'progress_percentage' => 0.00,
                'last_read_at' => now(),
            ])->save();
        }

        return view('reader', compact('ebook', 'startPage'));
    }

    /**
     * Update progress reading untuk user.
     */
    public function updateProgress(Request $request): JsonResponse
    {
        $request->validate([
            'ebook_id' => 'required|uuid|exists:ebooks,id',
            'last_page' => 'required|integer|min:1',
            'bookmark_page' => 'nullable|integer|min:1',
            'progress_percentage' => 'nullable|numeric|min:0|max:100',
        ]);

        $user = Auth::user();
        $ebookId = $request->input('ebook_id');
        $lastPage = $request->input('last_page');

        // Cari ebook untuk mendapatkan total halaman
        $ebook = Ebook::findOrFail($ebookId);

        // Hitung persentase progress
        if ($ebook->total_pages > 0) {
            $progressPercentage = ($lastPage / $ebook->total_pages) * 100;
        } else {
            $progressPercentage = 0;
        }

        // Update atau buat catatan reading
        $reading = UserReading::updateOrCreate(
            ['user_id' => $user->id, 'ebook_id' => $ebookId],
            [
                'last_page' => $lastPage,
                'bookmark_page' => $request->bookmark_page ?? $request->last_page,
                'progress_percentage' => round($progressPercentage, 2),
                'last_read_at' => now(),
            ]
        );

        return response()->json([
            'success' => true,
            'message' => 'Progress updated successfully.',
            'data' => [
                'last_page' => $reading->last_page,
                'bookmark_page' => $reading->bookmark_page,
                'progress_percentage' => $reading->progress_percentage,
            ]
        ]);
    }
}
