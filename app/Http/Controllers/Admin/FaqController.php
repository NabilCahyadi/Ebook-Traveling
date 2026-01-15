<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\FaqRepositoryInterface;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    protected $faqRepository;

    public function __construct(FaqRepositoryInterface $faqRepository)
    {
        $this->faqRepository = $faqRepository;
    }

    /**
     * Display a listing of pricing FAQs.
     */
    public function indexPricing(Request $request)
    {
        $search = $request->get('search');
        $perPage = $request->get('per_page', 10);

        $query = \App\Models\Faq::where('category', 'pricing');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('question', 'like', "%{$search}%")
                    ->orWhere('answer', 'like', "%{$search}%");
            });
        }

        $faqs = $query->orderBy('order_index', 'asc')
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);

        return view('admin.faqs.pricing.index', compact('faqs'));
    }

    /**
     * Show the form for creating a new pricing FAQ.
     */
    public function createPricing()
    {
        // Get the highest order_index for pricing category
        $maxOrder = \App\Models\Faq::where('category', 'pricing')->max('order_index') ?? 0;
        $nextOrder = $maxOrder + 1;

        return view('admin.faqs.pricing.create', compact('nextOrder'));
    }

    /**
     * Store a newly created pricing FAQ in storage.
     */
    public function storePricing(Request $request)
    {
        $validated = $request->validate([
            'question' => 'required|string|max:500',
            'answer' => 'required|string',
            'order_index' => 'required|integer|min:0',
            'is_active' => 'boolean',
        ], [
            'question.required' => 'Pertanyaan wajib diisi.',
            'question.max' => 'Pertanyaan maksimal 500 karakter.',
            'answer.required' => 'Jawaban wajib diisi.',
            'order_index.required' => 'Urutan wajib diisi.',
            'order_index.integer' => 'Urutan harus berupa angka.',
            'order_index.min' => 'Urutan minimal 0.',
        ]);

        $validated['category'] = 'pricing';
        $validated['is_active'] = $request->has('is_active') ? true : false;

        $this->faqRepository->create($validated);

        return redirect()->route('admin.faqs.pricing.index')
            ->with('success', 'FAQ Pricing berhasil ditambahkan!');
    }

    /**
     * Show the form for editing the specified pricing FAQ.
     */
    public function editPricing(string $id)
    {
        $faq = $this->faqRepository->findById($id);

        if ($faq->category !== 'pricing') {
            abort(404);
        }

        return view('admin.faqs.pricing.edit', compact('faq'));
    }

    /**
     * Update the specified pricing FAQ in storage.
     */
    public function updatePricing(Request $request, string $id)
    {
        $faq = $this->faqRepository->findById($id);

        if ($faq->category !== 'pricing') {
            abort(404);
        }

        $validated = $request->validate([
            'question' => 'required|string|max:500',
            'answer' => 'required|string',
            'order_index' => 'required|integer|min:0',
            'is_active' => 'boolean',
        ], [
            'question.required' => 'Pertanyaan wajib diisi.',
            'question.max' => 'Pertanyaan maksimal 500 karakter.',
            'answer.required' => 'Jawaban wajib diisi.',
            'order_index.required' => 'Urutan wajib diisi.',
            'order_index.integer' => 'Urutan harus berupa angka.',
            'order_index.min' => 'Urutan minimal 0.',
        ]);

        $validated['is_active'] = $request->has('is_active') ? true : false;

        $this->faqRepository->update($id, $validated);

        return redirect()->route('admin.faqs.pricing.index')
            ->with('success', 'FAQ Pricing berhasil diperbarui!');
    }

    /**
     * Remove the specified pricing FAQ from storage.
     */
    public function destroyPricing(string $id)
    {
        $faq = $this->faqRepository->findById($id);

        if ($faq->category !== 'pricing') {
            return response()->json(['success' => false, 'message' => 'FAQ tidak ditemukan.'], 404);
        }

        $this->faqRepository->delete($id);

        return response()->json(['success' => true, 'message' => 'FAQ Pricing berhasil dihapus!']);
    }

    /**
     * Toggle the status of the specified pricing FAQ.
     */
    public function toggleStatusPricing(string $id)
    {
        $faq = $this->faqRepository->findById($id);

        if ($faq->category !== 'pricing') {
            return response()->json(['success' => false, 'message' => 'FAQ tidak ditemukan.'], 404);
        }

        $this->faqRepository->toggleStatus($id);

        return response()->json([
            'success' => true,
            'message' => 'Status FAQ berhasil diubah!',
            'is_active' => $faq->fresh()->is_active
        ]);
    }

    /**
     * Update the order of pricing FAQs.
     */
    public function updateOrderPricing(Request $request)
    {
        $orders = $request->input('orders', []);

        $this->faqRepository->updateOrder($orders);

        return response()->json(['success' => true, 'message' => 'Urutan FAQ berhasil diperbarui!']);
    }

    /**
     * Bulk delete pricing FAQs.
     */
    public function bulkDeletePricing(Request $request)
    {
        $ids = $request->input('ids', []);

        if (empty($ids)) {
            return response()->json(['success' => false, 'message' => 'Tidak ada FAQ yang dipilih.'], 400);
        }

        // Verify all FAQs are pricing category
        $validIds = \App\Models\Faq::whereIn('id', $ids)
            ->where('category', 'pricing')
            ->pluck('id')
            ->toArray();

        if (empty($validIds)) {
            return response()->json(['success' => false, 'message' => 'FAQ tidak ditemukan.'], 404);
        }

        $this->faqRepository->bulkDelete($validIds);

        return response()->json([
            'success' => true,
            'message' => count($validIds) . ' FAQ berhasil dihapus!'
        ]);
    }
}
