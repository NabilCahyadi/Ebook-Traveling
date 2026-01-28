@extends('layouts.admin')

@section('title', 'Tambah Benefit')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.about-us-sections.index') }}">About Us</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.about-us.index') }}">Benefits</a></li>
            <li class="breadcrumb-item active">Tambah</li>
        </ol>
    </nav>

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1"><span class="text-muted fw-light">About Us /</span> Tambah Benefit</h4>
            <p class="text-muted mb-0">Tambah keuntungan/manfaat baru</p>
        </div>
        <a href="{{ route('admin.about-us.index') }}" class="btn btn-outline-secondary">
            <i class="bx bx-arrow-back me-1"></i> Kembali
        </a>
    </div>

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Form -->
    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.about-us.store') }}" method="POST">
                @csrf

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="icon" class="form-label">Icon <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text"><i id="icon-preview" class="bx bx-star"></i></span>
                            <input type="text" class="form-control @error('icon') is-invalid @enderror" 
                                id="icon" name="icon" value="{{ old('icon', 'bx bx-star') }}" 
                                placeholder="bx bx-star" required>
                        </div>
                        <small class="text-muted">Gunakan class icon dari <a href="https://boxicons.com/" target="_blank">Boxicons</a></small>
                        @error('icon')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="sort_order" class="form-label">Urutan Tampil</label>
                        <input type="number" class="form-control @error('sort_order') is-invalid @enderror" 
                            id="sort_order" name="sort_order" value="{{ old('sort_order') }}" 
                            min="0" placeholder="Kosongkan untuk otomatis">
                        @error('sort_order')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label for="title" class="form-label">Judul <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('title') is-invalid @enderror" 
                        id="title" name="title" value="{{ old('title') }}" required>
                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Deskripsi <span class="text-danger">*</span></label>
                    <textarea class="form-control @error('description') is-invalid @enderror" 
                        id="description" name="description" rows="4" required>{{ old('description') }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="status" name="status" value="1" 
                            {{ old('status', true) ? 'checked' : '' }}>
                        <label class="form-check-label" for="status">Aktif</label>
                    </div>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="bx bx-save me-1"></i> Simpan
                    </button>
                    <a href="{{ route('admin.about-us.index') }}" class="btn btn-outline-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.getElementById('icon').addEventListener('input', function() {
    document.getElementById('icon-preview').className = this.value || 'bx bx-star';
});
</script>
@endpush
