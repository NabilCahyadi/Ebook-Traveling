@extends('layouts.admin')

@section('title', 'Permission Management')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold py-3 mb-2">
                <span class="text-muted fw-light">Admin /</span> Permission Management
            </h4>
        </div>
        <div>
            <button type="button" class="btn btn-primary" disabled>
                <i class="ti ti-plus me-1"></i> Add New Permission
            </button>
        </div>
    </div>

    <div class="card">
        <div class="card-body text-center py-5">
            <i class="ti ti-lock ti-xl text-primary mb-3" style="font-size: 72px;"></i>
            <h4 class="mb-3">Permission Management</h4>
            <p class="text-muted mb-4">
                This feature is under development.<br>
                You will be able to manage system permissions and assign them to roles here.
            </p>
            <div class="badge bg-label-info">Coming Soon</div>
        </div>
    </div>
@endsection
