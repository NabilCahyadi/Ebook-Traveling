@extends('layouts.admin')

@section('title', 'About Us Sections Management')

@push('styles')
<link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5/43.0.0/ckeditor5.css" />
<style>
    .nav-tabs {
        border-bottom: 2px solid #f0f2f5;
        margin-bottom: 0;
    }
    .nav-tabs .nav-link {
        color: #697a8d;
        border: none;
        padding: 1rem 1.5rem;
        font-weight: 500;
        border-radius: 0;
        background: transparent;
        transition: all 0.3s ease;
        position: relative;
    }
    .nav-tabs .nav-link:not(.active):hover {
        color: #FF4C61;
        background: rgba(255, 76, 97, 0.04);
    }
    .nav-tabs .nav-link.active {
        color: #ffffff !important;
        background: #FF4C61 !important;
        font-weight: 600;
        border-bottom: 3px solid #FF4C61;
    }
    .nav-tabs .nav-link.active::after {
        content: '';
        position: absolute;
        bottom: -2px;
        left: 0;
        right: 0;
        height: 3px;
        background: #FF4C61;
    }
    .nav-tabs .nav-link i {
        font-size: 1.1rem;
    }
    .card-header-tabs {
        margin: 0;
        padding: 0;
    }
    .form-label {
        font-weight: 600;
        color: #566a7f;
        margin-bottom: 0.5rem;
        font-size: 0.9375rem;
    }
    .form-control:focus {
        border-color: #FF4C61;
        box-shadow: 0 0 0 0.2rem rgba(255, 76, 97, 0.15);
    }
    .form-check-input:checked {
        background-color: #FF4C61;
        border-color: #FF4C61;
    }
    .form-check-input:focus {
        border-color: #FF4C61;
        box-shadow: 0 0 0 0.2rem rgba(255, 76, 97, 0.15);
    }
    .btn-primary {
        background-color: #FF4C61;
        border-color: #FF4C61;
    }
    .btn-primary:hover,
    .btn-primary:focus {
        background-color: #e6445a;
        border-color: #e6445a;
        box-shadow: 0 0.125rem 0.25rem rgba(255, 76, 97, 0.4);
    }
    .card-header.bg-light {
        background: linear-gradient(135deg, rgba(255, 76, 97, 0.08) 0%, rgba(255, 76, 97, 0.03) 100%) !important;
        border-bottom: 2px solid rgba(255, 76, 97, 0.2);
        padding: 0.875rem 1.25rem;
    }
    .card-header.bg-light h6 {
        color: #FF4C61;
    }
    .card.border {
        border-color: rgba(255, 76, 97, 0.15) !important;
    }
    .image-preview {
        border: 2px dashed #e7e7e7;
        border-radius: 0.375rem;
        padding: 0.5rem;
        background: #fafafa;
        transition: all 0.3s ease;
    }
    .image-preview:hover {
        border-color: #FF4C61;
        background: rgba(255, 76, 97, 0.02);
    }
    .ck-editor__editable {
        min-height: 300px;
        max-height: 500px;
    }
