@extends('layouts.admin')

@section('title', 'Create New Ebook')

@section('styles')
    <style>
        /* Simple native CSS only */
    </style>
    color: #ea5455;
    }
    </style>
@endsection

@section('content')
    <!-- (form, left/right columns, preview, modal) -->
    <!-- I will keep your form exactly as before; only ids/classes matter to JS -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold py-3 mb-2"><span class="text-muted fw-light">Ebook /</span> Create New Ebook</h4>
        </div>
        <div>
            <a href="{{ route('admin.ebooks.index') }}" class="btn btn-secondary"><i class="ti ti-arrow-left me-1"></i>
                Back</a>
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
                            <i class="ti ti-book"></i> Informasi Ebook
                        </h5>

                        <div class="mb-3">
                            <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" id="title"
                                name="title" value="{{ old('title') }}" placeholder="Masukkan judul ebook" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="author" class="form-label">Author <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('author') is-invalid @enderror" id="author"
                                name="author" value="{{ old('author') }}" placeholder="Nama penulis" required>
                            @error('author')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="category_id" class="form-label">Category <span
                                        class="text-danger">*</span></label>
                                <select class="form-select @error('category_id') is-invalid @enderror" id="category_id"
                                    name="category_id" required>
                                    <option value="">Pilih Kategori</option>
                                    @if (isset($categories))
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}"
                                                {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                                @error('category_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="city_id" class="form-label">City</label>
                                <select class="form-select @error('city_id') is-invalid @enderror" id="city_id"
                                    name="city_id">
                                    <option value="">Pilih Kota (Optional)</option>
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
                            <label for="description" class="form-label">Description <span
                                    class="text-danger">*</span></label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"
                                rows="5" placeholder="Deskripsi singkat tentang ebook" required>{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
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
                                <small class="text-muted">Admin dapat langsung publish tanpa approval</small>
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
                            <i class="ti ti-photo"></i> Cover Image
                        </h5>

                        <div class="mb-3">
                            <label class="form-label">Cover Image (Ratio 1:1.6)</label>
                            <input type="file" class="form-control @error('cover_image') is-invalid @enderror"
                                id="coverImageInput" name="cover_image" accept="image/*">
                            <small class="text-muted">Gambar akan otomatis di-crop ke rasio 1:1.6 (contoh: 650x965px). Max
                                2MB.</small>
                            @error('cover_image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Preview Area -->
                        <div id="previewArea" style="display: none;" class="mt-3">
                            <label class="form-label">Preview (Auto-cropped)</label>
                            <div style="max-width: 200px;">
                                <img id="previewImage" src="" alt="Preview"
                                    style="width: 100%; border: 2px solid #ddd; border-radius: 8px;">
                            </div>
                            <button type="button" class="btn btn-sm btn-outline-secondary mt-2" onclick="resetCrop()">
                                <i class="ti ti-x me-1"></i> Hapus
                            </button>
                        </div>

                        <!-- Hidden input untuk menyimpan hasil crop -->
                        <input type="hidden" name="cover_image_cropped" id="croppedImageData">
                    </div>
                </div>

                <!-- File and submit same as original -->
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title mb-3">PDF File</h5>
                        <div class="mb-0">
                            <input type="file" class="form-control @error('pdf_file') is-invalid @enderror"
                                id="pdf_file" name="pdf_file" accept=".pdf">
                            <small class="text-muted">Max 10MB. PDF format only</small>
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
                            <i class="ti ti-check me-1"></i> Create Ebook
                        </button>
                        <a href="{{ route('admin.ebooks.index') }}" class="btn btn-label-secondary w-100">
                            <i class="ti ti-x me-1"></i> Cancel
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

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
    </script>
@endpush
