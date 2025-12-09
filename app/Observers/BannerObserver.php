<?php

namespace App\Observers;

use App\Models\Banner;

class BannerObserver extends BaseObserver
{
    /**
     * Handle the Banner "created" event.
     */
    public function created(Banner $banner): void
    {
        $this->logActivity('create', $this->getTableName($banner), $banner->id, [
            'banner_title' => $banner->title,
            'banner_type' => $banner->type,
            'is_active' => $banner->is_active,
            'data' => $this->getModelData($banner)
        ]);
    }

    /**
     * Handle the Banner "updated" event.
     */
    public function updated(Banner $banner): void
    {
        $this->logActivity('update', $this->getTableName($banner), $banner->id, [
            'banner_title' => $banner->title,
            'banner_type' => $banner->type,
            'is_active' => $banner->is_active,
            'changes' => $banner->getChanges(),
            'data' => $this->getModelData($banner)
        ]);
    }

    /**
     * Handle the Banner "deleted" event.
     */
    public function deleted(Banner $banner): void
    {
        $this->logActivity('delete', $this->getTableName($banner), $banner->id, [
            'banner_title' => $banner->title,
            'banner_type' => $banner->type,
            'is_active' => $banner->is_active,
            'soft_delete' => true,
            'data' => $this->getModelData($banner)
        ]);
    }

    /**
     * Handle the Banner "restored" event.
     */
    public function restored(Banner $banner): void
    {
        $this->logActivity('restore', $this->getTableName($banner), $banner->id, [
            'banner_title' => $banner->title,
            'banner_type' => $banner->type,
            'is_active' => $banner->is_active,
            'data' => $this->getModelData($banner)
        ]);
    }

    /**
     * Handle the Banner "force deleted" event.
     */
    public function forceDeleted(Banner $banner): void
    {
        $this->logActivity('force_delete', $this->getTableName($banner), $banner->id, [
            'banner_title' => $banner->title,
            'banner_type' => $banner->type,
            'is_active' => $banner->is_active,
            'force_delete' => true,
            'data' => $this->getModelData($banner)
        ]);
    }
}
