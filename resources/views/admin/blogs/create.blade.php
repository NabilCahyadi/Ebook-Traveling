@extends('layouts.admin')

@section('title', __('admin.blogs.create'))

@push('styles')
    <link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5/43.0.0/ckeditor5.css" />
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
    </style>
@endpush

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold py-3 mb-0">
                <span class="text-muted fw-light">Admin / Blogs /</span> {{ __('admin.blogs.create_new') }}
            </h4>
            <a href="{{ route('admin.blogs.index') }}" class="btn btn-secondary">
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
                                    placeholder="Type to search author..."
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
                                    Biarkan kosong jika blog ini dibuat oleh <strong>MeatMap Team</strong>
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
                                    <option value="unpublished" {{ old('status') == 'unpublished' ? 'selected' : '' }}>
                                        {{ __('admin.blogs.unpublished') }}</option>
                                    <option value="archived" {{ old('status') == 'archived' ? 'selected' : '' }}>{{ __('admin.blogs.archived') }}
                                    </option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">{{ __('admin.blogs.set_blog_status') }}</div>
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bx bx-save me-1"></i> {{ __('admin.blogs.create_blog') }}
                                </button>
                                <a href="{{ route('admin.blogs.index') }}" class="btn btn-secondary">
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
                            <div id="imagePreview" class="mt-2" style="display: none;">
                                <img src="" alt="Preview" class="img-fluid rounded">
                            </div>
                        </div>
                    </div>

                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0">{{ __('admin.blogs.category') }}</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label" for="category">{{ __('admin.blogs.blog_category') }}</label>
                                <select class="form-select @error('category') is-invalid @enderror" 
                                    id="category" 
                                    name="category">
                                    <option value="">{{ __('admin.blogs.select_category') }}</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->name }}" {{ old('category') == $category->name ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category')
                                    <div class="invalid-feedback">{{ $message }}</div>
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
        </form>
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
        </script>
    @endpush
@endsection
