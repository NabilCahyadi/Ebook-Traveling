@extends('layouts.admin')

@section('title', 'View Ebook')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold py-3 mb-0">
                <span class="text-muted fw-light">Admin / Ebooks /</span> {{ $ebook->title }}
            </h4>
            <div>
                <a href="{{ route('admin.ebooks.edit', $ebook->id) }}" class="btn btn-primary">
                    <i class="bx bx-edit-alt me-1"></i> Edit
                </a>
                <a href="{{ route('admin.ebooks.index') }}" class="btn btn-secondary">
                    <i class="bx bx-arrow-back me-1"></i> Back
                </a>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="card mb-4">
                    <div class="card-body text-center">
                        @if ($ebook->cover_image)
                            <img src="{{ asset('storage/' . $ebook->cover_image) }}" alt="{{ $ebook->title }}"
                                class="img-fluid rounded mb-3" style="max-height: 400px;">
                        @else
                            <div class="bg-light rounded mb-3"
                                style="height: 400px; display: flex; align-items: center; justify-content: center;">
                                <i class="bx bx-book" style="font-size: 72px; color: #ddd;"></i>
                            </div>
                        @endif

                        <h5 class="mb-2">{{ $ebook->title }}</h5>
                        <p class="text-muted mb-3">by {{ $ebook->author ?? 'Unknown' }}</p>

                        @if ($ebook->price > 0)
                            <h4 class="text-primary mb-3">Rp {{ number_format($ebook->price, 0, ',', '.') }}</h4>
                        @else
                            <span class="badge bg-success mb-3">Free</span>
                        @endif

                        <div class="d-flex justify-content-center gap-2 mb-3">
                            @if ($ebook->status === 'published')
                                <span class="badge bg-success">Published</span>
                            @elseif($ebook->status === 'draft')
                                <span class="badge bg-warning">Draft</span>
                            @else
                                <span class="badge bg-danger">Archived</span>
                            @endif

                            @if ($ebook->is_featured)
                                <span class="badge bg-primary">Featured</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">Ebook Details</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-borderless">
                            <tr>
                                <th width="200">Title:</th>
                                <td>{{ $ebook->title }}</td>
                            </tr>
                            <tr>
                                <th>Author:</th>
                                <td>{{ $ebook->author ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Category:</th>
                                <td>
                                    @if ($ebook->category)
                                        <span class="badge bg-label-info">{{ $ebook->category->name }}</span>
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>City:</th>
                                <td>
                                    @if ($ebook->city)
                                        <span class="badge bg-label-primary">{{ $ebook->city->name }}</span>
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>ISBN:</th>
                                <td>{{ $ebook->isbn ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Publisher:</th>
                                <td>{{ $ebook->publisher ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Publication Year:</th>
                                <td>{{ $ebook->publication_year ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Language:</th>
                                <td>{{ $ebook->language ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Pages:</th>
                                <td>{{ $ebook->pages ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>File Format:</th>
                                <td>
                                    @if ($ebook->file_format)
                                        <span class="badge bg-label-secondary">{{ strtoupper($ebook->file_format) }}</span>
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>File Size:</th>
                                <td>{{ $ebook->file_size ? number_format($ebook->file_size / 1024 / 1024, 2) . ' MB' : '-' }}
                                </td>
                            </tr>
                            <tr>
                                <th>Created:</th>
                                <td>{{ $ebook->created_at->format('d M Y H:i') }}</td>
                            </tr>
                            <tr>
                                <th>Last Updated:</th>
                                <td>{{ $ebook->updated_at->format('d M Y H:i') }}</td>
                            </tr>
                        </table>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">Description</h5>
                    </div>
                    <div class="card-body">
                        <p>{{ $ebook->description ?? 'No description available.' }}</p>
                    </div>
                </div>

                @if ($ebook->file_path)
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Ebook File</h5>
                        </div>
                        <div class="card-body">
                            <div class="alert alert-info d-flex align-items-center">
                                <i class="bx bx-file me-2" style="font-size: 24px;"></i>
                                <div>
                                    <strong>File Available</strong><br>
                                    <small>{{ basename($ebook->file_path) }}</small>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
