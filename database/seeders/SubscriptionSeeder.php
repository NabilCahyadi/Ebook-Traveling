<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\SubscriptionPlan;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class SubscriptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil semua user dengan role 'member'
        $members = User::whereHas('roles', function ($query) {
            $query->where('name', 'member');
        })->get();

        // Ambil semua paket berlangganan yang aktif
        $plans = SubscriptionPlan::where('is_active', true)->get();

        $subscriptionsToInsert = [];

        // Buat 15 data berlangganan acak untuk para member
        for ($i = 0; $i < 15; $i++) {
            $member = $members->random();
            $plan = $plans->random();

            // Hindari membuat duplikat subscription untuk user yang sama
            if (DB::table('subscriptions')->where('user_id', $member->id)->exists()) {
                continue;
            }

            $startDate = now()->subDays(rand(5, 60));
            $endDate = (clone $startDate)->addDays($plan->duration_days);
            $status = $endDate->isFuture() ? 'active' : 'expired';

            $subscriptionsToInsert[] = [
                'id' => Str::uuid(),
                'user_id' => $member->id,
                'subscription_plan_id' => $plan->id,
                'payment_id' => null, // Bisa diisi dengan ID payment jika ada
                'subscription_code' => 'SUB-' . strtoupper(Str::random(10)),
                'start_date' => $startDate->toDateString(),
                'end_date' => $endDate->toDateString(),
                'status' => $status,
                'auto_renew' => rand(0, 1), // 50% kemungkinan auto-renew
                'total_amount' => $plan->price,
                'created_at' => $startDate,
                'updated_at' => $startDate,
            ];
        }

        if (!empty($subscriptionsToInsert)) {
            DB::table('subscriptions')->insert($subscriptionsToInsert);
            $this->command->info(count($subscriptionsToInsert) . ' Subscriptions created successfully!');
        } else {
            $this->command->info('No new subscriptions to create.');
        }
    }
}
