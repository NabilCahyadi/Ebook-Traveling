{{--
    BLADE PERMISSION EXAMPLES
    
    This file contains examples of how to use permission checks in Blade views.
    Copy these patterns to your actual view files.
--}}

{{-- ==================== BASIC PERMISSION CHECKS ==================== --}}

{{-- Method 1: @adminCan directive (Admin guard only) --}}
@adminCan('admin.ebooks.create')
    <a href="{{ route('admin.ebooks.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Upload New Ebook
    </a>
@endAdminCan

{{-- Method 2: @hasPermission directive (Works for both guards) --}}
@hasPermission('admin.ebooks.approve')
    <button class="btn btn-success" onclick="approveEbook({{ $ebook->id }})">
        <i class="fas fa-check"></i> Approve
    </button>
    <button class="btn btn-danger" onclick="rejectEbook({{ $ebook->id }})">
        <i class="fas fa-times"></i> Reject
    </button>
@endHasPermission

{{-- Method 3: @canPermission directive (Alias for hasPermission) --}}
@canPermission('admin.users.edit')
    <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-sm btn-warning">
        Edit
    </a>
@endCanPermission

{{-- Method 4: Manual check using Auth facade --}}
@if(auth('admin')->check() && auth('admin')->user()->hasPermission('admin.ebooks.delete'))
    <form action="{{ route('admin.ebooks.destroy', $ebook->id) }}" method="POST" class="d-inline">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">
            Delete
        </button>
    </form>
@endif


{{-- ==================== SIDEBAR MENU EXAMPLES ==================== --}}

<ul class="nav nav-sidebar">
    {{-- Dashboard - Everyone can access --}}
    <li class="nav-item">
        <a href="{{ route('admin.dashboard') }}" class="nav-link">
            <i class="fas fa-tachometer-alt"></i> Dashboard
        </a>
    </li>

    {{-- Ebooks - Creators and Admins --}}
    @adminCan('admin.ebooks.view')
        <li class="nav-item">
            <a href="{{ route('admin.ebooks.index') }}" class="nav-link">
                <i class="fas fa-book"></i> Ebooks
            </a>
        </li>
    @endAdminCan

    {{-- Users - Admin only --}}
    @adminCan('admin.users.view')
        <li class="nav-item">
            <a href="{{ route('admin.users.index') }}" class="nav-link">
                <i class="fas fa-users"></i> Users
            </a>
        </li>
    @endAdminCan

    {{-- Categories - Admin only --}}
    @adminCan('admin.categories.view')
        <li class="nav-item">
            <a href="{{ route('admin.categories.index') }}" class="nav-link">
                <i class="fas fa-tags"></i> Categories
            </a>
        </li>
    @endAdminCan

    {{-- Settings - Admin only --}}
    @adminCan('admin.settings.view')
        <li class="nav-item">
            <a href="{{ route('admin.site-settings.index') }}" class="nav-link">
                <i class="fas fa-cog"></i> Settings
            </a>
        </li>
    @endAdminCan

    {{-- Activity Logs - Admin only --}}
    @adminCan('admin.activity_logs.view')
        <li class="nav-item">
            <a href="{{ route('admin.admin-activity-logs.index') }}" class="nav-link">
                <i class="fas fa-history"></i> Activity Logs
            </a>
        </li>
    @endAdminCan
</ul>


{{-- ==================== TABLE ACTION BUTTONS ==================== --}}

<table class="table">
    <thead>
        <tr>
            <th>Title</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($ebooks as $ebook)
            <tr>
                <td>{{ $ebook->title }}</td>
                <td>{{ $ebook->status }}</td>
                <td>
                    {{-- View button - Everyone can view --}}
                    <a href="{{ route('admin.ebooks.show', $ebook->id) }}" class="btn btn-sm btn-info">
                        View
                    </a>

                    {{-- Edit button - Check if can edit --}}
                    @adminCan('admin.ebooks.edit')
                        {{-- Additional check: Creator can only edit own ebooks --}}
                        @if(auth('admin')->user()->type === 'admin' || $ebook->creator_id === auth('admin')->id())
                            <a href="{{ route('admin.ebooks.edit', $ebook->id) }}" class="btn btn-sm btn-warning">
                                Edit
                            </a>
                        @endif
                    @endAdminCan

                    {{-- Approve button - Admin only --}}
                    @adminCan('admin.ebooks.approve')
                        @if($ebook->status === 'pending')
                            <button class="btn btn-sm btn-success" onclick="approve({{ $ebook->id }})">
                                Approve
                            </button>
                        @endif
                    @endAdminCan

                    {{-- Delete button - Check if can delete --}}
                    @adminCan('admin.ebooks.delete')
                        @if(auth('admin')->user()->type === 'admin' || $ebook->creator_id === auth('admin')->id())
                            <form action="{{ route('admin.ebooks.destroy', $ebook->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete this ebook?')">
                                    Delete
                                </button>
                            </form>
                        @endif
                    @endAdminCan
                </td>
            </tr>
        @endforeach
    </tbody>
</table>


{{-- ==================== CONDITIONAL SECTIONS ==================== --}}

