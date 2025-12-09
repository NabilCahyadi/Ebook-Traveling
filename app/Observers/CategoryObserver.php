<?php

namespace App\Observers;

use App\Models\Category;

class CategoryObserver extends BaseObserver
{
    /**
     * Handle the Category "created" event.
     */
    public function created(Category $category): void
    {
        $this->logActivity('create', $this->getTableName($category), $category->id, [
            'category_name' => $category->name,
            'category_slug' => $category->slug,
            'is_active' => $category->is_active,
            'data' => $this->getModelData($category)
        ]);
    }

    /**
     * Handle the Category "updated" event.
     */
    public function updated(Category $category): void
    {
        $this->logActivity('update', $this->getTableName($category), $category->id, [
            'category_name' => $category->name,
            'category_slug' => $category->slug,
            'is_active' => $category->is_active,
            'changes' => $category->getChanges(),
            'data' => $this->getModelData($category)
        ]);
    }

    /**
     * Handle the Category "deleted" event.
     */
    public function deleted(Category $category): void
    {
        $this->logActivity('delete', $this->getTableName($category), $category->id, [
            'category_name' => $category->name,
            'category_slug' => $category->slug,
            'is_active' => $category->is_active,
            'soft_delete' => true,
            'data' => $this->getModelData($category)
        ]);
    }

    /**
     * Handle the Category "restored" event.
     */
    public function restored(Category $category): void
    {
        $this->logActivity('restore', $this->getTableName($category), $category->id, [
            'category_name' => $category->name,
            'category_slug' => $category->slug,
            'is_active' => $category->is_active,
            'data' => $this->getModelData($category)
        ]);
    }

    /**
     * Handle the Category "force deleted" event.
     */
    public function forceDeleted(Category $category): void
    {
        $this->logActivity('force_delete', $this->getTableName($category), $category->id, [
            'category_name' => $category->name,
            'category_slug' => $category->slug,
            'is_active' => $category->is_active,
            'force_delete' => true,
            'data' => $this->getModelData($category)
        ]);
    }
}
