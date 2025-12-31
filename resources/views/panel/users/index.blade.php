@extends('layouts.panel')

@section('title', 'User Management')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold py-3 mb-0">
            <span class="text-muted fw-light">Panel /</span> User Management
        </h4>
        
        @if(auth()->user()->hasPermission('panel.users.create'))
        <a href="{{ route('panel.users.create') }}" class="btn btn-primary">
            <i class="ti ti-plus me-1"></i>Add User
        </a>
        @endif
    </div>

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Users List</h5>
            <div class="d-flex gap-2">
                <input type="text" class="form-control form-control-sm" placeholder="Search users..." style="width: 250px;">
            </div>
        </div>
        
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Joined</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}" class="rounded-circle me-2" width="32" height="32">
                                <span>{{ $user->name }}</span>
                            </div>
                        </td>
                        <td>{{ $user->email }}</td>
                        <td>
                            <span class="badge bg-label-primary">{{ ucfirst($user->user_type) }}</span>
                        </td>
                        <td>
                            @if($user->status === 'active')
                                <span class="badge bg-label-success">Active</span>
                            @else
                                <span class="badge bg-label-secondary">Inactive</span>
                            @endif
                        </td>
                        <td>{{ $user->created_at->format('d M Y') }}</td>
                        <td>
                            <div class="dropdown">
                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                    <i class="ti ti-dots-vertical"></i>
                                </button>
                                <div class="dropdown-menu">
                                    @if(auth()->user()->hasPermission('panel.users.view'))
                                    <a class="dropdown-item" href="{{ route('panel.users.show', $user->id) }}">
                                        <i class="ti ti-eye me-1"></i> View
                                    </a>
                                    @endif
                                    
                                    @if(auth()->user()->hasPermission('panel.users.edit'))
                                    <a class="dropdown-item" href="{{ route('panel.users.edit', $user->id) }}">
                                        <i class="ti ti-pencil me-1"></i> Edit
                                    </a>
                                    @endif
                                    
                                    @if(auth()->user()->hasPermission('panel.users.delete'))
                                    <form action="{{ route('panel.users.destroy', $user->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="dropdown-item text-danger" onclick="return confirm('Are you sure?')">
                                            <i class="ti ti-trash me-1"></i> Delete
                                        </button>
                                    </form>
                                    @endif
                                </div>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-4">
                            <div class="text-muted">
                                <i class="ti ti-users ti-lg mb-2"></i>
                                <p>No users found</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($users->hasPages())
        <div class="card-footer">
            {{ $users->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
