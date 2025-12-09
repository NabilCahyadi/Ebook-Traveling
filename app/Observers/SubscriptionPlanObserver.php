<?php

namespace App\Observers;

use App\Models\SubscriptionPlan;

class SubscriptionPlanObserver extends BaseObserver
{
    /**
     * Handle the SubscriptionPlan "created" event.
     */
    public function created(SubscriptionPlan $subscriptionPlan): void
    {
        $this->logActivity('create', $this->getTableName($subscriptionPlan), $subscriptionPlan->id, [
            'plan_name' => $subscriptionPlan->name,
            'plan_price' => $subscriptionPlan->price,
            'plan_duration' => $subscriptionPlan->duration_in_days,
            'is_active' => $subscriptionPlan->is_active,
            'data' => $this->getModelData($subscriptionPlan)
        ]);
    }

    /**
     * Handle the SubscriptionPlan "updated" event.
     */
    public function updated(SubscriptionPlan $subscriptionPlan): void
    {
        $this->logActivity('update', $this->getTableName($subscriptionPlan), $subscriptionPlan->id, [
            'plan_name' => $subscriptionPlan->name,
            'plan_price' => $subscriptionPlan->price,
            'plan_duration' => $subscriptionPlan->duration_in_days,
            'is_active' => $subscriptionPlan->is_active,
            'changes' => $subscriptionPlan->getChanges(),
            'data' => $this->getModelData($subscriptionPlan)
        ]);
    }

    /**
     * Handle the SubscriptionPlan "deleted" event.
     */
    public function deleted(SubscriptionPlan $subscriptionPlan): void
    {
        $this->logActivity('delete', $this->getTableName($subscriptionPlan), $subscriptionPlan->id, [
            'plan_name' => $subscriptionPlan->name,
            'plan_price' => $subscriptionPlan->price,
            'plan_duration' => $subscriptionPlan->duration_in_days,
            'is_active' => $subscriptionPlan->is_active,
            'soft_delete' => true,
            'data' => $this->getModelData($subscriptionPlan)
        ]);
    }

    /**
     * Handle the SubscriptionPlan "restored" event.
     */
    public function restored(SubscriptionPlan $subscriptionPlan): void
    {
        $this->logActivity('restore', $this->getTableName($subscriptionPlan), $subscriptionPlan->id, [
            'plan_name' => $subscriptionPlan->name,
            'plan_price' => $subscriptionPlan->price,
            'plan_duration' => $subscriptionPlan->duration_in_days,
            'is_active' => $subscriptionPlan->is_active,
            'data' => $this->getModelData($subscriptionPlan)
        ]);
    }

    /**
     * Handle the SubscriptionPlan "force deleted" event.
     */
    public function forceDeleted(SubscriptionPlan $subscriptionPlan): void
    {
        $this->logActivity('force_delete', $this->getTableName($subscriptionPlan), $subscriptionPlan->id, [
            'plan_name' => $subscriptionPlan->name,
            'plan_price' => $subscriptionPlan->price,
            'plan_duration' => $subscriptionPlan->duration_in_days,
            'is_active' => $subscriptionPlan->is_active,
            'force_delete' => true,
            'data' => $this->getModelData($subscriptionPlan)
        ]);
    }
}
