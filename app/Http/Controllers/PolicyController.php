<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PageSection;
use App\Models\City;

class PolicyController extends Controller
{
    public function show(string $type)
    {
        $sections = PageSection::where('page_type', $type)
            ->orderBy('order_index')
            ->get()
            ->groupBy('section_title');

        // Map type ke view name
        $viewMap = [
            'help' => 'help-center',
            'privacy' => 'privacy-policy',
            'terms' => 'terms-conditions',
            'shopping' => 'shopping-policy',
            'payment' => 'payment-policy',
        ];

        $citiesHeader = City::where('is_active', true)
            ->orderBy('order_index')
            ->orderBy('name')
            ->get();

        $view = $viewMap[$type] ?? abort(404);

        return view($view, compact('sections', 'citiesHeader'));
    }
}
