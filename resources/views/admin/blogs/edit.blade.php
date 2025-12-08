@extends('layouts.admin')

@section('title', 'Edit Blog')

@push('styles')
    <link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5/43.0.0/ckeditor5.css" />
    <style>
        .ck-editor__editable {
            min-height: 500px;
        }
    </style>
@endpush

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold py-3 mb-0">
                <span class="text-muted fw-light">Admin / Blogs /</span> Edit
            </h4>
            <a href="{{ route('admin.blogs.index') }}" class="btn btn-secondary">
                <i class="bx bx-arrow-back me-1"></i> Back
            </a>
        </div>

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <form action="{{ route('admin.blogs.update', $blog->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-lg-8">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0">Blog Content</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label" for="title">Title <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('title') is-invalid @enderror"
                                    id="title" name="title" value="{{ old('title', $blog->title) }}"
                                    placeholder="Enter blog title" required>
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="content">Content <span class="text-danger">*</span></label>
                                <textarea class="form-control @error('content') is-invalid @enderror" id="content" name="content" rows="20">{{ old('content', $blog->content) }}</textarea>
                                @error('content')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="excerpt">Excerpt</label>
                                <textarea class="form-control @error('excerpt') is-invalid @enderror" id="excerpt" name="excerpt" rows="3"
                                    placeholder="Short description">{{ old('excerpt', $blog->excerpt) }}</textarea>
                                @error('excerpt')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0">Publish</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label" for="status">Status <span class="text-danger">*</span></label>
                                <select class="form-select @error('status') is-invalid @enderror" id="status"
                                    name="status" required>
                                    <option value="draft" {{ old('status', $blog->status) == 'draft' ? 'selected' : '' }}>
                                        Draft</option>
                                    <option value="published"
                                        {{ old('status', $blog->status) == 'published' ? 'selected' : '' }}>Published
                                    </option>
                                    <option value="unpublished"
                                        {{ old('status', $blog->status) == 'unpublished' ? 'selected' : '' }}>Unpublished
                                    </option>
                                    <option value="archived"
                                        {{ old('status', $blog->status) == 'archived' ? 'selected' : '' }}>Archived
                                    </option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Set blog post status</div>
                            </div>

                            @if ($blog->published_at)
                                <div class="mb-3">
                                    <small class="text-muted">
                                        Published: {{ $blog->published_at->format('d M Y, H:i') }}
                                    </small>
                                </div>
                            @endif

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bx bx-save me-1"></i> Update Blog
                                </button>
                                <a href="{{ route('admin.blogs.index') }}" class="btn btn-secondary">
                                    Cancel
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0">Featured Image</h5>
                        </div>
                        <div class="card-body">
                            @if ($blog->featured_image)
                                <div class="mb-3">
                                    <img src="{{ asset('storage/' . $blog->featured_image) }}" alt="{{ $blog->title }}"
                                        class="img-fluid rounded">
                                    <div class="form-check mt-2">
                                        <input class="form-check-input" type="checkbox" id="remove_image"
                                            name="remove_image">
                                        <label class="form-check-label" for="remove_image">
                                            Remove current image
                                        </label>
                                    </div>
                                </div>
                            @endif

                            <div class="mb-3">
                                <label
                                    class="form-label">{{ $blog->featured_image ? 'Replace Image' : 'Upload Image' }}</label>
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
                            <h5 class="mb-0">Categories & Tags</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label" for="category">Category</label>
                                <input type="text" class="form-control @error('category') is-invalid @enderror"
                                    id="category" name="category" value="{{ old('category', $blog->category) }}"
                                    placeholder="e.g., Travel Tips">
                                @error('category')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="tags">Tags</label>
                                <input type="text" class="form-control @error('tags') is-invalid @enderror"
                                    id="tags" name="tags"
                                    value="{{ old('tags', is_array($blog->tags) ? implode(', ', $blog->tags) : '') }}"
                                    placeholder="travel, tips, guide">
                                @error('tags')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Separate tags with commas</div>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Statistics</h5>
                        </div>
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-2">
                                <i class="bx bx-show me-2"></i>
                                <span>{{ number_format($blog->view_count) }} views</span>
                            </div>
                            <div class="d-flex align-items-center">
                                <i class="bx bx-time me-2"></i>
                                <span>Updated {{ $blog->updated_at->diffForHumans() }}</span>
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
                    document.querySelector('form').addEventListener('submit', function(e) {
                        const content = editor.getData();
                        document.querySelector('#content').value = content;
                        console.log('Form submitting with content length:', content.length);
                    });
                })
                .catch(error => {
                    console.error('Editor initialization error:', error);
                });
        </script>
        <script>
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

            // Handle remove image checkbox
            document.getElementById('remove_image')?.addEventListener('change', function() {
                if (this.checked) {
                    document.getElementById('featured_image').value = '';
                }
            });
        </script>
    @endpush
@endsection
