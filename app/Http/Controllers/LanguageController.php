<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class LanguageController extends Controller
{
    /**
     * Switch application language for frontend/user
     *
     * @param string $locale
     * @return \Illuminate\Http\RedirectResponse
     */
    public function switch($locale)
    {
        // Validate locale
        if (!in_array($locale, ['en', 'id'])) {
            $locale = 'en';
        }

        // Store in session with explicit save
        Session::put('locale', $locale);
        Session::save();

        // Set application locale
        App::setLocale($locale);

        // Redirect back to previous page
        return redirect()->back()->with('locale_changed', true);
    }
}
