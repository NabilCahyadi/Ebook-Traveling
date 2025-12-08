<?php
// app/Providers/EventServiceProvider.php

use App\Observers\RatingObserver;
use App\Models\Rating;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        // ...
    ];

    /**
     * Register any observers for your application.
     *
     * @return void
     */
    public function boot()
    {
        // Tambahkan baris ini
        Rating::observe(RatingObserver::class);
    }
}
