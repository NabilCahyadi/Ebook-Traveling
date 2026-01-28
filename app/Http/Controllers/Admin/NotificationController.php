<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    protected NotificationService $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    /**
     * Display a listing of notifications.
     */
    public function index()
    {
        $notifications = $this->notificationService->getAdminNotifications(Auth::guard('admin')->id(), 20);

        return view('admin.notifications.index', compact('notifications'));
    }

    /**
     * Get unread notifications count.
     */
    public function getUnreadCount()
    {
        $count = $this->notificationService->getAdminUnreadCount(Auth::guard('admin')->id());

        return response()->json(['count' => $count]);
    }

    /**
     * Get recent notifications for dropdown.
     */
    public function getRecent()
    {
        $adminId = Auth::guard('admin')->id();
        $notifications = $this->notificationService->getAdminRecentNotifications($adminId, 5);
        $unreadCount = $this->notificationService->getAdminUnreadCount($adminId);

        return response()->json([
            'notifications' => $notifications,
            'unread_count' => $unreadCount,
        ]);
    }

    /**
     * Mark a notification as read.
     */
    public function markAsRead($id)
    {
        $this->notificationService->markAsRead($id);

        return response()->json(['success' => true]);
    }

    /**
     * Mark all notifications as read.
     */
    public function markAllAsRead()
    {
        $this->notificationService->markAllAdminNotificationsAsRead(Auth::guard('admin')->id());

        return response()->json(['success' => true, 'message' => __('admin.notifications.all_marked_read')]);
    }

    /**
     * Delete a notification.
     */
    public function destroy($id)
    {
        $this->notificationService->deleteNotification($id);

        return response()->json(['success' => true, 'message' => __('admin.notifications.deleted')]);
    }
}
