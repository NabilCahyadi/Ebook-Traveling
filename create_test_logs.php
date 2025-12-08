<?php

require_once 'vendor/autoload.php';

use Illuminate\Support\Facades\Artisan;

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;
use App\Models\ActionLog;
use App\Models\Role;

// Ambil user non-admin
$users = User::whereHas('roles', function($q) { 
    $q->where('slug', '!=', 'admin'); 
})->take(3)->get();

if($users->isEmpty()) {
    echo 'No non-admin users found. Creating test data...' . PHP_EOL;
    
    // Buat role member jika belum ada
    $memberRole = Role::firstOrCreate(['slug' => 'member'], [
        'name' => 'Member', 
        'description' => 'Regular member'
    ]);
    
    // Buat user test
    $testUser = User::create([
        'name' => 'Test User',
        'email' => 'testuser@example.com',
        'password' => bcrypt('password'),
        'email_verified_at' => now()
    ]);
    
    $testUser->roles()->attach($memberRole->id);
    $users = collect([$testUser]);
}

// Buat 10 activity log untuk testing
for($i = 0; $i < 10; $i++) {
    $user = $users->random();
    ActionLog::create([
        'user_id' => $user->id,
        'action_type' => collect(['create', 'update', 'view', 'delete', 'login', 'logout', 'download'])->random(),
        'table_name' => collect(['ebooks', 'blogs', 'users', 'orders', 'subscriptions'])->random(),
        'record_id' => \Illuminate\Support\Str::uuid(),
        'ip_address' => '127.0.0.1',
        'user_agent' => 'Mozilla/5.0 (Test Browser)',
        'url' => '/test/url/' . $i,
        'method' => collect(['GET', 'POST', 'PUT', 'DELETE'])->random(),
        'created_at' => now()->subMinutes(rand(1, 1440))
    ]);
}

echo 'Created 10 test activity logs!' . PHP_EOL;
echo 'Total logs: ' . ActionLog::count() . PHP_EOL;
echo 'Test users: ' . $users->count() . PHP_EOL;