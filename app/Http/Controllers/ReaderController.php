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
        $ebook = Ebook::where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

        UserReading::updateOrCreate(
            // Kondisi untuk mencari catatan yang sudah ada
            [
                'user_id' => Auth::id(),
                'ebook_id' => $ebook->id,
            ],
            // Data yang akan diperbarui atau dibuat baru
            [
                'last_read_at' => now(),
                // Anda bisa menambahkan logika lain di sini nantinya, misalnya:
                // 'last_page' => 1,
                // 'progress_percentage' => 0.00,
            ]
        );

        // Kirim data ebook ke view
        return view('reader', compact('ebook'));
    }

    /**
     * Update progress reading untuk user.
     */
    // public function updateProgress(Request $request): JsonResponse
    // {
    //     $request->validate([
    //         'ebook_id' => 'required|uuid|exists:ebooks,id',
    //         'last_page' => 'required|integer|min:1',
    //     ]);

    //     $user = Auth::user();
    //     $ebookId = $request->input('ebook_id');
    //     $lastPage = $request->input('last_page');

    //     // Cari ebook untuk mendapatkan total halaman
    //     $ebook = Ebook::findOrFail($ebookId);

    //     // Hitung persentase progress
    //     if ($ebook->total_pages > 0) {
    //         $progressPercentage = ($lastPage / $ebook->total_pages) * 100;
    //     } else {
    //         $progressPercentage = 0;
    //     }

    //     // Update atau buat catatan reading
    //     $reading = UserReading::updateOrCreate(
    //         ['user_id' => $user->id, 'ebook_id' => $ebookId],
    //         [
    //             'last_page' => $lastPage,
    //             'progress_percentage' => round($progressPercentage, 2),
    //             'last_read_at' => now(),
    //         ]
    //     );

    //     return response()->json([
    //         'success' => true,
    //         'message' => 'Progress updated successfully.',
    //         'data' => [
    //             'last_page' => $reading->last_page,
    //             'progress_percentage' => $reading->progress_percentage,
    //         ]
    //     ]);
    // }

    /**
     * Update progress reading untuk user.
     */
    public function updateProgress(Request $request): JsonResponse
    {
        $request->validate([
            'ebook_id' => 'required|uuid|exists:ebooks,id',
            'last_page' => 'required|integer|min:1',
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
                'progress_percentage' => round($progressPercentage, 2),
                'last_read_at' => now(),
            ]
        );

        return response()->json([
            'success' => true,
            'message' => 'Progress updated successfully.',
            'data' => [
                'last_page' => $reading->last_page,
                'progress_percentage' => $reading->progress_percentage,
            ]
        ]);
    }
}
