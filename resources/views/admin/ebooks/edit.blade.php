@extends('layouts.admin')

@section('title', 'Edit Ebook')

@section('styles')
    <style>
        /* Simple native CSS only */
    </style>
@endsection

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold py-3 mb-2"><span class="text-muted fw-light">Ebook /</span> Edit Ebook</h4>
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

    <form action="{{ route('admin.ebooks.update', $ebook->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
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
                                name="title" value="{{ old('title', $ebook->title) }}" placeholder="Masukkan judul ebook"
                                required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="author" class="form-label">Author <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('author') is-invalid @enderror" id="author"
                                name="author" value="{{ old('author', $ebook->author) }}" placeholder="Nama penulis"
                                required>
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
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}"
                                            {{ old('category_id', $ebook->category_id) == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
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
                                    @foreach ($cities as $city)
                                        <option value="{{ $city->id }}"
                                            {{ old('city_id', $ebook->city_id) == $city->id ? 'selected' : '' }}>
                                            {{ $city->name }}
                                        </option>
                                    @endforeach
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
                                rows="5" placeholder="Deskripsi singkat tentang ebook" required>{{ old('description', $ebook->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                                <select class="form-select @error('status') is-invalid @enderror" id="status"
                                    name="status" required>
                                    <option value="draft"
                                        {{ old('status', $ebook->status) == 'draft' ? 'selected' : '' }}>Draft</option>
                                    <option value="published"
                                        {{ old('status', $ebook->status) == 'published' ? 'selected' : '' }}>Published
                                    </option>
                                    <option value="unpublished"
                                        {{ old('status', $ebook->status) == 'unpublished' ? 'selected' : '' }}>Unpublished
                                    </option>
                                    <option value="archived"
                                        {{ old('status', $ebook->status) == 'archived' ? 'selected' : '' }}>Archived
                                    </option>
                                </select>
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
                <!-- Cover Image -->
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title mb-3">
                            <i class="ti ti-photo"></i> Cover Image
                        </h5>

                        @if ($ebook->cover_image)
                            <div class="mb-3">
                                <label class="form-label">Current Cover</label>
                                <div style="max-width: 200px;">
                                    @if (file_exists(public_path('storage/' . $ebook->cover_image)))
                                        <img src="{{ asset('storage/' . $ebook->cover_image) }}" alt="Current Cover"
                                            style="width: 100%; border: 2px solid #ddd; border-radius: 8px;">
                                    @else
                                        <div class="bg-label-secondary rounded d-flex align-items-center justify-content-center"
                                            style="width: 100%; aspect-ratio: 650/1040;">
                                            <i class="ti ti-book" style="font-size: 48px;"></i>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @else
                            <div class="mb-3">
                                <label class="form-label">Current Cover</label>
                                <div style="max-width: 200px;">
                                    <div class="bg-label-secondary rounded d-flex align-items-center justify-content-center"
                                        style="width: 100%; aspect-ratio: 650/1040;">
                                        <i class="ti ti-book" style="font-size: 48px;"></i>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="mb-3">
                            <label class="form-label">Change Cover (Ratio 1:1.6)</label>
                            <input type="file" class="form-control @error('cover_image') is-invalid @enderror"
                                id="coverImageInput" name="cover_image" accept="image/*">
                            <small class="text-muted">Gambar akan otomatis di-crop ke rasio 1:1.6. Max 2MB. Kosongkan jika
                                tidak ingin mengubah.</small>
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

                <!-- PDF File -->
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title mb-3">PDF File</h5>

                        @if ($ebook->pdf_file)
                            <div class="mb-2">
                                <small class="text-success">
                                    <i class="ti ti-file-check me-1"></i> File PDF sudah ada
                                </small>
                            </div>
                        @endif

                        <div class="mb-0">
                            <input type="file" class="form-control @error('pdf_file') is-invalid @enderror"
                                id="pdf_file" name="pdf_file" accept=".pdf">
                            <small class="text-muted">Max 10MB. PDF format only. Kosongkan jika tidak ingin
                                mengubah.</small>
                            @error('pdf_file')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <button type="submit" class="btn btn-primary w-100 mb-2">
                            <i class="ti ti-check me-1"></i> Update Ebook
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
    <script>
        const pdfInput = document.getElementById('pdf_file');
        if (pdfInput) {
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
        }
    </script>
@endpush
