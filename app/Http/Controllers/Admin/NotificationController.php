<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * Display a listing of notifications.
     */
    public function index()
    {
        $notifications = Auth::user()
            ->userNotifications()
            ->with('notification')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.notifications.index', compact('notifications'));
    }

    /**
     * Get unread notifications count.
     */
    public function getUnreadCount()
    {
        $count = Auth::user()
            ->userNotifications()
            ->where('is_read', false)
            ->count();

        return response()->json(['count' => $count]);
    }

    /**
     * Get recent notifications for dropdown.
     */
    public function getRecent()
    {
        $notifications = Auth::user()
            ->userNotifications()
            ->with('notification')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return response()->json([
            'notifications' => $notifications,
            'unread_count' => Auth::user()->userNotifications()->where('is_read', false)->count(),
        ]);
    }

    /**
     * Mark a notification as read.
     */
    public function markAsRead($id)
    {
        $userNotification = Auth::user()
            ->userNotifications()
            ->findOrFail($id);

        $userNotification->update(['is_read' => true]);

        return response()->json(['success' => true]);
    }

    /**
     * Mark all notifications as read.
     */
    public function markAllAsRead()
    {
        Auth::user()
            ->userNotifications()
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return response()->json(['success' => true, 'message' => __('admin.notifications.all_marked_read')]);
    }

    /**
     * Delete a notification.
     */
    public function destroy($id)
    {
        $userNotification = Auth::user()
            ->userNotifications()
            ->findOrFail($id);

        $userNotification->delete();

        return response()->json(['success' => true, 'message' => __('admin.notifications.deleted')]);
    }
}
