<?php

namespace App\Observers;

use App\Models\Subscription;

class SubscriptionObserver extends BaseObserver
{
    /**
     * Handle the Subscription "created" event.
     */
    public function created(Subscription $subscription)
    {
        $this->logActivity('create', $this->getTableName($subscription), $subscription->id, [
            'subscription_plan_id' => $subscription->subscription_plan_id,
            'plan_name' => $subscription->subscriptionPlan->name ?? 'N/A',
            'status' => $subscription->status,
            'start_date' => $subscription->start_date,
            'end_date' => $subscription->end_date,
            'data' => $this->getModelData($subscription)
        ]);
    }

    /**
     * Handle the Subscription "updated" event.
     */
    public function updated(Subscription $subscription)
    {
        $changes = $subscription->getChanges();
        
        // Determine action type based on status change
        $actionType = 'update';
        if (isset($changes['status'])) {
            $actionType = match($changes['status']) {
                'cancelled' => 'cancel_subscription',
                'active' => 'activate_subscription',
                'expired' => 'expire_subscription',
                default => 'update'
            };
        }
        
        $this->logActivity($actionType, $this->getTableName($subscription), $subscription->id, [
            'subscription_plan_id' => $subscription->subscription_plan_id,
            'plan_name' => $subscription->subscriptionPlan->name ?? 'N/A',
            'status' => $subscription->status,
            'changes' => $changes,
            'data' => $this->getModelData($subscription)
        ]);
    }

    /**
     * Handle the Subscription "deleted" event.
     */
    public function deleted(Subscription $subscription)
    {
        $this->logActivity('delete', $this->getTableName($subscription), $subscription->id, [
            'subscription_plan_id' => $subscription->subscription_plan_id,
            'plan_name' => $subscription->subscriptionPlan->name ?? 'N/A',
            'status' => $subscription->status,
            'data' => $this->getModelData($subscription)
        ]);
    }
}
