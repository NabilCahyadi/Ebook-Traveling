@extends('layouts_lp.app')

@section('content')
<div class="container py-5">
    <div class="text-center">
        <div class="mb-4">
            <i class="fi-rs-check-circle text-success" style="font-size: 64px;"></i>
        </div>
        <h2>Payment Successful!</h2>
        <p class="text-muted">Your subscription is now active.</p>

        @if($isPremium)
        <div class="alert alert-success">Welcome to Premium!</div>
        @endif

        <a href="{{ route('page-account') }}" class="btn btn-primary mt-3">
            Go to Account
        </a>
    </div>
</div>
@endsection
