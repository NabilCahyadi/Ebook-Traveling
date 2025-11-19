<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\EbookService;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    protected $ebookService;

    public function __construct(EbookService $ebookService)
    {
        $this->ebookService = $ebookService;
    }

    /**
     * Display admin dashboard.
     */
    public function index()
    {
        // Get statistics
        $totalEbooks = \App\Models\Ebook::count();
        $totalUsers = \App\Models\User::count();
        $totalCategories = \App\Models\Category::count();
        $totalCities = \App\Models\City::count();

        // Get recent data
        $recentEbooks = \App\Models\Ebook::with('category')->latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'recentEbooks',
            'totalEbooks',
            'totalUsers',
            'totalCategories',
            'totalCities'
        ));
    }
}
