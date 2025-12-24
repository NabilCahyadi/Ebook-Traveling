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
            $isAdmin = $event->guard === 'admin' || $event->user instanceof \App\Models\Admin;
            
            ActionLog::create([
                'user_id' => $isAdmin ? null : $event->user->id,
                'admin_id' => $isAdmin ? $event->user->id : null,
                'user_type' => $isAdmin ? 'admin' : 'user',
                'action_type' => 'login',
                'table_name' => $isAdmin ? 'admins' : 'users',
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
            $isAdmin = $event->guard === 'admin' || $event->user instanceof \App\Models\Admin;
            
            ActionLog::create([
                'user_id' => $isAdmin ? null : $event->user->id,
                'admin_id' => $isAdmin ? $event->user->id : null,
                'user_type' => $isAdmin ? 'admin' : 'user',
                'action_type' => 'logout',
                'table_name' => $isAdmin ? 'admins' : 'users',
                'record_id' => $event->user->id,
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
                'url' => request()->fullUrl(),
                'method' => request()->method(),
            ]);
        }
    }
}
