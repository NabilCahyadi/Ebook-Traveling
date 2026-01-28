@extends('layouts.admin')

@section('title', __('admin.categories.trashed'))

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.categories.index') }}">{{ __('admin.menu.categories') }}</a></li>
            <li class="breadcrumb-item active">{{ __('admin.common.trash') }}</li>
        </ol>
    </nav>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">
            <span class="text-muted fw-light">{{ __('admin.menu.categories') }} /</span> {{ __('admin.common.trash') }}
        </h4>
        <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary">
            <i class="ti ti-arrow-left me-1"></i> {{ __('admin.actions.back') }}
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            @if($categories->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>{{ __('admin.form.image') }}</th>
                                <th>{{ __('admin.form.name') }}</th>
                                <th>{{ __('admin.common.deleted_at') }}</th>
                                <th>{{ __('admin.common.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($categories as $category)
                                <tr>
                                    <td>
                                        <img src="{{ $category->image_url }}" alt="{{ $category->name }}" 
                                            class="rounded" style="width: 50px; height: 50px; object-fit: cover;">
                                    </td>
                                    <td>
                                        <span class="fw-medium">{{ $category->name }}</span>
                                    </td>
                                    <td>
                                        <small class="text-muted">{{ $category->deleted_at->format('d M Y H:i') }}</small>
                                    </td>
                                    <td>
                                        <form action="{{ route('admin.categories.restore', $category->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-sm btn-success" title="{{ __('admin.actions.restore') }}">
                                                <i class="ti ti-refresh"></i>
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.categories.force-delete', $category->id) }}" method="POST" class="d-inline" 
                                            onsubmit="return confirm('{{ __('admin.categories.permanent_delete_confirm') }}')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" title="{{ __('admin.actions.delete_permanently') }}">
                                                <i class="ti ti-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if($categories->hasPages())
                    <div class="mt-4">
                        {{ $categories->links() }}
                    </div>
                @endif
            @else
                <div class="text-center py-5">
                    <i class="ti ti-trash fs-1 text-muted mb-3"></i>
                    <h5>{{ __('admin.common.no_trashed_items') }}</h5>
                    <p class="text-muted">{{ __('admin.categories.no_trashed_categories') }}</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
