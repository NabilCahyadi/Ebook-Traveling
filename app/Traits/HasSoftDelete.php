<?php

namespace App\Traits;

use Illuminate\Http\Request;

trait HasSoftDelete
{
    /**
     * Get query with or without trashed records
     */
    protected function queryWithTrashed($query, $withTrashed = false)
    {
        if ($withTrashed) {
            return $query->withTrashed();
        }
        return $query;
    }

    /**
     * Add trashed filter to index method parameters
     */
    protected function addTrashedFilter($params = [])
    {
        return array_merge($params, ['withTrashed' => request('show_trashed', false)]);
    }

    /**
     * Get success message for delete action
     */
    protected function getDeleteMessage($permanent = false)
    {
        if ($permanent) {
            return 'Item permanently deleted successfully!';
        }
        return 'Item moved to trash successfully!';
    }

    /**
     * Get success message for restore action
     */
    protected function getRestoreMessage()
    {
        return 'Item restored successfully!';
    }

    /**
     * Handle soft delete
     */
    protected function performSoftDelete($model)
    {
        return $model->delete();
    }

    /**
     * Handle restore
     */
    protected function performRestore($model)
    {
        return $model->restore();
    }

    /**
     * Handle force delete
     */
    protected function performForceDelete($model)
    {
        return $model->forceDelete();
    }
}
