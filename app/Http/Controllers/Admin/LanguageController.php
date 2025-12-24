<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class LanguageController extends Controller
{
    /**
     * Switch application language
     */
    public function switch(Request $request, $locale)
    {
        // Validate locale
        if (!in_array($locale, ['en', 'id'])) {
            abort(400, 'Invalid language');
        }

        // Store language preference in session
        Session::put('locale', $locale);

        // Set application locale
        app()->setLocale($locale);

        // Redirect back with success message
        return redirect()->back()->with('success', 'Language changed successfully');
    }
}
