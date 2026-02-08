@extends('layouts.admin')

@section('title', 'Landing Page Content Management')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Page Header -->
        <div class="mb-4">
            <h4 class="fw-bold py-3 mb-2">
                <span class="text-muted fw-light">Website Management /</span> Landing Page Content
            </h4>
            <p class="text-muted">Kelola konten yang tampil di section landing page</p>
        </div>

        <div class="row">
            <!-- Top 10 Cities Card -->
            <div class="col-md-6 mb-4">
                <div class="card h-100">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="mb-0">
                            <i class="ti ti-map-pin text-primary me-2"></i>
                            Top 10 Cities
                        </h5>
                        @if($topCitiesSection && $topCitiesSection->is_visible)
                            <span class="badge bg-success">Aktif</span>
                        @else
                            <span class="badge bg-secondary">Nonaktif</span>
                        @endif
                    </div>
                    <div class="card-body">
                        <p class="text-muted mb-3">
                            Section untuk menampilkan kota-kota populer di landing page
                        </p>
                        
                        <div class="mb-3">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="text-muted">Kota Terpilih:</span>
                                <strong class="text-primary">{{ $topCitiesCount }} kota</strong>
                            </div>
                            <div class="progress" style="height: 8px;">
                                <div class="progress-bar" role="progressbar" 
                                     style="width: {{ ($topCitiesCount / 10) * 100 }}%"
                                     aria-valuenow="{{ $topCitiesCount }}" 
                                     aria-valuemin="0" 
                                     aria-valuemax="10">
                                </div>
                            </div>
                            <small class="text-muted">Rekomendasi: 10 kota</small>
                        </div>

                        @if($topCitiesSection && isset($topCitiesSection->config['selected_cities']))
                            <div class="alert alert-info mb-3">
                                <i class="ti ti-info-circle me-2"></i>
                                <small>
                                    Terakhir diupdate: {{ $topCitiesSection->updated_at->format('d M Y H:i') }}
                                </small>
                            </div>
                        @endif

                        <a href="{{ route('admin.landing-page-content.top-cities') }}" 
                           class="btn btn-primary w-100">
                            <i class="ti ti-edit me-2"></i>
                            Kelola Konten
                        </a>
                    </div>
                </div>
            </div>

            <!-- Ebook Collection Card -->
            <div class="col-md-6 mb-4">
                <div class="card h-100">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="mb-0">
                            <i class="ti ti-folders text-danger me-2"></i>
                            Ebook Collection
                        </h5>
                        <span class="badge bg-success">Aktif</span>
                    </div>
                    <div class="card-body">
                        <p class="text-muted mb-3">
                            Kelola koleksi ebook yang ditampilkan di landing page
                        </p>
                        
                        <div class="mb-3">
                            <div class="alert alert-info">
                                <i class="ti ti-info-circle me-2"></i>
                                <small>
                                    Gunakan menu Website Management untuk mengelola koleksi ebook
                                </small>
                            </div>
                        </div>

                        <a href="{{ route('admin.collections.index') }}" 
                           class="btn btn-danger w-100">
                            <i class="ti ti-folders me-2"></i>
                            Kelola Koleksi
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Information Card -->
        <div class="card">
            <div class="card-body">
                <h5 class="card-title mb-3">
                    <i class="ti ti-info-circle me-2"></i>
                    Informasi
                </h5>
                <ul class="mb-0">
                    <li class="mb-2">
                        <strong>Top 10 Cities:</strong> Pilih dan atur urutan kota yang akan ditampilkan di landing page. 
                        Maksimal 10 kota dapat dipilih.
                    </li>
                    <li>
                        <strong>Ebook Collection:</strong> Kelola koleksi ebook yang ditampilkan di landing page melalui menu Website Management.
                    </li>
                </ul>
            </div>
        </div>
    </div>
@endsection
