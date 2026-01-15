<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CategoryService;
use App\Services\CityService;
use App\Models\City;

class DestinationController extends Controller
{
    public function __construct(
        private CityService $cityService
    ) {}

    public function index()
    {
        $cities = $this->cityService->getHomepageCities(50);
        $citiesHeader = City::where('is_active', true)
            ->orderBy('order_index')
            ->orderBy('name')
            ->get();
        return view('destinations', compact('cities', 'citiesHeader'));
    }

    public function show(string $slug)
    {
        // Panggil satu method yang mengembalikan kota BESERTA ebook-nya
        $city = $this->cityService->getCityBySlugWithEbooks($slug);

        if (!$city) {
            abort(404);
        }
        $citiesHeader = City::where('is_active', true)
            ->orderBy('order_index')
            ->orderBy('name')
            ->get();
        // Ebook sekarang sudah menjadi relasi dari objek $city
        $ebooks = $city->ebooks;

        return view('components.destinations.show', compact('city', 'ebooks', 'citiesHeader'));
    }
}
