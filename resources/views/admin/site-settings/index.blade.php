@extends('layouts.admin')

@section('title', 'Site Settings')

@push('styles')
    <style>
        .setting-card {
            border-left: 4px solid #696cff;
        }

        .add-setting-card {
            border: 2px dashed #ddd;
            transition: all 0.3s;
        }

        .add-setting-card:hover {
            border-color: #696cff;
            background-color: #f8f9fa;
        }
    </style>
@endpush

@section('content')
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">
                <span class="text-muted fw-light">Website Management /</span> Site Settings
            </h4>
            <p class="mb-0">Kelola pengaturan website secara global</p>
        </div>
        {{-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addSettingModal">
            <i class="ti ti-plus me-1"></i> Add New Setting
        </button> --}}
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

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Error!</strong> Please check the form.
            <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Info Alert -->
    <div class="alert alert-info d-flex align-items-center" role="alert">
        <i class="ti ti-info-circle me-2"></i>
        <div>
            <strong>Tips:</strong> Site Settings digunakan untuk menyimpan konfigurasi global website seperti alamat, telepon, email, dll.
        </div>
    </div>

    <!-- Settings Form -->
    <form action="{{ route('admin.site-settings.update') }}" method="POST">
        @csrf
        @method('PUT')

        <div class="row">
            @foreach($settings as $key => $setting)
                <div class="col-md-6 mb-4">
                    <div class="card setting-card h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div>
                                    <h5 class="mb-1">{{ ucwords(str_replace('_', ' ', $setting->key)) }}</h5>
                                    <span class="badge bg-label-primary">{{ ucfirst($setting->type) }}</span>
                                </div>
                                {{-- Delete button disabled --}}
                                {{-- <form action="{{ route('admin.site-settings.destroy', $setting->id) }}" 
                                      method="POST" 
                                      class="d-inline delete-form"
                                      onsubmit="return confirm('Yakin ingin menghapus setting ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-label-danger" title="Delete">
                                        <i class="ti ti-trash"></i>
                                    </button>
                                </form> --}}
                            </div>

                            <input type="hidden" name="settings[{{ $loop->index }}][key]" value="{{ $setting->key }}">
                            <input type="hidden" name="settings[{{ $loop->index }}][type]" value="{{ $setting->type }}">

                            <div class="mb-2">
                                <label class="form-label">Key</label>
                                <input type="text" class="form-control-plaintext" value="{{ $setting->key }}" readonly>
                            </div>

                            <div class="mb-0">
                                <label for="value_{{ $setting->key }}" class="form-label">Value</label>
                                @if($setting->type === 'textarea')
                                    <textarea class="form-control" 
                                              id="value_{{ $setting->key }}"
                                              name="settings[{{ $loop->index }}][value]" 
                                              rows="3">{{ old("settings.{$loop->index}.value", $setting->value) }}</textarea>
                                @else
                                    <input type="{{ $setting->type === 'email' ? 'email' : ($setting->type === 'phone' ? 'tel' : 'text') }}" 
                                           class="form-control" 
                                           id="value_{{ $setting->key }}"
                                           name="settings[{{ $loop->index }}][value]" 
                                           value="{{ old("settings.{$loop->index}.value", $setting->value) }}"
                                           placeholder="Enter {{ $setting->key }}">
                                @endif
                                @if($setting->type === 'phone')
                                    <small class="form-text text-muted">Format: 628xxx (tanpa +, tanpa 0 di depan)</small>
                                @elseif($setting->type === 'email')
                                    <small class="form-text text-muted">Format: email@example.com</small>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        @if($settings->count() > 0)
            <div class="mt-4">
                <button type="submit" class="btn btn-primary">
                    <i class="ti ti-check me-1"></i> Save All Settings
                </button>
            </div>
        @else
            <div class="card">
                <div class="card-body text-center py-5">
                    <i class="ti ti-settings" style="font-size: 4rem; color: #ddd;"></i>
                    <p class="text-muted mt-3 mb-0">Belum ada settings. Tambahkan setting pertama!</p>
                </div>
            </div>
        @endif
    </form>

    {{-- Add Setting Modal - Disabled --}}
    {{-- <div class="modal fade" id="addSettingModal" tabindex="-1" aria-labelledby="addSettingModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addSettingModalLabel">Add New Setting</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('admin.site-settings.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="new_key" class="form-label">Key <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control" 
                                   id="new_key" 
                                   name="key" 
                                   required
                                   placeholder="e.g., company_name, footer_text">
                            <small class="form-text text-muted">Gunakan lowercase dan underscore. Contoh: company_name</small>
                        </div>

                        <div class="mb-3">
                            <label for="new_value" class="form-label">Value</label>
                            <textarea class="form-control" 
                                      id="new_value" 
                                      name="value" 
                                      rows="3"
                                      placeholder="Enter initial value"></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="new_type" class="form-label">Type <span class="text-danger">*</span></label>
                            <select class="form-select" id="new_type" name="type" required>
                                <option value="text">Text</option>
                                <option value="email">Email</option>
                                <option value="phone">Phone</option>
                                <option value="textarea">Textarea</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="ti ti-check me-1"></i> Add Setting
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div> --}}
@endsection

@push('scripts')
    <script>
        // Auto-dismiss alerts after 5 seconds
        setTimeout(function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 5000);
    </script>
@endpush
