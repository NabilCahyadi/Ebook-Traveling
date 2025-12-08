<?php

namespace App\Observers;

use App\Models\ActionLog;
use Illuminate\Support\Facades\Auth;

class EbookObserver
{
    /**
     * Handle the Ebook "created" event.
     */
    public function created($ebook)
    {
        $this->logActivity('create', 'ebooks', $ebook->id);
    }

    /**
     * Handle the Ebook "updated" event.
     */
    public function updated($ebook)
    {
        $this->logActivity('update', 'ebooks', $ebook->id);
    }

    /**
     * Handle the Ebook "deleted" event.
     */
    public function deleted($ebook)
    {
        $this->logActivity('delete', 'ebooks', $ebook->id);
    }

    /**
     * Log activity
     */
    private function logActivity($action, $table, $recordId)
    {
        if (Auth::check()) {
            ActionLog::create([
                'user_id' => Auth::id(),
                'action_type' => $action,
                'table_name' => $table,
                'record_id' => $recordId,
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
                'url' => request()->fullUrl(),
                'method' => request()->method(),
                'created_at' => now()
            ]);
        }
    }
}