<?php $__env->startSection('title', __('admin.manual_subscription.create')); ?>

<?php $__env->startSection('styles'); ?>
    <style>
        /* FIXED HERE */
        #user-suggestions {
            background-color: #ffffff !important;
            border-radius: 8px;
            margin-top: 4px;
            border: 1px solid #d9dee3;
            position: absolute;
            z-index: 2000 !important;
        }

        /* FIXED HERE – FORCE NON-TRANSPARENT */
        #user-suggestions .list-group-item.list-group-item {
            background-color: #ffffff !important;
            border: none;
            border-bottom: 1px solid #f0f2f5;
            padding: 12px 16px;
            cursor: pointer;
            transition: all 0.2s ease;
            color: #212529;
            backdrop-filter: none !important;
        }

        #user-suggestions .list-group-item:last-child {
            border-bottom: none;
        }

        /* Hover Effect */
        #user-suggestions .list-group-item:hover {
            background-color: #f0f3ff !important;
            transform: translateX(4px);
        }

        #user-suggestions .list-group-item:first-child {
            border-top-left-radius: 8px;
            border-top-right-radius: 8px;
        }

        #user-suggestions .list-group-item:last-child {
            border-bottom-left-radius: 8px;
            border-bottom-right-radius: 8px;
        }

        /* Search input focus */
        #user-search:focus {
            border-color: #696cff;
            box-shadow: 0 0 0 0.2rem rgba(105, 108, 255, 0.25);
        }
    </style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light"><?php echo e(__('admin.menu.subscription_management')); ?> / <?php echo e(__('admin.menu.manual_subscriptions')); ?> /</span> <?php echo e(__('admin.actions.add')); ?>

    </h4>

    <?php if(session('error')): ?>
        <div class="alert alert-danger alert-dismissible" role="alert">
            <?php echo e(session('error')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="row">
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><?php echo e(__('admin.manual_subscription.subscription_info')); ?></h5>
                </div>
                <div class="card-body">
                    <form action="<?php echo e(route('admin.manual-subscriptions.store')); ?>" method="POST">
                        <?php echo csrf_field(); ?>

                        <div class="mb-3">
                            <label class="form-label" for="user_search"><?php echo e(__('admin.manual_subscription.select_user')); ?> <span
                                    class="text-danger">*</span></label>

                            <input type="hidden" id="user_id" name="user_id" value="<?php echo e(old('user_id')); ?>">

                            <div class="position-relative">
                                <input type="text" class="form-control <?php $__errorArgs = ['user_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                    id="user_search" placeholder="<?php echo e(__('admin.manual_subscription.search_user')); ?>"
                                    autocomplete="off" value="<?php echo e(old('user_search')); ?>">

                                <div id="search-loading" class="position-absolute top-50 end-0 translate-middle-y me-3"
                                    style="display: none;">
                                    <div class="spinner-border spinner-border-sm text-primary" role="status">
                                        <span class="visually-hidden">Loading...</span>
                                    </div>
                                </div>

                                <!-- Suggestions -->
                                <div id="user-suggestions" class="list-group w-100 shadow-lg"
                                    style="display: none; max-height: 300px; overflow-y: auto;"></div>
                            </div>

                            <?php $__errorArgs = ['user_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback d-block"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                            <div class="form-text"><?php echo e(__('admin.manual_subscription.search_hint')); ?></div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="subscription_plan_id"><?php echo e(__('admin.manual_subscription.subscription_plan')); ?> <span
                                    class="text-danger">*</span></label>
                            <select class="form-select <?php $__errorArgs = ['subscription_plan_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                id="subscription_plan_id" name="subscription_plan_id" required>
                                <option value=""><?php echo e(__('admin.manual_subscription.choose_plan')); ?></option>
                                <?php $__currentLoopData = $plans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $plan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($plan->id); ?>" data-duration="<?php echo e($plan->duration_days); ?>"
                                        data-price="<?php echo e($plan->price); ?>"
                                        <?php echo e(old('subscription_plan_id') == $plan->id ? 'selected' : ''); ?>>
                                        <?php echo e($plan->name); ?> - <?php echo e($plan->duration_days); ?> days (Rp
                                        <?php echo e(number_format($plan->price, 0, ',', '.')); ?>)
                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <?php $__errorArgs = ['subscription_plan_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="quantity"><?php echo e(__('admin.manual_subscription.quantity')); ?> <span class="text-danger">*</span></label>
                            <input type="number" class="form-control <?php $__errorArgs = ['quantity'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                id="quantity" name="quantity" min="1" max="12"
                                value="<?php echo e(old('quantity', 1)); ?>" required>
                            <div class="form-text"><?php echo e(__('admin.manual_subscription.quantity_help')); ?>

                            </div>
                            <?php $__errorArgs = ['quantity'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="card bg-light-info mb-3" id="subscription-summary" style="display: none;">
                            <div class="card-body">
                                <h6 class="card-title mb-2"><?php echo e(__('admin.manual_subscription.subscription_summary')); ?></h6>
                                <div class="row">
                                    <div class="col-6">
                                        <small class="text-muted"><?php echo e(__('admin.manual_subscription.plan_duration')); ?>:</small>
                                        <div class="fw-semibold" id="plan-duration">-</div>
                                    </div>
                                    <div class="col-6">
                                        <small class="text-muted">Quantity:</small>
                                        <div class="fw-semibold" id="plan-quantity">-</div>
                                    </div>
                                    <div class="col-6 mt-2">
                                        <small class="text-muted">Total Duration:</small>
                                        <div class="fw-bold text-primary" id="total-duration">-</div>
                                    </div>
                                    <div class="col-6 mt-2">
                                        <small class="text-muted">Total Amount:</small>
                                        <div class="fw-bold text-success" id="total-amount">-</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="alert alert-info">
                            <h6 class="alert-heading mb-2"><i class="bx bx-info-circle me-1"></i> Information</h6>
                            <ul class="mb-0 ps-3">
                                <li>Subscription will start immediately upon creation</li>
                                <li>End date will be calculated automatically</li>
                                <li>Status will be "Active"</li>
                                <li>User will receive a unique subscription code</li>
                            </ul>
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary me-2">
                                <i class="bx bx-check me-1"></i> Create Subscription
                            </button>
                            <a href="<?php echo e(route('admin.manual-subscriptions.index')); ?>" class="btn btn-outline-secondary">
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Preview card -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title"><?php echo e(__('admin.manual_subscription.subscription_preview')); ?></h5>
                    <hr>
                    <div id="preview-info">
                        <div class="mb-3"><small class="text-muted d-block"><?php echo e(__('admin.manual_subscription.user')); ?></small><strong id="preview-user"><?php echo e(__('admin.manual_subscription.not_selected')); ?>

                                </strong></div>
                        <div class="mb-3"><small class="text-muted d-block"><?php echo e(__('admin.manual_subscription.plan')); ?></small><strong id="preview-plan"><?php echo e(__('admin.manual_subscription.not_selected')); ?>

                                </strong></div>
                        <div class="mb-3"><small class="text-muted d-block"><?php echo e(__('admin.manual_subscription.duration')); ?></small><strong
                                id="preview-duration">-</strong></div>
                        <div class="mb-3"><small class="text-muted d-block"><?php echo e(__('admin.manual_subscription.amount')); ?></small><strong
                                id="preview-amount">Rp 0</strong></div>
                        <div class="mb-3"><small class="text-muted d-block"><?php echo e(__('admin.manual_subscription.start_date')); ?>

                                </small><strong><?php echo e(now()->format('d M Y')); ?></strong></div>
                        <div class="mb-3"><small class="text-muted d-block"><?php echo e(__('admin.manual_subscription.end_date')); ?></small><strong
                                id="preview-end-date">-</strong></div>
                    </div>
                </div>
            </div>
        </div>

    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const userSearchInput = document.getElementById('user_search');
            const userIdInput = document.getElementById('user_id');
            const suggestionsDiv = document.getElementById('user-suggestions');
            const loadingIndicator = document.getElementById('search-loading');
            const planSelect = document.getElementById('subscription_plan_id');

            let searchTimeout;
            let selectedUserId = null;

            userSearchInput.addEventListener('input', function() {
                const query = this.value.trim();
                clearTimeout(searchTimeout);

                if (query.length < 2) {
                    suggestionsDiv.style.display = 'none';
                    suggestionsDiv.innerHTML = '';
                    userIdInput.value = '';
                    document.getElementById('preview-user').textContent = '<?php echo e(__('admin.manual_subscription.not_selected')); ?>';
                    return;
                }

                loadingIndicator.style.display = 'block';

                searchTimeout = setTimeout(() => {
                    fetch(
                            `<?php echo e(route('admin.manual-subscriptions.search-users')); ?>?q=${encodeURIComponent(query)}`)
                        .then(response => response.json())
                        .then(users => {
                            loadingIndicator.style.display = 'none';
                            displaySuggestions(users);
                        })
                        .catch(() => {
                            loadingIndicator.style.display = 'none';
                            suggestionsDiv.innerHTML =
                                '<div class="list-group-item text-danger"><?php echo e(__('admin.messages.error_loading')); ?></div>';
                            suggestionsDiv.style.display = 'block';
                        });
                }, 300);
            });

            function displaySuggestions(users) {
                suggestionsDiv.innerHTML = '';

                if (users.length === 0) {
                    suggestionsDiv.innerHTML = '<div class="list-group-item text-muted"><?php echo e(__('admin.users.no_users_found')); ?></div>';
                    suggestionsDiv.style.display = 'block';
                    return;
                }

                users.forEach(user => {
                    const item = document.createElement('a');
                    item.href = '#';
                    item.className = 'list-group-item list-group-item-action';
                    item.innerHTML = `
                <div class="d-flex align-items-center">
                    <div class="avatar avatar-sm me-2">
                        <span class="avatar-initial rounded-circle bg-label-primary">
                            ${user.name.charAt(0).toUpperCase()}
                        </span>
                    </div>
                    <div>
                        <div class="fw-medium">${user.name}</div>
                        <small class="text-muted">${user.email}</small>
                    </div>
                </div>
            `;

                    item.addEventListener('click', e => {
                        e.preventDefault();
                        selectUser(user);
                    });

                    suggestionsDiv.appendChild(item);
                });

                suggestionsDiv.style.display = 'block';
            }

            function selectUser(user) {
                selectedUserId = user.id;
                userIdInput.value = user.id;
                userSearchInput.value = `${user.name} (${user.email})`;
                suggestionsDiv.style.display = 'none';

                document.getElementById('preview-user').textContent = `${user.name} (${user.email})`;
            }

            document.addEventListener('click', function(e) {
                if (!userSearchInput.contains(e.target) && !suggestionsDiv.contains(e.target)) {
                    suggestionsDiv.style.display = 'none';
                }
            });

            function updateSubscriptionSummary() {
                const planSelect = document.getElementById('subscription_plan_id');
                const quantityInput = document.getElementById('quantity');
                const selectedOption = planSelect.options[planSelect.selectedIndex];

                if (selectedOption.value && quantityInput.value) {
                    const duration = parseInt(selectedOption.dataset.duration);
                    const price = parseFloat(selectedOption.dataset.price);
                    const quantity = parseInt(quantityInput.value);
                    const planName = selectedOption.text.split(' - ')[0];

                    const totalDuration = duration * quantity;
                    const totalAmount = price * quantity;

                    document.getElementById('plan-duration').textContent = duration + ' days';
                    document.getElementById('plan-quantity').textContent = quantity + 'x';
                    document.getElementById('total-duration').textContent = totalDuration + ' days';
                    document.getElementById('total-amount').textContent = 'Rp ' + new Intl.NumberFormat('id-ID')
                        .format(totalAmount);
                    document.getElementById('subscription-summary').style.display = 'block';

                    // Update preview
                    document.getElementById('preview-plan').textContent = planName + ' (' + quantity + 'x)';
                    document.getElementById('preview-duration').textContent = totalDuration + ' days';
                    document.getElementById('preview-amount').textContent = 'Rp ' + new Intl.NumberFormat('id-ID')
                        .format(totalAmount);

                    const startDate = new Date();
                    const endDate = new Date(startDate);
                    endDate.setDate(endDate.getDate() + totalDuration);
                    document.getElementById('preview-end-date').textContent = endDate.toLocaleDateString('en-US', {
                        year: 'numeric',
                        month: 'short',
                        day: 'numeric'
                    });
                } else {
                    document.getElementById('subscription-summary').style.display = 'none';
                    document.getElementById('preview-plan').textContent = '<?php echo e(__('admin.manual_subscription.not_selected')); ?>';
                    document.getElementById('preview-duration').textContent = '-';
                    document.getElementById('preview-amount').textContent = 'Rp 0';
                    document.getElementById('preview-end-date').textContent = '-';
                }
            }

            planSelect.addEventListener('change', updateSubscriptionSummary);
            document.getElementById('quantity').addEventListener('input', updateSubscriptionSummary);

        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\ebook_traveling\resources\views/admin/manual-subscriptions/create.blade.php ENDPATH**/ ?>