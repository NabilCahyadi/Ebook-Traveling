<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

DB::table('ebooks')->update(['creator_id' => null]);

echo "✅ All creator_id set to null\n";
