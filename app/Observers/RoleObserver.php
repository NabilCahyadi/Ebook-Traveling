<?php

namespace App\Observers;

use App\Models\Role;

class RoleObserver extends BaseObserver
{
    /**
     * Handle the Role "created" event.
     */
    public function created(Role $role): void
    {
        $this->logActivity('create', $this->getTableName($role), $role->id, [
            'role_name' => $role->name,
            'role_slug' => $role->slug,
            'role_description' => $role->description,
            'is_active' => $role->is_active,
            'data' => $this->getModelData($role)
        ]);
    }

    /**
     * Handle the Role "updated" event.
     */
    public function updated(Role $role): void
    {
        $this->logActivity('update', $this->getTableName($role), $role->id, [
            'role_name' => $role->name,
            'role_slug' => $role->slug,
            'role_description' => $role->description,
            'is_active' => $role->is_active,
            'changes' => $role->getChanges(),
            'data' => $this->getModelData($role)
        ]);
    }

    /**
     * Handle the Role "deleted" event.
     */
    public function deleted(Role $role): void
    {
        $this->logActivity('delete', $this->getTableName($role), $role->id, [
            'role_name' => $role->name,
            'role_slug' => $role->slug,
            'role_description' => $role->description,
            'is_active' => $role->is_active,
            'soft_delete' => true,
            'data' => $this->getModelData($role)
        ]);
    }

    /**
     * Handle the Role "restored" event.
     */
    public function restored(Role $role): void
    {
        $this->logActivity('restore', $this->getTableName($role), $role->id, [
            'role_name' => $role->name,
            'role_slug' => $role->slug,
            'role_description' => $role->description,
            'is_active' => $role->is_active,
            'data' => $this->getModelData($role)
        ]);
    }

    /**
     * Handle the Role "force deleted" event.
     */
    public function forceDeleted(Role $role): void
    {
        $this->logActivity('force_delete', $this->getTableName($role), $role->id, [
            'role_name' => $role->name,
            'role_slug' => $role->slug,
            'role_description' => $role->description,
            'is_active' => $role->is_active,
            'force_delete' => true,
            'data' => $this->getModelData($role)
        ]);
    }
}
