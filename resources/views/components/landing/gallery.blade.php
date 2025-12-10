{{-- Gallery Section --}}
<section class="gallery-section" style="padding: 100px 0; background: #F7FAFC;">
    <div class="container">
        @if ($section->section_title)
            <div class="text-center mb-5">
                <h2 class="mb-3" style="font-size: 2.8rem; font-weight: 700; color: #1A202C; letter-spacing: -0.5px;">
                    {{ $section->section_title }}
                </h2>
                <div
                    style="width: 80px; height: 4px; background: linear-gradient(90deg, #FF4C61, #FF6B7A); margin: 0 auto; border-radius: 2px;">
                </div>
            </div>
        @endif
        <div class="row g-4 mt-3">
            @foreach ($section->section_data['images'] ?? [] as $image)
                <div class="col-md-4 col-lg-3">
                    <div class="gallery-item"
                        style="position: relative; width: 100%; padding-bottom: 100%; overflow: hidden; border-radius: 16px; box-shadow: 0 4px 24px rgba(0,0,0,0.08); cursor: pointer; transition: all 0.3s ease;"
                        data-bs-toggle="modal" data-bs-target="#galleryModal{{ $section->id }}"
                        data-image="{{ asset('storage/' . $image) }}">
                        <img src="{{ asset('storage/' . $image) }}" alt="Gallery Image"
                            style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover; transition: transform 0.3s ease;">
                        <div class="gallery-overlay"
                            style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: linear-gradient(135deg, rgba(255, 76, 97, 0.8), rgba(255, 107, 122, 0.8)); opacity: 0; transition: opacity 0.3s ease; display: flex; align-items: center; justify-content: center;">
                            <i class="ti ti-zoom-in" style="font-size: 3rem; color: white;"></i>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<style>
    .gallery-item:hover {
        transform: scale(1.03);
        box-shadow: 0 12px 40px rgba(0, 0, 0, 0.15) !important;
    }

    .gallery-item:hover img {
        transform: scale(1.1);
    }

    .gallery-item:hover .gallery-overlay {
        opacity: 1;
    }
</style>

{{-- Gallery Modal --}}
<div class="modal fade" id="galleryModal{{ $section->id }}" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-body p-0">
                <button type="button" class="btn-close position-absolute top-0 end-0 m-3 bg-white rounded-circle p-2"
                    data-bs-dismiss="modal"></button>
                <img src="" id="modalImage{{ $section->id }}" class="img-fluid w-100">
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const modal = document.getElementById('galleryModal{{ $section->id }}');
        if (modal) {
            modal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;
                const imageSrc = button.getAttribute('data-image');
                const modalImage = modal.querySelector('#modalImage{{ $section->id }}');
                modalImage.src = imageSrc;
            });
        }
    });
</script>
