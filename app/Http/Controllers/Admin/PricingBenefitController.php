<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\PricingBenefitService;
use App\Models\PricingBenefit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PricingBenefitController extends Controller
{
    protected $pricingBenefitService;

    public function __construct(PricingBenefitService $pricingBenefitService)
    {
        $this->pricingBenefitService = $pricingBenefitService;
    }

    /**
     * Display a listing of pricing benefits.
     */
    public function index()
    {
        $benefits = PricingBenefit::orderBy('sort_order', 'asc')->get();
        
        return view('admin.pricing-benefits.index', compact('benefits'));
    }

    /**
     * Show the form for creating a new benefit.
     */
    public function create()
    {
        return view('admin.pricing-benefits.create');
    }

    /**
     * Store a newly created benefit.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'icon' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'status' => 'nullable|boolean',
            'sort_order' => 'nullable|integer|min:0',
        ], [
            'icon.required' => 'Icon wajib diisi',
            'title.required' => 'Judul wajib diisi',
            'description.required' => 'Deskripsi wajib diisi',
        ]);

        try {
            DB::beginTransaction();

            $validated['status'] = $request->has('status') ? 'active' : 'inactive';
            
            // Set default sort_order if not provided
            if (!isset($validated['sort_order'])) {
                $maxOrder = PricingBenefit::max('sort_order') ?? 0;
                $validated['sort_order'] = $maxOrder + 1;
            }

            // Check if sort_order already exists
            $existingBenefit = PricingBenefit::where('sort_order', $validated['sort_order'])->first();
            if ($existingBenefit) {
                $availableNumbers = $this->getAvailableNumbers();
                $errorMessage = 'Urutan tampil ' . $validated['sort_order'] . ' sudah digunakan oleh "' . $existingBenefit->title . '". ';
                
                if (!empty($availableNumbers['smallest'])) {
                    $errorMessage .= 'Angka terkecil yang tersedia: ' . implode(', ', $availableNumbers['smallest']) . '. ';
                }
                if (!empty($availableNumbers['largest'])) {
                    $errorMessage .= 'Angka terbesar yang tersedia: ' . implode(', ', $availableNumbers['largest']) . '.';
                }
                
                return redirect()->back()
                    ->withInput()
                    ->with('error', $errorMessage);
            }

            PricingBenefit::create($validated);

            DB::commit();

            return redirect()->route('admin.about-us.index')
                ->with('success', 'Benefit berhasil ditambahkan!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal menambahkan benefit: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified benefit.
     */
    public function edit($id)
    {
        $benefit = PricingBenefit::findOrFail($id);
        
        return view('admin.pricing-benefits.edit', compact('benefit'));
    }

    /**
     * Update the specified benefit.
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'icon' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'status' => 'nullable|boolean',
            'sort_order' => 'nullable|integer|min:0',
        ], [
            'icon.required' => 'Icon wajib diisi',
            'title.required' => 'Judul wajib diisi',
            'description.required' => 'Deskripsi wajib diisi',
        ]);

        try {
            DB::beginTransaction();

            $benefit = PricingBenefit::findOrFail($id);
            $validated['status'] = $request->has('status') ? 'active' : 'inactive';
            
            // Check if sort_order already exists (excluding current benefit)
            if (isset($validated['sort_order'])) {
                $existingBenefit = PricingBenefit::where('sort_order', $validated['sort_order'])
                    ->where('id', '!=', $id)
                    ->first();
                
                if ($existingBenefit) {
                    $availableNumbers = $this->getAvailableNumbers($id);
                    $errorMessage = 'Urutan tampil ' . $validated['sort_order'] . ' sudah digunakan oleh "' . $existingBenefit->title . '". ';
                    
                    if (!empty($availableNumbers['smallest'])) {
                        $errorMessage .= 'Angka terkecil yang tersedia: ' . implode(', ', $availableNumbers['smallest']) . '. ';
                    }
                    if (!empty($availableNumbers['largest'])) {
                        $errorMessage .= 'Angka terbesar yang tersedia: ' . implode(', ', $availableNumbers['largest']) . '.';
                    }
                    
                    return redirect()->back()
                        ->withInput()
                        ->with('error', $errorMessage);
                }
            }
            
            $benefit->update($validated);

            DB::commit();

            return redirect()->route('admin.about-us.index')
                ->with('success', 'Benefit berhasil diupdate!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal mengupdate benefit: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified benefit.
     */
    public function destroy($id)
    {
        try {
            $benefit = PricingBenefit::findOrFail($id);
            $benefit->delete();

            return redirect()->route('admin.about-us.index')
                ->with('success', 'Benefit berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menghapus benefit: ' . $e->getMessage());
        }
    }

    /**
     * Toggle status of a benefit.
     */
    public function toggleStatus($id)
    {
        try {
            $benefit = PricingBenefit::findOrFail($id);
            $benefit->status = $benefit->status === 'active' ? 'inactive' : 'active';
            $benefit->save();

            return response()->json([
                'success' => true,
                'message' => 'Status berhasil diubah',
                'status' => $benefit->status
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengubah status: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update order of benefits.
     */
    public function updateOrder(Request $request)
    {
        $validated = $request->validate([
            'benefits' => 'required|array',
            'benefits.*.id' => 'required|exists:pricing_benefits,id',
            'benefits.*.sort_order' => 'required|integer|min:0'
        ]);

        try {
            DB::beginTransaction();

            foreach ($validated['benefits'] as $benefit) {
                PricingBenefit::where('id', $benefit['id'])
                    ->update(['sort_order' => $benefit['sort_order']]);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Urutan benefit berhasil diupdate'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengupdate urutan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get available sort_order numbers.
     */
    private function getAvailableNumbers($excludeId = null)
    {
        $query = PricingBenefit::orderBy('sort_order');
        
        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }
        
        $usedNumbers = $query->pluck('sort_order')->toArray();
        
        if (empty($usedNumbers)) {
            return [
                'smallest' => [1],
                'largest' => [1]
            ];
        }
        
        $maxUsed = max($usedNumbers);
        $minUsed = min($usedNumbers);
        
        // Find smallest available numbers (gaps in sequence and numbers before min)
        $smallestAvailable = [];
        
        // Check numbers before minimum used
        for ($i = 0; $i < $minUsed; $i++) {
            if (!in_array($i, $usedNumbers)) {
                $smallestAvailable[] = $i;
                if (count($smallestAvailable) >= 3) break;
            }
        }
        
        // If we need more, check for gaps
        if (count($smallestAvailable) < 3) {
            for ($i = $minUsed; $i <= $maxUsed; $i++) {
                if (!in_array($i, $usedNumbers)) {
                    $smallestAvailable[] = $i;
                    if (count($smallestAvailable) >= 3) break;
                }
            }
        }
        
        // Find largest available numbers (after max used)
        $largestAvailable = [];
        for ($i = $maxUsed + 1; $i <= $maxUsed + 3; $i++) {
            $largestAvailable[] = $i;
        }
        
        return [
            'smallest' => $smallestAvailable,
            'largest' => $largestAvailable
        ];
    }
}
