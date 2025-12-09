@extends('layouts.admin')

@section('title', 'Manage Permissions - ' . ucfirst($role->name))

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="mb-4">
            <h4 class="fw-bold py-3 mb-0">
                <span class="text-muted fw-light">Admin / Permissions /</span> {{ ucfirst($role->name) }}
            </h4>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="mb-0">Manage Permissions for {{ ucfirst($role->name) }}</h5>
                    <p class="text-muted mb-0 mt-1">Set access permissions for each resource</p>
                </div>
                <a href="{{ route('admin.permissions.index') }}" class="btn btn-secondary">
                    <i class="ti ti-arrow-left me-1"></i> Back
                </a>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.permissions.update', $role->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th style="width: 250px;">Resource</th>
                                    <th class="text-center" style="width: 120px;">Create</th>
                                    <th class="text-center" style="width: 120px;">Read</th>
                                    <th class="text-center" style="width: 120px;">Update</th>
                                    <th class="text-center" style="width: 120px;">Delete</th>
                                    <th class="text-center" style="width: 120px;">
                                        <input type="checkbox" class="form-check-input" id="selectAll"
                                            onclick="toggleAll(this)">
                                        <label for="selectAll" class="ms-1">All</label>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($resources as $key => $label)
                                    @php
                                        $permission = $permissions->firstWhere('resource', $key);
                                    @endphp
                                    <tr>
                                        <td>
                                            <div class="d-flex flex-column">
                                                <span class="fw-semibold">{{ $label }}</span>
                                                <small class="text-muted">{{ $key }}</small>
                                            </div>
                                            <input type="hidden" name="permissions[{{ $loop->index }}][resource]"
                                                value="{{ $key }}">
                                        </td>
                                        <td class="text-center">
                                            <div class="form-check d-flex justify-content-center">
                                                <input class="form-check-input permission-check" type="checkbox"
                                                    name="permissions[{{ $loop->index }}][can_create]" value="1"
                                                    {{ $permission && $permission->can_create ? 'checked' : '' }}>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <div class="form-check d-flex justify-content-center">
                                                <input class="form-check-input permission-check" type="checkbox"
                                                    name="permissions[{{ $loop->index }}][can_read]" value="1"
                                                    {{ $permission && $permission->can_read ? 'checked' : '' }}>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <div class="form-check d-flex justify-content-center">
                                                <input class="form-check-input permission-check" type="checkbox"
                                                    name="permissions[{{ $loop->index }}][can_update]" value="1"
                                                    {{ $permission && $permission->can_update ? 'checked' : '' }}>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <div class="form-check d-flex justify-content-center">
                                                <input class="form-check-input permission-check" type="checkbox"
                                                    name="permissions[{{ $loop->index }}][can_delete]" value="1"
                                                    {{ $permission && $permission->can_delete ? 'checked' : '' }}>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <input type="checkbox" class="form-check-input row-select"
                                                onclick="toggleRow(this, {{ $loop->index }})">
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary">
                            <i class="ti ti-check me-1"></i> Save Permissions
                        </button>
                        <a href="{{ route('admin.permissions.index') }}" class="btn btn-secondary">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            function toggleAll(source) {
                const checkboxes = document.querySelectorAll('.permission-check');
                checkboxes.forEach(checkbox => {
                    checkbox.checked = source.checked;
                });

                const rowSelects = document.querySelectorAll('.row-select');
                rowSelects.forEach(select => {
                    select.checked = source.checked;
                });
            }

            function toggleRow(source, index) {
                const checkboxes = document.querySelectorAll(`input[name^="permissions[${index}]"]:not([type="hidden"])`);
                checkboxes.forEach(checkbox => {
                    checkbox.checked = source.checked;
                });
            }
        </script>
    @endpush
@endsection
