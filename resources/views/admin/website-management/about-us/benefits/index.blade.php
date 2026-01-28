@extends('layouts.admin')

@section('title', 'About Us Benefits')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.about-us-sections.index') }}">About Us</a></li>
            <li class="breadcrumb-item active">Benefits</li>
        </ol>
    </nav>

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1"><span class="text-muted fw-light">Website /</span> About Us Benefits</h4>
            <p class="text-muted mb-0">Kelola keuntungan/manfaat yang ditampilkan di halaman About Us</p>
        </div>
        <div>
            <a href="{{ route('admin.about-us.create') }}" class="btn btn-primary">
                <i class="bx bx-plus me-1"></i> Tambah Benefit
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Benefits List -->
    <div class="card">
        <div class="card-body">
            @if($benefits->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th width="50">No</th>
                                <th width="80">Icon</th>
                                <th>Judul</th>
                                <th>Deskripsi</th>
                                <th width="100">Urutan</th>
                                <th width="100">Status</th>
                                <th width="120">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="sortable-benefits">
                            @foreach($benefits as $index => $benefit)
                                <tr data-id="{{ $benefit->id }}">
                                    <td>{{ $index + 1 }}</td>
                                    <td>
                                        <i class="{{ $benefit->icon }} fs-4 text-primary"></i>
                                    </td>
                                    <td>{{ $benefit->title }}</td>
                                    <td>{{ Str::limit(strip_tags($benefit->description), 50) }}</td>
                                    <td>{{ $benefit->sort_order }}</td>
                                    <td>
                                        <span class="badge bg-{{ $benefit->status === 'active' ? 'success' : 'secondary' }}">
                                            {{ ucfirst($benefit->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="dropdown">
                                            <button type="button" class="btn btn-sm btn-icon dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                                <i class="bx bx-dots-vertical-rounded"></i>
                                            </button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" href="{{ route('admin.about-us.edit', $benefit->id) }}">
                                                    <i class="bx bx-edit-alt me-2"></i> Edit
                                                </a>
                                                <button type="button" class="dropdown-item" onclick="toggleStatus({{ $benefit->id }})">
                                                    <i class="bx bx-{{ $benefit->status === 'active' ? 'hide' : 'show' }} me-2"></i>
                                                    {{ $benefit->status === 'active' ? 'Nonaktifkan' : 'Aktifkan' }}
                                                </button>
                                                <div class="dropdown-divider"></div>
                                                <form action="{{ route('admin.about-us.destroy', $benefit->id) }}" method="POST" class="d-inline delete-form">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="dropdown-item text-danger" onclick="return confirm('Yakin ingin menghapus benefit ini?')">
                                                        <i class="bx bx-trash me-2"></i> Hapus
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="bx bx-info-circle fs-1 text-muted mb-3"></i>
                    <h5>Belum ada benefit</h5>
                    <p class="text-muted">Klik tombol "Tambah Benefit" untuk menambahkan benefit baru</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function toggleStatus(id) {
    fetch(`{{ url('admin/about-us') }}/${id}/toggle-status`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert(data.message || 'Terjadi kesalahan');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan');
    });
}
</script>
@endpush
