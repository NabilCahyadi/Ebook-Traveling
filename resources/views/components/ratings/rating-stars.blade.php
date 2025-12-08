@php
    $maxRating = 5;
@endphp

<div class="rating-stars">
    @for ($i = 1; $i <= $maxRating; $i++)
        @if ($i <= $rating)
            {{-- Bintang Terisi --}}
            <i class="fas fa-star text-warning"></i>
        @else
            {{-- Bintang Kosong --}}
            <i class="far fa-star text-warning"></i>
        @endif
    @endfor
</div>