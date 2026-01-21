<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use App\Models\Blog;
use App\Models\City;
use App\Models\Category;

class SitemapController extends Controller
{
    /**
     * Generate XML sitemap
     */
    public function index()
    {
        $blogs = Blog::where('is_published', true)
            ->where('published_at', '<=', now())
            ->orderBy('published_at', 'desc')
            ->get();

        $cities = City::where('is_active', true)
            ->orderBy('order_index')
            ->get();

        $categories = Category::where('is_active', true)
            ->orderBy('order')
            ->get();

        $content = view('sitemap', compact('blogs', 'cities', 'categories'))->render();

        return response($content, 200)
            ->header('Content-Type', 'application/xml');
    }
}
