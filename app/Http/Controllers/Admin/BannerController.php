<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $activeTab = $request->get('tab', 'home-slider');
        
        if ($activeTab === 'banner-pricing') {
            $bannerPricing = Banner::where('type', 'banner-pricing')->first();
            return view('admin.banners.index', compact('activeTab', 'bannerPricing'));
        }
        
        $banners = Banner::where('type', 'home-slider')
            ->orderBy('order_index', 'asc')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.banners.index', compact('banners', 'activeTab'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $hasBannerPricing = Banner::where('type', 'banner-pricing')->exists();
        return view('admin.banners.create', compact('hasBannerPricing'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'required|image|mimes:jpeg,jpg,png,webp|max:2048',
            'type' => 'nullable|string|max:50',
            'target_url' => 'nullable|string|max:500',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'order_index' => 'nullable|integer|min:0',
        ], [
            'title.required' => 'Judul banner wajib diisi.',
            'title.max' => 'Judul banner maksimal 255 karakter.',
            'image.required' => 'Gambar banner wajib diupload.',
            'image.image' => 'File harus berupa gambar.',
            'image.mimes' => 'Format gambar harus JPEG, JPG, PNG, atau WebP.',
            'image.max' => 'Ukuran gambar maksimal 2MB.',
            'target_url.max' => 'URL terlalu panjang (maksimal 500 karakter).',
            'start_date.date' => 'Format tanggal mulai tidak valid.',
            'end_date.date' => 'Format tanggal selesai tidak valid.',
            'end_date.after_or_equal' => 'Tanggal selesai harus setelah atau sama dengan tanggal mulai.',
            'order_index.integer' => 'Urutan harus berupa angka.',
            'order_index.min' => 'Urutan tidak boleh kurang dari 0.',
        ]);

        try {
            // Check if banner-pricing already exists (only 1 allowed)
            if ($validated['type'] === 'banner-pricing') {
                $existingPricingBanner = Banner::where('type', 'banner-pricing')->first();
                if ($existingPricingBanner) {
                    return redirect()->back()
                        ->withInput()
                        ->with('error', 'Banner Pricing sudah ada. Hanya boleh ada 1 banner pricing. Silakan edit banner yang sudah ada.');
                }
            }
            
            // Check if order_index already exists
            $orderIndex = $validated['order_index'] ?? 0;
            $existingBanner = Banner::where('order_index', $orderIndex)
                ->where('type', $validated['type'] ?? 'hero')
                ->first();
            
            if ($existingBanner && $validated['type'] !== 'banner-pricing') {
                // Find available order numbers
                $usedOrders = Banner::orderBy('order_index')->pluck('order_index')->toArray();
                $minAvailable = 0;
                $maxUsed = max($usedOrders);
                
                // Find smallest available number
                while (in_array($minAvailable, $usedOrders)) {
                    $minAvailable++;
                }
                
                $suggestion = "Nomor urutan $orderIndex sudah dipakai oleh banner lain. ";
                $suggestion .= "Nomor terkecil yang tersedia: $minAvailable. ";
                $suggestion .= "Atau gunakan nomor lebih besar dari: $maxUsed.";
                
                return redirect()->back()
                    ->withInput()
                    ->with('error', $suggestion);
            }
            
            // Handle image upload
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time() . '_' . Str::slug($request->title) . '.' . $image->getClientOriginalExtension();
                $imagePath = $image->storeAs('banners', $imageName, 'public');
                $validated['image'] = $imagePath;
            }

            $validated['is_active'] = $request->has('is_active');
            $validated['type'] = $validated['type'] ?? 'hero';
            $validated['order_index'] = $orderIndex;
            
            // Null target_url if banner type is banner-pricing
            if ($validated['type'] === 'banner-pricing') {
                $validated['target_url'] = null;
            }

            Banner::create($validated);

            return redirect()->route('admin.banners.index')
                ->with('success', 'Banner created successfully.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to create banner: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Banner $banner)
    {
        return view('admin.banners.show', compact('banner'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Banner $banner)
    {
        return view('admin.banners.edit', compact('banner'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Banner $banner)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:2048',
            'type' => 'nullable|string|max:50',
            'target_url' => 'nullable|string|max:500',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'order_index' => 'nullable|integer|min:0',
        ], [
            'title.required' => 'Judul banner wajib diisi.',
            'title.max' => 'Judul banner maksimal 255 karakter.',
            'image.image' => 'File harus berupa gambar.',
            'image.mimes' => 'Format gambar harus JPEG, JPG, PNG, atau WebP.',
            'image.max' => 'Ukuran gambar maksimal 2MB.',
            'target_url.max' => 'URL terlalu panjang (maksimal 500 karakter).',
            'start_date.date' => 'Format tanggal mulai tidak valid.',
            'end_date.date' => 'Format tanggal selesai tidak valid.',
            'end_date.after_or_equal' => 'Tanggal selesai harus setelah atau sama dengan tanggal mulai.',
            'order_index.integer' => 'Urutan harus berupa angka.',
            'order_index.min' => 'Urutan tidak boleh kurang dari 0.',
        ]);

        try {
            // Handle image upload
            if ($request->hasFile('image')) {
                // Delete old image
                if ($banner->image && Storage::disk('public')->exists($banner->image)) {
                    Storage::disk('public')->delete($banner->image);
                }

                $image = $request->file('image');
                $imageName = time() . '_' . Str::slug($request->title) . '.' . $image->getClientOriginalExtension();
                $imagePath = $image->storeAs('banners', $imageName, 'public');
                $validated['image'] = $imagePath;
            }

            // Check if order_index already exists (exclude current banner)
            $orderIndex = $validated['order_index'] ?? 0;
            $existingBanner = Banner::where('order_index', $orderIndex)
                ->where('id', '!=', $banner->id)
                ->first();
            
            if ($existingBanner) {
                // Find available order numbers
                $usedOrders = Banner::where('id', '!=', $banner->id)
                    ->orderBy('order_index')
                    ->pluck('order_index')
                    ->toArray();
                $minAvailable = 0;
                $maxUsed = count($usedOrders) > 0 ? max($usedOrders) : 0;
                
                // Find smallest available number
                while (in_array($minAvailable, $usedOrders)) {
                    $minAvailable++;
                }
                
                $suggestion = "Nomor urutan $orderIndex sudah dipakai oleh banner lain. ";
                $suggestion .= "Nomor terkecil yang tersedia: $minAvailable. ";
                $suggestion .= "Atau gunakan nomor lebih besar dari: $maxUsed.";
                
                return redirect()->back()
                    ->withInput()
                    ->with('error', $suggestion);
            }
            
            $validated['is_active'] = $request->has('is_active');
            $validated['type'] = $validated['type'] ?? 'hero';
            $validated['order_index'] = $orderIndex;
            
            // Null target_url if banner type is banner-pricing
            if ($validated['type'] === 'banner-pricing') {
                $validated['target_url'] = null;
            }

            $banner->update($validated);

            return redirect()->route('admin.banners.index')
                ->with('success', 'Banner updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to update banner: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Banner $banner)
    {
        try {
            // Delete image from storage
            if ($banner->image && Storage::disk('public')->exists($banner->image)) {
                Storage::disk('public')->delete($banner->image);
            }

            $banner->delete();

            return redirect()->route('admin.banners.index')
                ->with('success', 'Banner deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to delete banner: ' . $e->getMessage());
        }
    }

    /**
     * Toggle banner active status.
     */
    public function toggleActive(Request $request, $id)
    {
        try {
            $banner = Banner::findOrFail($id);
            $banner->is_active = !$banner->is_active;
            $banner->save();

            return response()->json([
                'success' => true,
                'is_active' => $banner->is_active,
                'message' => 'Banner status updated successfully.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update banner status.'
            ], 500);
        }
    }

    /**
     * Update banner order.
     */
    public function updateOrder(Request $request)
    {
        $validated = $request->validate([
            'banners' => 'required|array',
            'banners.*.id' => 'required|exists:banners,id',
            'banners.*.order_index' => 'required|integer|min:0',
        ]);

        try {
            foreach ($validated['banners'] as $bannerData) {
                Banner::where('id', $bannerData['id'])
                    ->update(['order_index' => $bannerData['order_index']]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Banner order updated successfully.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update banner order.'
            ], 500);
        }
    }

    /**
     * Check if display order already exists
     */
    public function checkOrder(Request $request)
    {
        $order = $request->input('order');
        $type = $request->input('type');
        $bannerId = $request->input('banner_id'); // For edit mode

        $query = Banner::where('order_index', $order)
            ->where('type', $type);

        // Exclude current banner when editing
        if ($bannerId) {
            $query->where('id', '!=', $bannerId);
        }

        $existingBanner = $query->first();

        if ($existingBanner) {
            // Find available orders
            $usedOrders = Banner::where('type', $type)
                ->when($bannerId, function($q) use ($bannerId) {
                    return $q->where('id', '!=', $bannerId);
                })
                ->pluck('order_index')
                ->toArray();

            $minAvailable = 0;
            while (in_array($minAvailable, $usedOrders)) {
                $minAvailable++;
            }

            $maxUsed = count($usedOrders) > 0 ? max($usedOrders) : 0;

            return response()->json([
                'exists' => true,
                'message' => "Nomor urutan {$order} sudah dipakai oleh banner: \"{$existingBanner->title}\"",
                'suggestion' => "Nomor terkecil yang tersedia: {$minAvailable}. Atau gunakan nomor lebih besar dari: {$maxUsed}."
            ]);
        }

        return response()->json([
            'exists' => false
        ]);
    }
}
