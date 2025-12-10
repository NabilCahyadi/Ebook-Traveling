<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\SubscriptionPlan;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class PremiumUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Cek apakah user sudah ada untuk menghindari duplikasi
        if (User::where('email', 'premium@gmail.com')->exists()) {
            $this->command->info('Premium user already exists. Skipping seeder.');
            return;
        }

        // 2. Buat pengguna baru
        $premiumUser = User::create([
            'name' => 'Premium User',
            'email' => 'premium@gmail.com',
            'password' => Hash::make('password'), // password: password
            'email_verified_at' => now(),
        ]);

        // 3. Assign role 'member' ke pengguna baru
        $memberRole = DB::table('roles')->where('name', 'member')->first();
        if ($memberRole) {
            DB::table('user_roles')->insert([
                'id' => Str::uuid(), // <-- TAMBAHKAN BARIS INI
                'user_id' => $premiumUser->id,
                'role_id' => $memberRole->id,
            ]);
        }

        // 4. Ambil paket berlangganan "Monthly Explorer" (atau paket berbayar lainnya)
        $plan = SubscriptionPlan::where('slug', 'monthly-explorer')->first();

        if (!$plan) {
            $this->command->error('Subscription plan "monthly-explorer" not found. Please run SubscriptionPlanSeeder first.');
            return;
        }

        // 5. Buat data langganan yang aktif untuk pengguna
        $startDate = now();
        $endDate = (clone $startDate)->addDays($plan->duration_days);

        DB::table('subscriptions')->insert([
            'id' => Str::uuid(),
            'user_id' => $premiumUser->id,
            'subscription_plan_id' => $plan->id,
            'payment_id' => null, // Bisa diisi dengan ID payment jika ada
            'subscription_code' => 'PREMIUM-' . strtoupper(Str::random(8)),
            'start_date' => $startDate->toDateString(),
            'end_date' => $endDate->toDateString(),
            'status' => 'active', // Statusnya AKTIF
            'auto_renew' => true,
            'total_amount' => $plan->price,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $this->command->info('Premium user created successfully!');
        $this->command->line('Email: premium@gmail.com');
        $this->command->line('Password: password');
    }
}
