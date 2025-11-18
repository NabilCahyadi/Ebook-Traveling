<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\EbookService;
use Illuminate\Http\Request;

class EbookController extends Controller
{
    protected $ebookService;

    public function __construct(EbookService $ebookService)
    {
        $this->ebookService = $ebookService;
    }

    /**
     * Display a listing of all ebooks.
     */
    public function index()
    {
        $ebooks = $this->ebookService->getAllEbooks(12);
        return view('admin.ebooks.index', compact('ebooks'));
    }

    /**
     * Show the form for creating a new ebook.
     */
    public function create()
    {
        return view('admin.ebooks.create');
    }

    /**
     * Store a newly created ebook.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:ebook_categories,id',
            'city_id' => 'required|exists:cities,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'cover_image' => 'nullable|image|max:2048',
            'file_url' => 'nullable|file|mimes:pdf|max:10240',
            'pdf_file' => 'nullable|file|mimes:pdf|max:51200',
            'preview_content' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        try {
            $this->ebookService->createEbook($validated);
            return redirect()->route('admin.ebooks.index')->with('success', 'Ebook created successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to create ebook: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Display the specified ebook.
     */
    public function show($id)
    {
        $ebook = $this->ebookService->getEbookById($id);
        return view('admin.ebooks.show', compact('ebook'));
    }

    /**
     * Show the form for editing the specified ebook.
     */
    public function edit($id)
    {
        $ebook = $this->ebookService->getEbookById($id);
        return view('admin.ebooks.edit', compact('ebook'));
    }

    /**
     * Update the specified ebook.
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:ebook_categories,id',
            'city_id' => 'required|exists:cities,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'cover_image' => 'nullable|image|max:2048',
            'file_url' => 'nullable|file|mimes:pdf|max:10240',
            'pdf_file' => 'nullable|file|mimes:pdf|max:51200',
            'preview_content' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        try {
            $this->ebookService->updateEbook($id, $validated);
            return redirect()->route('admin.ebooks.index')->with('success', 'Ebook updated successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to update ebook: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Remove the specified ebook.
     */
    public function destroy($id)
    {
        try {
            $this->ebookService->deleteEbook($id);
            return redirect()->route('admin.ebooks.index')->with('success', 'Ebook deleted successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to delete ebook: ' . $e->getMessage());
        }
    }
}
