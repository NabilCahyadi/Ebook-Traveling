@extends('layouts.admin')

@section('title', __('admin.ratings.title') . ' - ' . $ebook->title)

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-bold py-3 mb-0">
                    <span class="text-muted fw-light">{{ __('admin.ebooks.title') }} /</span> {{ __('admin.ratings.title') }}
                </h4>
                <small class="text-muted">{{ $ebook->title }}</small>
            </div>
            <div>
                <a href="{{ route('admin.ebooks.ratings.create', $ebook->id) }}" class="btn btn-primary me-2">
                    <i class="ti ti-plus me-1"></i> {{ __('admin.ratings.add_new') }}
                </a>
                <a href="{{ route('admin.ebooks.index') }}" class="btn btn-secondary">
                    <i class="ti ti-arrow-left me-1"></i> {{ __('admin.ratings.back_to_ebooks') }}
                </a>
            </div>
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

        <!-- Statistics Cards -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card h-100">
                    <div class="card-body text-center d-flex flex-column justify-content-center py-4">
                        <h1 class="mb-3 text-primary fw-bold">{{ number_format($stats['average'], 1) }}</h1>
                        <div class="mb-3">
                            @for ($i = 1; $i <= 5; $i++)
                                <i class="ti ti-star{{ $i <= round($stats['average']) ? '-filled text-warning' : ' text-muted' }} fs-4"></i>
                            @endfor
                        </div>
                        <p class="text-muted mb-0">{{ __('admin.ratings.average_rating') }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card h-100">
                    <div class="card-body text-center d-flex flex-column justify-content-center py-4">
                        <h1 class="mb-3 fw-bold">{{ $ebook->ratings()->count() }}</h1>
                        <p class="text-muted mb-0">{{ __('admin.ratings.total_reviews') }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card h-100">
                    <div class="card-body">
                        <h6 class="mb-3">{{ __('admin.ratings.rating_distribution') }}</h6>
                        @for ($i = 5; $i >= 1; $i--)
                            @php
                                $count = $stats['distribution'][$i];
                                $percentage = $stats['total'] > 0 ? ($count / $stats['total']) * 100 : 0;
                            @endphp
                            <div class="d-flex align-items-center mb-2">
                                <span class="me-2" style="width: 20px;">{{ $i }}</span>
                                <i class="ti ti-star-filled text-warning me-2"></i>
                                <div class="progress flex-grow-1" style="height: 10px;">
                                    <div class="progress-bar bg-warning" style="width: {{ $percentage }}%"></div>
                                </div>
                                <span class="ms-2" style="width: 40px;">{{ $count }}</span>
                            </div>
                        @endfor
                    </div>
                </div>
            </div>
        </div>

        <!-- Ratings Table -->
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">{{ __('admin.ratings.all_reviews') }}</h5>
            </div>
            <div class="card-body">
                @if ($ratings->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>{{ __('admin.ratings.user') }}</th>
                                    <th>{{ __('admin.ratings.rating') }}</th>
                                    <th>{{ __('admin.ratings.review') }}</th>
                                    <th>{{ __('admin.ratings.status') }}</th>
                                    <th>{{ __('admin.ratings.date') }}</th>
                                    <th>{{ __('admin.ratings.actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($ratings as $rating)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar avatar-sm me-2">
                                                    <span class="avatar-initial rounded-circle bg-label-primary">
                                                        {{ substr($rating->user->name ?? 'U', 0, 1) }}
                                                    </span>
                                                </div>
                                                <div>
                                                    <div class="fw-medium">{{ $rating->user->name ?? __('admin.ebooks.unknown') }}</div>
                                                    <small class="text-muted">{{ $rating->user->email ?? '-' }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    <i class="ti ti-star{{ $i <= $rating->rating ? '-filled text-warning' : ' text-muted' }}" style="font-size: 14px;"></i>
                                                @endfor
                                                <span class="ms-2 badge bg-label-primary">{{ $rating->rating }}/5</span>
                                            </div>
                                        </td>
                                        <td style="max-width: 300px;">
                                            @if ($rating->review_title)
                                                <div class="fw-medium">{{ $rating->review_title }}</div>
                                            @endif
                                            @if ($rating->review_text)
                                                <small class="text-muted">{{ Str::limit($rating->review_text, 100) }}</small>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($rating->is_approved)
                                                <span class="badge bg-success">
                                                    <i class="ti ti-check ti-xs"></i> {{ __('admin.ratings.approved') }}
                                                </span>
                                            @else
                                                <span class="badge bg-warning">
                                                    <i class="ti ti-clock ti-xs"></i> {{ __('admin.ratings.unapproved') }}
                                                </span>
                                            @endif
                                        </td>
                                        <td>
                                            <small class="text-muted">{{ $rating->created_at->format('d M Y') }}</small>
                                        </td>
                                        <td>
                                            <div class="dropdown">
                                                <button type="button"
                                                    class="btn btn-sm btn-icon btn-text-secondary rounded-pill dropdown-toggle hide-arrow"
                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="ti ti-dots-vertical"></i>
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-end">
                                                    <a class="dropdown-item" href="{{ route('admin.ebooks.ratings.edit', [$ebook->id, $rating->id]) }}">
                                                        <i class="ti ti-pencil me-2"></i> {{ __('admin.ratings.edit') }}
                                                    </a>
                                                    <form action="{{ route('admin.ebooks.ratings.toggle-approval', [$ebook->id, $rating->id]) }}" method="POST" style="display: inline;">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" class="dropdown-item">
                                                            @if ($rating->is_approved)
                                                                <i class="ti ti-x me-2"></i> {{ __('admin.ratings.unapproved') }}
                                                            @else
                                                                <i class="ti ti-check me-2"></i> {{ __('admin.ratings.approved') }}
                                                            @endif
                                                        </button>
                                                    </form>
                                                    <div class="dropdown-divider"></div>
                                                    <form action="{{ route('admin.ebooks.ratings.destroy', [$ebook->id, $rating->id]) }}" method="POST"
                                                        id="delete-rating-{{ $rating->id }}" style="display: none;">
                                                        @csrf
                                                        @method('DELETE')
                                                    </form>
                                                    <a class="dropdown-item text-danger" href="javascript:void(0);"
                                                        onclick="if(confirm('{{ __('admin.ratings.delete_confirm') }}')) document.getElementById('delete-rating-{{ $rating->id }}').submit();">
                                                        <i class="ti ti-trash me-2"></i> {{ __('admin.ratings.delete') }}
                                                    </a>
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
                        {{ $ratings->links() }}
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="ti ti-star-off" style="font-size: 48px; color: #ddd;"></i>
                        <p class="mt-2 text-muted">{{ __('admin.ratings.no_reviews') }}</p>
                        <small class="text-muted d-block mb-3">{{ __('admin.ratings.no_reviews_description') }}</small>
                        <a href="{{ route('admin.ebooks.ratings.create', $ebook->id) }}" class="btn btn-primary">
                            <i class="ti ti-plus me-1"></i> {{ __('admin.ratings.add_new') }}
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
