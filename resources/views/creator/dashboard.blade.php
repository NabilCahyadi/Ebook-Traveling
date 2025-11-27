@extends('layouts.admin')

@section('title', 'Creator Dashboard')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Creator Dashboard</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                        <li class="breadcrumb-item active">Creator</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Row -->
    <div class="row">
        <div class="col-xl-3 col-md-6">
            <div class="card card-animate">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1 overflow-hidden">
                            <p class="text-uppercase fw-medium text-muted text-truncate mb-0">My Ebooks</p>
                        </div>
                    </div>
                    <div class="d-flex align-items-end justify-content-between mt-4">
                        <div>
                            <h4 class="fs-22 fw-semibold ff-secondary mb-4">0</h4>
                            <a href="#" class="text-decoration-underline">View all ebooks</a>
                        </div>
                        <div class="avatar-sm flex-shrink-0">
                            <span class="avatar-title bg-primary rounded fs-3">
                                <i class="bx bx-book"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card card-animate">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1 overflow-hidden">
                            <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Total Readers</p>
                        </div>
                    </div>
                    <div class="d-flex align-items-end justify-content-between mt-4">
                        <div>
                            <h4 class="fs-22 fw-semibold ff-secondary mb-4">0</h4>
                            <span class="badge bg-success-subtle text-success mb-0">
                                <i class="ri-arrow-up-line align-middle"></i> 0%
                            </span>
                        </div>
                        <div class="avatar-sm flex-shrink-0">
                            <span class="avatar-title bg-info rounded fs-3">
                                <i class="bx bx-user-check"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card card-animate">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1 overflow-hidden">
                            <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Total Views</p>
                        </div>
                    </div>
                    <div class="d-flex align-items-end justify-content-between mt-4">
                        <div>
                            <h4 class="fs-22 fw-semibold ff-secondary mb-4">0</h4>
                            <span class="badge bg-success-subtle text-success mb-0">
                                <i class="ri-arrow-up-line align-middle"></i> 0%
                            </span>
                        </div>
                        <div class="avatar-sm flex-shrink-0">
                            <span class="avatar-title bg-warning rounded fs-3">
                                <i class="bx bx-show"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card card-animate">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1 overflow-hidden">
                            <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Total Earnings</p>
                        </div>
                    </div>
                    <div class="d-flex align-items-end justify-content-between mt-4">
                        <div>
                            <h4 class="fs-22 fw-semibold ff-secondary mb-4">Rp 0</h4>
                            <span class="badge bg-success-subtle text-success mb-0">
                                <i class="ri-arrow-up-line align-middle"></i> 0%
                            </span>
                        </div>
                        <div class="avatar-sm flex-shrink-0">
                            <span class="avatar-title bg-success rounded fs-3">
                                <i class="bx bx-wallet"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Welcome Message -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-3">Welcome, {{ auth()->user()->name }}! 👋</h5>
                    <p class="text-muted">
                        As a content creator, you can create and manage your ebooks here. 
                        Start creating amazing travel content and share your knowledge with readers around the world!
                    </p>
                    <div class="mt-3">
                        <a href="#" class="btn btn-primary">
                            <i class="bx bx-plus"></i> Create New Ebook
                        </a>
                        <a href="#" class="btn btn-outline-primary ms-2">
                            <i class="bx bx-book"></i> My Ebooks
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">Recent Activity</h4>
                </div>
                <div class="card-body">
                    <div class="text-center text-muted py-4">
                        <i class="bx bx-info-circle fs-1 mb-3"></i>
                        <p>No recent activity yet. Start creating content!</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
