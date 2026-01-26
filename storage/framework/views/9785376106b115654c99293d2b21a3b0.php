<?php $__env->startSection('title', 'Promo Detail - MeatMap'); ?>

<?php $__env->startSection('content'); ?>
<style>
    .card-body {
        text-align: left;
    }

    .card {
        margin: 15px 0 15px 0;
    }

    .promo-image {
        width: 100%;
        height: auto;
        object-fit: cover;
    }
</style>
<div class="container mt-5">
    <?php if($promo): ?>
    <div class="container my-4">
        <div class="breadcrumb">
            <a href="<?php echo e(route('home')); ?>" rel="nofollow"><i class="fi fi-rs-home mr-5"></i></a>
            <span></span>
            <a href="<?php echo e(route('promo')); ?>">Promo</a>
            <span class="active">‎ ‎ <?php echo e($promo->name); ?></span>
        </div>
    </div>

    <!-- Gambar Promo dan Deskripsi dalam satu container -->
    <div class="row justify-content-center">
        <div class="col-md-8">
            <!-- Gambar Promo -->
            <?php if($promo->banner_image): ?>
            <img src="<?php echo e(asset($promo->banner_image)); ?>" alt="<?php echo e($promo->name); ?>" class="promo-image rounded-md shadow-sm">
            <?php endif; ?>

            <!-- Deskripsi Promo -->
            <div class="card mt-4">
                <div class="card-body">
                    <h4><?php echo e($promo->name); ?></h4>
                    <p><?php echo e($promo->description); ?></p>
                    <h6 class="fw-semibold my-2">Promotion Period</h6>
                    <p>
                        <?php echo e(\Carbon\Carbon::parse($promo->start_date)->locale('id')->translatedFormat('d F Y')); ?> -
                        <?php echo e(\Carbon\Carbon::parse($promo->end_date)->locale('id')->translatedFormat('d F Y')); ?>

                    </p>
                    <div class="mb-5">
                        <h6 class="fw-semibold my-2">Terms and Conditions</h6>
                        <div>
                            <?php echo $promo->terms_conditions; ?>

                        </div>
                    </div>
                    <?php if($promo->date_range): ?>
                    <p class="text-success">
                        <i class="bi bi-info-circle-fill"></i>
                        Special Period : <?php echo e($promo->date_range); ?>

                    </p>
                    <?php endif; ?>

                    
                    <?php if(auth()->check()): ?>
                    <!-- Tampilkan kode promo dan tombol salin jika user sudah login -->
                    <div class="d-inline-flex align-items-center">
                        <code id="promo-code" class="fs-5 bg-white border rounded px-3 py-2 me-2"><?php echo e($promo->code); ?></code>
                        <button onclick="copyCode()" class="btn btn-sm" id="copy-btn">
                            <i class="bi bi-clipboard me-1"></i> Copy Promo Code
                        </button>
                    </div>
                    <?php else: ?>
                    <!-- Tampilkan pesan untuk login jika user belum login -->
                    <div class="alert alert-info d-flex align-items-center" role="alert">
                        <div>
                            Please <a href="<?php echo e(route('login')); ?>" class="alert-link">log in</a> or <a href="<?php echo e(route('register')); ?>" class="alert-link">sign up</a> to view this promo code.
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <?php else: ?>
    <div class="alert alert-warning" role="alert">
        <h4>Promo Tidak Ditemukan</h4>
        <p>Maaf, promo yang Anda cari tidak tersedia atau telah habis masa berlakunya.</p>
    </div>
    <?php endif; ?>
</div>
<script>
    function copyCode() {
        var codeText = document.getElementById("promo-code").innerText;
        var copyButton = document.getElementById("copy-btn");

        navigator.clipboard.writeText(codeText).then(function() {
            // Ubah teks tombol sementara
            copyButton.innerHTML = '<i class="bi bi-check-lg me-1"></i> Copied!';
            // copyButton.classList.remove('btn-dark');
            // copyButton.classList.add('btn-success');

            // Kembalikan ke semula setelah 2 detik
            setTimeout(function() {
                copyButton.innerHTML = '<i class="bi bi-clipboard me-1"></i> Copy Promo Code';
                // copyButton.classList.remove('btn-success');
                // copyButton.classList.add('btn-dark');
            }, 2000);
        }, function(err) {
            console.error('Gagal menyalin: ', err);
        });
    }
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts_lp.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\ebook_traveling\resources\views\components\promos\detail.blade.php ENDPATH**/ ?>