</style>
@endpush

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Success/Error Messages -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Success!</strong> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Error!</strong> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Page Header -->
        <div class="mb-4">
            <h4 class="fw-bold mb-1">
                <span class="text-muted fw-light">Website Management /</span> About Us Sections
            </h4>
            <p class="text-muted mb-0">Kelola konten section pada halaman About Us</p>
        </div>

        <!-- Tabs Navigation -->
        <div class="card shadow-sm">
            <div class="card-header p-0 bg-white">
                <ul class="nav nav-tabs card-header-tabs mb-0" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link {{ $activeTab === 'welcome' ? 'active' : '' }}" 
                           href="{{ route('admin.about-us-sections.index', ['tab' => 'welcome']) }}">
                            <i class="ti ti-home me-2"></i> Welcome
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ $activeTab === 'performance' ? 'active' : '' }}" 
                           href="{{ route('admin.about-us-sections.index', ['tab' => 'performance']) }}">
                            <i class="ti ti-chart-bar me-2"></i> Performance
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ $activeTab === 'about_details' ? 'active' : '' }}" 
                           href="{{ route('admin.about-us-sections.index', ['tab' => 'about_details']) }}">
                            <i class="ti ti-list-details me-2"></i> About Details
                        </a>
                    </li>
                </ul>
            </div>
            <div class="card-body p-4">
                @if(isset($sections[$activeTab]))
                    @php $section = $sections[$activeTab]; @endphp
                    
                    <!-- Section Edit Form -->
                    <form action="{{ route('admin.about-us-sections.update', $activeTab) }}" method="POST" enctype="multipart/form-data" id="sectionForm">
                        @csrf
                        @method('PUT')

                        <div class="row g-4">
                            <div class="col-lg-8">
                                <!-- Title -->
                                <div class="mb-3">
                                    <label for="title" class="form-label">Judul Section <span class="text-danger">*</span></label>
                                    <input type="text" 
                                           class="form-control @error('title') is-invalid @enderror" 
                                           id="title" 
                                           name="title" 
                                           value="{{ old('title', $section->title) }}" 
                                           required>
                                    @error('title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                @if($activeTab === 'about_details')
                                    <!-- About Details - 3 Columns -->
                                    @php 
                                        $details = json_decode($section->content, true) ?? [
                                            ['title' => '', 'description' => ''],
                                            ['title' => '', 'description' => ''],
                                            ['title' => '', 'description' => '']
                                        ];
                                    @endphp
                                    
                                    <div class="alert alert-info d-flex align-items-center mb-4" role="alert">
                                        <i class="ti ti-info-circle me-2" style="font-size: 1.5rem;"></i>
                                        <div>
                                            <strong>Informasi:</strong> Section ini menampilkan 3 kolom informasi di halaman About Us.
                                        </div>
                                    </div>

                                    @foreach($details as $index => $detail)
                                        <div class="card mb-3 border-0 shadow-sm">
                                            <div class="card-header" style="background: linear-gradient(135deg, rgba(255, 76, 97, 0.1) 0%, rgba(255, 76, 97, 0.05) 100%); border-bottom: 2px solid #FF4C61;">
                                                <h6 class="mb-0 fw-semibold" style="color: #FF4C61;">
                                                    <i class="ti ti-layout-columns me-2"></i>Kolom {{ $index + 1 }}
                                                </h6>
                                            </div>
                                            <div class="card-body p-4">
                                                <div class="mb-3">
                                                    <label class="form-label">Judul <span class="text-danger">*</span></label>
                                                    <input type="text" 
                                                           class="form-control @error('details.'.$index.'.title') is-invalid @enderror" 
                                                           name="details[{{ $index }}][title]" 
                                                           value="{{ old('details.'.$index.'.title', $detail['title'] ?? '') }}" 
                                                           placeholder="Contoh: Who we are"
                                                           required>
                                                    @error('details.'.$index.'.title')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="mb-0">
                                                    <label class="form-label">Deskripsi <span class="text-danger">*</span></label>
                                                    <textarea class="form-control @error('details.'.$index.'.description') is-invalid @enderror" 
                                                              name="details[{{ $index }}][description]" 
                                                              rows="4" 
                                                              placeholder="Masukkan deskripsi untuk kolom ini..."
                                                              required>{{ old('details.'.$index.'.description', $detail['description'] ?? '') }}</textarea>
                                                    @error('details.'.$index.'.description')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <!-- Content (with HTML support) -->
                                    <div class="mb-0">
                                        <label for="content" class="form-label">Konten <span class="text-danger">*</span></label>
                                        <textarea class="form-control @error('content') is-invalid @enderror" 
                                                  id="content" 
                                                  name="content" 
                                                  rows="8" 
                                                  required>{{ old('content', $section->content) }}</textarea>
                                        @error('content')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="form-text text-muted d-block mt-2">
                                            <i class="ti ti-info-circle me-1"></i>
                                            Editor mendukung format HTML lengkap
                                        </small>
                                    </div>
                                @endif
                            </div>

                            <div class="col-lg-4">
                                <!-- Status -->
                                <div class="card border-0 shadow-sm mb-3">
                                    <div class="card-header bg-light">
                                        <h6 class="mb-0 fw-semibold">
                                            <i class="ti ti-toggle-left me-2"></i>Status Section
                                        </h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-check form-switch mb-0 mt-3">
                                            <input class="form-check-input" 
                                                   type="checkbox" 
                                                   id="is_active" 
                                                   name="is_active" 
                                                   value="1"
                                                   style="width: 3rem; height: 1.5rem;"
                                                   {{ old('is_active', $section->is_active) ? 'checked' : '' }}>
                                            <label class="form-check-label ms-2" for="is_active">
                                                <span class="fw-semibold">Aktif</span>
                                                <small class="d-block text-muted">Tampilkan di website</small>
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                @if(in_array($activeTab, ['welcome', 'performance']))
                                    <!-- Image Upload -->
                                    <div class="card border-0 shadow-sm mb-3">
                                        <div class="card-header bg-light">
                                            <h6 class="mb-0 fw-semibold">
                                                <i class="ti ti-photo me-2"></i>Gambar Section
                                            </h6>
                                        </div>
                                        <div class="card-body">
                                            @if($section->image)
                                                <div class="mb-3 mt-3">
                                                    <label class="form-label fw-semibold text-muted small">Preview Saat Ini</label>
                                                    <div class="image-preview text-center" style="aspect-ratio: 12/8; overflow: hidden;">
                                                        <img src="{{ asset($section->image) }}" 
                                                             alt="{{ $section->title }}" 
                                                             class="img-fluid rounded" 
                                                             style="width: 100%; height: 100%; object-fit: cover;">
                                                    </div>
                                                </div>
                                            @endif

                                            <div class="mb-0 mt-3">
                                                <label for="image" class="form-label fw-semibold">
                                                    <i class="ti ti-upload me-1"></i>
                                                    {{ $section->image ? 'Ganti Gambar' : 'Upload Gambar' }}
                                                </label>
                                                <input type="file" 
                                                       class="form-control @error('image') is-invalid @enderror" 
                                                       id="image" 
                                                       name="image" 
                                                       accept="image/*">
                                                @error('image')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                                <small class="form-text text-muted d-block mt-1">
                                                    <i class="ti ti-info-circle me-1"></i>
                                                    JPEG, PNG, JPG, GIF, WEBP • Max 2MB
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                <!-- Section Info -->
                                <div class="card border-0 shadow-sm">
                                    <div class="card-header bg-light">
                                        <h6 class="mb-0 fw-semibold">
                                            <i class="ti ti-info-circle me-2"></i>Informasi Section
                                        </h6>
                                    </div>
                                    <div class="card-body pt-3">
                                        <div class="mb-3 pb-3 border-bottom">
                                            <small class="text-muted d-block mb-1">Section Key</small>
                                            <code class="px-2 py-1 bg-light rounded">{{ $section->section_key }}</code>
                                        </div>
                                        <div class="mb-3 pb-3 border-bottom">
                                            <small class="text-muted d-block mb-1">Layout Type</small>
                                            <span class="badge bg-label-secondary">{{ $section->layout_type }}</span>
                                        </div>
                                        <div class="mb-3 pb-3 border-bottom">
                                            <small class="text-muted d-block mb-1">Urutan Tampil</small>
                                            <span class="fw-semibold">#{{ $section->order_index }}</span>
                                        </div>
                                        <div class="mb-0">
                                            <small class="text-muted d-block mb-1">
                                                <i class="ti ti-clock me-1"></i>Terakhir Diupdate
                                            </small>
                                            <span class="small">{{ $section->updated_at ? $section->updated_at->format('d M Y, H:i') : '-' }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="row">
                            <div class="col-12">
                                <div class="d-flex justify-content-between align-items-center pt-4 border-top">
                                    <a href="{{ route('admin.about-us.index') }}" class="btn btn-label-secondary">
                                        <i class="ti ti-arrow-left me-1"></i> Kembali ke Benefits
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="ti ti-device-floppy me-1"></i> Simpan Perubahan
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                @else
                    <div class="text-center py-5">
                        <div class="mb-4">
                            <i class="ti ti-alert-circle" style="font-size: 4rem; color: #FF4C61; opacity: 0.5;"></i>
                        </div>
                        <h5 class="mb-2">Section Tidak Ditemukan</h5>
                        <p class="text-muted mb-0">Section "{{ $activeTab }}" tidak ditemukan di database.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script type="importmap">
    {
        "imports": {
            "ckeditor5": "https://cdn.ckeditor.com/ckeditor5/43.0.0/ckeditor5.js",
            "ckeditor5/": "https://cdn.ckeditor.com/ckeditor5/43.0.0/"
        }
    }
</script>
<script type="module">
    import {
        ClassicEditor,
        Essentials,
        Bold,
        Italic,
        Underline,
        Strikethrough,
        Paragraph,
        Heading,
        List,
        Link,
        BlockQuote,
        Alignment,
        Font,
        Indent,
        IndentBlock,
        Table,
        TableToolbar,
        HorizontalLine,
        RemoveFormat,
        Undo
    } from 'ckeditor5';

    let editorInstance;

    // Only initialize editor if content textarea exists (not for about_details)
    const contentTextarea = document.querySelector('#content');
    if (contentTextarea) {
        ClassicEditor
            .create(contentTextarea, {
                plugins: [
                    Essentials, Bold, Italic, Underline, Strikethrough, Paragraph, Heading,
                    List, Link, BlockQuote, Alignment, Font, Indent, IndentBlock,
                    Table, TableToolbar, HorizontalLine, RemoveFormat, Undo
                ],
                toolbar: [
                    'undo', 'redo', '|',
                    'heading', '|',
                    'bold', 'italic', 'underline', 'strikethrough', '|',
                    'fontSize', 'fontFamily', 'fontColor', '|',
                    'alignment', '|',
                    'bulletedList', 'numberedList', '|',
                    'outdent', 'indent', '|',
                    'link', 'blockQuote', 'insertTable', '|',
                    'horizontalLine', 'removeFormat'
                ],
                heading: {
                    options: [
                        { model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph' },
                        { model: 'heading1', view: 'h1', title: 'Heading 1', class: 'ck-heading_heading1' },
                        { model: 'heading2', view: 'h2', title: 'Heading 2', class: 'ck-heading_heading2' },
                        { model: 'heading3', view: 'h3', title: 'Heading 3', class: 'ck-heading_heading3' }
                    ]
                },
                table: {
                    contentToolbar: ['tableColumn', 'tableRow', 'mergeTableCells']
                }
            })
            .then(editor => {
                editorInstance = editor;
                console.log('CKEditor initialized successfully');

                // Sync editor content before form submit
                const form = document.getElementById('sectionForm');
                if (form) {
                    form.addEventListener('submit', function(e) {
                        const content = editor.getData();
                        contentTextarea.value = content;
                        console.log('Content synced to textarea');
                    });
                }
            })
            .catch(error => {
                console.error('CKEditor initialization error:', error);
            });
    }
</script>
@endpush
