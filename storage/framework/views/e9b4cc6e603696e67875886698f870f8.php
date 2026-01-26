<?php $__env->startSection('title', 'Kelola Top 10 Cities Content'); ?>

<?php $__env->startSection('content'); ?>
    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Success/Error Messages -->
        <?php if(session('success')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Success!</strong> <?php echo e(session('success')); ?>

                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <?php if(session('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Error!</strong> <?php echo e(session('error')); ?>

                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <!-- Page Header -->
        <div class="mb-4">
            <h4 class="fw-bold py-3 mb-2">
                <span class="text-muted fw-light">
                    <a href="<?php echo e(route('admin.landing-page-content.index')); ?>" class="text-muted">Landing Page Content</a> /
                </span>
                Top 10 Cities
            </h4>
            <p class="text-muted">Pilih dan atur urutan kota yang akan ditampilkan di landing page</p>
        </div>

        <form action="<?php echo e(route('admin.landing-page-content.top-cities.update')); ?>" method="POST" id="citiesForm">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>

            <div class="row">
                <!-- Selected Cities (Sortable) -->
                <div class="col-lg-7 mb-4">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">
                                <i class="ti ti-list-check me-2"></i>
                                Kota Terpilih (<span id="selected-count"><?php echo e($selectedCities->count()); ?></span>/10)
                            </h5>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="is_visible" name="is_visible" 
                                       value="1" <?php echo e(old('is_visible', $section->is_visible) ? 'checked' : ''); ?>>
                                <label class="form-check-label" for="is_visible">
                                    Tampilkan di Landing Page
                                </label>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="alert alert-info">
                                <i class="ti ti-info-circle me-2"></i>
                                <strong>Tips:</strong> Drag & drop untuk mengatur urutan tampilan
                            </div>

                            <div id="selected-cities" class="sortable-list">
                                <?php $__empty_1 = true; $__currentLoopData = $selectedCities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $city): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <div class="sortable-item" data-id="<?php echo e($city->id); ?>">
                                        <div class="d-flex align-items-center justify-content-between p-3 mb-2 border rounded">
                                            <div class="d-flex align-items-center flex-grow-1">
                                                <i class="ti ti-grip-vertical text-muted me-3" style="cursor: grab;"></i>
                                                <img src="<?php echo e(asset($city->image)); ?>" 
                                                     alt="<?php echo e($city->name); ?>" 
                                                     class="rounded me-3" 
                                                     style="width: 50px; height: 50px; object-fit: cover;">
                                                <div>
                                                    <strong><?php echo e($city->name); ?></strong>
                                                    <br>
                                                    <small class="text-muted"><?php echo e($city->province); ?></small>
                                                </div>
                                            </div>
                                            <button type="button" class="btn btn-sm btn-icon btn-danger remove-city" data-id="<?php echo e($city->id); ?>">
                                                <i class="ti ti-x"></i>
                                            </button>
                                        </div>
                                        <input type="hidden" name="selected_cities[]" value="<?php echo e($city->id); ?>">
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <div id="empty-state" class="text-center py-5">
                                        <i class="ti ti-map-pin-off" style="font-size: 3rem; color: #ddd;"></i>
                                        <p class="text-muted mt-2">Belum ada kota yang dipilih</p>
                                        <small class="text-muted">Pilih kota dari daftar di sebelah kanan</small>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <?php $__errorArgs = ['selected_cities'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="text-danger mt-2"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>
                </div>

                <!-- Available Cities -->
                <div class="col-lg-5 mb-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">
                                <i class="ti ti-map-pin me-2"></i>
                                Daftar Kota
                            </h5>
                        </div>
                        <div class="card-body">
                            <input type="text" 
                                   id="search-cities" 
                                   class="form-control mb-3" 
                                   placeholder="Cari kota...">

                            <div id="available-cities" style="max-height: 600px; overflow-y: auto;">
                                <?php $__currentLoopData = $allCities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $city): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="available-city-item border rounded p-2 mb-2" 
                                         data-id="<?php echo e($city->id); ?>"
                                         data-name="<?php echo e(strtolower($city->name)); ?>"
                                         style="cursor: pointer; <?php echo e($selectedCities->contains('id', $city->id) ? 'display: none;' : ''); ?>">
                                        <div class="d-flex align-items-center">
                                            <img src="<?php echo e(asset($city->image)); ?>" 
                                                 alt="<?php echo e($city->name); ?>" 
                                                 class="rounded me-2" 
                                                 style="width: 40px; height: 40px; object-fit: cover;">
                                            <div class="flex-grow-1">
                                                <div><strong><?php echo e($city->name); ?></strong></div>
                                                <small class="text-muted"><?php echo e($city->province); ?></small>
                                            </div>
                                            <i class="ti ti-plus text-primary"></i>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="card">
                <div class="card-body">
                    <button type="submit" class="btn btn-primary me-2">
                        <i class="ti ti-device-floppy me-1"></i> Simpan Perubahan
                    </button>
                    <a href="<?php echo e(route('admin.landing-page-content.index')); ?>" class="btn btn-label-secondary">
                        <i class="ti ti-arrow-left me-1"></i> Kembali
                    </a>
                </div>
            </div>
        </form>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script>
    $(document).ready(function() {
        const maxCities = 10;
        let selectedCount = <?php echo e($selectedCities->count()); ?>;

        // Initialize Sortable
        const sortable = new Sortable(document.getElementById('selected-cities'), {
            animation: 150,
            handle: '.ti-grip-vertical',
            ghostClass: 'sortable-ghost',
            onEnd: function() {
                updateSelectedCount();
            }
        });

        // Add city
        $(document).on('click', '.available-city-item', function() {
            if (selectedCount >= maxCities) {
                toastr.warning('Maksimal ' + maxCities + ' kota dapat dipilih');
                return;
            }

            const cityId = $(this).data('id');
            const cityName = $(this).find('strong').text();
            const cityProvince = $(this).find('small').text();
            const cityImage = $(this).find('img').attr('src');

            // Hide from available list
            $(this).hide();

            // Remove empty state
            $('#empty-state').remove();

            // Add to selected list
            const html = `
                <div class="sortable-item" data-id="${cityId}">
                    <div class="d-flex align-items-center justify-content-between p-3 mb-2 border rounded">
                        <div class="d-flex align-items-center flex-grow-1">
                            <i class="ti ti-grip-vertical text-muted me-3" style="cursor: grab;"></i>
                            <img src="${cityImage}" alt="${cityName}" class="rounded me-3" 
                                 style="width: 50px; height: 50px; object-fit: cover;">
                            <div>
                                <strong>${cityName}</strong>
                                <br>
                                <small class="text-muted">${cityProvince}</small>
                            </div>
                        </div>
                        <button type="button" class="btn btn-sm btn-icon btn-danger remove-city" data-id="${cityId}">
                            <i class="ti ti-x"></i>
                        </button>
                    </div>
                    <input type="hidden" name="selected_cities[]" value="${cityId}">
                </div>
            `;

            $('#selected-cities').append(html);
            selectedCount++;
            updateSelectedCount();
        });

        // Remove city
        $(document).on('click', '.remove-city', function() {
            const cityId = $(this).data('id');
            $(this).closest('.sortable-item').remove();
            
            // Show back in available list
            $(`.available-city-item[data-id="${cityId}"]`).show();
            
            selectedCount--;
            updateSelectedCount();

            // Show empty state if no cities selected
            if (selectedCount === 0) {
                $('#selected-cities').html(`
                    <div id="empty-state" class="text-center py-5">
                        <i class="ti ti-map-pin-off" style="font-size: 3rem; color: #ddd;"></i>
                        <p class="text-muted mt-2">Belum ada kota yang dipilih</p>
                        <small class="text-muted">Pilih kota dari daftar di sebelah kanan</small>
                    </div>
                `);
            }
        });

        // Search cities
        $('#search-cities').on('keyup', function() {
            const searchTerm = $(this).val().toLowerCase();
            
            $('.available-city-item').each(function() {
                const cityName = $(this).data('name');
                if (cityName.includes(searchTerm)) {
                    // Only show if not already selected
                    const cityId = $(this).data('id');
                    const isSelected = $(`.sortable-item[data-id="${cityId}"]`).length > 0;
                    if (!isSelected) {
                        $(this).show();
                    }
                } else {
                    $(this).hide();
                }
            });
        });

        function updateSelectedCount() {
            $('#selected-count').text(selectedCount);
        }

        // Form validation
        $('#citiesForm').on('submit', function(e) {
            if (selectedCount === 0) {
                e.preventDefault();
                toastr.error('Pilih minimal 1 kota');
                return false;
            }
        });
    });
</script>

<style>
    .sortable-ghost {
        opacity: 0.4;
    }
    
    .available-city-item:hover {
        background-color: #f8f9fa;
        border-color: #007bff !important;
    }

    .sortable-item {
        transition: all 0.3s ease;
    }
</style>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\ebook_traveling\resources\views\admin\landing-page-content\top-cities.blade.php ENDPATH**/ ?>