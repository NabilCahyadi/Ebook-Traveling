@extends('layouts.admin')

@section('title', 'User Management')

@section('content')

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
                <span class="text-muted fw-light">Admin /</span> User Management
                @if (isset($roleSlug) && $roleSlug)
                    <span class="badge bg-label-primary ms-2">
                        {{ ucfirst(str_replace('-', ' ', $roleSlug)) }}
                    </span>
                @endif
                @if ($showTrashed ?? false)
                    <span class="badge bg-label-danger ms-2">Trashed Users</span>
                @endif
            </h4>
        </div>
        <div>
            @if ($showTrashed ?? false)
                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary me-2">
                    <i class="ti ti-arrow-left me-1"></i> Back to Active Users
                </a>
            @else
                <a href="{{ route('admin.users.trashed') }}" class="btn btn-outline-danger me-2">
                    <i class="ti ti-trash me-1"></i> View Trashed Users
                </a>
            @endif
            <a href="{{ route('admin.users.create', ['role' => $roleSlug ?? '']) }}" class="btn btn-primary">
                <i class="ti ti-plus me-1"></i> Add New 
                @if (isset($roleSlug) && $roleSlug && $roleSlug !== 'all')
                    {{ ucfirst($roleSlug) }}
                @else
                    User
                @endif
            </a>
        </div>
    </div>

    <!-- Users Table -->
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Users List</h5>
            <div class="text-muted">Total: {{ $users->total() }} users</div>
        </div>

        <!-- Search Filter -->
        <div class="card-body border-bottom">
            <form action="{{ route('admin.users.index') }}" method="GET" class="row g-3">
                @if (isset($roleSlug) && $roleSlug)
                    <input type="hidden" name="role" value="{{ $roleSlug }}">
                @endif
                <div class="col-md-10">
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="ti ti-search"></i>
                        </span>
                        <input type="text" class="form-control" name="search" value="{{ $search ?? '' }}"
                            placeholder="Search by name, email, or phone...">
                    </div>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="ti ti-search me-1"></i> Search
                    </button>
                </div>
                @if (isset($search) && $search)
                    <div class="col-12">
                        <a href="{{ route('admin.users.index', ['role' => $roleSlug]) }}"
                            class="btn btn-sm btn-outline-secondary">
                            <i class="ti ti-x me-1"></i> Clear Filter
                        </a>
                        <span class="text-muted ms-2">Showing results for: <strong>"{{ $search }}"</strong></span>
                    </div>
                @endif
            </form>
        </div>

        <div class="card-body">
            @if ($users->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role(s)</th>
                                <th>Google ID</th>
                                <th>Registered</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr @if ($user->trashed()) class="table-danger" @endif>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar avatar-sm me-2">
                                                <span class="avatar-initial rounded-circle bg-label-primary">
                                                    {{ substr($user->name, 0, 1) }}
                                                </span>
                                            </div>
                                            <div>
                                                <div class="fw-medium">
                                                    {{ $user->name }}
                                                    @if ($user->trashed())
                                                        <i class="ti ti-trash text-danger ms-1" title="Deleted"></i>
                                                    @endif
                                                </div>
                                                @if ($user->id === auth()->id())
                                                    <small class="badge bg-label-success">You</small>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div>{{ $user->email }}</div>
                                        @if ($user->email_verified_at)
                                            <small class="text-success">
                                                <i class="ti ti-check ti-xs"></i> Verified
                                            </small>
                                        @else
                                            <small class="text-muted">
                                                <i class="ti ti-x ti-xs"></i> Not verified
                                            </small>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($user->roles && $user->roles->count() > 0)
                                            @foreach ($user->roles as $role)
                                                <span class="badge bg-label-primary mb-1">{{ $role->name }}</span>
                                            @endforeach
                                        @else
                                            <span class="badge bg-label-secondary">No Role</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($user->google_id)
                                            <span class="badge bg-label-info">
                                                <i class="ti ti-brand-google ti-xs"></i> Linked
                                            </span>
                                        @else
                                            <span class="badge bg-label-secondary">
                                                <i class="ti ti-user ti-xs"></i> Regular
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        <small class="text-muted">
                                            {{ $user->created_at->format('d M Y') }}<br>
                                            {{ $user->created_at->format('H:i') }}
                                        </small>
                                    </td>
                                    <td>
                                        <div class="dropdown">
                                            <button type="button"
                                                class="btn btn-sm btn-icon btn-text-secondary rounded-pill dropdown-toggle hide-arrow"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="ti ti-dots-vertical"></i>
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-end">
                                                @if (!$user->trashed())
                                                    {{-- Actions for active users --}}
                                                    <a class="dropdown-item" href="javascript:void(0);"
                                                        onclick="editUser('{{ $user->id }}', '{{ $user->name }}', '{{ $user->email }}')">
                                                        <i class="ti ti-pencil me-2"></i>
                                                        <span>Edit</span>
                                                    </a>
                                                    <a class="dropdown-item"
                                                        href="{{ route('admin.users.show', $user->id) }}">
                                                        <i class="ti ti-eye me-2"></i>
                                                        <span>View Details</span>
                                                    </a>
                                                    @if ($user->id !== auth()->id())
                                                        <div class="dropdown-divider"></div>
                                                        @if (!$user->email_verified_at)
                                                            <a class="dropdown-item text-success" href="javascript:void(0);"
                                                                onclick="event.preventDefault(); if(confirm('Are you sure you want to verify this user email?')) document.getElementById('verify-form-{{ $user->id }}').submit();">
                                                                <i class="ti ti-circle-check me-2"></i>
                                                                <span>Verify Email</span>
                                                            </a>
                                                            <form id="verify-form-{{ $user->id }}"
                                                                action="{{ route('admin.users.verify-email', $user->id) }}"
                                                                method="POST" style="display: none;">
                                                                @csrf
                                                                @method('PATCH')
                                                            </form>
                                                        @else
                                                            <a class="dropdown-item text-secondary" href="javascript:void(0);"
                                                                onclick="event.preventDefault(); if(confirm('Are you sure you want to unverify this user email?')) document.getElementById('unverify-form-{{ $user->id }}').submit();">
                                                                <i class="ti ti-circle-x me-2"></i>
                                                                <span>Unverify Email</span>
                                                            </a>
                                                            <form id="unverify-form-{{ $user->id }}"
                                                                action="{{ route('admin.users.unverify-email', $user->id) }}"
                                                                method="POST" style="display: none;">
                                                                @csrf
                                                                @method('PATCH')
                                                            </form>
                                                        @endif
                                                        <div class="dropdown-divider"></div>
                                                        <a class="dropdown-item text-warning" href="javascript:void(0);"
                                                            onclick="event.preventDefault(); if(confirm('Are you sure you want to move this user to trash?')) document.getElementById('delete-form-{{ $user->id }}').submit();">
                                                            <i class="ti ti-trash me-2"></i>
                                                            <span>Move to Trash</span>
                                                        </a>
                                                        <form id="delete-form-{{ $user->id }}"
                                                            action="{{ route('admin.users.destroy', $user->id) }}"
                                                            method="POST" style="display: none;">
                                                            @csrf
                                                            @method('DELETE')
                                                        </form>
                                                    @endif
                                                @else
                                                    {{-- Actions for trashed users --}}
                                                    <a class="dropdown-item text-success" href="javascript:void(0);"
                                                        onclick="event.preventDefault(); if(confirm('Are you sure you want to restore this user?')) document.getElementById('restore-form-{{ $user->id }}').submit();">
                                                        <i class="ti ti-restore me-2"></i>
                                                        <span>Restore</span>
                                                    </a>
                                                    <form id="restore-form-{{ $user->id }}"
                                                        action="{{ route('admin.users.restore', $user->id) }}"
                                                        method="POST" style="display: none;">
                                                        @csrf
                                                        @method('PATCH')
                                                    </form>
                                                    @if ($user->id !== auth()->id())
                                                        <div class="dropdown-divider"></div>
                                                        <a class="dropdown-item text-danger" href="javascript:void(0);"
                                                            onclick="event.preventDefault(); if(confirm('Are you sure you want to permanently delete this user? This action cannot be undone!')) document.getElementById('force-delete-form-{{ $user->id }}').submit();">
                                                            <i class="ti ti-trash-x me-2"></i>
                                                            <span>Delete Permanently</span>
                                                        </a>
                                                        <form id="force-delete-form-{{ $user->id }}"
                                                            action="{{ route('admin.users.force-delete', $user->id) }}"
                                                            method="POST" style="display: none;">
                                                            @csrf
                                                            @method('DELETE')
                                                        </form>
                                                    @endif
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="mt-4">
                    {{ $users->appends(['role' => $roleSlug, 'search' => $search])->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="ti ti-users-off ti-xl text-muted mb-3"></i>
                    <h5 class="text-muted">No users found</h5>
                    <p class="text-muted">Start by creating your first user</p>
                    <a href="{{ route('admin.users.create', ['role' => $roleSlug ?? '']) }}" class="btn btn-primary mt-2">
                        <i class="ti ti-plus me-1"></i> Add New 
                        @if (isset($roleSlug) && $roleSlug && $roleSlug !== 'all')
                            {{ ucfirst($roleSlug) }}
                        @else
                            User
                        @endif
                    </a>
                </div>
            @endif
        </div>
    </div>
    </div>

    <!-- Create Modal -->
    <div class="modal fade" id="createModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="{{ route('admin.users.store') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Create New User</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="name" class="form-label">Full Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                name="name" value="{{ old('name') }}" placeholder="e.g. John Doe" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address <span
                                    class="text-danger">*</span></label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror"
                                id="email" name="email" value="{{ old('email') }}"
                                placeholder="e.g. user@example.com" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror"
                                id="password" name="password" placeholder="Min. 8 characters" required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Confirm Password <span
                                    class="text-danger">*</span></label>
                            <input type="password" class="form-control" id="password_confirmation"
                                name="password_confirmation" placeholder="Retype password" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="ti ti-device-floppy me-1"></i> Create User
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
                        <h5 class="modal-title">Edit User</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="edit_name" class="form-label">Full Name <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="edit_name" name="name"
                                placeholder="e.g. John Doe" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_email" class="form-label">Email Address <span
                                    class="text-danger">*</span></label>
                            <input type="email" class="form-control" id="edit_email" name="email"
                                placeholder="e.g. user@example.com" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_password" class="form-label">New Password</label>
                            <input type="password" class="form-control" id="edit_password" name="password"
                                placeholder="Leave blank to keep current password">
                            <small class="text-muted">Only fill if you want to change password</small>
                        </div>
                        <div class="mb-3">
                            <label for="edit_password_confirmation" class="form-label">Confirm New Password</label>
                            <input type="password" class="form-control" id="edit_password_confirmation"
                                name="password_confirmation" placeholder="Retype new password">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="ti ti-device-floppy me-1"></i> Update User
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            function editUser(id, name, email) {
                document.getElementById('editForm').action = '/admin/users/' + id;
                document.getElementById('edit_name').value = name;
                document.getElementById('edit_email').value = email;
                document.getElementById('edit_password').value = '';
                document.getElementById('edit_password_confirmation').value = '';
                new bootstrap.Modal(document.getElementById('editModal')).show();
            }

            // Show create modal if validation error exists
            @if ($errors->any() && !old('_method'))
                new bootstrap.Modal(document.getElementById('createModal')).show();
            @elseif ($errors->any() && old('_method') === 'PUT')
                // Show edit modal if edit validation failed
                // You might need to pass user data back to show the modal
            @endif
        </script>
    @endpush
@endsection
