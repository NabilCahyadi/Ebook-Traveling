<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$indexes = DB::select("SHOW INDEXES FROM ebooks");
echo "All indexes for ebooks table:\n\n";
foreach ($indexes as $index) {
    echo "Key_name: {$index->Key_name}\n";
    echo "Column_name: {$index->Column_name}\n";
    echo "Non_unique: {$index->Non_unique} (0=UNIQUE, 1=NON-UNIQUE)\n";
    echo "---\n";
}
