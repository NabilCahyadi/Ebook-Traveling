@extends('layouts.admin')

@section('title', 'Kelola Latest Blogs Content')

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
            <h4 class="fw-bold py-3 mb-2">
                <span class="text-muted fw-light">
                    <a href="{{ route('admin.landing-page-content.index') }}" class="text-muted">Landing Page Content</a> /
                </span>
                Latest Blogs
            </h4>
            <p class="text-muted">Pilih dan atur urutan blog yang akan ditampilkan di landing page</p>
        </div>

        <form action="{{ route('admin.landing-page-content.latest-blogs.update') }}" method="POST" id="blogsForm">
            @csrf
            @method('PUT')

            <div class="row">
                <!-- Selected Blogs (Sortable) -->
                <div class="col-lg-7 mb-4">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5 class="mb-0">
                                    <i class="ti ti-list-check me-2"></i>
                                    Blog Terpilih (<span id="selected-count">{{ $selectedBlogs->count() }}</span>)
                                </h5>
                                <!-- <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="is_visible" name="is_visible" 
                                           value="1" {{ old('is_visible', $section->is_visible) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_visible">
                                        Tampilkan di Landing Page
                                    </label>
                                </div> -->
                            </div>
                            <div class="mb-0">
                                <label for="display_count" class="form-label">Jumlah Blog yang Ditampilkan</label>
                                <input type="number" 
                                       class="form-control @error('display_count') is-invalid @enderror" 
                                       id="display_count" 
                                       name="display_count" 
                                       min="1" 
                                       max="12" 
                                       value="{{ old('display_count', $displayCount) }}"
                                       required>
                                @error('display_count')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">
                                    Maksimal 12 blog. Hanya blog yang dipilih akan ditampilkan.
                                </small>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="alert alert-info">
                                <i class="ti ti-info-circle me-2"></i>
                                <strong>Tips:</strong> Drag & drop untuk mengatur urutan tampilan
                            </div>

                            <div id="selected-blogs" class="sortable-list">
                                @forelse($selectedBlogs as $index => $blog)
                                    <div class="sortable-item" data-id="{{ $blog->id }}">
                                        <div class="d-flex align-items-center p-3 mb-2 border rounded" style="gap: 12px;">
                                            <!-- Drag Handle - Tengah Kiri -->
                                            <div class="d-flex align-items-center" style="cursor: grab;">
                                                <i class="ti ti-grip-vertical text-muted" style="font-size: 1.5rem;"></i>
                                            </div>
                                            
                                            <!-- Blog Image - Tengah -->
                                            <img src="@if($blog->featured_image && filter_var($blog->featured_image, FILTER_VALIDATE_URL)){{ $blog->featured_image }}@elseif($blog->featured_image){{ asset('storage/' . $blog->featured_image) }}@else{{ asset('images/blog-placeholder.webp') }}@endif" 
                                                 alt="{{ $blog->title }}" 
                                                 class="rounded" 
                                                 style="width: 80px; height: 80px; object-fit: cover; flex-shrink: 0;">
                                            
                                            <!-- Blog Info - Tengah -->
                                            <div class="flex-grow-1">
                                                <strong>{{ Str::limit($blog->title, 60) }}</strong>
                                                <br>
                                                <small class="text-muted">
                                                    <i class="ti ti-calendar-event me-1"></i>
                                                    {{ $blog->published_at->format('d M Y') }}
                                                </small>
                                                <br>
                                                <span class="badge bg-label-primary mt-1">{{ $blog->category }}</span>
                                            </div>
                                            
                                            <!-- Remove Button - Tengah Kanan -->
                                            <button type="button" class="btn btn-sm btn-icon btn-danger remove-blog" data-id="{{ $blog->id }}" style="flex-shrink: 0;">
                                                <i class="ti ti-x"></i>
                                            </button>
                                        </div>
                                        <input type="hidden" name="selected_blogs[]" value="{{ $blog->id }}">
                                    </div>
                                @empty
                                    <div id="empty-state" class="text-center py-5">
                                        <i class="ti ti-article-off" style="font-size: 3rem; color: #ddd;"></i>
                                        <p class="text-muted mt-2">Belum ada blog yang dipilih</p>
                                        <small class="text-muted">Pilih blog dari daftar di sebelah kanan</small>
                                    </div>
                                @endforelse
                            </div>

                            @error('selected_blogs')
                                <div class="text-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Available Blogs -->
                <div class="col-lg-5 mb-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">
                                <i class="ti ti-article me-2"></i>
                                Daftar Blog Published
                            </h5>
                        </div>
                        <div class="card-body">
                            <input type="text" 
                                   id="search-blogs" 
                                   class="form-control mb-3" 
                                   placeholder="Cari blog...">

                            <div id="available-blogs" style="max-height: 600px; overflow-y: auto;">
                                @forelse($allBlogs as $blog)
                                    <div class="available-blog-item border rounded p-2 mb-2" 
                                         data-id="{{ $blog->id }}"
                                         data-title="{{ strtolower($blog->title) }}"
                                         style="cursor: pointer; transition: all 0.2s ease; {{ $selectedBlogs->contains('id', $blog->id) ? 'display: none;' : '' }}">
                                        <div class="d-flex align-items-center" style="gap: 10px;">
                                            <!-- Blog Image - Tengah Kiri -->
                                            <img src="@if($blog->featured_image && filter_var($blog->featured_image, FILTER_VALIDATE_URL)){{ $blog->featured_image }}@elseif($blog->featured_image){{ asset('storage/' . $blog->featured_image) }}@else{{ asset('images/blog-placeholder.webp') }}@endif" 
                                                 alt="{{ $blog->title }}" 
                                                 class="rounded" 
                                                 style="width: 60px; height: 60px; object-fit: cover; flex-shrink: 0;">
                                            
                                            <!-- Blog Info - Tengah -->
                                            <div class="flex-grow-1">
                                                <div><strong>{{ Str::limit($blog->title, 50) }}</strong></div>
                                                <small class="text-muted">
                                                    <i class="ti ti-calendar-event me-1"></i>
                                                    {{ $blog->published_at->format('d M Y') }}
                                                </small>
                                                <br>
                                                <span class="badge bg-label-primary mt-1" style="font-size: 0.7rem;">{{ $blog->category }}</span>
                                            </div>
                                            
                                            <!-- Add Icon - Tengah Kanan -->
                                            <i class="ti ti-plus text-danger" style="font-size: 1.5rem; flex-shrink: 0;"></i>
                                        </div>
                                    </div>
                                @empty
                                    <div class="text-center py-5">
                                        <i class="ti ti-article-off" style="font-size: 3rem; color: #ddd;"></i>
                                        <p class="text-muted mt-2">Tidak ada blog yang dipublikasi</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="card">
                <div class="card-body">
                    <button type="submit" class="btn btn-primary me-2">
                        <i class="ti ti-device-floppy me-1"></i> Simpan Perubahan
                    </button>
                    <a href="{{ route('admin.landing-page-content.index') }}" class="btn btn-label-secondary">
                        <i class="ti ti-arrow-left me-1"></i> Kembali
                    </a>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script>
    $(document).ready(function() {
        let selectedCount = {{ $selectedBlogs->count() }};

        // Initialize Sortable
        const sortable = new Sortable(document.getElementById('selected-blogs'), {
            animation: 150,
            handle: '.ti-grip-vertical',
            ghostClass: 'sortable-ghost',
            onEnd: function() {
                updateSelectedCount();
            }
        });

        // Add blog
        $(document).on('click', '.available-blog-item', function() {
            const blogId = $(this).data('id');
            const blogTitle = $(this).find('strong').text();
            const blogDate = $(this).find('small').text();
            const blogCategory = $(this).find('.badge').text();
            const blogImage = $(this).find('img').attr('src');

            // Hide from available list
            $(this).hide();

            // Remove empty state
            $('#empty-state').remove();

            // Add to selected list
            const html = `
                <div class="sortable-item" data-id="${blogId}">
                    <div class="d-flex align-items-start justify-content-between p-3 mb-2 border rounded">
                        <div class="d-flex align-items-start flex-grow-1">
                            <i class="ti ti-grip-vertical text-muted me-3 mt-2" style="cursor: grab;"></i>
                            <img src="${blogImage}" alt="${blogTitle}" class="rounded me-3" 
                                 style="width: 80px; height: 60px; object-fit: cover;">
                            <div class="flex-grow-1">
                                <strong>${blogTitle}</strong>
                                <br>
                                <small class="text-muted">
                                    <i class="ti ti-calendar-event me-1"></i>
                                    ${blogDate}
                                </small>
                                <br>
                                <span class="badge bg-label-primary mt-1">${blogCategory}</span>
                            </div>
                        </div>
                        <button type="button" class="btn btn-sm btn-icon btn-danger remove-blog" data-id="${blogId}">
                            <i class="ti ti-x"></i>
                        </button>
                    </div>
                    <input type="hidden" name="selected_blogs[]" value="${blogId}">
                </div>
            `;

            $('#selected-blogs').append(html);
            selectedCount++;
            updateSelectedCount();
        });

        // Remove blog
        $(document).on('click', '.remove-blog', function() {
            const blogId = $(this).data('id');
            $(this).closest('.sortable-item').remove();
            
            // Show back in available list
            $(`.available-blog-item[data-id="${blogId}"]`).show();
            
            selectedCount--;
            updateSelectedCount();

            // Show empty state if no blogs selected
            if (selectedCount === 0) {
                $('#selected-blogs').html(`
                    <div id="empty-state" class="text-center py-5">
                        <i class="ti ti-article-off" style="font-size: 3rem; color: #ddd;"></i>
                        <p class="text-muted mt-2">Belum ada blog yang dipilih</p>
                        <small class="text-muted">Pilih blog dari daftar di sebelah kanan</small>
                    </div>
                `);
            }
        });

        // Search blogs
        $('#search-blogs').on('keyup', function() {
            const searchTerm = $(this).val().toLowerCase();
            
            $('.available-blog-item').each(function() {
                const blogTitle = $(this).data('title');
                if (blogTitle.includes(searchTerm)) {
                    // Only show if not already selected
                    const blogId = $(this).data('id');
                    const isSelected = $(`.sortable-item[data-id="${blogId}"]`).length > 0;
                    if (!isSelected) {
                        $(this).show();
                    }
                } else {
                    $(this).hide();
                }
            });
        });

        function updateSelectedCount() {
            $('#selected-count').text(selectedCount);
        }

        // Form validation
        $('#blogsForm').on('submit', function(e) {
            if (selectedCount === 0) {
                e.preventDefault();
                toastr.error('Pilih minimal 1 blog');
                return false;
            }
        });
    });
</script>

<style>
    .sortable-ghost {
        opacity: 0.4;
    }
    
    .available-blog-item:hover {
        background-color: #f8f9fa;
        border-color: #1e3a8a !important;
    }

    .sortable-item {
        transition: all 0.3s ease;
    }
</style>
@endpush
