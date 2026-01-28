<?php

namespace App\Services;

use App\Repositories\NotificationRepository;
use App\Models\Notification;
use App\Models\UserNotification;
use App\Models\Admin;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class NotificationService
{
    protected NotificationRepository $repository;

    public function __construct(NotificationRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Get admin notifications
     */
    public function getAdminNotifications(int $adminId, int $perPage = 20): LengthAwarePaginator
    {
        return $this->repository->getAdminNotifications($adminId, $perPage);
    }

    /**
     * Get user notifications
     */
    public function getUserNotifications(int $userId, int $perPage = 20): LengthAwarePaginator
    {
        return $this->repository->getUserNotifications($userId, $perPage);
    }

    /**
     * Get unread count for admin
     */
    public function getAdminUnreadCount(int $adminId): int
    {
        return $this->repository->getUnreadCount($adminId, true);
    }

    /**
     * Get unread count for user
     */
    public function getUserUnreadCount(int $userId): int
    {
        return $this->repository->getUnreadCount($userId, false);
    }

    /**
     * Get recent notifications for admin
     */
    public function getAdminRecentNotifications(int $adminId, int $limit = 5): Collection
    {
        return $this->repository->getRecentNotifications($adminId, true, $limit);
    }

    /**
     * Get recent notifications for user
     */
    public function getUserRecentNotifications(int $userId, int $limit = 5): Collection
    {
        return $this->repository->getRecentNotifications($userId, false, $limit);
    }

    /**
     * Mark notification as read
     */
    public function markAsRead(int $notificationId): bool
    {
        $notification = $this->repository->findUserNotification($notificationId);
        
        if (!$notification) {
            return false;
        }

        return $this->repository->markAsRead($notification);
    }

    /**
     * Mark all admin notifications as read
     */
    public function markAllAdminNotificationsAsRead(int $adminId): int
    {
        return $this->repository->markAllAsRead($adminId, true);
    }

    /**
     * Mark all user notifications as read
     */
    public function markAllUserNotificationsAsRead(int $userId): int
    {
        return $this->repository->markAllAsRead($userId, false);
    }

    /**
     * Delete notification
     */
    public function deleteNotification(int $notificationId): bool
    {
        $notification = $this->repository->findUserNotification($notificationId);
        
        if (!$notification) {
            return false;
        }

        return $this->repository->delete($notification);
    }

    /**
     * Send notification to admin
     */
    public function sendToAdmin(int $adminId, string $title, string $message, ?string $type = 'info', ?string $actionUrl = null): UserNotification
    {
        $notification = $this->repository->createNotification([
            'title' => $title,
            'message' => $message,
            'type' => $type,
            'action_url' => $actionUrl,
        ]);

        return $this->repository->createUserNotification([
            'notification_id' => $notification->id,
            'admin_id' => $adminId,
            'is_read' => false,
        ]);
    }

    /**
     * Send notification to user
     */
    public function sendToUser(int $userId, string $title, string $message, ?string $type = 'info', ?string $actionUrl = null): UserNotification
    {
        $notification = $this->repository->createNotification([
            'title' => $title,
            'message' => $message,
            'type' => $type,
            'action_url' => $actionUrl,
        ]);

        return $this->repository->createUserNotification([
            'notification_id' => $notification->id,
            'user_id' => $userId,
            'is_read' => false,
        ]);
    }

    /**
     * Send notification to all admins
     */
    public function sendToAllAdmins(string $title, string $message, ?string $type = 'info', ?string $actionUrl = null): void
    {
        $notification = $this->repository->createNotification([
            'title' => $title,
            'message' => $message,
            'type' => $type,
            'action_url' => $actionUrl,
        ]);

        $adminIds = Admin::pluck('id')->toArray();
        $this->repository->sendToAllAdmins($notification->id, $adminIds);
    }

    /**
     * Send notification to multiple users
     */
    public function sendToMultipleUsers(array $userIds, string $title, string $message, ?string $type = 'info', ?string $actionUrl = null): void
    {
        $notification = $this->repository->createNotification([
            'title' => $title,
            'message' => $message,
            'type' => $type,
            'action_url' => $actionUrl,
        ]);

        $this->repository->sendToMultipleUsers($notification->id, $userIds);
    }

    /**
     * Get notification types
     */
    public function getNotificationTypes(): array
    {
        return [
            'info' => 'Information',
            'success' => 'Success',
            'warning' => 'Warning',
            'error' => 'Error',
        ];
    }
}
