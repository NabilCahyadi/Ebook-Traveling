<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

$admin = Admin::where('email', 'admin@gmail.com')->first();

if ($admin) {
    $admin->password = Hash::make('admin123');
    $admin->save();
    echo "✓ Password reset successfully for: {$admin->email}\n";
    echo "New password: admin123\n";
} else {
    echo "✗ Admin not found with email: admin@gmail.com\n";
    echo "Trying nabilcahyadi155@gmail.com...\n";
    
    $admin = Admin::where('email', 'nabilcahyadi155@gmail.com')->first();
    if ($admin) {
        $admin->password = Hash::make('admin123');
        $admin->save();
        echo "✓ Password reset successfully for: {$admin->email}\n";
        echo "New password: admin123\n";
    } else {
        echo "✗ No admin found!\n";
    }
}
