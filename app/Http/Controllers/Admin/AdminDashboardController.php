<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\EbookService;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    protected $ebookService;

    public function __construct(EbookService $ebookService)
    {
        $this->ebookService = $ebookService;
    }

    /**
     * Display admin dashboard.
     */
    public function index()
    {
        $ebooks = $this->ebookService->getAllEbooks(10);

        return view('admin.dashboard', compact('ebooks'));
    }
}
