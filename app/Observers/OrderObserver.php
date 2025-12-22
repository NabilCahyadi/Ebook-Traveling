<?php

namespace App\Observers;

use App\Models\Order;

class OrderObserver extends BaseObserver
{
    /**
     * Handle the Order "created" event.
     */
    public function created(Order $order)
    {
        $this->logActivity('create', $this->getTableName($order), $order->id, [
            'order_number' => $order->order_number,
            'total_amount' => $order->total_amount,
            'status' => $order->status,
            'payment_method' => $order->payment_method ?? 'N/A',
            'data' => $this->getModelData($order)
        ]);
    }

    /**
     * Handle the Order "updated" event.
     */
    public function updated(Order $order)
    {
        $changes = $order->getChanges();
        
        // Determine action type based on status change
        $actionType = 'update';
        if (isset($changes['status'])) {
            $actionType = match($changes['status']) {
                'cancelled' => 'cancel_order',
                'completed' => 'complete_order',
                'paid' => 'paid_order',
                default => 'update'
            };
        }
        
        $this->logActivity($actionType, $this->getTableName($order), $order->id, [
            'order_number' => $order->order_number,
            'total_amount' => $order->total_amount,
            'status' => $order->status,
            'changes' => $changes,
            'data' => $this->getModelData($order)
        ]);
    }

    /**
     * Handle the Order "deleted" event.
     */
    public function deleted(Order $order)
    {
        $this->logActivity('delete', $this->getTableName($order), $order->id, [
            'order_number' => $order->order_number,
            'total_amount' => $order->total_amount,
            'status' => $order->status,
            'data' => $this->getModelData($order)
        ]);
    }
}
