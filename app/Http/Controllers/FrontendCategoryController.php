<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CategoryService;
use App\Models\City;

class FrontendCategoryController extends Controller
{
    protected $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    /**
     * Display the specified category and its ebooks.
     */
    public function show($slug)
    {
        // Ambil data kategori
        $category = $this->categoryService->getCategoryBySlug($slug);

        // --- SOLUSI SEMENTARA: Query Manual untuk Menghindari Error ---
        $ebooks = \App\Models\Ebook::select('ebooks.*')
            ->join('ebook_categories', 'ebooks.id', '=', 'ebook_categories.ebook_id')
            ->where('ebook_categories.category_id', $category->id)
            ->where('ebooks.status', 'published')
            ->whereNull('ebooks.deleted_at')
            ->with(['creator', 'city'])
            ->get();

        // Lampirkan hasil query manual ke objek kategori
        $category->setRelation('ebooks', $ebooks);

        $citiesHeader = City::where('is_active', true)
            ->orderBy('order_index')
            ->orderBy('name')
            ->get();

        return view('components.categories.show', compact('category', 'citiesHeader'));
    }
}
