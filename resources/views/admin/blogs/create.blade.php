@extends('layouts.admin')

@section('title', __('admin.blogs.create'))

@push('styles')
    <link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5/43.0.0/ckeditor5.css" />
    <link href="https://cdn.jsdelivr.net/npm/@yaireo/tagify/dist/tagify.css" rel="stylesheet" type="text/css" />
    <style>
        .ck-editor__editable {
            min-height: 500px;
        }
        
        /* Author Autocomplete Suggestions */
        #author_suggestions {
            background-color: #fff;
            border: 1px solid #d9dee3;
            border-radius: 0.375rem;
            box-shadow: 0 0.25rem 0.5rem rgba(0, 0, 0, 0.1);
            margin-top: 0.25rem;
        }

        #author_suggestions .list-group-item {
            background-color: #fff;
            border: none;
            border-bottom: 1px solid #f0f0f0;
            cursor: pointer;
            padding: 0.75rem 1rem;
        }

        #author_suggestions .list-group-item:last-child {
            border-bottom: none;
        }

        #author_suggestions .list-group-item:hover {
            background-color: #f8f9fa;
        }

        #author_suggestions .list-group-item.text-muted,
        #author_suggestions .list-group-item.text-danger {
            cursor: default;
        }
        
        /* Category Badges */
        #selected-categories .category-badge {
            display: inline-block;
            margin-right: 0.5rem;
            margin-bottom: 0.5rem;
        }
        
        #selected-categories .category-badge .remove-category:hover {
            color: #d32f2f;
        }
    </style>
