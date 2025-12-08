<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Services\CityService;

$cityService = app(CityService::class);

echo "=== Testing CityService getPopularCitiesWithEbookCount ===\n\n";

$cities = $cityService->getPopularCitiesWithEbookCount();

foreach ($cities as $city) {
    printf(
        "%-20s : %3d items (ID: %s)\n",
        $city['name'],
        $city['items_count'],
        substr($city['id'], 0, 8)
    );
}

echo "\nTotal cities returned: " . count($cities) . "\n";
