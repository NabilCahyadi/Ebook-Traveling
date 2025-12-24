@extends('layouts.admin')

@section('title', __('admin.ebooks.create_new_ebook'))

@push('styles')
<link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5/43.0.0/ckeditor5.css" />
<style>
    .ck-editor__editable {
        min-height: 400px;
    }
    /* Category Badge Styles - Override Vuexy */
    .category-badge {
        display: inline-flex !important;
        align-items: center !important;
        padding: 0.5rem 0.75rem !important;
        margin: 0.25rem 0.25rem 0.25rem 0 !important;
        font-size: 0.875rem !important;
        font-weight: 500 !important;
        line-height: 1.5 !important;
        color: #7367f0 !important;
        background-color: #f8f7ff !important;
        border: 2px solid #7367f0 !important;
        border-radius: 0.5rem !important;
        box-shadow: 0 2px 6px rgba(115, 103, 240, 0.15) !important;
    }

    .remove-category {
        margin-left: 0.5rem !important;
        cursor: pointer !important;
        font-size: 1rem !important;
        line-height: 1 !important;
        opacity: 0.8 !important;
        color: #7367f0 !important;
    }
    
    .remove-category:hover {
        opacity: 1 !important;
    }
    
    #selected-categories {
        min-height: 20px !important;
    }

    #selected-categories .category-badge .remove-category:hover {
        opacity: 1 !important;
    }

    /* Creator Autocomplete Suggestions */
    #creator_suggestions {
        background-color: #fff;
        border: 1px solid #d9dee3;
        border-radius: 0.375rem;
        box-shadow: 0 0.25rem 0.5rem rgba(0, 0, 0, 0.1);
        margin-top: 0.25rem;
    }

    #creator_suggestions .list-group-item {
        background-color: #fff;
        border: none;
        border-bottom: 1px solid #f0f0f0;
        cursor: pointer;
        padding: 0.75rem 1rem;
    }

    #creator_suggestions .list-group-item:last-child {
        border-bottom: none;
    }

    #creator_suggestions .list-group-item:hover {
        background-color: #f8f9fa;
    }

    #creator_suggestions .list-group-item.text-muted,
    #creator_suggestions .list-group-item.text-danger {
        cursor: default;
    }
</style>
@endpush


