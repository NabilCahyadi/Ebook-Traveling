<?php

namespace App\Http\Controllers\Admin\WebsiteManagement;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\FaqRepositoryInterface;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    protected $faqRepository;

    // Category mapping: slug => database value
    protected $categoryMap = [
        'pricing' => 'pricing',
        'subscription' => 'subscription',
        'payment' => 'payment',
        'ebook-access' => 'ebook-access',
        'support' => 'support',
        'content' => 'content'
    ];

    // Category display names
    protected $categoryNames = [
        'pricing' => 'Pricing',
        'subscription' => 'Subscription & Membership',
        'payment' => 'Payments & Transactions',
        'ebook-access' => 'eBook Access & Reading',
        'support' => 'Account & Technical Support',
        'content' => 'Content & Features'
    ];

    public function __construct(FaqRepositoryInterface $faqRepository)
    {
        $this->faqRepository = $faqRepository;
    }

    /**
     * Generic index method for all FAQ categories
     */
    protected function indexCategory($category, Request $request)
    {
        $search = $request->get('search');
        $perPage = $request->get('per_page', 10);

        $query = \App\Models\Faq::where('category', $category);

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('question', 'like', "%{$search}%")
                    ->orWhere('answer', 'like', "%{$search}%");
            });
        }

        $faqs = $query->orderBy('order_index', 'asc')
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);

        $categoryName = $this->categoryNames[$category] ?? ucfirst($category);
        $categorySlug = $category;

        return view('admin.website-management.faqs.index', compact('faqs', 'categoryName', 'categorySlug'));
    }

    /**
     * Generic create method for all FAQ categories
     */
    protected function createCategory($category)
    {
        $maxOrder = \App\Models\Faq::where('category', $category)->max('order_index') ?? 0;
        $nextOrder = $maxOrder + 1;

        $categoryName = $this->categoryNames[$category] ?? ucfirst($category);
        $categorySlug = $category;

        return view('admin.website-management.faqs.create', compact('nextOrder', 'categoryName', 'categorySlug'));
    }

    /**
     * Generic store method for all FAQ categories
     */
    protected function storeCategory($category, Request $request)
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

        $validated['category'] = $category;
        $validated['is_active'] = $request->has('is_active') ? true : false;

        $this->faqRepository->create($validated);

        $categoryName = $this->categoryNames[$category] ?? ucfirst($category);

        return redirect()->route("admin.faqs.{$category}.index")
            ->with('success', "FAQ {$categoryName} berhasil ditambahkan!");
    }

    /**
     * Generic edit method for all FAQ categories
     */
    protected function editCategory($category, string $id)
    {
        $faq = $this->faqRepository->findById($id);

        if ($faq->category !== $category) {
            abort(404);
        }

        $categoryName = $this->categoryNames[$category] ?? ucfirst($category);
        $categorySlug = $category;

        return view('admin.website-management.faqs.edit', compact('faq', 'categoryName', 'categorySlug'));
    }

    /**
     * Generic update method for all FAQ categories
     */
    protected function updateCategory($category, Request $request, string $id)
    {
        $faq = $this->faqRepository->findById($id);

        if ($faq->category !== $category) {
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

        $categoryName = $this->categoryNames[$category] ?? ucfirst($category);

        return redirect()->route("admin.faqs.{$category}.index")
            ->with('success', "FAQ {$categoryName} berhasil diperbarui!");
    }

    /**
     * Generic destroy method for all FAQ categories
     */
    protected function destroyCategory($category, string $id)
    {
        $faq = $this->faqRepository->findById($id);

        if ($faq->category !== $category) {
            return response()->json(['success' => false, 'message' => 'FAQ tidak ditemukan.'], 404);
        }

        $this->faqRepository->delete($id);

        $categoryName = $this->categoryNames[$category] ?? ucfirst($category);

        return response()->json(['success' => true, 'message' => "FAQ {$categoryName} berhasil dihapus!"]);
    }

    /**
     * Generic toggle status method for all FAQ categories
     */
    protected function toggleStatusCategory($category, string $id)
    {
        $faq = $this->faqRepository->findById($id);

        if ($faq->category !== $category) {
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
     * Generic update order method for all FAQ categories
     */
    protected function updateOrderCategory($category, Request $request)
    {
        $orders = $request->input('orders', []);

        $this->faqRepository->updateOrder($orders);

        return response()->json(['success' => true, 'message' => 'Urutan FAQ berhasil diperbarui!']);
    }

    /**
     * Generic bulk delete method for all FAQ categories
     */
    protected function bulkDeleteCategory($category, Request $request)
    {
        $ids = $request->input('ids', []);

        if (empty($ids)) {
            return response()->json(['success' => false, 'message' => 'Tidak ada FAQ yang dipilih.'], 400);
        }

        $validIds = \App\Models\Faq::whereIn('id', $ids)
            ->where('category', $category)
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

    // Magic method to handle all category-specific methods
    public function __call($method, $parameters)
    {
        // Extract category from method name
        // e.g., indexPricing -> pricing, createSubscription -> subscription
        foreach ($this->categoryMap as $slug => $dbValue) {
            $camelCase = str_replace(' ', '', ucwords(str_replace('-', ' ', $slug)));
            
            if (str_ends_with($method, $camelCase)) {
                $action = str_replace($camelCase, '', $method);
                
                switch ($action) {
                    case 'index':
                        return $this->indexCategory($dbValue, $parameters[0] ?? request());
                    case 'create':
                        return $this->createCategory($dbValue);
                    case 'store':
                        return $this->storeCategory($dbValue, $parameters[0] ?? request());
                    case 'edit':
                        return $this->editCategory($dbValue, $parameters[0]);
                    case 'update':
                        return $this->updateCategory($dbValue, $parameters[0] ?? request(), $parameters[1] ?? $parameters[0]);
                    case 'destroy':
                        return $this->destroyCategory($dbValue, $parameters[0]);
                    case 'toggleStatus':
                        return $this->toggleStatusCategory($dbValue, $parameters[0]);
                    case 'updateOrder':
                        return $this->updateOrderCategory($dbValue, $parameters[0] ?? request());
                    case 'bulkDelete':
                        return $this->bulkDeleteCategory($dbValue, $parameters[0] ?? request());
                }
            }
        }

        // If no match found, throw error
        throw new \BadMethodCallException("Method {$method} does not exist.");
    }
}
