<?php

namespace App\Console\Commands;

use App\Models\Subscription;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class UpdateExpiredSubscriptions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'subscriptions:update-expired';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update status subscriptions that have expired based on end_date';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🔄 Checking for expired subscriptions...');

        // Find all subscriptions with status 'active' but end_date has passed
        $expiredSubscriptions = Subscription::where('status', 'active')
            ->where('end_date', '<', now())
            ->get();

        $count = $expiredSubscriptions->count();

        if ($count === 0) {
            $this->info('✅ No expired subscriptions found.');
            return Command::SUCCESS;
        }

        $this->info("📋 Found {$count} expired subscription(s). Updating...");

        $updated = 0;
        foreach ($expiredSubscriptions as $subscription) {
            try {
                $subscription->status = 'expired';
                $subscription->save();

                $userEmail = $subscription->user ? $subscription->user->email : 'N/A';
                $this->line("  ➤ Updated subscription #{$subscription->subscription_code} (User: {$userEmail})");
                $updated++;

                // Log the update
                Log::info('Subscription expired', [
                    'subscription_id' => $subscription->id,
                    'subscription_code' => $subscription->subscription_code,
                    'user_id' => $subscription->user_id,
                    'end_date' => $subscription->end_date,
                ]);
            } catch (\Exception $e) {
                $this->error("  ✗ Failed to update subscription #{$subscription->subscription_code}: {$e->getMessage()}");
                Log::error('Failed to update expired subscription', [
                    'subscription_id' => $subscription->id,
                    'error' => $e->getMessage(),
                ]);
            }
        }

        $this->newLine();
        $this->info("✅ Successfully updated {$updated} out of {$count} subscription(s).");

        return Command::SUCCESS;
    }
}
