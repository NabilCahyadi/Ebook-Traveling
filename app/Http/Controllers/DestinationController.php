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
        $city = $this->cityService->getCityBySlug($slug);

        if (!$city) {
            abort(404);
        }

        return view('destinations.show', compact('city'));
    }
}
