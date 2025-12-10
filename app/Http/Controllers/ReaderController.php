<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ebook;

class ReaderController extends Controller
{
    /**
     * Tampilkan halaman reader untuk ebook tertentu.
     */
    public function show($slug)
    {
        // Cari ebook berdasarkan slug dan status 'published' SAJA.
        // Kita tidak perlu mengecek 'is_active' karena kolomnya tidak ada.
        $ebook = Ebook::where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

        // Kirim data ebook ke view
        return view('reader', compact('ebook'));
    }
}
