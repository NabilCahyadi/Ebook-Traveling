<?php

namespace App\Observers;

use App\Models\User;

class UserObserver extends BaseObserver
{
    /**
     * Handle the User "created" event.
     */
    public function created($user)
    {
        $this->logActivity('create', $this->getTableName($user), $user->id, [
            'target_user_name' => $user->name,
            'target_user_email' => $user->email,
            'target_user_id' => $user->id,
            'data' => $this->getModelData($user, ['id', 'password', 'remember_token', 'email_verified_at', 'created_at', 'updated_at'])
        ]);
    }

    /**
     * Handle the User "updated" event.
     */
    public function updated($user)
    {
        $this->logActivity('update', $this->getTableName($user), $user->id, [
            'target_user_name' => $user->name,
            'target_user_email' => $user->email,
            'target_user_id' => $user->id,
            'changes' => $user->getChanges(),
            'data' => $this->getModelData($user, ['id', 'password', 'remember_token', 'email_verified_at', 'created_at', 'updated_at'])
        ]);
    }

    /**
     * Handle the User "deleted" event.
     */
    public function deleted($user)
    {
        $this->logActivity('delete', $this->getTableName($user), $user->id, [
            'target_user_name' => $user->name,
            'target_user_email' => $user->email,
            'target_user_id' => $user->id,
            'soft_delete' => true,
            'data' => $this->getModelData($user, ['id', 'password', 'remember_token', 'email_verified_at', 'created_at', 'updated_at'])
        ]);
    }

    /**
     * Handle the User "restored" event.
     */
    public function restored($user)
    {
        $this->logActivity('restore', $this->getTableName($user), $user->id, [
            'target_user_name' => $user->name,
            'target_user_email' => $user->email,
            'target_user_id' => $user->id,
            'data' => $this->getModelData($user, ['id', 'password', 'remember_token', 'email_verified_at', 'created_at', 'updated_at'])
        ]);
    }

    /**
     * Handle the User "force deleted" event.
     */
    public function forceDeleted($user)
    {
        $this->logActivity('force_delete', $this->getTableName($user), $user->id, [
            'target_user_name' => $user->name,
            'target_user_email' => $user->email,
            'target_user_id' => $user->id,
            'force_delete' => true,
            'data' => $this->getModelData($user, ['id', 'password', 'remember_token', 'email_verified_at', 'created_at', 'updated_at'])
        ]);
    }
}
