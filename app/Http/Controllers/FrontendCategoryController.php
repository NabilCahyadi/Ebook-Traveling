<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CategoryService;

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
        // Gunakan service untuk mendapatkan data kategori berdasarkan slug
        $category = $this->categoryService->getCategoryBySlug($slug);

        // Pastikan kita juga memuat relasi ebooks untuk ditampilkan
        $category->load(['ebooks.creator', 'ebooks.city']); 

        return view('components.categories.show', compact('category'));
    }
}
