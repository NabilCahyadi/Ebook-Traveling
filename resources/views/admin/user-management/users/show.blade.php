@extends('layouts.admin')

@section('title', 'User Detail - ' . $user->name)

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">

        <!-- Page Header -->
        <div class="mb-4">
            <h4 class="fw-bold py-3 mb-2">
                <span class="text-muted fw-light">{{ __('admin.menu.user_management') }} / {{ __('admin.users.title') }} /</span> 
                Detail
            </h4>
        </div>

        <!-- User Information Cards -->
        <div class="row">
            <!-- Left Column - Profile Card -->
            <div class="col-lg-4 col-md-5">
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="text-center mb-4">
                            @if ($user->avatar)
                                <img src="{{ Storage::url($user->avatar) }}" alt="Avatar" 
                                    class="rounded-circle" width="120" height="120" style="object-fit: cover;">
                            @else
                                <div class="d-inline-flex align-items-center justify-content-center rounded-circle" 
                                    style="width: 120px; height: 120px; background: linear-gradient(135deg, #e8eaf6 0%, #f5f5f5 100%); border: 3px solid #fff; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                                    <span style="font-size: 3rem; font-weight: 600; color: #5a5a5a;">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </span>
                                </div>
                            @endif
                        </div>

                        <h4 class="text-center mb-2">{{ $user->name }}</h4>
                        <p class="text-center text-muted mb-3">{{ $user->email }}</p>

                        <!-- Status Badge -->
                        <div class="text-center mb-3">
                            @if ($user->deleted_at)
                                <span class="badge bg-danger">Deleted</span>
                            @elseif ($user->email_verified_at)
                                <span class="badge bg-success">Verified</span>
                            @else
                                <span class="badge bg-warning">Unverified</span>
                            @endif

                            @if ($user->google_id)
                                <span class="badge bg-info ms-1">
                                    <i class="ti ti-brand-google"></i> Google
                                </span>
                            @endif
                        </div>

                        <!-- User Roles -->
                        @if ($user->roles && $user->roles->count() > 0)
                        <div class="mb-3">
                            <h6 class="mb-2">Roles:</h6>
                            @foreach ($user->roles as $role)
                                @php
                                    $badgeColors = [
                                        'Creator' => 'bg-label-success',
                                        'Reader' => 'bg-label-info',
                                        'Admin' => 'bg-label-danger',
                                        'Super Admin' => 'bg-label-primary',
                                    ];
                                    $badgeClass = $badgeColors[$role->name] ?? 'bg-label-warning';
                                @endphp
                                <span class="badge {{ $badgeClass }} me-1">{{ $role->name }}</span>
                            @endforeach
                        </div>
                        @endif

                        <!-- Quick Actions -->
                        <div class="d-grid gap-2 mt-4">
                            @if(auth('admin')->user()->isSuperAdmin() || auth('admin')->user()->hasPermission('users.edit'))
                            <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-primary">
                                <i class="ti ti-edit me-1"></i> Edit User
                            </a>
                            @endif

                            @if (!$user->email_verified_at && (auth('admin')->user()->isSuperAdmin() || auth('admin')->user()->hasPermission('users.edit')))
                            <form action="{{ route('admin.users.verify-email', $user->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-success w-100">
                                    <i class="ti ti-check me-1"></i> Verify Email
                                </button>
                            </form>
                            @endif

                            <a href="{{ route('admin.users.index') }}" class="btn btn-label-secondary">
                                <i class="ti ti-arrow-left me-1"></i> Back to List
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column - Details Tab -->
            <div class="col-lg-8 col-md-7">
                <!-- Nav tabs -->
                <ul class="nav nav-pills mb-4" id="userTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="overview-tab" data-bs-toggle="tab" 
                            data-bs-target="#overview" type="button" role="tab">
                            <i class="ti ti-user me-1"></i> Overview
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="account-tab" data-bs-toggle="tab" 
                            data-bs-target="#account" type="button" role="tab">
                            <i class="ti ti-settings me-1"></i> Account Info
                        </button>
                    </li>
                    @if ($user->subscriptions && $user->subscriptions->count() > 0)
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="subscriptions-tab" data-bs-toggle="tab" 
                            data-bs-target="#subscriptions" type="button" role="tab">
                            <i class="ti ti-credit-card me-1"></i> Subscriptions
                        </button>
                    </li>
                    @endif
                </ul>

                <!-- Tab content -->
                <div class="tab-content">
                    <!-- Overview Tab -->
                    <div class="tab-pane fade show active" id="overview" role="tabpanel">
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="mb-0">Personal Information</h5>
                            </div>
                            <div class="card-body">
                                <div class="row mb-3">
                                    <div class="col-sm-4">
                                        <strong>Full Name:</strong>
                                    </div>
                                    <div class="col-sm-8">
                                        {{ $user->name }}
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-sm-4">
                                        <strong>Email:</strong>
                                    </div>
                                    <div class="col-sm-8">
                                        {{ $user->email }}
                                        @if ($user->email_verified_at)
                                            <i class="ti ti-circle-check text-success ms-1" title="Verified"></i>
                                        @else
                                            <i class="ti ti-alert-circle text-warning ms-1" title="Not Verified"></i>
                                        @endif
                                    </div>
                                </div>

                                @if ($user->phone)
                                <div class="row mb-3">
                                    <div class="col-sm-4">
                                        <strong>Phone:</strong>
                                    </div>
                                    <div class="col-sm-8">
                                        {{ $user->phone }}
                                    </div>
                                </div>
                                @endif

                                <div class="row mb-3">
                                    <div class="col-sm-4">
                                        <strong>User Type:</strong>
                                    </div>
                                    <div class="col-sm-8">
                                        <span class="badge bg-label-info">{{ ucfirst($user->user_type ?? 'user') }}</span>
                                    </div>
                                </div>

                                @if ($user->google_id)
                                <div class="row mb-3">
                                    <div class="col-sm-4">
                                        <strong>Google ID:</strong>
                                    </div>
                                    <div class="col-sm-8">
                                        {{ $user->google_id }}
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>

                        <!-- Statistics Card -->
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">User Statistics</h5>
                            </div>
                            <div class="card-body">
                                <div class="row text-center">
                                    <div class="col-4">
                                        <div class="d-flex flex-column">
                                            <div class="mb-2">
                                                <i class="ti ti-book-2 ti-lg text-primary"></i>
                                            </div>
                                            <h4 class="mb-0">{{ $user->savedBooks->count() ?? 0 }}</h4>
                                            <small class="text-muted">Saved Books</small>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="d-flex flex-column">
                                            <div class="mb-2">
                                                <i class="ti ti-book-upload ti-lg text-success"></i>
                                            </div>
                                            <h4 class="mb-0">{{ $user->readings->count() ?? 0 }}</h4>
                                            <small class="text-muted">Reading History</small>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="d-flex flex-column">
                                            <div class="mb-2">
                                                <i class="ti ti-credit-card ti-lg text-info"></i>
                                            </div>
                                            <h4 class="mb-0">{{ $user->subscriptions->count() ?? 0 }}</h4>
                                            <small class="text-muted">Subscriptions</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Account Info Tab -->
                    <div class="tab-pane fade" id="account" role="tabpanel">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="mb-4">Account Details</h5>
                                <div class="row mb-3">
                                    <div class="col-sm-4">
                                        <strong>User ID:</strong>
                                    </div>
                                    <div class="col-sm-8">
                                        <code>{{ $user->id }}</code>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-sm-4">
                                        <strong>Registration Date:</strong>
                                    </div>
                                    <div class="col-sm-8">
                                        {{ $user->created_at->format('d M Y, H:i') }}
                                        <small class="text-muted">({{ $user->created_at->diffForHumans() }})</small>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-sm-4">
                                        <strong>Last Updated:</strong>
                                    </div>
                                    <div class="col-sm-8">
                                        {{ $user->updated_at->format('d M Y, H:i') }}
                                        <small class="text-muted">({{ $user->updated_at->diffForHumans() }})</small>
                                    </div>
                                </div>

                                @if ($user->email_verified_at)
                                <div class="row mb-3">
                                    <div class="col-sm-4">
                                        <strong>Email Verified At:</strong>
                                    </div>
                                    <div class="col-sm-8">
                                        {{ $user->email_verified_at->format('d M Y, H:i') }}
                                    </div>
                                </div>
                                @endif

                                @if ($user->deleted_at)
                                <div class="row mb-3">
                                    <div class="col-sm-4">
                                        <strong>Deleted At:</strong>
                                    </div>
                                    <div class="col-sm-8">
                                        <span class="text-danger">
                                            {{ $user->deleted_at->format('d M Y, H:i') }}
                                            ({{ $user->deleted_at->diffForHumans() }})
                                        </span>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Subscriptions Tab -->
                    @if ($user->subscriptions && $user->subscriptions->count() > 0)
                    <div class="tab-pane fade" id="subscriptions" role="tabpanel">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">Subscription History</h5>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Plan</th>
                                                <th>Status</th>
                                                <th>Start Date</th>
                                                <th>End Date</th>
                                                <th>Price</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($user->subscriptions as $subscription)
                                            <tr>
                                                <td>
                                                    <strong>{{ $subscription->subscriptionPlan->name ?? 'N/A' }}</strong>
                                                </td>
                                                <td>
                                                    @if ($subscription->status === 'active')
                                                        <span class="badge bg-success">Active</span>
                                                    @elseif ($subscription->status === 'expired')
                                                        <span class="badge bg-danger">Expired</span>
                                                    @elseif ($subscription->status === 'cancelled')
                                                        <span class="badge bg-warning">Cancelled</span>
                                                    @else
                                                        <span class="badge bg-secondary">{{ ucfirst($subscription->status) }}</span>
                                                    @endif
                                                </td>
                                                <td>{{ \Carbon\Carbon::parse($subscription->start_date)->format('d M Y') }}</td>
                                                <td>{{ \Carbon\Carbon::parse($subscription->end_date)->format('d M Y') }}</td>
                                                <td>Rp {{ number_format($subscription->price ?? 0, 0, ',', '.') }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    // Auto-hide alerts after 3 seconds
    setTimeout(function() {
        $('.alert').fadeOut('slow');
    }, 3000);
</script>
@endpush