@endpush

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold py-3 mb-0">
                <span class="text-muted fw-light">Admin / Blogs /</span> {{ __('admin.blogs.create_new') }}
            </h4>
            <a href="{{ route('admin.blogs.index') }}" class="btn" style="background-color: #ea5455; color: white;">
                <i class="bx bx-arrow-back me-1"></i> {{ __('admin.blogs.back') }}
            </a>
        </div>

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <form id="blogForm" action="{{ route('admin.blogs.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row">
                <div class="col-lg-8">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0">{{ __('admin.blogs.blog_content') }}</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label" for="title">{{ __('admin.blogs.blog_title') }} <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('title') is-invalid @enderror"
                                    id="title" name="title" value="{{ old('title') }}" placeholder="{{ __('admin.blogs.enter_title') }}"
                                    required>
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="content">{{ __('admin.blogs.content') }} <span class="text-danger">*</span></label>
                                <textarea class="form-control @error('content') is-invalid @enderror" id="content" name="content" rows="20">{{ old('content') }}</textarea>
                                @error('content')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="excerpt">{{ __('admin.blogs.excerpt') }}</label>
                                <textarea class="form-control @error('excerpt') is-invalid @enderror" id="excerpt" name="excerpt" rows="3"
                                    placeholder="{{ __('admin.blogs.excerpt_placeholder') }}">{{ old('excerpt') }}</textarea>
                                @error('excerpt')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">{{ __('admin.blogs.excerpt_help') }}</div>
                            </div>

                            <!-- Tags Input -->
                            <div class="mb-3">
                                <label class="form-label" for="tags">{{ __('admin.blogs.tags') }} <span class="text-muted">({{ __('admin.common.optional') }})</span></label>
                                <input type="text" 
                                    class="form-control @error('tags') is-invalid @enderror" 
                                    id="tags" 
                                    name="tags" 
                                    value="{{ old('tags') }}"
                                    placeholder="{{ __('admin.blogs.tags_placeholder') }}"
                                    data-role="tagsinput">
                                @error('tags')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">{{ __('admin.blogs.tags_help') }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0">{{ __('admin.blogs.publish') }}</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label" for="author_search">{{ __('admin.blogs.author') }} <span class="text-muted">({{ __('admin.common.optional') }})</span></label>
                                <input type="text" 
                                    class="form-control @error('author_id') is-invalid @enderror" 
                                    id="author_search" 
                                    placeholder="{{ __('admin.blogs.search_author_placeholder') }}"
                                    autocomplete="off">
                                <input type="hidden" name="author_id" id="author_id" value="{{ old('author_id') }}">
                                
                                <!-- Autocomplete dropdown -->
                                <div id="author_suggestions" class="list-group position-absolute w-100" style="z-index: 1000; display: none; max-height: 250px; overflow-y: auto;"></div>
                                
                                <!-- Selected author display -->
                                <div id="selected_author" class="mt-2"></div>
                                
                                @error('author_id')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                                <div class="form-text text-info">
                                    <i class="ti ti-info-circle me-1"></i>
                                    {!! __('admin.blogs.leave_empty_for_team') !!}
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label" for="status">{{ __('admin.blogs.status') }} <span class="text-danger">*</span></label>
                                <select class="form-select @error('status') is-invalid @enderror" id="status"
                                    name="status" required>
                                    <option value="draft" {{ old('status', 'draft') == 'draft' ? 'selected' : '' }}>{{ __('admin.blogs.draft') }}
                                    </option>
                                    <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>
                                        {{ __('admin.blogs.published') }}</option>
                                    <option value="scheduled" {{ old('status') == 'scheduled' ? 'selected' : '' }}>
                                        <i class="ti ti-clock"></i> Scheduled</option>
                                    <option value="unpublished" {{ old('status') == 'unpublished' ? 'selected' : '' }}>
                                        {{ __('admin.blogs.unpublished') }}</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">{{ __('admin.blogs.set_blog_status') }}</div>
                            </div>

                            <!-- Scheduled Publishing Date/Time -->
                            <div class="mb-3" id="scheduledDateContainer" style="display: none;">
                                <label class="form-label" for="published_at"><i class="ti ti-calendar-time me-1"></i> Publish Date & Time <span class="text-danger">*</span></label>
                                <input type="datetime-local" class="form-control @error('published_at') is-invalid @enderror" 
                                    id="published_at" name="published_at" 
                                    value="{{ old('published_at') }}"
                                    min="{{ now()->format('Y-m-d\TH:i') }}">
                                @error('published_at')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Set the date and time when this blog will be automatically published</div>
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bx bx-save me-1"></i> {{ __('admin.blogs.create_blog') }}
                                </button>
                                <a href="{{ route('admin.blogs.index') }}" class="btn" style="background-color: #ea5455; color: white;">
                                    {{ __('admin.blogs.cancel') }}
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0">{{ __('admin.blogs.featured_image') }}</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <input type="file" class="form-control @error('featured_image') is-invalid @enderror"
                                    id="featured_image" name="featured_image" accept="image/*">
                                @error('featured_image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div id="imagePreview" class="mt-2" style="display: none; width: 100%; height: 500px; border: 2px solid #d9dee3; border-radius: 8px; overflow: hidden; padding: 10px; background-color: #f8f9fa;">
                                <img src="" alt="Preview" style="width: 100%; height: 100%; object-fit: contain;">
                            </div>
                        </div>
                    </div>

                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0">{{ __('admin.blogs.category') }}</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label" for="category_selector">{{ __('admin.blogs.blog_category') }}</label>
                                <select class="form-select @error('categories') is-invalid @enderror" 
                                    id="category_selector">
                                    <option value="">{{ __('admin.blogs.select_category') }}</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" data-name="{{ $category->name }}">
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                
                                <!-- Selected Categories Display -->
                                <div id="selected-categories" class="mt-2">
                                    <!-- Badges will appear here -->
                                </div>
                                
                                @error('categories')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                                <div class="form-text">
                                    {{ __('admin.blogs.select_category_text') }}
                                    <a href="{{ route('admin.blog-categories.create') }}" target="_blank">{{ __('admin.blogs.add_new_category') }}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- SEO Section - Full Width Below -->
            <div class="row">
                <div class="col-12">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0"><i class="bx bx-search-alt me-2"></i>{{ __('admin.blogs.seo_settings') }}</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label class="form-label" for="meta_title">{{ __('admin.blogs.meta_title') }}</label>
                                    <input type="text" 
                                        class="form-control @error('meta_title') is-invalid @enderror" 
                                        id="meta_title" 
                                        name="meta_title" 
                                        value="{{ old('meta_title') }}"
                                        maxlength="500"
                                        placeholder="{{ __('admin.blogs.meta_title_placeholder') }}">
                                    @error('meta_title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">
                                        <span id="meta_title_count">0</span>/500 {{ __('admin.blogs.meta_title_count') }}
                                    </div>
                                </div>
                                
                                <div class="col-md-12 mb-3">
                                    <label class="form-label" for="meta_description">{{ __('admin.blogs.meta_description') }}</label>
                                    <textarea 
                                        class="form-control @error('meta_description') is-invalid @enderror" 
                                        id="meta_description" 
                                        name="meta_description" 
                                        rows="3"
                                        maxlength="1000"
                                        placeholder="{{ __('admin.blogs.meta_description_placeholder') }}">{{ old('meta_description') }}</textarea>
                                    @error('meta_description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">
                                        <span id="meta_description_count">0</span>/1000 {{ __('admin.blogs.meta_description_count') }}
                                    </div>
                                </div>
                                
                                <div class="col-md-12 mb-3">
                                    <label class="form-label" for="meta_keywords">{{ __('admin.blogs.meta_keywords') }}</label>
                                    <input type="text" 
                                        class="form-control @error('meta_keywords') is-invalid @enderror" 
                                        id="meta_keywords" 
                                        name="meta_keywords" 
                                        value="{{ old('meta_keywords') }}"
                                        maxlength="500"
                                        placeholder="{{ __('admin.blogs.meta_keywords_placeholder') }}">
                                    @error('meta_keywords')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">
                                        <span id="meta_keywords_count">0</span>/500 {{ __('admin.blogs.meta_keywords_count') }}
                                    </div>
                                </div>
                            </div>
                            
                            <div class="alert alert-info mb-0">
                                <i class="bx bx-info-circle me-2"></i>
                                <strong>{{ __('admin.blogs.seo_tips') }}</strong>
                                <ul class="mb-0 mt-2">
                                    <li>{{ __('admin.blogs.seo_tip_1') }}</li>
                                    <li>{{ __('admin.blogs.seo_tip_2') }}</li>
                                    <li>{{ __('admin.blogs.seo_tip_3') }}</li>
                                    <li>{{ __('admin.blogs.seo_tip_4') }}</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Related Ebooks Section - Full Width Below -->
            <div class="row">
                <div class="col-12">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0">{{ __('admin.blogs.related_ebooks') }}</h5>
                        </div>
                        <div class="card-body">
                            <!-- Filters -->
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label class="form-label">{{ __('admin.blogs.search') }}</label>
                                    <input type="text" 
                                        class="form-control" 
                                        id="ebook_search" 
                                        placeholder="{{ __('admin.blogs.search_ebooks') }}">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">{{ __('admin.blogs.filter_by_city') }}</label>
                                    <select class="form-select" id="city_filter">
                                        <option value="">{{ __('admin.blogs.all_cities') }}</option>
                                        @foreach($cities as $city)
                                            <option value="{{ $city->id }}">{{ $city->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">{{ __('admin.blogs.filter_by_category') }}</label>
                                    <select class="form-select" id="category_filter">
                                        <option value="">{{ __('admin.blogs.all_categories') }}</option>
                                        @foreach($ebookCategories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            
                            <!-- Ebooks Table -->
                            <div class="table-responsive" style="max-height: 500px; overflow-y: auto;">
                                <table class="table table-hover">
                                    <thead style="background-color: #fff; position: sticky; top: 0; z-index: 10;">
                                        <tr>
                                            <th style="width: 50px;">
                                                <input type="checkbox" class="form-check-input" id="select_all">
                                            </th>
                                            <th style="width: 100px;">{{ __('admin.blogs.cover') }}</th>
                                            <th>{{ __('admin.blogs.title') }}</th>
                                            <th style="width: 150px;">{{ __('admin.blogs.creator') }}</th>
                                            <th style="width: 150px;">{{ __('admin.blogs.city') }}</th>
                                            <th style="width: 200px;">{{ __('admin.blogs.categories') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody id="ebooks_table_body">
                                        @if($ebooks->count() > 0)
                                            @foreach($ebooks as $ebook)
                                                <tr class="ebook-row" 
                                                    data-city="{{ $ebook->city_id ?? '' }}" 
                                                    data-category="{{ $ebook->categories->pluck('id')->join(',') }}"
                                                    data-title="{{ strtolower($ebook->title) }}"
                                                    style="cursor: pointer;">
                                                    <td onclick="event.stopPropagation();">
                                                        <input class="form-check-input ebook-checkbox" 
                                                            type="checkbox" 
                                                            name="related_ebooks[]" 
                                                            value="{{ $ebook->id }}"
                                                            {{ in_array($ebook->id, old('related_ebooks', [])) ? 'checked' : '' }}>
                                                    </td>
                                                    <td>
                                                        <img src="{{ $ebook->cover_image_url }}" 
                                                            alt="{{ $ebook->title }}" 
                                                            class="img-thumbnail"
                                                            style="width: 70px; height: 100px; object-fit: cover;"
                                                            onerror="this.src='{{ asset('images/no-cover.png') }}'">
                                                    </td>
                                                    <td>{{ $ebook->title }}</td>
                                                    <td>
                                                        <span class="badge bg-label-success">
                                                            {{ $ebook->creator->name ?? 'N/A' }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <span class="badge bg-label-info">
                                                            {{ $ebook->city->name ?? 'N/A' }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        @if($ebook->categories->count() > 0)
                                                            @foreach($ebook->categories as $cat)
                                                                <span class="badge bg-label-primary me-1">{{ $cat->name }}</span>
                                                            @endforeach
                                                        @else
                                                            <span class="badge bg-label-secondary">N/A</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="6" class="text-center text-muted">{{ __('admin.blogs.no_ebooks_available') }}</td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                            
                            @error('related_ebooks')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                            <div class="form-text mt-2">
                                <span id="selected_count">0</span> {{ __('admin.blogs.ebooks_selected') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>

        @push('scripts')
        <script>
            // Filter and search functionality
            function filterEbooks() {
                const searchText = document.getElementById('ebook_search').value.toLowerCase();
                const cityFilter = document.getElementById('city_filter').value;
                const categoryFilter = document.getElementById('category_filter').value;
                const rows = document.querySelectorAll('.ebook-row');
                
                rows.forEach(row => {
                    const title = row.dataset.title;
                    const city = row.dataset.city;
                    const categories = row.dataset.category.split(',');
                    
                    let showRow = true;
                    
                    // Search filter
                    if (searchText && !title.includes(searchText)) {
                        showRow = false;
                    }
                    
                    // City filter
                    if (cityFilter && city !== cityFilter) {
                        showRow = false;
                    }
                    
                    // Category filter - check if any category matches
                    if (categoryFilter && !categories.includes(categoryFilter)) {
                        showRow = false;
                    }
                    
                    row.style.display = showRow ? '' : 'none';
                });
                
                updateSelectedCount();
            }
            
            // Update selected count
            function updateSelectedCount() {
                const visibleChecked = document.querySelectorAll('.ebook-row:not([style*="display: none"]) .ebook-checkbox:checked');
                document.getElementById('selected_count').textContent = visibleChecked.length;
            }
            
            // Select all functionality
            document.getElementById('select_all').addEventListener('change', function() {
                const visibleCheckboxes = document.querySelectorAll('.ebook-row:not([style*="display: none"]) .ebook-checkbox');
                visibleCheckboxes.forEach(cb => cb.checked = this.checked);
                updateSelectedCount();
            });
            
            // Individual checkbox change
            document.querySelectorAll('.ebook-checkbox').forEach(cb => {
                cb.addEventListener('change', updateSelectedCount);
            });
            
            // Click row to toggle checkbox
            document.querySelectorAll('.ebook-row').forEach(row => {
                row.addEventListener('click', function(e) {
                    // Don't toggle if clicking on checkbox itself
                    if (e.target.type !== 'checkbox') {
                        const checkbox = this.querySelector('.ebook-checkbox');
                        checkbox.checked = !checkbox.checked;
                        updateSelectedCount();
                    }
                });
            });
            
            // Attach filter event listeners
            document.getElementById('ebook_search').addEventListener('keyup', filterEbooks);
            document.getElementById('city_filter').addEventListener('change', filterEbooks);
            document.getElementById('category_filter').addEventListener('change', filterEbooks);
            
            // Initial count
            updateSelectedCount();
        </script>
        @endpush
    </div>

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
                    .create(document.querySelector('#content'), {
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
                        console.log('Editor initialized successfully');

                        // Sync editor content before form submit
                        const form = document.getElementById('blogForm');
                        if (form) {
                            form.addEventListener('submit', function(e) {
                                console.log('Form submit event triggered');
                                const content = editor.getData();
                                console.log('Editor content length:', content.length);
                                document.querySelector('#content').value = content;
                                console.log('Content synced to textarea');
                                // Let form submit naturally
                            });
                            console.log('Form submit listener attached');
                        } else {
                            console.error('Form not found!');
                        }
                    })
                    .catch(error => {
                        console.error('Editor initialization error:', error);
                    });
            });
        </script>
        <script>
            // Debug: Check if form exists
            document.addEventListener('DOMContentLoaded', function() {
                const form = document.getElementById('blogForm');
                console.log('Form found:', form ? 'Yes' : 'No');
                if (form) {
                    console.log('Form action:', form.action);
                    console.log('Form method:', form.method);
                }
            });

            // Image preview
            document.getElementById('featured_image').addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const preview = document.getElementById('imagePreview');
                        preview.querySelector('img').src = e.target.result;
                        preview.style.display = 'block';
                    }
                    reader.readAsDataURL(file);
                }
            });

            // Author Autocomplete
            const authorSearch = $('#author_search');
            const authorId = $('#author_id');
            const authorSuggestions = $('#author_suggestions');
            const selectedAuthorDiv = $('#selected_author');
            let searchTimeout;
            let allAuthors = [];

            // Load selected author if edit mode
            @if(old('author_id'))
                loadSelectedAuthor('{{ old('author_id') }}');
            @endif

            // Load all authors on focus
            authorSearch.on('focus', function() {
                if (authorId.val()) {
                    return;
                }
                
                if (allAuthors.length > 0) {
                    displayAuthors(allAuthors);
                } else {
                    loadAllAuthors();
                }
            });

            // Search on input
            authorSearch.on('input', function() {
                const query = $(this).val().trim();
                
                clearTimeout(searchTimeout);
                
                if (query.length === 0) {
                    loadAllAuthors();
                } else {
                    searchTimeout = setTimeout(() => {
                        searchAuthorsFromServer(query);
                    }, 300);
                }
            });
            
            function searchAuthorsFromServer(query) {
                authorSuggestions.html('<div class="list-group-item text-muted"><i class="bx bx-loader-alt bx-spin me-1"></i> Searching...</div>').show();
                
                $.ajax({
                    url: '{{ route('admin.blogs.search-authors') }}',
                    method: 'GET',
                    data: { q: query },
                    success: function(data) {
                        displayAuthors(data);
                    },
                    error: function() {
                        authorSuggestions.html(
                            '<div class="list-group-item text-danger">Error searching authors</div>'
                        ).show();
                    }
                });
            }

            function loadAllAuthors() {
                authorSuggestions.html('<div class="list-group-item text-muted"><i class="bx bx-loader-alt bx-spin me-1"></i> Loading authors...</div>').show();
                
                $.ajax({
                    url: '{{ route('admin.blogs.search-authors') }}',
                    method: 'GET',
                    data: { q: '' },
                    success: function(data) {
                        allAuthors = data;
                        displayAuthors(data);
                    },
                    error: function() {
                        authorSuggestions.html(
                            '<div class="list-group-item text-danger">Error loading authors</div>'
                        ).show();
                    }
                });
            }

            function displayAuthors(authors) {
                authorSuggestions.empty();
                
                if (authors.length === 0) {
                    authorSuggestions.append(
                        '<div class="list-group-item text-muted">No authors found</div>'
                    );
                } else {
                    authors.forEach(author => {
                        const item = $('<a href="javascript:void(0)" class="list-group-item list-group-item-action"></a>');
                        item.html(`
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <strong>${author.name}</strong>
                                    <br><small class="text-muted">${author.email}</small>
                                </div>
                            </div>
                        `);
                        item.on('click', function() {
                            selectAuthor(author);
                        });
                        authorSuggestions.append(item);
                    });
                }
                
                authorSuggestions.show();
            }

            function selectAuthor(author) {
                authorId.val(author.id);
                authorSearch.val('');
                authorSuggestions.hide().empty();
                
                selectedAuthorDiv.html(`
                    <div class="alert alert-info d-flex justify-content-between align-items-center py-2 mb-0">
                        <div>
                            <i class="bx bx-user me-1"></i>
                            <strong>${author.name}</strong>
                            <br><small>${author.email}</small>
                        </div>
                        <button type="button" class="btn btn-sm btn-outline-danger" onclick="clearAuthor()">
                            <i class="bx bx-x"></i>
                        </button>
                    </div>
                `);
            }

            function loadSelectedAuthor(authorId) {
                $.ajax({
                    url: '{{ route('admin.blogs.search-authors') }}',
                    method: 'GET',
                    data: { q: '' },
                    success: function(data) {
                        const author = data.find(c => c.id == authorId);
                        if (author) {
                            selectAuthor(author);
                        }
                    }
                });
            }

            window.clearAuthor = function() {
                authorId.val('');
                authorSearch.val('');
                selectedAuthorDiv.empty();
            };

            // Hide suggestions when clicking outside
            $(document).on('click', function(e) {
                if (!$(e.target).closest('#author_search, #author_suggestions').length) {
                    authorSuggestions.hide();
                }
            });
            
            // SEO Character Counters
            $('#meta_title').on('input', function() {
                $('#meta_title_count').text($(this).val().length);
            });
            
            $('#meta_description').on('input', function() {
                $('#meta_description_count').text($(this).val().length);
            });
            
            $('#meta_keywords').on('input', function() {
                $('#meta_keywords_count').text($(this).val().length);
            });
            
            // Initialize counters on page load
            $('#meta_title_count').text($('#meta_title').val().length);
            $('#meta_description_count').text($('#meta_description').val().length);
            $('#meta_keywords_count').text($('#meta_keywords').val().length);
            
            // Category Selection Handler
            const selectedCategories = new Map();
            const categorySelector = $('#category_selector');
            const selectedContainer = $('#selected-categories');

            // Handle old input on validation errors
            @if(old('categories'))
                const oldCategories = @json(old('categories'));
                $('#category_selector option').each(function() {
                    const optionValue = $(this).val();
                    const optionName = $(this).data('name');
                    if (oldCategories.includes(optionValue)) {
                        selectedCategories.set(optionValue, optionName);
                    }
                });
                renderCategories();
            @endif

            // Add category when selected
            categorySelector.on('change', function() {
                const selectedValue = $(this).val();
                const selectedText = $(this).find('option:selected').data('name');
                
                if (selectedValue && !selectedCategories.has(selectedValue)) {
                    selectedCategories.set(selectedValue, selectedText);
                    renderCategories();
                    $(this).val(''); // Reset selector
                }
            });

            // Render selected categories as badges
            function renderCategories() {
                selectedContainer.empty();
                selectedCategories.forEach((name, id) => {
                    const badge = $(`
                        <span class="badge bg-primary category-badge">
                            ${name}
                            <input type="hidden" name="categories[]" value="${id}">
                            <i class="bx bx-x ms-1 remove-category" style="cursor: pointer;" data-id="${id}"></i>
                        </span>
                    `);
                    selectedContainer.append(badge);
                });
                
                // Bind remove handlers
                $('.remove-category').on('click', function() {
                    const id = $(this).data('id');
                    selectedCategories.delete(id);
                    renderCategories();
                });
            }

            // Toggle scheduled date container based on status selection
            const statusSelect = document.getElementById('status');
            const scheduledContainer = document.getElementById('scheduledDateContainer');
            const publishedAtInput = document.getElementById('published_at');
            
            function toggleScheduledDate() {
                if (statusSelect.value === 'scheduled') {
                    scheduledContainer.style.display = 'block';
                    publishedAtInput.required = true;
                } else {
                    scheduledContainer.style.display = 'none';
                    publishedAtInput.required = false;
                }
            }
            
            statusSelect.addEventListener('change', toggleScheduledDate);
            // Run on page load
            toggleScheduledDate();
        </script>

        <!-- Tagify Script -->
        <script src="https://cdn.jsdelivr.net/npm/@yaireo/tagify"></script>
        <script>
            // Initialize Tagify on tags input
            const tagsInput = document.querySelector('input[name="tags"]');
            const tagify = new Tagify(tagsInput, {
                delimiters: ",",
                maxTags: 10,
                placeholder: "Type and press Enter...",
                dropdown: {
                    enabled: 0
                }
            });

            // Convert tagify format to simple array for form submission
            document.querySelector('form').addEventListener('submit', function(e) {
                const tags = tagify.value.map(tag => tag.value);
                tagsInput.value = JSON.stringify(tags);
            });
        </script>
    @endpush
@endsection
