<?php

namespace App\Observers;

use App\Models\BlogCategory;

class BlogCategoryObserver extends BaseObserver
{
    /**
     * Handle the BlogCategory "created" event.
     */
    public function created(BlogCategory $blogCategory): void
    {
        $this->logActivity(
            'create',
            $this->getTableName($blogCategory),
            $blogCategory->id,
            $this->getModelData($blogCategory)
        );
    }

    /**
     * Handle the BlogCategory "updated" event.
     */
    public function updated(BlogCategory $blogCategory): void
    {
        $this->logActivity(
            'update',
            $this->getTableName($blogCategory),
            $blogCategory->id,
            $this->getModelData($blogCategory)
        );
    }

    /**
     * Handle the BlogCategory "deleted" event.
     */
    public function deleted(BlogCategory $blogCategory): void
    {
        $this->logActivity(
            'delete',
            $this->getTableName($blogCategory),
            $blogCategory->id,
            ['name' => $blogCategory->name, 'soft_deleted' => true]
        );
    }

    /**
     * Handle the BlogCategory "restored" event.
     */
    public function restored(BlogCategory $blogCategory): void
    {
        $this->logActivity(
            'restore',
            $this->getTableName($blogCategory),
            $blogCategory->id,
            ['name' => $blogCategory->name]
        );
    }

    /**
     * Handle the BlogCategory "force deleted" event.
     */
    public function forceDeleted(BlogCategory $blogCategory): void
    {
        $this->logActivity(
            'force_delete',
            $this->getTableName($blogCategory),
            $blogCategory->id,
            ['name' => $blogCategory->name, 'permanently_deleted' => true]
        );
    }
}
