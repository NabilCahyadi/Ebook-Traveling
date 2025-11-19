@extends('layouts.front')

@section('title', 'Home')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <h1 class="mt-50 mb-50">Welcome to {{ config('app.name') }}</h1>
            <p>This is the home page using the Front (Nest) template for regular users.</p>
            
            <div class="alert alert-info">
                <strong>Template Info:</strong> This page uses the <strong>Front Template (Nest)</strong> 
                which is stored in <code>resources/views/layouts/front.blade.php</code>
            </div>
            
            <h3>Template Features:</h3>
            <ul>
                <li>Header with navigation</li>
                <li>Shopping cart integration</li>
                <li>Wishlist functionality</li>
                <li>User account access</li>
                <li>Responsive design</li>
                <li>Footer with newsletter</li>
            </ul>
            
            <h3>Quick Links:</h3>
            <div class="mt-30">
                <a href="{{ route('shop.index') }}" class="btn btn-primary">Browse Shop</a>
                <a href="{{ route('blog.index') }}" class="btn btn-secondary">Read Blog</a>
                <a href="{{ route('page.about') }}" class="btn btn-info">About Us</a>
                <a href="{{ route('page.contact') }}" class="btn btn-warning">Contact</a>
            </div>
        </div>
    </div>
</div>
@endsection
