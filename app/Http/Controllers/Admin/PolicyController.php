<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PageSection;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PolicyController extends Controller
{
    // Page type mapping: slug => database value
    protected $pageTypeMap = [
        'help' => 'help',
        'privacy' => 'privacy',
        'terms' => 'terms',
        'shopping' => 'shopping',
        'payment' => 'payment'
    ];

    // Page type display names
    protected $pageTypeNames = [
        'help' => 'Help Center',
        'privacy' => 'Privacy Policy',
        'terms' => 'Terms & Conditions',
        'shopping' => 'Shopping Policy',
        'payment' => 'Payment Policy'
    ];

    /**
     * Generic index method for all policy page types
     */
    protected function indexPageType($pageType, Request $request)
    {
        $search = $request->get('search');
        $perPage = $request->get('per_page', 10);

        $query = PageSection::where('page_type', $pageType);

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('section_title', 'like', "%{$search}%")
                    ->orWhere('subsection_title', 'like', "%{$search}%")
                    ->orWhere('content', 'like', "%{$search}%");
            });
        }

        $sections = $query->orderBy('order_index', 'asc')
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);

        $pageTypeName = $this->pageTypeNames[$pageType] ?? ucfirst($pageType);
        $pageTypeSlug = $pageType;

        return view('admin.policies.index', compact('sections', 'pageTypeName', 'pageTypeSlug'));
    }

    /**
     * Generic create method for all policy page types
     */
    protected function createPageType($pageType)
    {
        $maxOrder = PageSection::where('page_type', $pageType)->max('order_index') ?? 0;
        $nextOrder = $maxOrder + 1;

        $pageTypeName = $this->pageTypeNames[$pageType] ?? ucfirst($pageType);
        $pageTypeSlug = $pageType;

        return view('admin.policies.create', compact('nextOrder', 'pageTypeName', 'pageTypeSlug'));
    }

    /**
     * Generic store method for all policy page types
     */
    protected function storePageType($pageType, Request $request)
    {
        $validated = $request->validate([
            'section_title' => 'nullable|string|max:255',
            'subsection_title' => 'nullable|string|max:255',
            'content' => 'required|string',
            'order_index' => 'required|integer|min:0',
        ], [
            'content.required' => 'Konten wajib diisi.',
            'order_index.required' => 'Urutan wajib diisi.',
            'order_index.integer' => 'Urutan harus berupa angka.',
            'order_index.min' => 'Urutan minimal 0.',
        ]);

        PageSection::create([
            'id' => Str::uuid(),
            'page_type' => $pageType,
            'section_title' => $validated['section_title'],
            'subsection_title' => $validated['subsection_title'],
            'content' => $validated['content'],
            'order_index' => $validated['order_index'],
        ]);

        $pageTypeName = $this->pageTypeNames[$pageType] ?? ucfirst($pageType);

        return redirect()->route("admin.policies.{$pageType}.index")
            ->with('success', "Section {$pageTypeName} berhasil ditambahkan!");
    }

    /**
     * Generic edit method for all policy page types
     */
    protected function editPageType($pageType, string $id)
    {
        $section = PageSection::findOrFail($id);

        if ($section->page_type !== $pageType) {
            abort(404);
        }

        $pageTypeName = $this->pageTypeNames[$pageType] ?? ucfirst($pageType);
        $pageTypeSlug = $pageType;

        return view('admin.policies.edit', compact('section', 'pageTypeName', 'pageTypeSlug'));
    }

    /**
     * Generic update method for all policy page types
     */
    protected function updatePageType($pageType, Request $request, string $id)
    {
        $section = PageSection::findOrFail($id);

        if ($section->page_type !== $pageType) {
            abort(404);
        }

        $validated = $request->validate([
            'section_title' => 'nullable|string|max:255',
            'subsection_title' => 'nullable|string|max:255',
            'content' => 'required|string',
            'order_index' => 'required|integer|min:0',
        ], [
            'content.required' => 'Konten wajib diisi.',
            'order_index.required' => 'Urutan wajib diisi.',
            'order_index.integer' => 'Urutan harus berupa angka.',
            'order_index.min' => 'Urutan minimal 0.',
        ]);

        $section->update($validated);

        $pageTypeName = $this->pageTypeNames[$pageType] ?? ucfirst($pageType);

        return redirect()->route("admin.policies.{$pageType}.index")
            ->with('success', "Section {$pageTypeName} berhasil diperbarui!");
    }

    /**
     * Generic destroy method for all policy page types
     */
    protected function destroyPageType($pageType, string $id)
    {
        $section = PageSection::findOrFail($id);

        if ($section->page_type !== $pageType) {
            return response()->json(['success' => false, 'message' => 'Section tidak ditemukan.'], 404);
        }

        $section->delete();

        $pageTypeName = $this->pageTypeNames[$pageType] ?? ucfirst($pageType);

        return response()->json(['success' => true, 'message' => "Section {$pageTypeName} berhasil dihapus!"]);
    }

    /**
     * Generic update order method for all policy page types
     */
    protected function updateOrderPageType($pageType, Request $request)
    {
        $orders = $request->input('orders', []);

        foreach ($orders as $order) {
            PageSection::where('id', $order['id'])
                ->where('page_type', $pageType)
                ->update(['order_index' => $order['order_index']]);
        }

        return response()->json(['success' => true, 'message' => 'Urutan berhasil diperbarui!']);
    }

    /**
     * Generic bulk delete method for all policy page types
     */
    protected function bulkDeletePageType($pageType, Request $request)
    {
        $ids = $request->input('ids', []);

        if (empty($ids)) {
            return response()->json(['success' => false, 'message' => 'Tidak ada section yang dipilih.'], 400);
        }

        $validIds = PageSection::whereIn('id', $ids)
            ->where('page_type', $pageType)
            ->pluck('id')
            ->toArray();

        if (empty($validIds)) {
            return response()->json(['success' => false, 'message' => 'Section tidak ditemukan.'], 404);
        }

        PageSection::whereIn('id', $validIds)->delete();

        return response()->json([
            'success' => true,
            'message' => count($validIds) . ' section berhasil dihapus!'
        ]);
    }

    // Magic method to handle all page type-specific methods
    public function __call($method, $parameters)
    {
        // Extract page type from method name
        // e.g., indexHelp -> help, createPrivacy -> privacy
        foreach ($this->pageTypeMap as $slug => $dbValue) {
            $camelCase = str_replace(' ', '', ucwords(str_replace('-', ' ', $slug)));
            
            if (str_ends_with($method, $camelCase)) {
                $action = str_replace($camelCase, '', $method);
                
                switch ($action) {
                    case 'index':
                        return $this->indexPageType($dbValue, $parameters[0] ?? request());
                    case 'create':
                        return $this->createPageType($dbValue);
                    case 'store':
                        return $this->storePageType($dbValue, $parameters[0] ?? request());
                    case 'edit':
                        return $this->editPageType($dbValue, $parameters[0]);
                    case 'update':
                        return $this->updatePageType($dbValue, $parameters[0] ?? request(), $parameters[1] ?? $parameters[0]);
                    case 'destroy':
                        return $this->destroyPageType($dbValue, $parameters[0]);
                    case 'updateOrder':
                        return $this->updateOrderPageType($dbValue, $parameters[0] ?? request());
                    case 'bulkDelete':
                        return $this->bulkDeletePageType($dbValue, $parameters[0] ?? request());
                }
            }
        }

        // If no match found, throw error
        throw new \BadMethodCallException("Method {$method} does not exist.");
    }
}
