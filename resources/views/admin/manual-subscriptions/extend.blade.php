@extends('layouts.admin')

@section('title', 'Extend Subscription')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4">
            <span class="text-muted fw-light">Subscription / Manual Subscriptions /</span> Extend
        </h4>

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row">
            <div class="col-md-8">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">Extend Subscription</h5>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-info mb-4" role="alert">
                            <h6 class="alert-heading mb-2">
                                <i class="bx bx-info-circle me-1"></i> Current Subscription Details
                            </h6>
                            <div class="row">
                                <div class="col-md-6">
                                    <small class="text-muted d-block">User</small>
                                    <strong>{{ $subscription->user->name }}</strong>
                                </div>
                                <div class="col-md-6">
                                    <small class="text-muted d-block">Plan</small>
                                    <strong>{{ $subscription->plan->name }}</strong>
                                </div>
                                <div class="col-md-6 mt-2">
                                    <small class="text-muted d-block">Current End Date</small>
                                    <strong>{{ $subscription->end_date->format('d M Y') }}</strong>
                                </div>
                                <div class="col-md-6 mt-2">
                                    <small class="text-muted d-block">Status</small>
                                    <span class="badge bg-success">{{ ucfirst($subscription->status) }}</span>
                                </div>
                            </div>
                        </div>

                        <form action="{{ route('admin.manual-subscriptions.process-extend', $subscription->id) }}"
                            method="POST">
                            @csrf

                            <div class="mb-3">
                                <label class="form-label" for="days">Extend by (days) <span
                                        class="text-danger">*</span></label>
                                <input type="number" class="form-control @error('days') is-invalid @enderror"
                                    id="days" name="days" min="1" max="365"
                                    value="{{ old('days', 30) }}" required>
                                @error('days')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Enter the number of days to extend (1-365 days)</div>
                            </div>

                            <div class="alert alert-warning" role="alert">
                                <h6 class="alert-heading mb-2">
                                    <i class="bx bx-bulb me-1"></i> Quick Options
                                </h6>
                                <div class="btn-group" role="group">
                                    <button type="button" class="btn btn-sm btn-outline-primary"
                                        onclick="document.getElementById('days').value = 7">7 days</button>
                                    <button type="button" class="btn btn-sm btn-outline-primary"
                                        onclick="document.getElementById('days').value = 30">30 days</button>
                                    <button type="button" class="btn btn-sm btn-outline-primary"
                                        onclick="document.getElementById('days').value = 90">90 days</button>
                                    <button type="button" class="btn btn-sm btn-outline-primary"
                                        onclick="document.getElementById('days').value = 180">180 days</button>
                                    <button type="button" class="btn btn-sm btn-outline-primary"
                                        onclick="document.getElementById('days').value = 365">365 days</button>
                                </div>
                            </div>

                            <div class="mt-4">
                                <button type="submit" class="btn btn-primary me-2">
                                    <i class="bx bx-check me-1"></i> Extend Subscription
                                </button>
                                <a href="{{ route('admin.manual-subscriptions.show', $subscription->id) }}"
                                    class="btn btn-outline-secondary">
                                    Cancel
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Extension Preview</h5>
                        <hr>
                        <div class="mb-3">
                            <small class="text-muted d-block">Current End Date</small>
                            <strong>{{ $subscription->end_date->format('d M Y') }}</strong>
                        </div>
                        <div class="mb-3">
                            <small class="text-muted d-block">Extension Days</small>
                            <strong id="preview-days">30 days</strong>
                        </div>
                        <div class="mb-3">
                            <small class="text-muted d-block">New End Date</small>
                            <strong id="preview-new-end"
                                class="text-primary">{{ $subscription->end_date->copy()->addDays(30)->format('d M Y') }}</strong>
                        </div>
                        <hr>
                        <div class="alert alert-success mb-0" role="alert">
                            <small>
                                <i class="bx bx-info-circle me-1"></i>
                                The subscription will remain active and the end date will be extended.
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const daysInput = document.getElementById('days');
            const currentEndDate = new Date('{{ $subscription->end_date->format('Y-m-d') }}');

            function updatePreview() {
                const days = parseInt(daysInput.value) || 0;
                document.getElementById('preview-days').textContent = days + ' days';

                const newEndDate = new Date(currentEndDate);
                newEndDate.setDate(newEndDate.getDate() + days);

                const options = {
                    year: 'numeric',
                    month: 'short',
                    day: 'numeric'
                };
                document.getElementById('preview-new-end').textContent = newEndDate.toLocaleDateString('en-US',
                    options);
            }

            daysInput.addEventListener('input', updatePreview);
            daysInput.addEventListener('change', updatePreview);
        });
    </script>
@endpush
