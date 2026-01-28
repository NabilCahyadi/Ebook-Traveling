<?php

namespace App\Http\Controllers\Admin\WebsiteManagement;

use App\Http\Controllers\Controller;
use App\Models\AboutUsSection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AboutUsSectionController extends Controller
{
    /**
     * Display a listing of about us sections with tabs.
     */
    public function index(Request $request)
    {
        $activeTab = $request->get('tab', 'welcome');
        
        $sections = AboutUsSection::orderBy('order_index', 'asc')->get()->keyBy('section_key');
        
        return view('admin.website-management.about-us.index', compact('sections', 'activeTab'));
    }

    /**
     * Show the form for editing the specified section.
     */
    public function edit($sectionKey)
    {
        $section = AboutUsSection::where('section_key', $sectionKey)->firstOrFail();
        
        // For about_details, decode JSON content
        $details = null;
        if ($sectionKey === 'about_details') {
            $details = json_decode($section->content, true);
        }
        
        return view('admin.website-management.about-us.edit', compact('section', 'details'));
    }

    /**
     * Update the specified section.
     */
    public function update(Request $request, $sectionKey)
    {
        $section = AboutUsSection::where('section_key', $sectionKey)->firstOrFail();
        
        // Different validation rules based on section_key
        if ($sectionKey === 'about_details') {
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'details' => 'required|array|size:3',
                'details.*.title' => 'required|string|max:255',
                'details.*.description' => 'required|string',
                'is_active' => 'nullable|boolean',
            ], [
                'title.required' => 'Judul section wajib diisi',
                'details.required' => 'Detail harus berisi 3 item',
                'details.*.title.required' => 'Judul detail wajib diisi',
                'details.*.description.required' => 'Deskripsi detail wajib diisi',
            ]);
        } else {
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'content' => 'required|string',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
                'is_active' => 'nullable|boolean',
            ], [
                'title.required' => 'Judul wajib diisi',
                'content.required' => 'Konten wajib diisi',
                'image.image' => 'File harus berupa gambar',
                'image.mimes' => 'Format gambar yang diperbolehkan: jpeg, png, jpg, gif, webp',
                'image.max' => 'Ukuran gambar maksimal 2MB',
            ]);
        }

        try {
            DB::beginTransaction();

            $updateData = [
                'title' => $validated['title'],
                'is_active' => $request->has('is_active') ? 1 : 0,
            ];

            // Handle content based on section type
            if ($sectionKey === 'about_details') {
                $updateData['content'] = json_encode($validated['details']);
            } else {
                $updateData['content'] = $validated['content'];
            }

            // Handle image upload for welcome and performance sections
            if (in_array($sectionKey, ['welcome', 'performance']) && $request->hasFile('image')) {
                // Delete old image if exists
                if ($section->image && file_exists(public_path($section->image))) {
                    unlink(public_path($section->image));
                }

                $image = $request->file('image');
                $imageName = $sectionKey . '_' . time() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('images/about-us'), $imageName);
                $updateData['image'] = 'images/about-us/' . $imageName;
            }

            $section->update($updateData);

            DB::commit();

            return redirect()->route('admin.about-us-sections.index', ['tab' => $sectionKey])
                ->with('success', 'Section "' . $this->getSectionName($sectionKey) . '" berhasil diupdate!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal mengupdate section: ' . $e->getMessage());
        }
    }

    /**
     * Toggle status of a section.
     */
    public function toggleStatus($sectionKey)
    {
        try {
            $section = AboutUsSection::where('section_key', $sectionKey)->firstOrFail();
            $section->is_active = !$section->is_active;
            $section->save();

            return response()->json([
                'success' => true,
                'message' => 'Status berhasil diubah',
                'is_active' => $section->is_active
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengubah status: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get section display name.
     */
    private function getSectionName($sectionKey)
    {
        $names = [
            'welcome' => 'Welcome',
            'performance' => 'Performance',
            'about_details' => 'About Details',
        ];

        return $names[$sectionKey] ?? ucfirst(str_replace('_', ' ', $sectionKey));
    }
}
