# Student Notification System - Complete Implementation

## Overview
A comprehensive notification system has been implemented to notify students when admin updates their application status or selection status. Students receive both in-app notifications and SMS alerts.

## Features

✅ **In-App Notifications**
- Notification bell in student header showing unread count
- Dedicated notifications page with full message details
- Mark as read / Mark all as read functionality
- Delete individual notifications

✅ **SMS Notifications**
- Automatic SMS sent to student's registered phone number
- SMS contains status update information

✅ **Triggered On:**
1. Application Status Change (Approved/Rejected)
2. Selection Status Change (Selected/Not Selected)

## What Was Added

### 1. Database Table: `notifications`
- Stores all student notifications
- Fields:
  - `user_id` - Student receiving notification
  - `title` - Notification title
  - `message` - Full notification message with event details
  - `type` - 'application_status' or 'selection_status'
  - `application_id` - Related application
  - `is_read` - Read status
  - `read_at` - Timestamp when marked as read

**Migration**: `2026_01_19_000001_create_notifications_table.php`

### 2. Models

#### Notification Model
**File**: `app/Models/Notification.php`

Methods:
- `markAsRead()` - Mark notification as read
- `unreadCount($userId)` - Get unread count for user
- `getUnread($userId)` - Get all unread notifications
- `getAllForUser($userId)` - Get paginated notifications for user

### 3. Service Layer

#### NotificationService
**File**: `app/Services/NotificationService.php`

Key Methods:
- `notifyApplicationStatusUpdate($application, $newStatus)` - Create notification when application status changes
- `notifySelectionStatusUpdate($application, $newStatus)` - Create notification when selection status changes
- `sendSMS($phoneNumber, $message)` - Send SMS to student

### 4. Controller

#### NotificationController
**File**: `app/Http/Controllers/NotificationController.php`

Routes:
- `GET /student/notifications` - View all notifications
- `GET /student/notifications/unread-count` - Get unread count (AJAX)
- `GET /student/notifications/recent` - Get recent unread (AJAX)
- `POST /student/notifications/{id}/mark-read` - Mark as read
- `POST /student/notifications/mark-all-read` - Mark all as read
- `POST /student/notifications/{id}/delete` - Delete notification

### 5. Views

#### Notification Index Page
**File**: `resources/views/Notification/Index.blade.php`

Features:
- Lists all notifications with icons and timestamps
- Unread notifications highlighted in green
- Mark as read / Delete buttons
- Empty state when no notifications
- Pagination support

### 6. Updated Files

#### ApplicationController
- Added `NotificationService::notifyApplicationStatusUpdate()` call in `selectApplicant()` method
- Added `NotificationService::notifySelectionStatusUpdate()` call in `updateSelection()` method

#### Student Layout (app.blade.php)
- Added notification bell icon in header
- Shows unread count badge
- Links to notifications page

#### Routes (web.php)
- Added 6 new notification routes
- All protected with student middleware

## How It Works

### Application Status Update Flow
```
Admin updates application status (Approve/Reject)
        ↓
selectApplicant() method in ApplicationController
        ↓
NotificationService::notifyApplicationStatusUpdate() called
        ↓
1. Notification created in database
2. SMS sent to student's phone number
3. Message shows:
   - "Your application for [Event] has been [Status]"
   - Reminder to read game information for date, place, coach details
        ↓
Student sees:
- Notification bell in header (with count)
- Full notification on notifications page
- Can mark as read or delete
```

### Selection Status Update Flow
```
Admin updates selection (Selected/Not Selected)
        ↓
updateSelection() method in ApplicationController
        ↓
NotificationService::notifySelectionStatusUpdate() called
        ↓
1. Notification created in database
2. SMS sent to student's phone number
3. Message shows:
   - "Your selection status for [Event] has been [Status]"
   - Reminder to read game information
        ↓
Student sees notification immediately
```

## Usage Examples

