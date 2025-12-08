<?php

namespace App\Observers;

use App\Models\Ebook;

class EbookObserver extends BaseObserver
{
    /**
     * Handle the Ebook "created" event.
     */
    public function created($ebook)
    {
        $this->logActivity('create', $this->getTableName($ebook), $ebook->id, [
            'ebook_title' => $ebook->title,
            'ebook_slug' => $ebook->slug,
            'is_published' => $ebook->is_published,
            'data' => $this->getModelData($ebook)
        ]);
    }

    /**
     * Handle the Ebook "updated" event.
     */
    public function updated($ebook)
    {
        $this->logActivity('update', $this->getTableName($ebook), $ebook->id, [
            'ebook_title' => $ebook->title,
            'ebook_slug' => $ebook->slug,
            'is_published' => $ebook->is_published,
            'changes' => $ebook->getChanges(),
            'data' => $this->getModelData($ebook)
        ]);
    }

    /**
     * Handle the Ebook "deleted" event.
     */
    public function deleted($ebook)
    {
        $this->logActivity('delete', $this->getTableName($ebook), $ebook->id, [
            'ebook_title' => $ebook->title,
            'ebook_slug' => $ebook->slug,
            'is_published' => $ebook->is_published,
            'soft_delete' => true,
            'data' => $this->getModelData($ebook)
        ]);
    }

    /**
     * Handle the Ebook "restored" event.
     */
    public function restored($ebook)
    {
        $this->logActivity('restore', $this->getTableName($ebook), $ebook->id, [
            'ebook_title' => $ebook->title,
            'ebook_slug' => $ebook->slug,
            'is_published' => $ebook->is_published,
            'data' => $this->getModelData($ebook)
        ]);
    }

    /**
     * Handle the Ebook "force deleted" event.
     */
    public function forceDeleted($ebook)
    {
        $this->logActivity('force_delete', $this->getTableName($ebook), $ebook->id, [
            'ebook_title' => $ebook->title,
            'ebook_slug' => $ebook->slug,
            'is_published' => $ebook->is_published,
            'force_delete' => true,
            'data' => $this->getModelData($ebook)
        ]);
    }
}