@section('content')
    <!-- (form, left/right columns, preview, modal) -->
    <!-- I will keep your form exactly as before; only ids/classes matter to JS -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold py-3 mb-2"><span class="text-muted fw-light">{{ __('admin.menu.ebooks') }} /</span> {{ __('admin.ebooks.create_new_ebook') }}</h4>
        </div>
        <div>
            <a href="{{ route('admin.ebooks.index') }}" class="btn btn-secondary"><i class="ti ti-arrow-left me-1"></i>
                {{ __('admin.ebooks.back') }}</a>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Success!</strong> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Error!</strong> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Validation Error!</strong>
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <form action="{{ route('admin.ebooks.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <!-- Left Column - Main Information -->
            <div class="col-md-8">
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title mb-4">
                            <i class="ti ti-book"></i> {{ __('admin.ebooks.ebook_info') }}
                        </h5>

                        <div class="mb-3">
                            <label for="title" class="form-label">{{ __('admin.ebooks.title_field') }} <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" id="title"
                                name="title" value="{{ old('title') }}" placeholder="{{ __('admin.ebooks.title_placeholder') }}" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="creator_search" class="form-label">{{ __('admin.ebooks.creator') }} <span class="text-danger">*</span></label>
                            <input type="text" 
                                class="form-control @error('creator_id') is-invalid @enderror" 
                                id="creator_search" 
                                placeholder="{{ __('admin.ebooks.creator_search_placeholder') }}"
                                autocomplete="off">
                            <input type="hidden" name="creator_id" id="creator_id" value="{{ old('creator_id') }}">
                            
                            <!-- Autocomplete dropdown -->
                            <div id="creator_suggestions" class="list-group position-absolute w-100" style="z-index: 1000; display: none; max-height: 250px; overflow-y: auto;"></div>
                            
                            <!-- Selected creator display -->
                            <div id="selected_creator" class="mt-2"></div>
                            
                            @error('creator_id')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="category_selector" class="form-label">{{ __('admin.ebooks.category') }} <span
                                        class="text-danger">*</span></label>
                                <select class="form-select @error('category_ids') is-invalid @enderror" 
                                    id="category_selector">
                                    <option value="">{{ __('admin.ebooks.select_category') }}</option>
                                    @if (isset($categories))
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}" data-name="{{ $category->name }}">
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                                
                                <!-- Selected Categories Display -->
                                <div id="selected-categories" class="mt-2">
                                    <!-- Badges will appear here -->
                                </div>
                                
                                <!-- Hidden inputs for form submission -->
                                <div id="category-inputs"></div>
                                
                                @error('category_ids')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                                @error('category_ids.*')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="city_id" class="form-label">{{ __('admin.ebooks.city') }}</label>
                                <select class="form-select @error('city_id') is-invalid @enderror" id="city_id"
                                    name="city_id">
                                    <option value="">{{ __('admin.ebooks.select_city') }}</option>
                                    @if (isset($cities))
                                        @foreach ($cities as $city)
                                            <option value="{{ $city->id }}"
                                                {{ old('city_id') == $city->id ? 'selected' : '' }}>
                                                {{ $city->name }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                                @error('city_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">{{ __('admin.ebooks.description') }} <span
                                    class="text-danger">*</span></label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"
                                rows="5" placeholder="{{ __('admin.ebooks.description_placeholder') }}">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="status" class="form-label">{{ __('admin.ebooks.status') }} <span class="text-danger">*</span></label>
                                <select class="form-select @error('status') is-invalid @enderror" id="status"
                                    name="status" required>
                                    <option value="draft" {{ old('status', 'draft') == 'draft' ? 'selected' : '' }}>{{ __('admin.ebooks.draft') }}
                                    </option>
                                    <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>
                                        {{ __('admin.ebooks.published') }}</option>
                                    <option value="unpublished" {{ old('status') == 'unpublished' ? 'selected' : '' }}>
                                        {{ __('admin.ebooks.unpublished') }}</option>
                                    <option value="archived" {{ old('status') == 'archived' ? 'selected' : '' }}>{{ __('admin.ebooks.archived') }}
                                    </option>
                                </select>
                                <!-- <small class="text-muted">Admin dapat langsung publish tanpa approval</small> -->
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column -->
            <div class="col-md-4">
                <!-- Cover Image with Auto Crop -->
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title mb-3">
                            <i class="ti ti-photo"></i> {{ __('admin.ebooks.cover_image') }}
                        </h5>

                        <div class="mb-3">
                            <label class="form-label">{{ __('admin.ebooks.cover_image_ratio') }}</label>
                            <input type="file" class="form-control @error('cover_image') is-invalid @enderror"
                                id="coverImageInput" name="cover_image" accept="image/*">
                            <!-- <small class="text-muted">Rasio 1:1.6 (contoh: 650x965px). 
                                <strong>File besar akan otomatis dikompresi.</strong></small> -->
                            @error('cover_image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Preview Area -->
                        <div id="previewArea" style="display: none;" class="mt-3">
                            <label class="form-label">{{ __('admin.ebooks.preview') }}</label>
                            <div style="max-width: 200px;">
                                <img id="previewImage" src="" alt="Preview"
                                    style="width: 100%; border: 2px solid #ddd; border-radius: 8px;">
                            </div>
                            <button type="button" class="btn btn-sm btn-outline-secondary mt-2" onclick="resetCrop()">
                                <i class="ti ti-x me-1"></i> {{ __('admin.ebooks.remove') }}
                            </button>
                        </div>

                        <!-- Hidden input untuk menyimpan hasil crop -->
                        <input type="hidden" name="cover_image_cropped" id="croppedImageData">
                    </div>
                </div>

                <!-- File and submit same as original -->
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title mb-3">{{ __('admin.ebooks.pdf_file') }}</h5>
                        <div class="mb-0">
                            <input type="file" class="form-control @error('pdf_file') is-invalid @enderror"
                                id="pdf_file" name="pdf_file" accept=".pdf">
                            <small class="text-muted">{{ __('admin.ebooks.pdf_hint') }}</small>
                            <div id="pdfLoadingInfo" class="mt-2" style="display: none;">
                                <small class="text-info">
                                    <i class="ti ti-loader ti-spin me-1"></i> Membaca jumlah halaman...
                                </small>
                            </div>
                            <div id="pdfPageInfo" class="mt-2" style="display: none;">
                                <small class="text-success">
                                    <i class="ti ti-check-circle me-1"></i>
                                    <span id="pdfPageCount"></span> halaman terdeteksi
                                </small>
                            </div>
                            @error('pdf_file')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <button type="submit" class="btn btn-primary w-100 mb-2">
                            <i class="ti ti-check me-1"></i> {{ __('admin.ebooks.create_ebook') }}
                        </button>
                        <a href="{{ route('admin.ebooks.index') }}" class="btn btn-label-secondary w-100">
                            <i class="ti ti-x me-1"></i> {{ __('admin.ebooks.cancel') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </form>
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
        MediaEmbed,
        HorizontalLine,
        RemoveFormat,
        Undo,
        Image,
        ImageCaption,
        ImageStyle,
        ImageToolbar,
        ImageUpload,
        ImageResize,
        LinkImage,
        Base64UploadAdapter
    } from 'ckeditor5';

    let editorInstance;

    // Wait for DOM to be ready
    document.addEventListener('DOMContentLoaded', function() {
        ClassicEditor
            .create(document.querySelector('#description'), {
                plugins: [
                    Essentials, Bold, Italic, Underline, Strikethrough, Paragraph, Heading,
                    List, Link, BlockQuote, Alignment, Font, Indent, IndentBlock,
                    Table, TableToolbar, MediaEmbed, HorizontalLine, RemoveFormat, Undo,
                    Image, ImageCaption, ImageStyle, ImageToolbar, ImageUpload, ImageResize, LinkImage,
                    Base64UploadAdapter
                ],
                toolbar: [
                    'undo', 'redo', '|',
                    'heading', '|',
                    'bold', 'italic', 'underline', 'strikethrough', '|',
                    'fontSize', 'fontFamily', 'fontColor', 'fontBackgroundColor', '|',
                    'alignment', '|',
                    'bulletedList', 'numberedList', '|',
                    'outdent', 'indent', '|',
                    'link', 'uploadImage', 'blockQuote', 'insertTable', 'mediaEmbed', '|',
                    'horizontalLine', 'removeFormat'
                ],
                image: {
                    toolbar: [
                        'imageStyle:inline',
                        'imageStyle:block',
                        'imageStyle:side',
                        '|',
                        'toggleImageCaption',
                        'imageTextAlternative',
                        '|',
                        'linkImage'
                    ]
                },
                heading: {
                    options: [{
                            model: 'paragraph',
                            title: 'Paragraph',
                            class: 'ck-heading_paragraph'
                        },
                        {
                            model: 'heading1',
                            view: 'h1',
                            title: 'Heading 1',
                            class: 'ck-heading_heading1'
                        },
                        {
                            model: 'heading2',
                            view: 'h2',
                            title: 'Heading 2',
                            class: 'ck-heading_heading2'
                        },
                        {
                            model: 'heading3',
                            view: 'h3',
                            title: 'Heading 3',
                            class: 'ck-heading_heading3'
                        }
                    ]
                },
                table: {
                    contentToolbar: ['tableColumn', 'tableRow', 'mergeTableCells']
                }
            })
            .then(editor => {
                editorInstance = editor;
                console.log('Description editor initialized');

                // Sync editor content before form submit
                const form = document.querySelector('form');
                if (form) {
                    form.addEventListener('submit', function(e) {
                        e.preventDefault();
                        console.log('Form submit intercepted');
                        
                        const content = editor.getData();
                        console.log('Editor content:', content.substring(0, 100));
                        
                        document.querySelector('#description').value = content;
                        console.log('Content synced to textarea');
                        
                        // Submit form
                        setTimeout(() => {
                            form.submit();
                        }, 100);
                    });
                }
            })
            .catch(error => {
                console.error('Editor initialization error:', error);
            });
    });
</script>
@endpush

@push('scripts')
    <script>
        (function() {
            // Configuration untuk auto crop
            const CROP_CONFIG = {
                ratioWidth: 1,
                ratioHeight: 1.6,
                minWidth: 400,
                minHeight: 640,
                maxFileSize: 2 * 1024 * 1024, // 2MB
                outputWidth: 650,
                outputHeight: 1040, // 650 * 1.6
                quality: 0.90,
                outputFormat: 'image/jpeg'
            };

            const coverImageInput = document.getElementById('coverImageInput');
            const croppedImageData = document.getElementById('croppedImageData');
            const previewArea = document.getElementById('previewArea');
            const previewImage = document.getElementById('previewImage');

            if (!coverImageInput || !croppedImageData) {
                console.error('Required elements not found');
                return;
            }

            coverImageInput.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (!file) return;

                // Validate file size
                if (file.size > CROP_CONFIG.maxFileSize) {
                    alert('File terlalu besar. Maksimal 2MB.');
                    coverImageInput.value = '';
                    return;
                }

                // Validate file type
                if (!file.type.match('image.*')) {
                    alert('File harus berupa gambar (JPG, PNG, atau WEBP)');
                    coverImageInput.value = '';
                    return;
                }

                // Read and process image
                const reader = new FileReader();
                reader.onload = function(event) {
                    const img = new Image();
                    img.onload = function() {
                        autoCropImage(img);
                    };
                    img.src = event.target.result;
                };
                reader.readAsDataURL(file);
            });

            function autoCropImage(image) {
                const targetRatio = CROP_CONFIG.ratioWidth / CROP_CONFIG.ratioHeight;
                const sourceWidth = image.width;
                const sourceHeight = image.height;
                const sourceRatio = sourceWidth / sourceHeight;

                let cropWidth, cropHeight, cropX, cropY;

                if (sourceRatio > targetRatio) {
                    // Crop width (gambar terlalu lebar)
                    cropHeight = sourceHeight;
                    cropWidth = sourceHeight * targetRatio;
                    cropX = (sourceWidth - cropWidth) / 2;
                    cropY = 0;
                } else {
                    // Crop height (gambar terlalu tinggi)
                    cropWidth = sourceWidth;
                    cropHeight = sourceWidth / targetRatio;
                    cropX = 0;
                    cropY = (sourceHeight - cropHeight) / 2;
                }

                // TIDAK ada minimum size - gambar kecil akan diperbesar, besar akan dikompres
                // Semua akan di-resize ke 650x1040px

                // Create canvas
                const canvas = document.createElement('canvas');
                canvas.width = CROP_CONFIG.outputWidth;
                canvas.height = CROP_CONFIG.outputHeight;

                const ctx = canvas.getContext('2d');
                ctx.imageSmoothingEnabled = true;
                ctx.imageSmoothingQuality = 'high';

                // Draw cropped image
                ctx.drawImage(
                    image,
                    cropX, cropY, cropWidth, cropHeight,
                    0, 0, CROP_CONFIG.outputWidth, CROP_CONFIG.outputHeight
                );

                // Convert to base64
                canvas.toBlob(function(blob) {
                    const reader = new FileReader();
                    reader.onloadend = function() {
                        const base64Data = reader.result;
                        croppedImageData.value = base64Data;

                        // Show preview
                        previewImage.src = base64Data;
                        previewArea.style.display = 'block';

                        console.log('Image cropped and saved to hidden input');
                    };
                    reader.readAsDataURL(blob);
                }, CROP_CONFIG.outputFormat, CROP_CONFIG.quality);
            }

            // Reset function
            window.resetCrop = function() {
                coverImageInput.value = '';
                croppedImageData.value = '';
                previewArea.style.display = 'none';
            };

        })();
    </script>

    <!-- PDF validation script -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js"></script>
    <script>
        pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js';

        const pdfInput = document.getElementById('pdf_file');
        pdfInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (!file) return;

            if (file.type !== 'application/pdf') {
                alert('File harus berformat PDF');
                pdfInput.value = '';
                return;
            }

            if (file.size > 10 * 1024 * 1024) {
                alert('Ukuran file maksimal 10MB');
                pdfInput.value = '';
                return;
            }
        });

        
        // Category Selection Handler
        $(document).ready(function() {
            const selectedCategories = new Map();
            const categorySelector = $('#category_selector');
            const selectedContainer = $('#selected-categories');
            const inputsContainer = $('#category-inputs');
            
            // Load old values if validation failed
            @if(old('category_ids'))
                const oldCategories = @json(old('category_ids'));
                categorySelector.find('option').each(function() {
                    const optionValue = $(this).val();
                    const optionName = $(this).data('name');
                    if (oldCategories.includes(optionValue)) {
                        selectedCategories.set(optionValue, optionName);
                    }
                });
                updateDisplay();
            @endif
            
            // Handle category selection
            categorySelector.on('change', function() {
                const selectedValue = $(this).val();
                const selectedText = $(this).find('option:selected').data('name');
                
                if (selectedValue && !selectedCategories.has(selectedValue)) {
                    selectedCategories.set(selectedValue, selectedText);
                    updateDisplay();
                    $(this).val(''); // Reset selector
                }
            });
            
            // Update display and hidden inputs
            function updateDisplay() {
                // Clear existing badges
                selectedContainer.empty();
                inputsContainer.empty();
                
                // Create badges for each selected category
                selectedCategories.forEach((name, id) => {
                    // Create badge
                    const badge = $('<span class="category-badge"></span>');
                    badge.text(name);
                    
                    // Create remove button
                    const removeBtn = $('<span class="remove-category">&times;</span>');
                    removeBtn.on('click', function() {
                        selectedCategories.delete(id);
                        updateDisplay();
                    });
                    
                    badge.append(removeBtn);
                    selectedContainer.append(badge);
                    
                    // Create hidden input
                    const input = $('<input type="hidden" name="category_ids[]">');
                    input.val(id);
                    inputsContainer.append(input);
                });
            }
        });

        // Creator Autocomplete
        const creatorSearch = $('#creator_search');
        const creatorId = $('#creator_id');
        const creatorSuggestions = $('#creator_suggestions');
        const selectedCreatorDiv = $('#selected_creator');
        let searchTimeout;
        let allCreators = []; // Cache all creators

        // Load selected creator if edit mode
        @if(old('creator_id'))
            loadSelectedCreator('{{ old('creator_id') }}');
        @endif

        // Load all creators on focus
        creatorSearch.on('focus', function() {
            if (creatorId.val()) {
                // Already has selected creator, don't show list
                return;
            }
            
            if (allCreators.length > 0) {
                // Already loaded, show from cache
                displayCreators(allCreators);
            } else {
                // Load all creators
                loadAllCreators();
            }
        });

        // Search on input (from first character)
        creatorSearch.on('input', function() {
            const query = $(this).val().trim();
            
            clearTimeout(searchTimeout);
            
            if (query.length === 0) {
                // Show first 10 when input is empty
                loadAllCreators();
            } else {
                // Search from server when typing (even 1 character)
                searchTimeout = setTimeout(() => {
                    searchCreatorsFromServer(query);
                }, 300);
            }
        });
        
        function searchCreatorsFromServer(query) {
            creatorSuggestions.html('<div class="list-group-item text-muted"><i class="ti ti-loader ti-spin me-1"></i> Searching...</div>').show();
            
            $.ajax({
                url: '{{ route('admin.ebooks.search-creators') }}',
                method: 'GET',
                data: { q: query },
                success: function(data) {
                    displayCreators(data);
                },
                error: function() {
                    creatorSuggestions.html(
                        '<div class="list-group-item text-danger">Error searching creators</div>'
                    ).show();
                }
            });
        }

        function loadAllCreators() {
            creatorSuggestions.html('<div class="list-group-item text-muted"><i class="ti ti-loader ti-spin me-1"></i> Loading creators...</div>').show();
            
            $.ajax({
                url: '{{ route('admin.ebooks.search-creators') }}',
                method: 'GET',
                data: { q: '' }, // Empty query to get all
                success: function(data) {
                    allCreators = data;
                    displayCreators(data);
                },
                error: function() {
                    creatorSuggestions.html(
                        '<div class="list-group-item text-danger">Error loading creators</div>'
                    ).show();
                }
            });
        }

        function displayCreators(creators) {
            creatorSuggestions.empty();
            
            if (creators.length === 0) {
                creatorSuggestions.append(
                    '<div class="list-group-item text-muted">Tidak ada creator ditemukan</div>'
                );
            } else {
                creators.forEach(creator => {
                    const item = $('<a href="javascript:void(0)" class="list-group-item list-group-item-action"></a>');
                    item.html(`
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <strong>${creator.name}</strong>
                                <br><small class="text-muted">${creator.email}</small>
                            </div>
                        </div>
                    `);
                    item.on('click', function() {
                        selectCreator(creator);
                    });
                    creatorSuggestions.append(item);
                });
            }
            
            creatorSuggestions.show();
        }

        function selectCreator(creator) {
            creatorId.val(creator.id);
            creatorSearch.val('');
            creatorSuggestions.hide().empty();
            
            selectedCreatorDiv.html(`
                <div class="alert alert-info d-flex justify-content-between align-items-center py-2 mb-0">
                    <div>
                        <i class="ti ti-user me-1"></i>
                        <strong>${creator.name}</strong>
                        <br><small>${creator.email}</small>
                    </div>
                    <button type="button" class="btn btn-sm btn-outline-danger" onclick="clearCreator()">
                        <i class="ti ti-x"></i>
                    </button>
                </div>
            `);
        }

        function loadSelectedCreator(creatorId) {
            $.ajax({
                url: '{{ route('admin.ebooks.search-creators') }}',
                method: 'GET',
                data: { q: '' },
                success: function(data) {
                    const creator = data.find(c => c.id == creatorId);
                    if (creator) {
                        selectCreator(creator);
                    }
                }
            });
        }

        window.clearCreator = function() {
            creatorId.val('');
            creatorSearch.val('');
            selectedCreatorDiv.empty();
        };

        // Hide suggestions when clicking outside
        $(document).on('click', function(e) {
            if (!$(e.target).closest('#creator_search, #creator_suggestions').length) {
                creatorSuggestions.hide();
            }
        });
    </script>
@endpush
