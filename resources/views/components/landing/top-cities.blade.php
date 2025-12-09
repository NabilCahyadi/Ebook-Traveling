<section class="popular-categories section-padding">
    <div class="container wow animate__animated animate__fadeIn">
        <div class="section-title style-2 flex-container-custom">
            <div class="title">
                <h3>Top 10 City Guides</h3>
            </div>
            <a href="/destinations" class="show-all">View All</a>
        </div>
        <div class="slider-arrow slider-arrow-2 flex carausel-10-columns-arrow"></div>
        <div class="carausel-10-columns-cover position-relative">
            <div class="carausel-10-columns" id="carausel-10-columns">

                @foreach ($topCities as $index => $city)
                    <div class="card-2 bg-12 wow animate__animated animate__fadeInUp"
                        data-wow-delay="{{ ($index + 1) * 0.1 }}s">
                        <figure class="img-hover-scale overflow-hidden"
                            style="width: 100px; height: 120px; margin: 0 auto 10px; border-radius: 8px;">
                            <a href="/destination/{{ $city->slug }}">
                                <img src="{{ asset($city->image) }}" alt="{{ $city->name }}"
                                    style="width: 100%; height: 100%; object-fit: cover;" />
                            </a>
                        </figure>
                        <h6>
                            <a href="/destination/{{ $city->slug }}">{{ $city->name }}</a>
                        </h6>
                    </div>
                @endforeach

            </div>
        </div>
    </div>
</section>
