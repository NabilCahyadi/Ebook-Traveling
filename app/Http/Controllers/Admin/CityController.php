<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = City::query();

        // Search
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('province', 'like', "%{$search}%");
            });
        }

        // Filter by province
        if ($request->has('province') && $request->province != '') {
            $query->where('province', $request->province);
        }

        // Sorting
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        $cities = $query->paginate(8)->withQueryString();

        // Get unique provinces for filter dropdown
        $provinces = City::select('province')->distinct()->orderBy('province')->pluck('province');

        return view('admin.cities.index', compact('cities', 'provinces'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.cities.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'province' => 'required|string|max:255',
            'city_image_cropped' => 'nullable|string',
        ], [
            'name.required' => 'Nama kota wajib diisi.',
            'name.max' => 'Nama kota maksimal 255 karakter.',
            'province.required' => 'Nama provinsi wajib diisi.',
            'province.max' => 'Nama provinsi maksimal 255 karakter.',
        ]);

        // Handle base64 cropped image from JavaScript (ratio 4:3, 980x735px)
        if ($request->has('city_image_cropped') && !empty($request->city_image_cropped)) {
            $base64Image = $request->city_image_cropped;

            // Extract base64 data
            if (preg_match('/^data:image\/(\w+);base64,/', $base64Image, $type)) {
                $base64Image = substr($base64Image, strpos($base64Image, ',') + 1);
                $imageData = base64_decode($base64Image);

                $filename = 'city_' . time() . '_' . uniqid() . '.jpg';
                $path = 'cities/' . $filename;
                
                // Save to Laravel storage (storage/app/public/cities/)
                Storage::disk('public')->put($path, $imageData);

                $validated['image'] = $path;
            }
            unset($validated['city_image_cropped']);
        }

        City::create($validated);

        return redirect()->route('admin.cities.index')
            ->with('success', 'City created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $city = City::findOrFail($id);
        return view('admin.cities.show', compact('city'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $city = City::findOrFail($id);
        return view('admin.cities.edit', compact('city'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $city = City::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'province' => 'required|string|max:255',
            'city_image_cropped' => 'nullable|string',
        ], [
            'name.required' => 'Nama kota wajib diisi.',
            'name.max' => 'Nama kota maksimal 255 karakter.',
            'province.required' => 'Nama provinsi wajib diisi.',
            'province.max' => 'Nama provinsi maksimal 255 karakter.',
        ]);

        // Handle base64 cropped image from JavaScript (ratio 4:3, 980x735px)
        if ($request->has('city_image_cropped') && !empty($request->city_image_cropped)) {
            // Delete old image if exists
            if ($city->image && Storage::disk('public')->exists($city->image)) {
                Storage::disk('public')->delete($city->image);
            }

            $base64Image = $request->city_image_cropped;

            // Extract base64 data
            if (preg_match('/^data:image\/(\w+);base64,/', $base64Image, $type)) {
                $base64Image = substr($base64Image, strpos($base64Image, ',') + 1);
                $imageData = base64_decode($base64Image);

                $filename = 'city_' . time() . '_' . uniqid() . '.jpg';
                $path = 'cities/' . $filename;
                
                // Save to Laravel storage (storage/app/public/cities/)
                Storage::disk('public')->put($path, $imageData);

                $validated['image'] = $path;
            }
            unset($validated['city_image_cropped']);
        }

        $city->update($validated);

        return redirect()->route('admin.cities.index')
            ->with('success', 'City updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $city = City::findOrFail($id);

        if ($city->ebooks()->count() > 0) {
            return back()->with('error', 'Cannot delete city with existing ebooks!');
        }

        $city->delete();

        return redirect()->route('admin.cities.index')
            ->with('success', 'City deleted successfully!');
    }
}
