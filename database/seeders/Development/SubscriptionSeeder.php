<?php

namespace Database\Seeders\Development;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Subscription;
use App\Models\SubscriptionPlan;
use Illuminate\Support\Str;

class SubscriptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Uses updateOrCreate to be safe for production deployment
     */
    public function run(): void
    {
        // Ambil semua user dengan user_type 'member' (premium subscription status)
        $members = User::where('user_type', 'member')->get();

        if ($members->isEmpty()) {
            $this->command->warn('⚠️  No users with user_type "member" found. Skipping subscription seeding.');
            return;
        }

        // Ambil semua paket berlangganan yang aktif
        $plans = SubscriptionPlan::where('is_active', true)->get();

        if ($plans->isEmpty()) {
            $this->command->warn('⚠️  No active subscription plans found. Please run SubscriptionPlanSeeder first.');
            return;
        }

        $createdCount = 0;
        $updatedCount = 0;

        // Untuk setiap member, buat atau update subscription
        foreach ($members as $member) {
            // Check if user already has any subscription (active or expired)
            $existingSubscription = Subscription::where('user_id', $member->id)->first();
            
            // Pilih random plan (atau bisa disesuaikan dengan logic bisnis)
            $plan = $plans->random();

            // Hitung tanggal subscription
            $startDate = now()->subDays(rand(1, 30));
            $endDate = (clone $startDate)->addDays($plan->duration_days);
            $status = $endDate->isFuture() ? 'active' : 'expired';

            // Generate subscription code yang unique
            $subscriptionCode = $existingSubscription 
                ? $existingSubscription->subscription_code 
                : 'SUB-' . strtoupper(Str::random(10));

            // UpdateOrCreate berdasarkan user_id
            $subscription = Subscription::updateOrCreate(
                ['user_id' => $member->id],
                [
                    'subscription_plan_id' => $plan->id,
                    'subscription_code' => $subscriptionCode,
                    'start_date' => $startDate,
                    'end_date' => $endDate,
                    'status' => $status,
                    'auto_renew' => (bool) rand(0, 1),
                    'total_amount' => $plan->price,
                ]
            );

            if ($subscription->wasRecentlyCreated) {
                $createdCount++;
            } else {
                $updatedCount++;
            }
        }

        $this->command->info('✅ Subscription seeding completed!');
        $this->command->info("   📝 Created: {$createdCount} subscriptions");
        $this->command->info("   🔄 Updated: {$updatedCount} subscriptions");
        $this->command->info("   👥 Total members processed: {$members->count()}");
    }
}
