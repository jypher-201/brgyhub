<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Notifications - BarangayHub</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --primary-blue: #1a4f8c;
            --secondary-blue: #2c6cb0;
            --dark-text: #2c3e50;
            --light-text: #6c757d;
            --border-color: #e0e0e0;
            --success-green: #28a745;
            --warning-amber: #ffc107;
            --info-blue: #0dcaf0;
        }

        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif; 
            padding: 1.5rem 0;
        }

        .container {
            max-width: 900px;
        }

        .header-section {
            border-bottom: 2px solid var(--border-color);
            padding-bottom: 1rem;
            margin-bottom: 1.5rem;
        }

        .notification-item {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.08);
            margin-bottom: 0.75rem;
            transition: all 0.2s ease-in-out;
            cursor: pointer;
        }

        .notification-item:hover {
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            transform: translateY(-2px);
        }

        .unread {
            border-left: 5px solid var(--primary-blue);
            background-color: #f0f7ff; /* Light blue background for unread */
        }
        
        .read {
            border-left: 5px solid var(--border-color);
        }

        .icon-box {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .icon-box.status-resolved { background-color: rgba(40, 167, 69, 0.1); color: var(--success-green); }
        .icon-box.status-progress { background-color: rgba(26, 79, 140, 0.1); color: var(--primary-blue); }
        .icon-box.status-new { background-color: rgba(255, 193, 7, 0.1); color: var(--warning-amber); }
        .icon-box.status-suggestion { background-color: rgba(13, 202, 240, 0.1); color: var(--info-blue); }

        .notification-message {
            color: var(--dark-text);
            font-size: 1rem;
            line-height: 1.4;
        }

        .notification-title {
            font-weight: 600;
        }

        .timestamp {
            font-size: 0.8rem;
            color: var(--light-text);
        }

        .btn-mark-all {
            background-color: var(--primary-blue);
            border: none;
            color: white;
        }
        .btn-mark-all:hover {
            background-color: var(--secondary-blue);
            color: white;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header-section d-flex justify-content-between align-items-center">
            <h2 class="page-title">
                <i class="fas fa-bell me-2" style="color: var(--primary-blue);"></i>My Notifications
            </h2>
            <div class="d-flex gap-2">
                <a href="{{ route('resident.dashboard') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left"></i> Back to Dashboard
                </a>
                
                @if($notifications->where('status', 'Unread')->count() > 0)
                <form action="{{ route('resident.notifications.readAll') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-mark-all">
                        <i class="fas fa-check-double me-1"></i> Mark All as Read
                    </button>
                </form>
                @endif
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success mt-3 mb-4">
                {{ session('success') }}
            </div>
        @endif
        
        @forelse($notifications as $notification)
            @php
                // Determine icon and colors based on notification content/status
                $icon = 'fas fa-info-circle';
                $iconClass = 'status-new';
                $targetRoute = '#'; // Default
                $targetId = $notification->report_id ?? $notification->suggestion_id ?? null;
                
                if ($notification->report_id) {
                    $targetRoute = 'resident.issues.show';
                    if (str_contains($notification->message, 'resolved')) {
                        $icon = 'fas fa-check-circle';
                        $iconClass = 'status-resolved';
                    } elseif (str_contains($notification->message, 'progress')) {
                        $icon = 'fas fa-spinner';
                        $iconClass = 'status-progress';
                    } else {
                        $icon = 'fas fa-file-alt';
                    }
                } elseif ($notification->suggestion_id) {
                    $targetRoute = 'resident.suggestions.show';
                    $icon = 'fas fa-lightbulb';
                    $iconClass = 'status-suggestion';
                }
            @endphp
            
            <form action="{{ route('resident.notifications.read', $notification->id) }}" method="POST" class="notification-item {{ $notification->status == 'Unread' ? 'unread' : 'read' }}"
                  onsubmit="event.preventDefault(); this.submit();"
                  onclick="window.location='{{ $targetId ? route($targetRoute, $targetId) : '#' }}';">
                @csrf
                <input type="hidden" name="_method" value="POST">

                <div class="d-flex p-3 align-items-center">
                    <div class="icon-box {{ $iconClass }} me-3">
                        <i class="{{ $icon }}"></i>
                    </div>

                    <div class="flex-grow-1">
                        <p class="mb-1 notification-message">
                            <span class="notification-title">{{ $notification->title }}</span>: {{ $notification->message }}
                        </p>
                        <span class="timestamp">{{ $notification->created_at->diffForHumans() }}</span>
                    </div>

                    @if($notification->status == 'Unread')
                        <button type="submit" class="btn btn-sm btn-outline-secondary ms-3" title="Mark as Read">
                            <i class="fas fa-check"></i>
                        </button>
                    @endif
                </div>
            </form>
        @empty
            <div class="alert alert-info text-center mt-4">
                <i class="fas fa-inbox me-2"></i>You have no notifications.
            </div>
        @endforelse

        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-4">
            {{ $notifications->links('pagination::bootstrap-5') }}
        </div>
        
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>