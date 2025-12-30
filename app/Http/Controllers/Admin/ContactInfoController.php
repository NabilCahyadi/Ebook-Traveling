<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactInfo;
use Illuminate\Http\Request;

class ContactInfoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $contacts = ContactInfo::orderBy('contact_type')->get();
        return view('admin.contact-info.index', compact('contacts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.contact-info.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'contact_type' => 'required|string|max:50',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'link' => 'nullable|string|max:500',
            'icon_class' => 'nullable|string|max:100',
        ], [
            'contact_type.required' => 'Tipe kontak wajib diisi.',
            'contact_type.max' => 'Tipe kontak maksimal 50 karakter.',
            'title.required' => 'Judul wajib diisi.',
            'title.max' => 'Judul maksimal 255 karakter.',
            'link.max' => 'Link maksimal 500 karakter.',
            'icon_class.max' => 'Icon class maksimal 100 karakter.',
        ]);

        try {
            $validated['is_active'] = $request->has('is_active');
            $validated['show_in_contact_page'] = $request->has('show_in_contact_page');

            ContactInfo::create($validated);

            return redirect()->route('admin.contact-info.index')
                ->with('success', 'Contact info berhasil ditambahkan.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal menambahkan contact info: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(ContactInfo $contactInfo)
    {
        return view('admin.contact-info.show', compact('contactInfo'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ContactInfo $contactInfo)
    {
        return view('admin.contact-info.edit', compact('contactInfo'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ContactInfo $contactInfo)
    {
        $validated = $request->validate([
            'contact_type' => 'required|string|max:50',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'link' => 'nullable|string|max:500',
            'icon_class' => 'nullable|string|max:100',
        ], [
            'contact_type.required' => 'Tipe kontak wajib diisi.',
            'contact_type.max' => 'Tipe kontak maksimal 50 karakter.',
            'title.required' => 'Judul wajib diisi.',
            'title.max' => 'Judul maksimal 255 karakter.',
            'link.max' => 'Link maksimal 500 karakter.',
            'icon_class.max' => 'Icon class maksimal 100 karakter.',
        ]);

        try {
            $validated['is_active'] = $request->has('is_active');
            $validated['show_in_contact_page'] = $request->has('show_in_contact_page');

            $contactInfo->update($validated);

            return redirect()->route('admin.contact-info.index')
                ->with('success', 'Contact info berhasil diupdate.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal mengupdate contact info: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ContactInfo $contactInfo)
    {
        try {
            $contactInfo->delete();

            return redirect()->route('admin.contact-info.index')
                ->with('success', 'Contact info berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menghapus contact info: ' . $e->getMessage());
        }
    }

    /**
     * Toggle active status
     */
    public function toggleActive($id)
    {
        try {
            $contactInfo = ContactInfo::findOrFail($id);
            $contactInfo->is_active = !$contactInfo->is_active;
            $contactInfo->save();

            return response()->json([
                'success' => true,
                'message' => 'Status berhasil diubah.',
                'is_active' => $contactInfo->is_active
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengubah status: ' . $e->getMessage()
            ], 500);
        }
    }
}
