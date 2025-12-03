<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HelpController extends Controller
{
    /**
     * Load help content via AJAX.
     */
    public function loadContent($type)
    {
        $view = '';
        switch ($type) {
            case 'reading':
                $view = 'partials.user.reading-guide-content';
                break;
            case 'billing':
                $view = 'partials.user.billing-help-content';
                break;
            case 'account':
                $view = 'partials.user.account-help-content';
                break;
            default:
                // Jika tipe tidak dikenal, kembalikan error 404
                abort(404);
        }

        // Render view partial dan kembalikan sebagai HTML
        return response()->view($view);
    }
}
