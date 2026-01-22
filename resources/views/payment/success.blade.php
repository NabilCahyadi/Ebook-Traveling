@extends('layouts_lp.app')

@section('content')
<style>
    .custom-button {
        padding: 8px 20px !important;
        border: none !important;
        border-radius: 50px !important;
        font-size: 0.8rem !important;
        font-weight: 600 !important;
        cursor: pointer !important;
        transition: all 0.3s ease !important;
        letter-spacing: 1px !important;
        text-decoration: none !important;
        text-align: center !important;
        display: inline-block !important;
    }

    .custom-button--primary {
        background-color: #FF4C61 !important;
        color: #fff !important;
    }

    .pricing-card--featured .custom-button--primary {
        background-color: var(--primary-color);
        box-shadow: 0 5px 15px rgba(255, 76, 97, 0.3);
    }

    .custom-button--primary:hover {
        background-color: #FF416C !important;
        transform: translateY(-3px) !important;
    }

    /* untuk progresss subscription */
    .progress-bar {
        transition: width 0.5s ease;
    }
</style>
<div class="container py-5">
    <div class="text-center">
        @if(session('webhookError'))
        <div class="alert alert-danger">
            <strong>Webhook Error:</strong> {{ session('webhookError') }}
        </div>
        @endif

        @if($webhookError ?? null)
        <div class="alert alert-danger">
            <strong>Webhook Error:</strong> {{ $webhookError }}
        </div>
        @endif
        <div class="mb-4">
            <i class="fi fi-rs-check-circle text-success" style="font-size: 64px;"></i>
        </div>
        <h2>Payment Successful!</h2>
        <p class="text-muted">Your subscription is now active.</p>

        @if($isPremium)
        <div class="alert alert-success">You're now a Premium member!</div>
        @endif

        <a href="{{ route('page-account') }}?tab=library" class="custom-button custom-button--primary text-white px-4 mt-1">
            Member Area
        </a>
    </div>
</div>
@endsection
