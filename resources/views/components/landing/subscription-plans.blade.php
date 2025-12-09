<section class="banners mb-25">
    <div class="container">
        <div class="row">
            <div class="section-title style-2">
                <div class="title">
                    <h3>Subscription Plans</h3>
                </div>
                <a href="{{ route('pricing') }}" class="show-all">View All</a>
            </div>

            @php
                // Fallback jika $subscriptionPlans tidak ada
                if (!isset($subscriptionPlans)) {
                    $subscriptionPlans = app(\App\Services\SubscriptionPlanService::class)->getHomepagePlans(3);
                }
            @endphp

            @foreach ($subscriptionPlans as $index => $plan)
                @php
                    // Tentukan class col untuk responsive design
                    $colClass = 'col-lg-4 ';
                    $colClass .= $index == 2 ? 'd-md-none d-lg-flex' : 'col-md-6';

                    // Tentukan delay untuk animation
                    $delay = $index * 0.2;
                @endphp

                <div class="{{ $colClass }}">
                    <div class="banner-img wow animate__animated animate__fadeInUp" data-wow-delay="{{ $delay }}s">
                        <a href="{{ route('pricing') }}">
                            <img src="{{ asset($plan->image) }}" alt="{{ $plan->name }}" />
                        </a>
                    </div>
                </div>
            @endforeach

        </div>
    </div>
</section>