### For Students:
1. **View Notifications**: Click bell icon in header or go to `/student/notifications`
2. **Mark as Read**: Click "Mark as Read" button on unread notification
3. **Mark All as Read**: Use "Mark All as Read" button to bulk mark
4. **Delete**: Click "Delete" to remove notification
5. **Check Unread Count**: Badge on notification bell shows count

### For Admins:
1. **Update Application Status**: Go to Applications → View Applicants → Approve/Reject
   - Notification automatically sent to student
2. **Update Selection Status**: Go to Selection Panel → Select/Reject
   - Notification automatically sent to student

## SMS Integration

### Current Implementation
- SMS logging is implemented (checks logs)
- Ready for integration with SMS providers

### To Integrate Real SMS (Twilio Example):

1. **Install Twilio package**:
```bash
composer require twilio/sdk
```

2. **Add to config/services.php**:
```php
'twilio' => [
    'sid' => env('TWILIO_SID'),
    'token' => env('TWILIO_TOKEN'),
    'from' => env('TWILIO_FROM'),
],
```

3. **Update NotificationService.php**:
```php
public static function sendTwilioSMS($phoneNumber, $message)
{
    $twilio = new Client(config('services.twilio.sid'), config('services.twilio.token'));
    $twilio->messages->create($phoneNumber, [
        'from' => config('services.twilio.from'),
        'body' => $message
    ]);
}
```

## Database Schema

```sql
CREATE TABLE notifications (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    user_id BIGINT NOT NULL,
    title VARCHAR(255),
    message LONGTEXT,
    type VARCHAR(255), -- 'application_status' or 'selection_status'
    application_id BIGINT NULLABLE,
    is_read BOOLEAN DEFAULT 0,
    read_at TIMESTAMP NULLABLE,
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(UserID),
    FOREIGN KEY (application_id) REFERENCES applications(ApplicationID)
);
```

## Testing Checklist

- [ ] Run migration: `php artisan migrate`
- [ ] Test: Admin approves application → Student gets notification
- [ ] Test: Admin rejects application → Student gets notification
- [ ] Test: Admin selects student → Student gets notification
- [ ] Test: Admin rejects student → Student gets notification
- [ ] Test: Notification bell shows correct count
- [ ] Test: Mark notification as read
- [ ] Test: Mark all as read
- [ ] Test: Delete notification
- [ ] Test: SMS logged (check `storage/logs/laravel.log`)
- [ ] Verify notification message includes event name and reminder

## Notification Message Templates

### Application Status - Approved
```
Title: Application Status Updated
Message: Your application for [Event Name] has been Approved.

📋 Important: Please read the Game Information description to see selection date, venue, coach name and contact details.
```

### Application Status - Rejected
```
Title: Application Status Updated
Message: Your application for [Event Name] has been Rejected.

📋 Important: Please read the Game Information description to see selection date, venue, coach name and contact details.
```

### Selection Status - Selected
```
Title: Selection Status Updated
Message: Your selection status for [Event Name] has been updated to Selected.

📋 Important: Please read the Game Information description to see selection date, venue, coach name and contact details.
```

### Selection Status - Not Selected
```
Title: Selection Status Updated
Message: Your selection status for [Event Name] has been updated to Not Selected.

📋 Important: Please read the Game Information description to see selection date, venue, coach name and contact details.
```

## Files Modified/Created

### New Files:
- `database/migrations/2026_01_19_000001_create_notifications_table.php`
- `app/Models/Notification.php`
- `app/Services/NotificationService.php`
- `app/Http/Controllers/NotificationController.php`
- `resources/views/Notification/Index.blade.php`

### Modified Files:
- `app/Http/Controllers/ApplicationController.php`
- `resources/views/layouts/app.blade.php`
- `routes/web.php`

## Future Enhancements

1. **Email Notifications** - Send email notifications along with SMS
2. **Push Notifications** - Browser push notifications
3. **Notification Preferences** - Let students choose notification methods
4. **Auto-clear Old Notifications** - Archive old notifications after 30 days
5. **Notification History** - Keep analytics on notification delivery
6. **Custom Sound/Alert** - Different sounds for different notification types
