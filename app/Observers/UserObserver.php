<?php

namespace App\Observers;

use App\Models\ActionLog;
use Illuminate\Support\Facades\Auth;

class UserObserver
{
    /**
     * Handle the User "created" event.
     */
    public function created($user)
    {
        $this->logActivity('create', 'users', $user->id);
    }

    /**
     * Handle the User "updated" event.
     */
    public function updated($user)
    {
        $this->logActivity('update', 'users', $user->id);
    }

    /**
     * Handle the User "deleted" event.
     */
    public function deleted($user)
    {
        $this->logActivity('delete', 'users', $user->id);
    }

    /**
     * Log activity
     */
    private function logActivity($action, $table, $recordId)
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
                'created_at' => now()
            ]);
        }
    }
}