<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Schedule the publish command to run every minute
Schedule::command('content:publish-scheduled')->everyMinute();

// Schedule to check and update expired subscriptions every hour
Schedule::command('subscriptions:update-expired')->hourly();
