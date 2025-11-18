@extends('admin.layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">

        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-bold py-3 mb-2">
                    <span class="text-muted fw-light">Admin /</span> Dashboard
                </h4>
            </div>
            <div>
                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger">
                        <i class="ti ti-logout me-2"></i>Logout
                    </button>
                </form>
            </div>
        </div>

        <!-- User Info Card -->
        <div class="row">
            <div class="col-md-12 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-start">
                            <div class="avatar me-3">
                                @if (Auth::user()->avatar)
                                    <img src="{{ Auth::user()->avatar }}" alt="Avatar" class="rounded-circle"
                                        width="100" height="100">
                                @else
                                    <div class="avatar avatar-xl">
                                        <span class="avatar-initial rounded-circle bg-label-primary"
                                            style="width: 100px; height: 100px; font-size: 40px;">
                                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                        </span>
                                    </div>
                                @endif
                            </div>
                            <div class="flex-grow-1">
                                <h5 class="mb-1">{{ Auth::user()->name }}</h5>
                                <p class="mb-2 text-muted">{{ Auth::user()->email }}</p>
                                <div class="d-flex gap-3">
                                    <span class="badge bg-label-success">{{ ucfirst(Auth::user()->status) }}</span>
                                    @if (Auth::user()->google_id)
                                        <span class="badge bg-label-info">
                                            <i class="ti ti-brand-google me-1"></i>Google Account
                                        </span>
                                    @endif
                                </div>
                                <div class="mt-3">
                                    <small class="text-muted">
                                        <i class="ti ti-calendar me-1"></i>
                                        Member since {{ Auth::user()->created_at->format('F d, Y') }}
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Stats -->
        <div class="row">
            <div class="col-lg-3 col-sm-6 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="avatar me-3">
                                <div class="avatar-initial bg-label-primary rounded">
                                    <i class="ti ti-book ti-md"></i>
                                </div>
                            </div>
                            <div>
                                <h4 class="mb-0">{{ \App\Models\Ebook::count() }}</h4>
                                <small class="text-muted">Total Ebooks</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="avatar me-3">
                                <div class="avatar-initial bg-label-success rounded">
                                    <i class="ti ti-check ti-md"></i>
                                </div>
                            </div>
                            <div>
                                <h4 class="mb-0">{{ \App\Models\Ebook::where('status', 'active')->count() }}</h4>
                                <small class="text-muted">Active Ebooks</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="avatar me-3">
                                <div class="avatar-initial bg-label-warning rounded">
                                    <i class="ti ti-users ti-md"></i>
                                </div>
                            </div>
                            <div>
                                <h4 class="mb-0">{{ \App\Models\User::count() }}</h4>
                                <small class="text-muted">Total Users</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="avatar me-3">
                                <div class="avatar-initial bg-label-info rounded">
                                    <i class="ti ti-map-pin ti-md"></i>
                                </div>
                            </div>
                            <div>
                                <h4 class="mb-0">{{ \App\Models\City::count() }}</h4>
                                <small class="text-muted">Cities</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Ebooks Table -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Recent Ebooks</h5>
                        <a href="{{ route('admin.ebooks.index') }}" class="btn btn-sm btn-primary">
                            View All
                        </a>
                    </div>
                    <div class="table-responsive text-nowrap">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Cover</th>
                                    <th>Title</th>
                                    <th>Author</th>
                                    <th>Category</th>
                                    <th>City</th>
                                    <th>Status</th>
                                    <th>Created</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($ebooks as $ebook)
                                    <tr>
                                        <td>{{ $ebook->id }}</td>
                                        <td>
                                            @if ($ebook->cover_image)
                                                <img src="{{ asset('storage/' . $ebook->cover_image) }}" alt="Cover"
                                                    class="rounded" width="50" height="70"
                                                    style="object-fit: cover;">
                                            @else
                                                <div class="bg-label-secondary rounded d-flex align-items-center justify-content-center"
                                                    style="width: 50px; height: 70px;">
                                                    <i class="ti ti-book ti-md"></i>
                                                </div>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="d-flex flex-column">
                                                <span class="fw-medium">{{ Str::limit($ebook->title, 50) }}</span>
                                                <small class="text-muted">{{ $ebook->slug }}</small>
                                            </div>
                                        </td>
                                        <td>{{ $ebook->author }}</td>
                                        <td>
                                            @if ($ebook->category)
                                                <span class="badge bg-label-primary">{{ $ebook->category->name }}</span>
                                            @else
                                                <span class="badge bg-label-secondary">No Category</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($ebook->city)
                                                <span class="badge bg-label-info">{{ $ebook->city->name }}</span>
                                            @else
                                                <span class="badge bg-label-secondary">No City</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($ebook->status === 'active')
                                                <span class="badge bg-label-success">Active</span>
                                            @else
                                                <span class="badge bg-label-danger">Inactive</span>
                                            @endif
                                        </td>
                                        <td>{{ $ebook->created_at->format('M d, Y') }}</td>
                                        <td>
                                            <div class="dropdown">
                                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                    data-bs-toggle="dropdown">
                                                    <i class="ti ti-dots-vertical"></i>
                                                </button>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item"
                                                        href="{{ route('admin.ebooks.show', $ebook->id) }}">
                                                        <i class="ti ti-eye me-1"></i> View
                                                    </a>
                                                    <a class="dropdown-item"
                                                        href="{{ route('admin.ebooks.edit', $ebook->id) }}">
                                                        <i class="ti ti-pencil me-1"></i> Edit
                                                    </a>
                                                    <form action="{{ route('admin.ebooks.destroy', $ebook->id) }}"
                                                        method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="dropdown-item"
                                                            onclick="return confirm('Are you sure you want to delete this ebook?')">
                                                            <i class="ti ti-trash me-1"></i> Delete
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center py-4">
                                            <i class="ti ti-book-off ti-lg text-muted d-block mb-2"></i>
                                            <span class="text-muted">No ebooks found</span>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    @if ($ebooks->hasPages())
                        <div class="card-footer">
                            {{ $ebooks->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>

    </div>
@endsection
