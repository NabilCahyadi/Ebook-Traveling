@extends('layouts.app')

@section('title', 'Kelola Navbar Announcements')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="ti ti-speakerphone me-2"></i>Kelola Navbar Announcements
                    </h5>
                    <a href="{{ route('admin.landing-page-content.index') }}" class="btn btn-sm btn-secondary">
                        <i class="ti ti-arrow-left me-1"></i>Kembali
                    </a>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="alert alert-info">
                        <h6 class="alert-heading mb-2">
                            <i class="ti ti-info-circle me-1"></i>Informasi
                        </h6>
                        <ul class="mb-0 ps-3">
                            <li>Teks akan muncul di banner paling atas navbar dan berputar otomatis</li>
                            <li>Maksimal 55 karakter per teks untuk tampilan optimal</li>
                            <li>Minimal 1 teks, maksimal 5 teks pengumuman</li>
                            <li>Non-aktifkan teks yang tidak ingin ditampilkan tanpa menghapus</li>
                            <li>Urutan akan mengikuti urutan input dari atas ke bawah</li>
                        </ul>
                    </div>

                    <form action="{{ route('admin.landing-page-content.navbar-announcements.update') }}" method="POST" id="navbar-form">
                        @csrf
                        @method('PUT')

                        <div id="announcements-container">
                            @foreach($announcements as $index => $announcement)
                            <div class="announcement-item card mb-3 border" data-index="{{ $index }}">
                                <div class="card-body">
                                    <div class="row align-items-start">
                                        <div class="col-12 mb-3">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <h6 class="mb-0">
                                                    <i class="ti ti-grip-vertical me-2 text-muted"></i>
                                                    Teks #<span class="item-number">{{ $index + 1 }}</span>
                                                </h6>
                                                <button type="button" class="btn btn-sm btn-danger remove-item" 
                                                        {{ count($announcements) <= 1 ? 'disabled' : '' }}>
                                                    <i class="ti ti-trash"></i> Hapus
                                                </button>
                                            </div>
                                        </div>
                                        <div class="col-lg-10">
                                            <input type="hidden" name="announcements[{{ $index }}][id]" value="{{ $announcement->id }}">
                                            <label class="form-label">Teks Pengumuman</label>
                                            <input type="text" 
                                                   class="form-control @error('announcements.'.$index.'.title') is-invalid @enderror" 
                                                   name="announcements[{{ $index }}][title]" 
                                                   value="{{ old('announcements.'.$index.'.title', $announcement->title) }}"
                                                   placeholder="Flash Sale : Get 30% Off Destination Guides"
                                                   maxlength="55"
                                                   required>
                                            <div class="form-text">
                                                <span class="char-count">{{ strlen($announcement->title) }}</span>/55 karakter
                                            </div>
                                            @error('announcements.'.$index.'.title')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-lg-2">
                                            <label class="form-label">Status</label>
                                            <div class="form-check form-switch mt-2">
                                                <input class="form-check-input" 
                                                       type="checkbox" 
                                                       name="announcements[{{ $index }}][is_active]"
                                                       {{ old('announcements.'.$index.'.is_active', $announcement->is_active) ? 'checked' : '' }}>
                                                <label class="form-check-label">Aktif</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>

                        <div class="mb-4">
                            <button type="button" class="btn btn-outline-primary" id="add-item">
                                <i class="ti ti-plus me-1"></i>Tambah Teks
                            </button>
                            <small class="text-muted ms-2">Maksimal 5 teks</small>
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('admin.landing-page-content.index') }}" class="btn btn-label-secondary">
                                <i class="ti ti-x me-1"></i>Batal
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="ti ti-device-floppy me-1"></i>Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const container = document.getElementById('announcements-container');
    const addButton = document.getElementById('add-item');
    let itemCount = {{ count($announcements) }};

    // Character counter
    container.addEventListener('input', function(e) {
        if (e.target.matches('input[type="text"]')) {
            const charCountSpan = e.target.parentElement.querySelector('.char-count');
            if (charCountSpan) {
                charCountSpan.textContent = e.target.value.length;
            }
        }
    });

    // Add new item
    addButton.addEventListener('click', function() {
        if (itemCount >= 5) {
            alert('Maksimal 5 teks pengumuman');
            return;
        }

        const newIndex = itemCount;
        const newItem = `
            <div class="announcement-item card mb-3 border" data-index="${newIndex}">
                <div class="card-body">
                    <div class="row align-items-start">
                        <div class="col-12 mb-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <h6 class="mb-0">
                                    <i class="ti ti-grip-vertical me-2 text-muted"></i>
                                    Teks #<span class="item-number">${newIndex + 1}</span>
                                </h6>
                                <button type="button" class="btn btn-sm btn-danger remove-item">
                                    <i class="ti ti-trash"></i> Hapus
                                </button>
                            </div>
                        </div>
                        <div class="col-lg-10">
                            <label class="form-label">Teks Pengumuman</label>
                            <input type="text" 
                                   class="form-control" 
                                   name="announcements[${newIndex}][title]" 
                                   placeholder="Flash Sale : Get 30% Off Destination Guides"
                                   maxlength="55"
                                   required>
                            <div class="form-text">
                                <span class="char-count">0</span>/55 karakter
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <label class="form-label">Status</label>
                            <div class="form-check form-switch mt-2">
                                <input class="form-check-input" 
                                       type="checkbox" 
                                       name="announcements[${newIndex}][is_active]"
                                       checked>
                                <label class="form-check-label">Aktif</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        `;

        container.insertAdjacentHTML('beforeend', newItem);
        itemCount++;
        updateRemoveButtons();
        updateItemNumbers();
    });

    // Remove item
    container.addEventListener('click', function(e) {
        if (e.target.closest('.remove-item')) {
            const items = container.querySelectorAll('.announcement-item');
            if (items.length <= 1) {
                alert('Minimal 1 teks pengumuman harus ada');
                return;
            }

            e.target.closest('.announcement-item').remove();
            itemCount--;
            updateRemoveButtons();
            updateItemNumbers();
            reindexItems();
        }
    });

    function updateRemoveButtons() {
        const items = container.querySelectorAll('.announcement-item');
        const removeButtons = container.querySelectorAll('.remove-item');
        
        if (items.length <= 1) {
            removeButtons.forEach(btn => btn.disabled = true);
        } else {
            removeButtons.forEach(btn => btn.disabled = false);
        }
    }

    function updateItemNumbers() {
        const items = container.querySelectorAll('.announcement-item');
        items.forEach((item, index) => {
            item.querySelector('.item-number').textContent = index + 1;
        });
    }

    function reindexItems() {
        const items = container.querySelectorAll('.announcement-item');
        items.forEach((item, index) => {
            item.setAttribute('data-index', index);
            
            const inputs = item.querySelectorAll('input, select, textarea');
            inputs.forEach(input => {
                const name = input.getAttribute('name');
                if (name) {
                    const newName = name.replace(/\[\d+\]/, `[${index}]`);
                    input.setAttribute('name', newName);
                }
            });
        });
    }

    // Initialize
    updateRemoveButtons();
});
</script>
@endsection
