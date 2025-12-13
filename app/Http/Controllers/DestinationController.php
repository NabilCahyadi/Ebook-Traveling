<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CategoryService;
use App\Services\CityService;

class DestinationController extends Controller
{
    public function __construct(
        private CityService $cityService
    ) {}

    public function index()
    {
        $cities = $this->cityService->getHomepageCities(50);
        return view('destinations', compact('cities'));
    }

    public function show(string $slug)
    {
        // Panggil satu method yang mengembalikan kota BESERTA ebook-nya
        $city = $this->cityService->getCityBySlugWithEbooks($slug);

        if (!$city) {
            abort(404);
        }

        // Ebook sekarang sudah menjadi relasi dari objek $city
        $ebooks = $city->ebooks;

        return view('components.destinations.show', compact('city', 'ebooks'));
    }
}
