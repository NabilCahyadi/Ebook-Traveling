<?php

namespace App\Listeners;

use App\Models\ActionLog;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;

class AuthActivityListener
{
    /**
     * Handle user login events.
     */
    public function handleLogin(Login $event)
    {
        if ($event->user) {
            ActionLog::create([
                'user_id' => $event->user->id,
                'action_type' => 'login',
                'table_name' => 'users',
                'record_id' => $event->user->id,
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
                'url' => request()->fullUrl(),
                'method' => request()->method(),
            ]);
        }
    }

    /**
     * Handle user logout events.
     */
    public function handleLogout(Logout $event)
    {
        if ($event->user) {
            ActionLog::create([
                'user_id' => $event->user->id,
                'action_type' => 'logout',
                'table_name' => 'users',
                'record_id' => $event->user->id,
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
                'url' => request()->fullUrl(),
                'method' => request()->method(),
            ]);
        }
    }
}