{{-- Show different dashboard widgets based on permissions --}}
<div class="row">
    {{-- Stats for all users --}}
    <div class="col-md-3">
        <div class="card">
            <div class="card-body">
                <h5>My Ebooks</h5>
                <p class="display-4">{{ $myEbooksCount }}</p>
            </div>
        </div>
    </div>

    {{-- Admin-only stats --}}
    @adminCan('admin.users.view')
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h5>Total Users</h5>
                    <p class="display-4">{{ $totalUsers }}</p>
                </div>
            </div>
        </div>
    @endAdminCan

    @adminCan('admin.ebooks.approve')
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h5>Pending Approval</h5>
                    <p class="display-4">{{ $pendingEbooks }}</p>
                    <a href="{{ route('admin.ebooks.pending-approval') }}" class="btn btn-sm btn-primary">
                        Review
                    </a>
                </div>
            </div>
        </div>
    @endAdminCan

    @adminCan('admin.activity_logs.view')
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h5>Recent Activities</h5>
                    <a href="{{ route('admin.admin-activity-logs.index') }}" class="btn btn-sm btn-info">
                        View Logs
                    </a>
                </div>
            </div>
        </div>
    @endAdminCan
</div>


{{-- ==================== FORM FIELD VISIBILITY ==================== --}}

<form action="{{ route('admin.ebooks.update', $ebook->id) }}" method="POST">
    @csrf
    @method('PUT')

    {{-- Basic fields - Everyone can edit --}}
    <div class="form-group">
        <label>Title</label>
        <input type="text" name="title" class="form-control" value="{{ $ebook->title }}">
    </div>

    <div class="form-group">
        <label>Description</label>
        <textarea name="description" class="form-control">{{ $ebook->description }}</textarea>
    </div>

    {{-- Admin-only fields --}}
    @adminCan('admin.ebooks.approve')
        <div class="form-group">
            <label>Status</label>
            <select name="status" class="form-control">
                <option value="pending">Pending</option>
                <option value="approved" {{ $ebook->status === 'approved' ? 'selected' : '' }}>Approved</option>
                <option value="rejected" {{ $ebook->status === 'rejected' ? 'selected' : '' }}>Rejected</option>
            </select>
        </div>

        <div class="form-group">
            <label>Featured</label>
            <input type="checkbox" name="is_featured" {{ $ebook->is_featured ? 'checked' : '' }}>
        </div>
    @endAdminCan

    <button type="submit" class="btn btn-primary">Update</button>
</form>


{{-- ==================== ALERT MESSAGES ==================== --}}

{{-- Show permission-based welcome message --}}
@if(auth('admin')->check())
    @if(auth('admin')->user()->type === 'admin')
        <div class="alert alert-info">
            Welcome, Administrator! You have full access to all features.
        </div>
    @elseif(auth('admin')->user()->type === 'creator')
        <div class="alert alert-info">
            Welcome, Creator! You can manage your ebooks and view analytics.
        </div>
    @endif
@endif


{{-- ==================== DROPDOWN MENU WITH PERMISSIONS ==================== --}}

<div class="dropdown">
    <button class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown">
        Actions
    </button>
    <div class="dropdown-menu">
        <a class="dropdown-item" href="{{ route('admin.ebooks.show', $ebook->id) }}">View</a>
        
        @adminCan('admin.ebooks.edit')
            <a class="dropdown-item" href="{{ route('admin.ebooks.edit', $ebook->id) }}">Edit</a>
        @endAdminCan
        
        @adminCan('admin.ebooks.approve')
            <a class="dropdown-item" href="#" onclick="approve({{ $ebook->id }})">Approve</a>
        @endAdminCan
        
        @adminCan('admin.ebooks.delete')
            <div class="dropdown-divider"></div>
            <a class="dropdown-item text-danger" href="#" onclick="deleteEbook({{ $ebook->id }})">Delete</a>
        @endAdminCan
    </div>
</div>


{{-- ==================== PASSING PERMISSIONS TO JAVASCRIPT ==================== --}}

<script>
    // Pass permissions to JavaScript for dynamic UI
    window.userPermissions = {
        canEdit: {{ auth('admin')->user()->hasPermission('admin.ebooks.edit') ? 'true' : 'false' }},
        canDelete: {{ auth('admin')->user()->hasPermission('admin.ebooks.delete') ? 'true' : 'false' }},
        canApprove: {{ auth('admin')->user()->hasPermission('admin.ebooks.approve') ? 'true' : 'false' }},
    };

    // Use in JavaScript
    if (window.userPermissions.canApprove) {
        console.log('User can approve ebooks');
        // Show approve button dynamically
    }
</script>


{{-- ==================== COMPLEX CONDITIONAL LOGIC ==================== --}}

{{-- Show edit button only if: --}}
{{-- 1. User has edit permission AND --}}
{{-- 2. (User is admin OR user is the creator of the ebook) --}}
@php
    $canEdit = auth('admin')->user()->hasPermission('admin.ebooks.edit') && 
               (auth('admin')->user()->type === 'admin' || $ebook->creator_id === auth('admin')->id());
@endphp

@if($canEdit)
    <a href="{{ route('admin.ebooks.edit', $ebook->id) }}" class="btn btn-warning">
        Edit Ebook
    </a>
@endif
