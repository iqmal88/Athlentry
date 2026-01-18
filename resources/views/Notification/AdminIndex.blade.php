@extends('layouts.admin')

@section('title', 'Admin Notifications')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

<style>
    body {
        background-color: #F2F4F7;
        font-family: 'Inter', -apple-system, sans-serif;
        color: #1A1C1E;
    }

    .premium-header-rounded {
        background: #fff;
        border-radius: 24px;
        padding: 24px 40px;
        margin-bottom: 30px;
        border: 1px solid #E5E7EB;
        position: relative;
        overflow: hidden;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
    }

    .aura-glow {
        position: absolute;
        top: -100px;
        right: -30px;
        width: 350px;
        height: 350px;
        background: radial-gradient(circle, rgba(0, 128, 128, 0.05) 0%, rgba(255, 255, 255, 0) 70%);
        border-radius: 50%;
        z-index: 0;
    }

    .notification-card {
        background: #ffffff;
        border-radius: 16px;
        padding: 20px 24px;
        margin-bottom: 16px;
        border: 1px solid #E5E7EB;
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .notification-card:hover {
        border-color: #0D9488;
        box-shadow: 0 4px 12px rgba(13, 148, 136, 0.1);
    }

    .notification-card.unread {
        background: #F0FDFA;
        border-left: 4px solid #0D9488;
    }

    .notification-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
    }

    .notification-icon.application {
        background: #F0FDFA;
        color: #0D9488;
    }

    .notification-icon.selection {
        background: #FEF3C7;
        color: #F59E0B;
    }

    .notification-icon.new_application {
        background: #EDE9FE;
        color: #7C3AED;
    }

    .notification-title {
        font-weight: 700;
        font-size: 1rem;
        margin-bottom: 6px;
        color: #1A1C1E;
    }

    .notification-message {
        font-size: 0.875rem;
        color: #6B7280;
        line-height: 1.5;
        margin-bottom: 8px;
        white-space: pre-wrap;
    }

    .notification-time {
        font-size: 0.75rem;
        color: #9CA3AF;
        font-weight: 600;
    }

    .notification-actions {
        display: flex;
        gap: 8px;
        margin-top: 12px;
    }

    .btn-mark-read {
        padding: 6px 12px;
        font-size: 0.75rem;
        border-radius: 8px;
        border: none;
        background: #F3F4F6;
        color: #6B7280;
        cursor: pointer;
        transition: all 0.2s;
    }

    .btn-mark-read:hover {
        background: #E5E7EB;
        color: #1F2937;
    }

    .btn-delete {
        padding: 6px 12px;
        font-size: 0.75rem;
        border-radius: 8px;
        border: none;
        background: #FEE2E2;
        color: #DC2626;
        cursor: pointer;
        transition: all 0.2s;
    }

    .btn-delete:hover {
        background: #FECACA;
    }

    .empty-state {
        text-align: center;
        padding: 60px 30px;
    }

    .empty-icon {
        font-size: 64px;
        color: #D1D5DB;
        margin-bottom: 20px;
    }

    .empty-text {
        color: #9CA3AF;
        font-weight: 600;
    }

    .mark-all-read {
        text-align: right;
        margin-bottom: 20px;
    }

    .btn-mark-all {
        padding: 8px 16px;
        font-size: 0.85rem;
        border-radius: 12px;
        border: none;
        background: #0D9488;
        color: white;
        cursor: pointer;
        font-weight: 600;
        transition: all 0.2s;
    }

    .btn-mark-all:hover {
        background: #0F766E;
        transform: translateY(-2px);
    }
</style>

<div class="container pb-5">
    {{-- Header --}}
    <div class="premium-header-rounded">
        <div class="aura-glow"></div>
        <div class="row align-items-center position-relative">
            <div class="col-md-8">
                <h1 class="fw-bold mb-1" style="font-size:1.75rem;">
                    <i class="bi bi-bell me-2"></i>Admin Notifications
                </h1>
                <p class="text-muted small mb-0">Track new student applications and system updates</p>
            </div>
            <div class="col-md-4 text-md-end">
                @if($unreadCount > 0)
                    <span class="badge bg-danger me-2">{{ $unreadCount }} Unread</span>
                @endif
            </div>
        </div>
    </div>

    {{-- Mark All as Read Button --}}
    @if($unreadCount > 0)
        <div class="mark-all-read">
            <button class="btn-mark-all" onclick="markAllAsRead()">
                <i class="bi bi-check-all me-1"></i>Mark All as Read
            </button>
        </div>
    @endif

    {{-- Notifications List --}}
    @if($notifications->count() > 0)
        <div>
            @foreach($notifications as $notification)
                <div class="notification-card @if(!$notification->is_read) unread @endif" id="notification-{{ $notification->id }}">
                    <div class="d-flex gap-3">
                        {{-- Icon --}}
                        <div class="notification-icon {{ $notification->type === 'new_application' ? 'new_application' : ($notification->type === 'application_status' ? 'application' : 'selection') }}">
                            @if($notification->type === 'new_application')
                                <i class="bi bi-person-plus-fill"></i>
                            @elseif($notification->type === 'application_status')
                                <i class="bi bi-check2-circle"></i>
                            @else
                                <i class="bi bi-star-fill"></i>
                            @endif
                        </div>

                        {{-- Content --}}
                        <div class="flex-grow-1">
                            <div class="d-flex justify-content-between align-items-start">
                                <div class="flex-grow-1">
                                    <div class="notification-title">{{ $notification->title }}</div>
                                    <div class="notification-message">{{ $notification->message }}</div>
                                    <div class="notification-time">
                                        <i class="bi bi-clock me-1"></i>{{ $notification->created_at->diffForHumans() }}
                                    </div>
                                </div>
                                @if(!$notification->is_read)
                                    <span class="badge bg-teal" style="background-color: #0D9488 !important;">New</span>
                                @endif
                            </div>

                            {{-- Actions --}}
                            <div class="notification-actions">
                                @if(!$notification->is_read)
                                    <button class="btn-mark-read" onclick="markAsRead({{ $notification->id }})">
                                        <i class="bi bi-check me-1"></i>Mark as Read
                                    </button>
                                @endif
                                <button class="btn-delete" onclick="deleteNotification({{ $notification->id }})">
                                    <i class="bi bi-trash me-1"></i>Delete
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

            {{-- Pagination --}}
            <div class="mt-4">
                {{ $notifications->links('pagination::bootstrap-4') }}
            </div>
        </div>
    @else
        <div class="empty-state">
            <div class="empty-icon">🔔</div>
            <p class="empty-text">No notifications yet</p>
            <p class="text-muted small">You'll see notifications here when students submit new applications</p>
        </div>
    @endif
</div>

<script>
function markAsRead(notificationId) {
    fetch(`/admin/notifications/${notificationId}/mark-read`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content,
            'Content-Type': 'application/json',
        },
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const card = document.getElementById(`notification-${notificationId}`);
            card.classList.remove('unread');
            card.querySelector('.btn-mark-read').style.display = 'none';
            location.reload();
        }
    });
}

function markAllAsRead() {
    fetch('/admin/notifications/mark-all-read', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content,
            'Content-Type': 'application/json',
        },
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        }
    });
}

function deleteNotification(notificationId) {
    if (confirm('Are you sure you want to delete this notification?')) {
        fetch(`/admin/notifications/${notificationId}/delete`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content,
                'Content-Type': 'application/json',
            },
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById(`notification-${notificationId}`).remove();
                location.reload();
            }
        });
    }
}
</script>

@endsection
