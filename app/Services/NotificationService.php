<?php

namespace App\Services;

use App\Models\Notification;
use App\Models\User;

class NotificationService
{
    /**
     * Create notification for student when application status is updated
     */
    public static function notifyApplicationStatusUpdate($application, $newStatus)
    {
        $student = $application->user;
        $eventName = $application->event->EventName ?? 'Unknown Event';

        $title = 'Application Status Updated';
        $message = "Your application for {$eventName} has been {$newStatus}.\n\n";
        $message .= "📋 Important: Please read the Game Information description to see selection date, venue, coach name and contact details.";

        // Create notification
        Notification::create([
            'user_id' => $student->UserID,
            'title' => $title,
            'message' => $message,
            'type' => 'application_status',
            'application_id' => $application->ApplicationID,
        ]);
    }

    /**
     * Create notification for student when selection status is updated
     */
    public static function notifySelectionStatusUpdate($application, $newStatus)
    {
        $student = $application->user;
        $eventName = $application->event->EventName ?? 'Unknown Event';

        $title = 'Selection Status Updated';
        $message = "Your selection status for {$eventName} has been updated to {$newStatus}.\n\n";
        $message .= "📋 Important: Please read the Game Information description to see selection date, venue, coach name and contact details.";

        // Create notification
        Notification::create([
            'user_id' => $student->UserID,
            'title' => $title,
            'message' => $message,
            'type' => 'selection_status',
            'application_id' => $application->ApplicationID,
        ]);
    }

    /**
     * Get unread count for user
     */
    public static function getUnreadCount($userId)
    {
        return Notification::unreadCount($userId);
    }

    /**
     * Mark notification as read
     */
    public static function markAsRead($notificationId)
    {
        $notification = Notification::find($notificationId);
        if ($notification) {
            $notification->markAsRead();
            return true;
        }
        return false;
    }

    /**
     * Mark all as read for user
     */
    public static function markAllAsRead($userId)
    {
        Notification::where('user_id', $userId)
                    ->where('is_read', false)
                    ->update([
                        'is_read' => true,
                        'read_at' => now(),
                    ]);
    }

    /**
     * Create notification for all admins when student applies for a game
     */
    public static function notifyAdminNewApplication($application)
    {
        $student = $application->user;
        $event = $application->event;
        $game = $application->game;

        $title = 'New Game Application';
        $message = "📋 New Application Received\n\n";
        $message .= "Student: {$student->Name}\n";
        $message .= "Event: {$event->EventName}\n";
        $message .= "Game: {$game->GameName}\n";
        $message .= "Category: {$game->Category}\n";
        $message .= "Applied on: " . $application->DateApplied->format('Y-m-d H:i:s');

        // Get all admins
        $admins = User::where('Role', 'admin')->get();

        // Create notification for each admin
        foreach ($admins as $admin) {
            Notification::create([
                'user_id' => $admin->UserID,
                'title' => $title,
                'message' => $message,
                'type' => 'new_application',
                'application_id' => $application->ApplicationID,
            ]);
        }
    }
}
