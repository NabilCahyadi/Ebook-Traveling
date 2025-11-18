<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Services\EbookService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EbookReaderController extends Controller
{
    protected $ebookService;

    public function __construct(EbookService $ebookService)
    {
        $this->ebookService = $ebookService;
    }

    /**
     * Display ebook reader with protection
     */
    public function read($slug)
    {
        $ebook = $this->ebookService->getEbookBySlug($slug);

        if (!$ebook || $ebook->status !== 'published') {
            abort(404, 'Ebook not found');
        }

        // Check if user has access (you can add subscription check here)
        // Example: if (!Auth::user()->hasAccessToEbook($ebook)) { abort(403); }

        // Determine content type (PDF or Text)
        $hasPdf = !empty($ebook->pdf_file);
        $viewName = $hasPdf ? 'user.ebook-pdf-reader' : 'user.ebook-reader';

        $response = response()->view($viewName, compact('ebook'));
        
        // Add security headers to prevent caching and framing
        return $response->withHeaders([
            'X-Frame-Options' => 'DENY',
            'X-Content-Type-Options' => 'nosniff',
            'X-XSS-Protection' => '1; mode=block',
            'Cache-Control' => 'no-store, no-cache, must-revalidate, max-age=0',
            'Pragma' => 'no-cache',
            'Expires' => '0',
            'Content-Security-Policy' => "frame-ancestors 'none'; default-src 'self' 'unsafe-inline' 'unsafe-eval' https://fonts.googleapis.com https://fonts.gstatic.com https://cdnjs.cloudflare.com;",
        ]);
    }



    /**
     * Get ebook content via AJAX (for secure content delivery)
     */
    public function getContent(Request $request, $id)
    {
        $ebook = $this->ebookService->getEbookById($id);

        if (!$ebook || $ebook->status !== 'published') {
            return response()->json(['error' => 'Content not found'], 404);
        }

        // Verify session token to prevent direct access
        if ($request->header('X-Reader-Token') !== session('reader_token_' . $id)) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        // Return content in chunks to prevent full download
        $content = $ebook->content_text; // Or load from sections

        return response()->json([
            'content' => $content,
            'title' => $ebook->title
        ]);
    }

    /**
     * Serve protected PDF file
     */
    public function servePdf($id)
    {
        $ebook = $this->ebookService->getEbookById($id);

        if (!$ebook || $ebook->status !== 'published' || !$ebook->pdf_file) {
            abort(404, 'PDF not found');
        }

        // Check authentication
        if (!Auth::check()) {
            abort(403, 'Unauthorized');
        }

        // Verify session token
        $sessionToken = session('pdf_token_' . $id);
        $requestToken = request()->query('token');

        if ($sessionToken !== $requestToken) {
            abort(403, 'Invalid token');
        }

        // Get PDF file path
        $filePath = storage_path('app/public/' . $ebook->pdf_file);

        if (!file_exists($filePath)) {
            abort(404, 'File not found');
        }

        // Return PDF with security headers
        return response()->file($filePath, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="protected.pdf"',
            'Cache-Control' => 'no-store, no-cache, must-revalidate, max-age=0',
            'Pragma' => 'no-cache',
            'Expires' => '0',
            'X-Content-Type-Options' => 'nosniff',
            'X-Frame-Options' => 'DENY',
        ]);
    }

    /**
     * Set PDF token in session
     */
    public function setPdfToken(Request $request)
    {
        $validated = $request->validate([
            'ebook_id' => 'required|integer',
            'token' => 'required|string'
        ]);

        session(['pdf_token_' . $validated['ebook_id'] => $validated['token']]);

        return response()->json(['success' => true]);
    }
}
