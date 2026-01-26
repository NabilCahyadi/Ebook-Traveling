<?php $__env->startSection('title', 'Landing Page Content Management'); ?>

<?php $__env->startSection('content'); ?>
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
                        <?php if($topCitiesSection && $topCitiesSection->is_visible): ?>
                            <span class="badge bg-success">Aktif</span>
                        <?php else: ?>
                            <span class="badge bg-secondary">Nonaktif</span>
                        <?php endif; ?>
                    </div>
                    <div class="card-body">
                        <p class="text-muted mb-3">
                            Section untuk menampilkan kota-kota populer di landing page
                        </p>
                        
                        <div class="mb-3">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="text-muted">Kota Terpilih:</span>
                                <strong class="text-primary"><?php echo e($topCitiesCount); ?> kota</strong>
                            </div>
                            <div class="progress" style="height: 8px;">
                                <div class="progress-bar" role="progressbar" 
                                     style="width: <?php echo e(($topCitiesCount / 10) * 100); ?>%"
                                     aria-valuenow="<?php echo e($topCitiesCount); ?>" 
                                     aria-valuemin="0" 
                                     aria-valuemax="10">
                                </div>
                            </div>
                            <small class="text-muted">Rekomendasi: 10 kota</small>
                        </div>

                        <?php if($topCitiesSection && isset($topCitiesSection->config['selected_cities'])): ?>
                            <div class="alert alert-info mb-3">
                                <i class="ti ti-info-circle me-2"></i>
                                <small>
                                    Terakhir diupdate: <?php echo e($topCitiesSection->updated_at->format('d M Y H:i')); ?>

                                </small>
                            </div>
                        <?php endif; ?>

                        <a href="<?php echo e(route('admin.landing-page-content.top-cities')); ?>" 
                           class="btn btn-primary w-100">
                            <i class="ti ti-edit me-2"></i>
                            Kelola Konten
                        </a>
                    </div>
                </div>
            </div>

            <!-- Latest Blogs Card -->
            <div class="col-md-6 mb-4">
                <div class="card h-100">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="mb-0">
                            <i class="ti ti-article text-danger me-2"></i>
                            Latest Blogs
                        </h5>
                        <?php if($latestBlogsSection && $latestBlogsSection->is_visible): ?>
                            <span class="badge bg-success">Aktif</span>
                        <?php else: ?>
                            <span class="badge bg-secondary">Nonaktif</span>
                        <?php endif; ?>
                    </div>
                    <div class="card-body">
                        <p class="text-muted mb-3">
                            Section untuk menampilkan blog terbaru di landing page
                        </p>
                        
                        <div class="mb-3">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="text-muted">Blog Terpilih:</span>
                                <strong class="text-danger"><?php echo e($latestBlogsCount); ?> blog</strong>
                            </div>
                            <div class="progress" style="height: 8px;">
                                <div class="progress-bar bg-danger" role="progressbar" 
                                     style="width: <?php echo e(($latestBlogsCount / 12) * 100); ?>%"
                                     aria-valuenow="<?php echo e($latestBlogsCount); ?>" 
                                     aria-valuemin="0" 
                                     aria-valuemax="12">
                                </div>
                            </div>
                            <small class="text-muted">Maksimal: 12 blog</small>
                        </div>

                        <?php if($latestBlogsSection && isset($latestBlogsSection->config['selected_blogs'])): ?>
                            <div class="alert alert-info mb-3">
                                <i class="ti ti-info-circle me-2"></i>
                                <small>
                                    Terakhir diupdate: <?php echo e($latestBlogsSection->updated_at->format('d M Y H:i')); ?>

                                </small>
                            </div>
                        <?php endif; ?>

                        <a href="<?php echo e(route('admin.landing-page-content.latest-blogs')); ?>" 
                           class="btn btn-danger w-100">
                            <i class="ti ti-edit me-2"></i>
                            Kelola Konten
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
                    <li class="mb-2">
                        <strong>Latest Blogs:</strong> Pilih blog yang akan ditampilkan sebagai konten terbaru. 
                        Anda dapat memilih hingga 12 blog dan mengatur urutannya.
                    </li>
                    <li>
                        <strong>Drag & Drop:</strong> Gunakan fitur drag & drop untuk mengatur urutan tampilan dengan mudah.
                    </li>
                </ul>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\ebook_traveling\resources\views\admin\landing-page-content\index.blade.php ENDPATH**/ ?>