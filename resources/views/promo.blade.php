@extends('layouts_lp.app')
@section('title', 'Promo - MeatMap')

@section('content')
<style>
    /* CSS UPDATE UNTUK KOLOM PENCARIAN */
    .search-container {
        margin-top: 30px;
        margin-bottom: 30px;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .search-input {
        width: 1480px;
        height: 50px;
        /* padding: 5px 20px 5px 20px; */
        border: 1px solid #ff4c6144;
        border-radius: 8px;
        font-size: 1rem;
        transition: border-color 0.3s, box-shadow 0.3s;
        text-align: left;
    }

    .search-input:focus {
        border-color: #D94354;
        outline: none;
        box-shadow: 0 0 0 0.25rem rgba(255, 76, 97, 0.25);
    }

    /* Responsive */
    @media (max-width: 768px) {
        .search-input {
            width: 90%;
            /* Lebih fleksibel di mobile */
            max-width: 400px;
            /* Batas maksimal di mobile */
        }
    }

    @media (max-width: 576px) {
        .search-input {
            width: 95%;
            /* Hampir full width di mobile kecil */
            max-width: 350px;
        }
    }

    /* CSS LAMA UNTUK KARTU (TIDAK BERUBAH) */
    .card {
        width: 680px;
        position: relative;
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-orient: vertical;
        -webkit-box-direction: normal;
        -ms-flex-direction: column;
        flex-direction: column;
        min-width: 0;
        word-wrap: break-word;
        background-color: #fff;
        background-clip: border-box;
        border-radius: 25px;
        margin-top: 20px;
        margin-bottom: 20px;
        border: 1px solid rgba(0, 0, 0, 0.1);
    }

    .promo-container {
        padding: 0 15px;
    }

    .card-product-grid:hover {
        -webkit-box-shadow: 0 4px 15px rgba(153, 153, 153, 0.3);
        box-shadow: 0 4px 15px rgba(153, 153, 153, 0.3);
        -webkit-transition: .3s;
        transition: .3s
    }

    .card-product-grid .img-wrap {
        border-radius: 25px 25px 0 0;
        height: 220px
    }

    .card .img-wrap {
        overflow: hidden;
    }

    .card-lg .img-wrap {
        height: 280px
    }

    .card-product-grid .img-wrap {
        border-radius: 25px 25px 0 0;
        height: 275px;
        padding: 0px;
    }

    [class*='card-product'] .img-wrap img {
        height: 100%;
        max-width: 100%;
        width: auto;
        display: inline-block;
        -o-object-fit: cover;
        object-fit: cover;
    }

    .img-wrap {
        text-align: center;
        display: block
    }

    .card-product-grid .info-wrap {
        overflow: hidden;
        padding: 18px 20px;
    }

    [class*='card-product'] a.title {
        color: #212529;
        display: block
    }

    .card-product-grid .bottom-wrap {
        padding: 18px;
        border-top: 1px solid #e4e4e4;
        border-radius: 0 0 25px 25px;
    }

    .btn {
        display: inline-block;
        font-weight: 600;
        color: #343a40;
        text-align: center;
        vertical-align: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
        background-color: transparent;
        border: 1px solid transparent;
        padding: 0.45rem 0.85rem;
        font-size: 1rem;
        line-height: 1.5;
        border-radius: 25px;
    }

    .btn-primary {
        color: #fff;
        background-color: #FF4C61;
        border-color: #E54457;
        transition: background-color 0.3s;
    }

    .btn-primary:hover {
        background-color: #D94354;
        border-color: #C33B4A;
    }

    .btn-primary:focus,
    .btn-primary:active,
    .btn-primary:focus-visible {
        color: #fff;
        background-color: #D94354;
        border-color: #C33B4A;
        box-shadow: 0 0 0 0.25rem rgba(255, 76, 97, 0.5) !important;
    }

    .promo-title {
        font-size: 1.3rem;
        font-weight: 600;
        margin-bottom: 5px;
        color: #333;
    }

    .promo-period,
    .promo-date {
        font-size: 0.9rem;
        color: #666;
        display: block;
    }

    .btn-full-width {
        width: 100%;
        text-align: center;
        margin: 0;
        padding: 0.75rem 0.85rem;
        font-size: 1.1rem;
    }

    .bottom-wrap a.btn-primary {
        float: none !important;
    }

    .price-wrap {
        display: none;
    }
</style>

<div class="container promo-container">
    <div class="row">
        <div class="col-12">
            <div class="search-container">
                <input type="text" class="search-input" placeholder="Cari Promo">
            </div>
        </div>
    </div>
    <div class="row d-flex justify-content-center">
        @php
        // Data dummy untuk 6 kartu
        $promos = [
        ['title' => 'Flash Sale Mendadak Kaya', 'date' => '15 Oktober - 31 Desember 2025', 'img' => '/images/banner-promo-1.webp'],
        ['title' => 'Diskon Kilat Daging Segar', 'date' => '1 November - 30 November 2025', 'img' => '/images/banner-promo-2.webp'],
        ['title' => 'Promo Akhir Tahun Steak Premium', 'date' => '10 Desember - 31 Desember 2025', 'img' => '/images/banner-promo-3.webp'],
        ['title' => 'Beli 2 Gratis 1 Ayam Fillet', 'date' => 'Setiap Hari Jumat', 'img' => '/images/banner-promo-4.webp'],
        ['title' => 'Gratis Ongkir Seluruh Kota', 'date' => 'Berlaku Hingga Akhir Bulan', 'img' => '/images/banner-promo-2.webp'],
        ['title' => 'Mystery Box Daging Eksklusif', 'date' => 'Periode Terbatas', 'img' => '/images/banner-promo-3.webp'],
        ];
        @endphp

        @foreach ($promos as $promo)
        <div class="col-12 col-sm-6 col-md-6 d-flex justify-content-center">
            <figure class="card card-product-grid card-lg">
                <a href="#" class="img-wrap" data-abc="true">
                    <img src="{{ $promo['img'] }}">
                </a>
                <figcaption class="info-wrap">
                    <div class="row">
                        <div class="col-md-12">
                            <a href="#" class="title promo-title" data-abc="true">{{ $promo['title'] }}</a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <span class="promo-period">Periode Promo</span>
                            <span class="promo-date">{{ $promo['date'] }}</span>
                        </div>
                    </div>
                </figcaption>
                <div class="bottom-wrap">
                    <a href="#" class="btn btn-primary btn-full-width" data-abc="true"> View Details </a>
                </div>
            </figure>
        </div>
        @endforeach
    </div>
</div>
@endsection