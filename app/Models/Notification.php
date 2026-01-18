<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'message',
        'type',
        'application_id',
        'is_read',
        'read_at',
    ];

    protected $casts = [
        'is_read' => 'boolean',
        'read_at' => 'datetime',
    ];

    /**
     * Relationship: Notification belongs to User
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'UserID');
    }

    /**
     * Relationship: Notification belongs to Application
     */
    public function application()
    {
        return $this->belongsTo(Application::class, 'application_id', 'ApplicationID');
    }

    /**
     * Mark notification as read
     */
    public function markAsRead()
    {
        $this->update([
            'is_read' => true,
            'read_at' => now(),
        ]);
    }

    /**
     * Get unread notifications count for a user
     */
    public static function unreadCount($userId)
    {
        return self::where('user_id', $userId)
                   ->where('is_read', false)
                   ->count();
    }

    /**
     * Get all unread notifications for a user
     */
    public static function getUnread($userId)
    {
        return self::where('user_id', $userId)
                   ->where('is_read', false)
                   ->orderBy('created_at', 'desc')
                   ->get();
    }

    /**
     * Get all notifications for a user (ordered by latest)
     */
    public static function getAllForUser($userId)
    {
        return self::where('user_id', $userId)
                   ->orderBy('created_at', 'desc')
                   ->paginate(20);
    }
}
