<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ContactInfo;
use App\Models\City;

class ContactController extends Controller
{
    public function index()
    {
        $contacts = ContactInfo::where('is_active', true)
            ->where('show_in_contact_page', true) // ---> INI KUNCI
            ->get()
            ->keyBy('contact_type');

        $contactImage = '/images/banner-contact.webp';

        $citiesHeader = City::where('is_active', true)
            ->orderBy('order_index')
            ->orderBy('name')
            ->get();
        return view('contact', compact('contacts', 'contactImage', 'citiesHeader'));
    }
}
