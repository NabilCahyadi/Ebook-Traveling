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
     * DISABLED: Contact info cannot be created, only edited
     */
    public function create()
    {
        return redirect()->route('admin.contact-info.index')
            ->with('error', 'Pembuatan contact info baru tidak diizinkan. Silakan edit data yang sudah ada.');
    }

    /**
     * Store a newly created resource in storage.
     * DISABLED: Contact info cannot be created, only edited
     */
    public function store(Request $request)
    {
        return redirect()->route('admin.contact-info.index')
            ->with('error', 'Pembuatan contact info baru tidak diizinkan. Silakan edit data yang sudah ada.');
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
     * DISABLED: Contact info cannot be deleted, only edited
     */
    public function destroy(ContactInfo $contactInfo)
    {
        return redirect()->route('admin.contact-info.index')
            ->with('error', 'Penghapusan contact info tidak diizinkan. Silakan nonaktifkan jika tidak ingin ditampilkan.');
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

    /**
     * Update all contacts at once
     */
    public function updateAll(Request $request)
    {
        // Custom validation untuk link - hanya validasi jika tidak kosong dan bukan '#'
        $validatedData = $request->validate([
            'contacts' => 'required|array',
            'contacts.*.id' => 'required|exists:contact_infos,id',
            'contacts.*.title' => 'required|string|max:255',
            'contacts.*.icon_class' => 'nullable|string|max:100',
            'contacts.*.description' => 'nullable|string',
            'contacts.*.link' => 'nullable|string|max:500',
        ], [
            'contacts.required' => 'Data contact tidak ditemukan.',
            'contacts.*.title.required' => 'Judul wajib diisi.',
        ]);

        try {
            foreach ($request->contacts as $contactData) {
                $contact = ContactInfo::find($contactData['id']);
                if ($contact) {
                    // Clean link - jika kosong atau '#' set ke null
                    $link = $contactData['link'] ?? null;
                    
                    // Validasi link jika ada
                    if ($link && $link !== '#') {
                        // Cek apakah valid URL atau URI scheme (tel:, mailto:, https:, http:, etc)
                        $validSchemes = ['tel:', 'mailto:', 'http://', 'https://', 'whatsapp:', 'sms:'];
                        $isValidScheme = false;
                        
                        foreach ($validSchemes as $scheme) {
                            if (stripos($link, $scheme) === 0) {
                                $isValidScheme = true;
                                break;
                            }
                        }
                        
                        // Jika tidak menggunakan scheme yang valid, cek apakah valid URL
                        if (!$isValidScheme && !filter_var($link, FILTER_VALIDATE_URL)) {
                            return redirect()->back()
                                ->withInput()
                                ->with('error', "Format link tidak valid untuk {$contactData['title']}. Gunakan URL lengkap (https://...) atau URI scheme (tel:, mailto:, dll)");
                        }
                    }
                    
                    $contact->update([
                        'title' => $contactData['title'],
                        'icon_class' => $contactData['icon_class'] ?? null,
                        'description' => $contactData['description'] ?? null,
                        'link' => ($link && $link !== '#') ? $link : null,
                        'is_active' => isset($contactData['is_active']) ? 1 : 0,
                        'show_in_contact_page' => isset($contactData['show_in_contact_page']) ? 1 : 0,
                    ]);
                }
            }

            return redirect()->route('admin.contact-info.index')
                ->with('success', 'Semua contact info berhasil diupdate.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal mengupdate contact info: ' . $e->getMessage());
        }
    }
}
