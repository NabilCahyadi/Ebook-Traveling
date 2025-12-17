@extends('layouts_lp.app')
@section('title', 'Promo Detail - MeatMap')

@section('content')
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
    @if($promo)
    <div class="container my-4">
        <div class="breadcrumb">
            <a href="{{ route('home') }}" rel="nofollow"><i class="fi-rs-home mr-5"></i></a>
            <span></span>
            <a href="{{ route('promo') }}">Promo</a>
            <span class="active">‎ ‎ {{ $promo->name }}</span>
        </div>
    </div>

    <!-- Gambar Promo dan Deskripsi dalam satu container -->
    <div class="row justify-content-center">
        <div class="col-md-8">
            <!-- Gambar Promo -->
            @if($promo->banner_image)
            <img src="{{ asset($promo->banner_image) }}" alt="{{ $promo->name }}" class="promo-image rounded-md shadow-sm">
            @endif

            <!-- Deskripsi Promo -->
            <div class="card mt-4">
                <div class="card-body">
                    <h4>{{ $promo->name }}</h4>
                    <p>{{$promo->description}}</p>
                    <h6 class="fw-semibold my-2">Promotion Period</h6>
                    <p>
                        {{ \Carbon\Carbon::parse($promo->start_date)->locale('id')->translatedFormat('d F Y') }} -
                        {{ \Carbon\Carbon::parse($promo->end_date)->locale('id')->translatedFormat('d F Y') }}
                    </p>
                    <div class="mb-5">
                        <h6 class="fw-semibold my-2">Terms and Conditions</h6>
                        <div>
                            {!! $promo->terms_conditions !!}
                        </div>
                    </div>
                    @if($promo->date_range)
                    <p class="text-success">
                        <i class="bi bi-info-circle-fill"></i>
                        Special Period : {{ $promo->date_range }}
                    </p>
                    @endif

                    {{-- CEK: Apakah user sudah login? --}}
                    @if(auth()->check())
                    <!-- Tampilkan kode promo dan tombol salin jika user sudah login -->
                    <div class="d-inline-flex align-items-center">
                        <code id="promo-code" class="fs-5 bg-white border rounded px-3 py-2 me-2">{{ $promo->code }}</code>
                        <button onclick="copyCode()" class="btn btn-sm" id="copy-btn">
                            <i class="bi bi-clipboard me-1"></i> Copy Promo Code
                        </button>
                    </div>
                    @else
                    <!-- Tampilkan pesan untuk login jika user belum login -->
                    <div class="alert alert-info d-flex align-items-center" role="alert">
                        <div>
                            Please <a href="{{ route('login') }}" class="alert-link">log in</a> or <a href="{{ route('register') }}" class="alert-link">sign up</a> to view this promo code.
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @else
    <div class="alert alert-warning" role="alert">
        <h4>Promo Tidak Ditemukan</h4>
        <p>Maaf, promo yang Anda cari tidak tersedia atau telah habis masa berlakunya.</p>
    </div>
    @endif
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
@endsection