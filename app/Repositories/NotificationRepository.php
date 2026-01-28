<?php

namespace App\Repositories;

use App\Models\Notification;
use App\Models\UserNotification;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class NotificationRepository
{
    /**
     * Get user notifications
     */
    public function getUserNotifications(int $userId, int $perPage = 20): LengthAwarePaginator
    {
        return UserNotification::where('user_id', $userId)
            ->with('notification')
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
    }

    /**
     * Get user notifications for admin
     */
    public function getAdminNotifications(int $adminId, int $perPage = 20): LengthAwarePaginator
    {
        return UserNotification::where('admin_id', $adminId)
            ->with('notification')
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
    }

    /**
     * Get unread count
     */
    public function getUnreadCount(int $userId, bool $isAdmin = false): int
    {
        $query = UserNotification::where('is_read', false);

        if ($isAdmin) {
            return $query->where('admin_id', $userId)->count();
        }

        return $query->where('user_id', $userId)->count();
    }

    /**
     * Get recent notifications
     */
    public function getRecentNotifications(int $userId, bool $isAdmin = false, int $limit = 5): Collection
    {
        $query = UserNotification::with('notification')
            ->orderBy('created_at', 'desc')
            ->limit($limit);

        if ($isAdmin) {
            return $query->where('admin_id', $userId)->get();
        }

        return $query->where('user_id', $userId)->get();
    }

    /**
     * Find user notification by ID
     */
    public function findUserNotification(int $id): ?UserNotification
    {
        return UserNotification::with('notification')->find($id);
    }

    /**
     * Mark notification as read
     */
    public function markAsRead(UserNotification $notification): bool
    {
        return $notification->update(['is_read' => true]);
    }

    /**
     * Mark all notifications as read
     */
    public function markAllAsRead(int $userId, bool $isAdmin = false): int
    {
        $query = UserNotification::where('is_read', false);

        if ($isAdmin) {
            return $query->where('admin_id', $userId)->update(['is_read' => true]);
        }

        return $query->where('user_id', $userId)->update(['is_read' => true]);
    }

    /**
     * Delete notification
     */
    public function delete(UserNotification $notification): bool
    {
        return $notification->delete();
    }

    /**
     * Create notification
     */
    public function createNotification(array $data): Notification
    {
        return Notification::create($data);
    }

    /**
     * Create user notification
     */
    public function createUserNotification(array $data): UserNotification
    {
        return UserNotification::create($data);
    }

    /**
     * Send notification to multiple users
     */
    public function sendToMultipleUsers(int $notificationId, array $userIds): void
    {
        $records = array_map(function ($userId) use ($notificationId) {
            return [
                'notification_id' => $notificationId,
                'user_id' => $userId,
                'is_read' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }, $userIds);

        UserNotification::insert($records);
    }

    /**
     * Send notification to all admins
     */
    public function sendToAllAdmins(int $notificationId, array $adminIds): void
    {
        $records = array_map(function ($adminId) use ($notificationId) {
            return [
                'notification_id' => $notificationId,
                'admin_id' => $adminId,
                'is_read' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }, $adminIds);

        UserNotification::insert($records);
    }
}
