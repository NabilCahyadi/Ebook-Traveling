<?php

namespace App\Observers;

use App\Models\Blog;

class BlogObserver extends BaseObserver
{
    /**
     * Handle the Blog "created" event.
     */
    public function created(Blog $blog): void
    {
        $this->logActivity('create', $this->getTableName($blog), $blog->id, [
            'blog_title' => $blog->title,
            'blog_slug' => $blog->slug,
            'status' => $blog->status,
            'data' => $this->getModelData($blog)
        ]);
    }

    /**
     * Handle the Blog "updated" event.
     */
    public function updated(Blog $blog): void
    {
        $this->logActivity('update', $this->getTableName($blog), $blog->id, [
            'blog_title' => $blog->title,
            'blog_slug' => $blog->slug,
            'status' => $blog->status,
            'changes' => $blog->getChanges(),
            'data' => $this->getModelData($blog)
        ]);
    }

    /**
     * Handle the Blog "deleted" event.
     */
    public function deleted(Blog $blog): void
    {
        $this->logActivity('delete', $this->getTableName($blog), $blog->id, [
            'blog_title' => $blog->title,
            'blog_slug' => $blog->slug,
            'status' => $blog->status,
            'soft_delete' => true,
            'data' => $this->getModelData($blog)
        ]);
    }

    /**
     * Handle the Blog "restored" event.
     */
    public function restored(Blog $blog): void
    {
        $this->logActivity('restore', $this->getTableName($blog), $blog->id, [
            'blog_title' => $blog->title,
            'blog_slug' => $blog->slug,
            'status' => $blog->status,
            'data' => $this->getModelData($blog)
        ]);
    }

    /**
     * Handle the Blog "force deleted" event.
     */
    public function forceDeleted(Blog $blog): void
    {
        $this->logActivity('force_delete', $this->getTableName($blog), $blog->id, [
            'blog_title' => $blog->title,
            'blog_slug' => $blog->slug,
            'status' => $blog->status,
            'force_delete' => true,
            'data' => $this->getModelData($blog)
        ]);
    }
}
