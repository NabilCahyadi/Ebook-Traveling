@extends('layouts.admin')

@section('title', 'Create Blog')

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
                <span class="text-muted fw-light">Admin / Blogs /</span> Create New
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

        <form id="blogForm" action="{{ route('admin.blogs.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

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
                                    id="title" name="title" value="{{ old('title') }}" placeholder="Enter blog title"
                                    required>
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="content">Content <span class="text-danger">*</span></label>
                                <textarea class="form-control @error('content') is-invalid @enderror" id="content" name="content" rows="20">{{ old('content') }}</textarea>
                                @error('content')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="excerpt">Excerpt</label>
                                <textarea class="form-control @error('excerpt') is-invalid @enderror" id="excerpt" name="excerpt" rows="3"
                                    placeholder="Short description (auto-generated if left empty)">{{ old('excerpt') }}</textarea>
                                @error('excerpt')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Brief summary of the blog post</div>
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
                                    <option value="draft" {{ old('status', 'draft') == 'draft' ? 'selected' : '' }}>Draft
                                    </option>
                                    <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>
                                        Published</option>
                                    <option value="unpublished" {{ old('status') == 'unpublished' ? 'selected' : '' }}>
                                        Unpublished</option>
                                    <option value="archived" {{ old('status') == 'archived' ? 'selected' : '' }}>Archived
                                    </option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Set blog post status</div>
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bx bx-save me-1"></i> Create Blog
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
                            <h5 class="mb-0">Category</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label" for="blog_category_id">Blog Category</label>
                                <select class="form-select @error('blog_category_id') is-invalid @enderror"
                                    id="blog_category_id" name="blog_category_id">
                                    <option value="">Select a category</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('blog_category_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('blog_category_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">
                                    Select a category for this blog post. 
                                    <a href="{{ route('admin.blog-categories.create') }}" target="_blank">Add new category</a>
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
        </script>
    @endpush
@endsection
