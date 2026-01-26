<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Faq;
use App\Models\City;
use App\Models\ContactInfo;

class FaqController extends Controller
{
    public function faqs()
    {
        // Ambil semua kategori unik yang aktif
        $categories = Faq::where('is_active', true)
            ->orderBy('order_index')
            ->pluck('category')
            ->unique();

        // Ambil semua FAQ aktif, urutkan per kategori & order_index
        $faqs = Faq::where('is_active', true)
            ->orderBy('category')
            ->orderBy('order_index')
            ->get()
            ->groupBy('category');

        $citiesHeader = City::where('is_active', true)
            ->orderBy('order_index')
            ->orderBy('name')
            ->get();

        // Ambil contact info yang aktif
        $contactInfos = ContactInfo::where('is_active', true)
            ->orderBy('contact_type')
            ->get();

        return view('faq', compact('faqs', 'categories', 'citiesHeader', 'contactInfos'));
    }
}
