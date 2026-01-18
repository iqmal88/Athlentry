<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * Show all notifications for the student
     */
    public function index()
    {
        $userId = Auth::user()->UserID;
        $notifications = Notification::getAllForUser($userId);
        $unreadCount = NotificationService::getUnreadCount($userId);

        return view('Notification.Index', [
            'notifications' => $notifications,
            'unreadCount' => $unreadCount,
        ]);
    }

    /**
     * Show all notifications for the admin
     */
    public function adminIndex()
    {
        $userId = Auth::user()->UserID;
        $notifications = Notification::getAllForUser($userId);
        $unreadCount = NotificationService::getUnreadCount($userId);

        return view('Notification.AdminIndex', [
            'notifications' => $notifications,
            'unreadCount' => $unreadCount,
        ]);
    }

    /**
     * Get unread notifications count (for AJAX)
     */
    public function getUnreadCount()
    {
        $userId = Auth::user()->UserID;
        $count = NotificationService::getUnreadCount($userId);

        return response()->json(['count' => $count]);
    }

    /**
     * Mark single notification as read
     */
    public function markAsRead($notificationId)
    {
        $notification = Notification::find($notificationId);

        if (!$notification || $notification->user_id !== Auth::user()->UserID) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $notification->markAsRead();

        return response()->json(['message' => 'Marked as read', 'success' => true]);
    }

    /**
     * Mark all notifications as read
     */
    public function markAllAsRead()
    {
        $userId = Auth::user()->UserID;
        NotificationService::markAllAsRead($userId);

        return response()->json(['message' => 'All marked as read', 'success' => true]);
    }

    /**
     * Delete a notification
     */
    public function delete($notificationId)
    {
        $notification = Notification::find($notificationId);

        if (!$notification || $notification->user_id !== Auth::user()->UserID) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $notification->delete();

        return response()->json(['message' => 'Notification deleted', 'success' => true]);
    }

    /**
     * Get recent unread notifications (for sidebar/dropdown)
     */
    public function getRecent()
    {
        $userId = Auth::user()->UserID;
        $unread = Notification::getUnread($userId);

        return response()->json([
            'notifications' => $unread,
            'count' => $unread->count(),
        ]);
    }
}
