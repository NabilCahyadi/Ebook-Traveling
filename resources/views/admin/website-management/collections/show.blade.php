@extends('layouts.admin')

@section('title', __('admin.collections.detail'))

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.collections.index') }}">{{ __('admin.menu.collections') }}</a></li>
            <li class="breadcrumb-item active">{{ $collection->name }}</li>
        </ol>
    </nav>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">{{ $collection->name }}</h4>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.collections.manage-ebooks', $collection->id) }}" class="btn btn-info">
                <i class="ti ti-book me-1"></i> {{ __('admin.collections.manage_ebooks') }}
            </a>
            <a href="{{ route('admin.collections.edit', $collection->id) }}" class="btn btn-primary">
                <i class="ti ti-pencil me-1"></i> {{ __('admin.actions.edit') }}
            </a>
            <a href="{{ route('admin.collections.index') }}" class="btn btn-outline-secondary">
                <i class="ti ti-arrow-left me-1"></i> {{ __('admin.actions.back') }}
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-body text-center">
                    @if($collection->image)
                        <img src="{{ $collection->image_url }}" alt="{{ $collection->name }}" 
                            class="rounded mb-3" style="max-width: 200px; max-height: 200px; object-fit: cover;">
                    @else
                        <div class="bg-light rounded mb-3 d-flex align-items-center justify-content-center mx-auto" 
                            style="width: 200px; height: 200px;">
                            <i class="ti ti-folder fs-1 text-muted"></i>
                        </div>
                    @endif
                    <h5 class="mb-1">{{ $collection->name }}</h5>
                    @if($collection->is_featured)
                        <span class="badge bg-warning">
                            <i class="ti ti-star me-1"></i> {{ __('admin.common.featured') }}
                        </span>
                    @endif
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">{{ __('admin.common.statistics') }}</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="text-muted">{{ __('admin.collections.total_ebooks') }}</span>
                        <span class="badge bg-primary fs-6">{{ $collection->ebooks_count ?? 0 }}</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="text-muted">{{ __('admin.common.status') }}</span>
                        @if($collection->is_active ?? true)
                            <span class="badge bg-success">{{ __('admin.common.active') }}</span>
                        @else
                            <span class="badge bg-danger">{{ __('admin.common.inactive') }}</span>
                        @endif
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-muted">{{ __('admin.common.order') }}</span>
                        <span class="fw-medium">{{ $collection->order ?? 0 }}</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">{{ __('admin.common.information') }}</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-6 mb-3">
                            <label class="form-label text-muted small">ID</label>
                            <p class="mb-0 fw-medium">{{ $collection->id }}</p>
                        </div>
                        <div class="col-sm-6 mb-3">
                            <label class="form-label text-muted small">Slug</label>
                            <p class="mb-0 fw-medium">{{ $collection->slug }}</p>
                        </div>
                        <div class="col-12 mb-3">
                            <label class="form-label text-muted small">{{ __('admin.collections.name') }}</label>
                            <p class="mb-0 fw-medium">{{ $collection->name }}</p>
                        </div>
                        @if($collection->description)
                        <div class="col-12 mb-3">
                            <label class="form-label text-muted small">{{ __('admin.collections.description') }}</label>
                            <p class="mb-0">{{ $collection->description }}</p>
                        </div>
                        @endif
                        <div class="col-sm-6 mb-3">
                            <label class="form-label text-muted small">{{ __('admin.common.date_created') }}</label>
                            <p class="mb-0 fw-medium">{{ $collection->created_at->format('d F Y H:i') }}</p>
                        </div>
                        <div class="col-sm-6 mb-3">
                            <label class="form-label text-muted small">{{ __('admin.common.last_updated') }}</label>
                            <p class="mb-0 fw-medium">{{ $collection->updated_at->format('d F Y H:i') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            @if(isset($collection->ebooks) && $collection->ebooks->count() > 0)
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">{{ __('admin.collections.ebooks_in_collection') }}</h5>
                    <a href="{{ route('admin.collections.manage-ebooks', $collection->id) }}" class="btn btn-sm btn-outline-primary">
                        {{ __('admin.actions.manage') }}
                    </a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>{{ __('admin.common.image') }}</th>
                                    <th>{{ __('admin.ebooks.title') }}</th>
                                    <th>{{ __('admin.ebooks.author') }}</th>
                                    <th>{{ __('admin.common.status') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($collection->ebooks->take(5) as $ebook)
                                <tr>
                                    <td>
                                        @if($ebook->cover_image)
                                            <img src="{{ $ebook->cover_image_url }}" alt="{{ $ebook->title }}" 
                                                class="rounded" style="width: 40px; height: 50px; object-fit: cover;">
                                        @else
                                            <div class="bg-light rounded d-flex align-items-center justify-content-center" 
                                                style="width: 40px; height: 50px;">
                                                <i class="ti ti-book text-muted"></i>
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.ebooks.show', $ebook->id) }}">
                                            {{ Str::limit($ebook->title, 30) }}
                                        </a>
                                    </td>
                                    <td>{{ $ebook->author ?? '-' }}</td>
                                    <td>
                                        @if($ebook->is_published)
                                            <span class="badge bg-success">{{ __('admin.common.published') }}</span>
                                        @else
                                            <span class="badge bg-secondary">{{ __('admin.common.draft') }}</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @if($collection->ebooks->count() > 5)
                    <div class="card-footer text-center">
                        <a href="{{ route('admin.collections.manage-ebooks', $collection->id) }}">
                            {{ __('admin.common.view_all') }} ({{ $collection->ebooks->count() }})
                        </a>
                    </div>
                    @endif
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
