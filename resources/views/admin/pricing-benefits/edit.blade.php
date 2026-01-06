@extends('layouts.admin')

@section('title', 'Edit Benefit')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Page Header -->
        <div class="mb-4">
            <h4 class="fw-bold py-3 mb-2">
                <span class="text-muted fw-light">
                    <a href="{{ route('admin.about-us.index') }}" class="text-muted">Website Management / About Us</a> /
                </span>
                Edit
            </h4>
        </div>

        <!-- Form Card -->
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Form Edit Benefit</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.about-us.update', $benefit->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <!-- Icon Input -->
                            <div class="mb-3">
                                <label for="icon" class="form-label">Icon Class <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="ti ti-icons"></i></span>
                                    <input type="text" 
                                           class="form-control @error('icon') is-invalid @enderror" 
                                           id="icon" 
                                           name="icon" 
                                           value="{{ old('icon', $benefit->icon) }}" 
                                           placeholder="bi bi-card-checklist"
                                           required
                                           readonly>
                                    <button class="btn btn-outline-primary" type="button" id="openIconPicker">
                                        <i class="ti ti-search"></i> Pilih Icon
                                    </button>
                                </div>
                                @error('icon')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">
                                    Klik tombol "Pilih Icon" untuk memilih dari daftar Bootstrap Icons
                                </small>
                            </div>

                            <!-- Icon Preview -->
                            <div class="mb-3">
                                <label class="form-label">Preview Icon</label>
                                <div class="icon-preview-box" id="iconPreview">
                                    <i class="{{ old('icon', $benefit->icon) }}" style="font-size: 3rem; color: #FF4C61;"></i>
                                    <small class="d-block text-muted mt-2">{{ old('icon', $benefit->icon) }}</small>
                                </div>
                            </div>

                            <!-- Title Input -->
                            <div class="mb-3">
                                <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                                <input type="text" 
                                       class="form-control @error('title') is-invalid @enderror" 
                                       id="title" 
                                       name="title" 
                                       value="{{ old('title', $benefit->title) }}" 
                                       placeholder="Masukkan judul benefit"
                                       required>
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Description Textarea -->
                            <div class="mb-3">
                                <label for="description" class="form-label">Description <span class="text-danger">*</span></label>
                                <textarea class="form-control @error('description') is-invalid @enderror" 
                                          id="description" 
                                          name="description" 
                                          rows="4" 
                                          placeholder="Masukkan deskripsi benefit"
                                          required>{{ old('description', $benefit->description) }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Status Switch -->
                            <div class="mb-3">
                                <label for="status" class="form-label">Status</label>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" 
                                           type="checkbox" 
                                           id="status" 
                                           name="status" 
                                           value="active" 
                                           {{ old('status', $benefit->status) === 'active' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="status">
                                        Aktif (ditampilkan di halaman pricing)
                                    </label>
                                </div>
                            </div>

                            <!-- Sort Order Input -->
                            <div class="mb-4">
                                <label for="sort_order" class="form-label">Urutan Tampilan</label>
                                <input type="number" 
                                       class="form-control @error('sort_order') is-invalid @enderror" 
                                       id="sort_order" 
                                       name="sort_order" 
                                       value="{{ old('sort_order', $benefit->sort_order) }}" 
                                       min="0">
                                @error('sort_order')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Semakin kecil angka, semakin awal ditampilkan.</small>
                            </div>

                            <!-- Form Actions -->
                            <div class="d-flex justify-content-between">
                                <a href="{{ route('admin.about-us.index') }}" class="btn btn-label-secondary">
                                    <i class="ti ti-arrow-left me-1"></i> Kembali
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="ti ti-device-floppy me-1"></i> Update Benefit
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Delete Section -->
                <div class="card mt-3">
                    <div class="card-body">
                        <h5 class="card-title text-danger mb-3">
                            <i class="ti ti-alert-triangle me-2"></i> Danger Zone
                        </h5>
                        <p class="text-muted mb-3">Hapus benefit ini secara permanen. Aksi ini tidak dapat dibatalkan!</p>
                        <form action="{{ route('admin.about-us.destroy', $benefit->id) }}" 
                              method="POST" 
                              id="deleteForm">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="btn btn-danger" id="deleteBtn">
                                <i class="ti ti-trash me-1"></i> Hapus Benefit
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Help Card -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title mb-3">
                            <i class="ti ti-help me-2"></i> Panduan Bootstrap Icons
                        </h5>
                        
                        <div class="alert alert-info mb-3">
                            <i class="ti ti-info-circle me-2"></i>
                            <small><strong>Hanya gunakan Bootstrap Icons!</strong> Icon library lain tidak tersedia di halaman pricing.</small>
                        </div>

                        <div class="mb-3">
                            <p class="small text-muted mb-2">Format: <code>bi bi-[nama]</code></p>
                            <div class="d-flex flex-wrap gap-2">
                                <span class="badge bg-label-primary icon-example" data-icon="bi bi-globe-americas">
                                    <i class="bi bi-globe-americas"></i> globe-americas
                                </span>
                                <span class="badge bg-label-primary icon-example" data-icon="bi bi-file-earmark-arrow-down">
                                    <i class="bi bi-file-earmark-arrow-down"></i> file-earmark-arrow-down
                                </span>
                                <span class="badge bg-label-primary icon-example" data-icon="bi bi-card-checklist">
                                    <i class="bi bi-card-checklist"></i> card-checklist
                                </span>
                                <span class="badge bg-label-primary icon-example" data-icon="bi bi-arrow-repeat">
                                    <i class="bi bi-arrow-repeat"></i> arrow-repeat
                                </span>
                                <span class="badge bg-label-primary icon-example" data-icon="bi bi-book">
                                    <i class="bi bi-book"></i> book
                                </span>
                                <span class="badge bg-label-primary icon-example" data-icon="bi bi-heart">
                                    <i class="bi bi-heart"></i> heart
                                </span>
                                <span class="badge bg-label-primary icon-example" data-icon="bi bi-star">
                                    <i class="bi bi-star"></i> star
                                </span>
                                <span class="badge bg-label-primary icon-example" data-icon="bi bi-shield-check">
                                    <i class="bi bi-shield-check"></i> shield-check
                                </span>
                                <span class="badge bg-label-primary icon-example" data-icon="bi bi-award">
                                    <i class="bi bi-award"></i> award
                                </span>
                                <span class="badge bg-label-primary icon-example" data-icon="bi bi-people">
                                    <i class="bi bi-people"></i> people
                                </span>
                                <span class="badge bg-label-primary icon-example" data-icon="bi bi-map">
                                    <i class="bi bi-map"></i> map
                                </span>
                                <span class="badge bg-label-primary icon-example" data-icon="bi bi-lightning">
                                    <i class="bi bi-lightning"></i> lightning
                                </span>
                            </div>
                            <a href="https://icons.getbootstrap.com/" target="_blank" class="btn btn-sm btn-label-primary mt-3 w-100">
                                <i class="ti ti-external-link me-1"></i> Lihat Semua Bootstrap Icons (2000+)
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Tips Card -->
                <div class="card mt-3">
                    <div class="card-body">
                        <h5 class="card-title mb-3">
                            <i class="ti ti-bulb me-2"></i> Tips
                        </h5>
                        <ul class="small mb-0 ps-3">
                            <li class="mb-2">Gunakan judul yang singkat dan jelas (max 5 kata)</li>
                            <li class="mb-2">Deskripsi sebaiknya 1-2 kalimat saja</li>
                            <li class="mb-2">Pilih icon yang sesuai dengan benefit</li>
                            <li>Maksimal 6 benefit untuk tampilan terbaik</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Icon Picker Modal -->
    <div class="modal fade" id="iconPickerModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Pilih Bootstrap Icon</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <input type="text" class="form-control" id="iconSearch" placeholder="Cari icon... (contoh: heart, star, globe)">
                    </div>
                    <div class="row g-2" id="iconGrid">
                        <!-- Icons will be loaded here -->
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    // Popular Bootstrap Icons list
    const bootstrapIcons = [
        'globe-americas', 'globe-europe-africa', 'globe-asia-australia', 'globe', 'globe2',
        'file-earmark-arrow-down', 'file-earmark-arrow-up', 'file-earmark-check', 'file-earmark-text',
        'card-checklist', 'card-list', 'card-text', 'card-heading',
        'arrow-repeat', 'arrow-clockwise', 'arrow-counterclockwise', 'arrow-left-right',
        'book', 'book-half', 'book-fill', 'bookmarks', 'bookmark', 'bookmark-heart',
        'heart', 'heart-fill', 'heart-half', 'hearts',
        'star', 'star-fill', 'star-half', 'stars',
        'shield-check', 'shield-fill-check', 'shield', 'shield-fill',
        'award', 'award-fill', 'trophy', 'trophy-fill',
        'people', 'people-fill', 'person', 'person-fill', 'person-check', 'person-heart',
        'map', 'map-fill', 'geo', 'geo-alt', 'geo-alt-fill', 'pin-map', 'pin-map-fill',
        'lightning', 'lightning-fill', 'lightning-charge', 'lightning-charge-fill',
        'download', 'upload', 'cloud-download', 'cloud-upload',
        'check-circle', 'check-circle-fill', 'check-square', 'check-square-fill', 'check-all', 'check2-all',
        'hand-thumbs-up', 'hand-thumbs-up-fill', 'hand-thumbs-down', 'hand-thumbs-down-fill',
        'emoji-smile', 'emoji-smile-fill', 'emoji-laughing', 'emoji-laughing-fill', 'emoji-heart-eyes', 'emoji-heart-eyes-fill',
        'gift', 'gift-fill', 'balloon', 'balloon-fill', 'balloon-heart', 'balloon-heart-fill',
        'calendar', 'calendar-check', 'calendar-event', 'calendar-date', 'calendar-heart',
        'chat', 'chat-fill', 'chat-dots', 'chat-dots-fill', 'chat-heart', 'chat-heart-fill',
        'camera', 'camera-fill', 'camera-video', 'camera-video-fill',
        'image', 'image-fill', 'images', 'file-image', 'file-image-fill',
        'music-note', 'music-note-beamed', 'music-note-list',
        'envelope', 'envelope-fill', 'envelope-open', 'envelope-open-fill', 'envelope-heart', 'envelope-heart-fill',
        'telephone', 'telephone-fill', 'phone', 'phone-fill',
        'house', 'house-fill', 'house-door', 'house-door-fill', 'house-heart', 'house-heart-fill',
        'bag', 'bag-fill', 'bag-check', 'bag-check-fill', 'bag-heart', 'bag-heart-fill',
        'cart', 'cart-fill', 'cart-check', 'cart-check-fill',
        'compass', 'compass-fill', 'airplane', 'airplane-fill', 'train-front', 'train-front-fill',
        'wifi', 'wifi-off', 'router', 'router-fill',
        'battery-charging', 'battery-full', 'battery-half',
        'sun', 'sun-fill', 'moon', 'moon-fill', 'moon-stars', 'moon-stars-fill',
        'flower1', 'flower2', 'flower3', 'tree', 'tree-fill',
        'gem', 'diamond', 'diamond-fill', 'diamond-half',
        'fire', 'droplet', 'droplet-fill', 'droplet-half',
        'wind', 'snow', 'snow2', 'snow3',
        'cup', 'cup-fill', 'cup-hot', 'cup-hot-fill',
        'gift-fill', 'rocket', 'rocket-fill', 'rocket-takeoff', 'rocket-takeoff-fill'
    ];

    $(document).ready(function() {
        // Load icons into modal
        function loadIcons(filter = '') {
            const iconGrid = $('#iconGrid');
            iconGrid.empty();
            
            const filteredIcons = filter 
                ? bootstrapIcons.filter(icon => icon.includes(filter.toLowerCase()))
                : bootstrapIcons;

            if (filteredIcons.length === 0) {
                iconGrid.html('<div class="col-12 text-center py-5"><p class="text-muted">Tidak ada icon yang cocok</p></div>');
                return;
            }

            filteredIcons.forEach(icon => {
                const iconClass = `bi bi-${icon}`;
                const iconHtml = `
                    <div class="col-6 col-sm-4 col-md-3">
                        <div class="icon-picker-item p-3 text-center border rounded cursor-pointer" data-icon="${iconClass}">
                            <i class="${iconClass}" style="font-size: 2rem; color: #FF4C61;"></i>
                            <small class="d-block mt-2 text-truncate">${icon}</small>
                        </div>
                    </div>
                `;
                iconGrid.append(iconHtml);
            });
        }

        // Open icon picker modal
        $('#openIconPicker').on('click', function() {
            loadIcons();
            $('#iconPickerModal').modal('show');
        });

        // Search icons
        $('#iconSearch').on('input', function() {
            const searchTerm = $(this).val();
            loadIcons(searchTerm);
        });

        // Select icon from modal
        $(document).on('click', '.icon-picker-item', function() {
            const iconClass = $(this).data('icon');
            $('#icon').val(iconClass).trigger('input');
            $('#iconPickerModal').modal('hide');
        });

        // Icon preview
        $('#icon').on('input', function() {
            const iconClass = $(this).val().trim();
            const previewBox = $('#iconPreview');
            
            if (iconClass) {
                previewBox.html(`
                    <i class="${iconClass}" style="font-size: 3rem; color: #FF4C61;"></i>
                    <small class="d-block text-muted mt-2">${iconClass}</small>
                `);
            } else {
                previewBox.html(`
                    <i class="ti ti-photo text-muted"></i>
                    <small class="d-block text-muted mt-2">Ketik icon class untuk melihat preview</small>
                `);
            }
        });

        // Click icon example to use it
        $('.icon-example').on('click', function() {
            const iconClass = $(this).data('icon');
            $('#icon').val(iconClass).trigger('input');
            
            // Scroll to icon input
            $('html, body').animate({
                scrollTop: $('#icon').offset().top - 100
            }, 300);
        });

        // Delete confirmation
        $('#deleteBtn').on('click', function(e) {
            e.preventDefault();
            
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Benefit akan dihapus secara permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#deleteForm').submit();
                }
            });
        });
    });
</script>

<style>
    .icon-preview-box {
        width: 120px;
        height: 120px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        background-color: #fff5f5;
        border: 2px dashed #ddd;
        border-radius: 10px;
        font-size: 3rem;
        color: #999;
    }

    .icon-example {
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .icon-example:hover {
        transform: scale(1.1);
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    .icon-picker-item {
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .icon-picker-item:hover {
        background-color: #f8f9fa;
        border-color: #FF4C61 !important;
        transform: translateY(-2px);
    }

    .cursor-pointer {
        cursor: pointer;
    }
</style>
@endpush
