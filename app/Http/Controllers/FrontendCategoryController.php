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
    public function show(Request $request, $slug)
    {
        // Ambil data kategori
        $category = $this->categoryService->getCategoryBySlug($slug);

        // Get filter parameters
        $perPage = $request->input('per_page', 50);
        $sortBy = $request->input('sort_by', 'featured');

        // Validate per_page
        $validPerPage = ['50', '100', '150', '200', '250', '300', 'all'];
        if (!in_array(strtolower($perPage), $validPerPage)) {
            $perPage = 50;
        }

        // --- Query dengan Sorting dan Filtering ---
        $query = \App\Models\Ebook::select('ebooks.*')
            ->join('ebook_categories', 'ebooks.id', '=', 'ebook_categories.ebook_id')
            ->where('ebook_categories.category_id', $category->id)
            ->where('ebooks.status', 'published')
            ->whereNull('ebooks.deleted_at')
            ->with(['creator', 'city']);

        // Apply sorting
        switch ($sortBy) {
            case 'newest':
                $query->orderBy('ebooks.created_at', 'desc');
                break;
            case 'most_comments':
                $query->orderBy('ebooks.comments_count', 'desc');
                break;
            case 'release_date':
                $query->orderBy('ebooks.published_at', 'desc');
                break;
            case 'featured':
            default:
                // Featured: kombinasi rating dan views
                $query->orderBy('ebooks.average_rating', 'desc')
                      ->orderBy('ebooks.view_count', 'desc');
                break;
        }

        // Get results with pagination or all
        if (strtolower($perPage) === 'all') {
            $ebooks = $query->get();
        } else {
            $ebooks = $query->paginate((int)$perPage)->appends([
                'per_page' => $perPage,
                'sort_by' => $sortBy
            ]);
        }

        // Lampirkan hasil query manual ke objek kategori
        $category->setRelation('ebooks', $ebooks);

        $citiesHeader = City::where('is_active', true)
            ->orderBy('order_index')
            ->orderBy('name')
            ->get();

        return view('components.categories.show', compact('category', 'citiesHeader', 'perPage', 'sortBy'));
    }
}
