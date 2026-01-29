<?php

namespace Database\Seeders\Testing;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Subscription;
use App\Models\SubscriptionPlan;
use Illuminate\Support\Str;
use Carbon\Carbon;

class SubscriptionHistoryTestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::inRandomOrder()->limit(10)->get();
        $plans = SubscriptionPlan::where('is_active', true)->get();

        if ($users->isEmpty() || $plans->isEmpty()) {
            $this->command->warn('No users or active plans found. Please seed users and plans first.');
            return;
        }

        $statuses = ['active', 'expired', 'pending', 'cancelled', 'failed'];

        for ($i = 1; $i <= 60; $i++) {
            $user = $users->random();
            $plan = $plans->random();
            $startDate = Carbon::now()->subDays(rand(0, 365));
            $endDate = (clone $startDate)->addDays($plan->duration_days ?? 30);
            $status = $statuses[array_rand($statuses)];
            $autoRenew = rand(0, 1);
            $amount = $plan->price ?? rand(10000, 100000);

            Subscription::create([
                'user_id' => $user->id,
                'subscription_plan_id' => $plan->id,
                'subscription_code' => 'SUB-' . strtoupper(Str::random(10)) . "-TST{$i}",
                'start_date' => $startDate,
                'end_date' => $endDate,
                'status' => $status,
                'auto_renew' => $autoRenew,
                'total_amount' => $amount,
            ]);
        }

        $this->command->info('✅ 60 subscription history test data created!');
    }
}
