<?php

namespace App\Observers;

use App\Models\ActionLog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

abstract class BaseObserver
{
    /**
     * Log activity
     */
    protected function logActivity($action, $table, $recordId, $additionalData = [])
    {
        if (Auth::check()) {
            ActionLog::create([
                'user_id' => Auth::id(),
                'action_type' => $action,
                'table_name' => $table,
                'record_id' => $recordId,
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
                'url' => request()->fullUrl(),
                'method' => request()->method(),
                'new_values' => !empty($additionalData) ? json_encode($additionalData) : null,
            ]);
        }
    }

    /**
     * Get model data for logging
     */
    protected function getModelData(Model $model, array $excludeFields = ['id', 'created_at', 'updated_at'])
    {
        $data = $model->toArray();

        // Remove excluded fields
        foreach ($excludeFields as $field) {
            unset($data[$field]);
        }

        return $data;
    }

    /**
     * Get table name from model
     */
    protected function getTableName(Model $model)
    {
        return $model->getTable();
    }
}
