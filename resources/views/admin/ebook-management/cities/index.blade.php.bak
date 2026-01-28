@extends('layouts.admin')

@section('title', 'Cities Management')

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
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-bold py-3 mb-2">
                    <span class="text-muted fw-light">Master Data /</span> Cities
                </h4>
            </div>
            <div>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal">
                    <i class="ti ti-plus me-1"></i> Add New City
                </button>
            </div>
        </div>

        <!-- Cities Table -->
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Cities</h5>
                <div class="text-muted">Total: {{ $cities->total() }} cities</div>
            </div>
            <div class="card-body">
                @if ($cities->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>City Name</th>
                                    <th>Country</th>
                                    <th>Total Ebooks</th>
                                    <th>Created</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($cities as $city)
                                    <tr>
                                        <td><strong>#{{ $city->id }}</strong></td>
                                        <td>
                                            <div class="fw-medium">
                                                <i class="ti ti-map-pin ti-xs me-1"></i>
                                                {{ $city->name }}
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge bg-label-primary">{{ $city->country }}</span>
                                        </td>
                                        <td>
                                            <span class="badge bg-label-info">{{ $city->ebooks_count }} ebooks</span>
                                        </td>
                                        <td>
                                            <small class="text-muted">{{ $city->created_at->format('d M Y') }}</small>
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-sm btn-icon btn-primary"
                                                onclick="editCity({{ $city->id }}, '{{ $city->name }}', '{{ $city->country }}')">
                                                <i class="ti ti-pencil"></i>
                                            </button>
                                            <form action="{{ route('admin.cities.destroy', $city->id) }}" method="POST"
                                                class="d-inline"
                                                onsubmit="return confirm('Are you sure you want to delete this city?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-icon btn-danger">
                                                    <i class="ti ti-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-4">
                        {{ $cities->links() }}
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="ti ti-map-off ti-xl text-muted mb-3"></i>
                        <h5 class="text-muted">No cities found</h5>
                        <p class="text-muted">Start by creating your first city</p>
                        <button type="button" class="btn btn-primary mt-2" data-bs-toggle="modal"
                            data-bs-target="#createModal">
                            <i class="ti ti-plus me-1"></i> Add New City
                        </button>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Create Modal -->
    <div class="modal fade" id="createModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="{{ route('admin.cities.store') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Create New City</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="name" class="form-label">City Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                name="name" value="{{ old('name') }}" placeholder="e.g. Bali" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="country" class="form-label">Country <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('country') is-invalid @enderror" id="country"
                                name="country" value="{{ old('country') }}" placeholder="e.g. Indonesia" required>
                            @error('country')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="ti ti-device-floppy me-1"></i> Create City
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form id="editForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title">Edit City</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="edit_name" class="form-label">City Name <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="edit_name" name="name"
                                placeholder="e.g. Bali" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_country" class="form-label">Country <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="edit_country" name="country"
                                placeholder="e.g. Indonesia" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="ti ti-device-floppy me-1"></i> Update City
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            function editCity(id, name, country) {
                document.getElementById('editForm').action = '/admin/cities/' + id;
                document.getElementById('edit_name').value = name;
                document.getElementById('edit_country').value = country;
                new bootstrap.Modal(document.getElementById('editModal')).show();
            }

            // Show create modal if validation error exists
            @if ($errors->any())
                new bootstrap.Modal(document.getElementById('createModal')).show();
            @endif
        </script>
    @endpush
@endsection
