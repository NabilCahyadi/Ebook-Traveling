@extends('layouts.admin')

@section('title', 'Contact Info Management')

@push('styles')
    <style>
        .contact-icon {
            font-size: 2rem;
            width: 60px;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
        }

        .action-buttons {
            gap: 0.25rem;
        }

        .badge-active {
            background-color: #28a745;
        }

        .badge-inactive {
            background-color: #6c757d;
        }
    </style>
@endpush

@section('content')
    <!-- Header -->
    <div class="mb-4">
        <h4 class="fw-bold mb-1">
            <span class="text-muted fw-light">Website Management /</span> Contact Info
        </h4>
        <p class="mb-0">Kelola informasi kontak dan media sosial</p>
    </div>

    <!-- Success/Error Messages -->
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Info Alert -->
    <div class="alert alert-info d-flex align-items-center" role="alert">
        <i class="ti ti-info-circle me-2"></i>
        <div>
            <strong>Tips:</strong> Contact Info digunakan untuk menampilkan informasi kontak di footer dan halaman Contact Us.
        </div>
    </div>

    <!-- Contact Info Cards -->
    <div class="row">
        @forelse($contacts as $contact)
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-start mb-3">
                            <div class="contact-icon bg-label-primary me-3">
                                <i class="{{ $contact->icon_class ?? 'ti ti-mail' }}"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h5 class="mb-1">{{ $contact->title }}</h5>
                                <span class="badge {{ $contact->is_active ? 'badge-active' : 'badge-inactive' }} mb-1">
                                    {{ $contact->is_active ? 'Active' : 'Inactive' }}
                                </span>
                                @if($contact->show_in_contact_page)
                                    <span class="badge bg-info">Contact Page</span>
                                @endif
                            </div>
                        </div>

                        <!-- <p class="text-muted mb-2">
                            <strong>Type:</strong> {{ ucfirst($contact->contact_type) }}
                        </p> -->

                        @if($contact->description)
                            <p class="text-muted mb-2">{{ Str::limit($contact->description, 80) }}</p>
                        @endif

                        @if($contact->link)
                            <div class="mb-3">
                                <p class="text-muted mb-1">
                                    <strong>Link:</strong>
                                </p>
                                <a href="{{ $contact->link }}" target="_blank" class="text-primary text-truncate d-block" style="max-width: 100%;">
                                    {{ $contact->link }}
                                </a>
                            </div>
                        @endif

                        <div class="d-flex action-buttons gap-2">
                            <a href="{{ route('admin.contact-info.edit', $contact->id) }}" 
                               class="btn btn-sm btn-label-primary" title="Edit">
                                <i class="ti ti-pencil"></i> Edit
                            </a>
                            <button type="button" 
                                    class="btn btn-sm btn-label-{{ $contact->is_active ? 'warning' : 'success' }} toggle-active" 
                                    data-id="{{ $contact->id }}"
                                    data-status="{{ $contact->is_active }}"
                                    title="Toggle Status">
                                <i class="ti ti-toggle-{{ $contact->is_active ? 'right' : 'left' }}"></i>
                                {{ $contact->is_active ? 'Disable' : 'Enable' }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="card">
                    <div class="card-body text-center py-5">
                        <i class="ti ti-address-book" style="font-size: 4rem; color: #ddd;"></i>
                        <p class="text-muted mt-3 mb-0">Belum ada contact info. Tambahkan yang pertama!</p>
                    </div>
                </div>
            </div>
        @endforelse
    </div>
@endsection

@push('scripts')
    <script>
        // Toggle Active Status
        document.querySelectorAll('.toggle-active').forEach(button => {
            button.addEventListener('click', function() {
                const contactId = this.dataset.id;
                const isActive = this.dataset.status === '1';

                if (confirm(`Apakah Anda yakin ingin ${isActive ? 'menonaktifkan' : 'mengaktifkan'} contact info ini?`)) {
                    fetch(`/admin/contact-info/${contactId}/toggle-active`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            location.reload();
                        } else {
                            alert('Error: ' + data.message);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Terjadi kesalahan saat mengubah status');
                    });
                }
            });
        });
    </script>
@endpush
