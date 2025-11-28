<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Issue Reports Management - BarangayHub</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        :root {
            --primary-blue: #1a4f8c;
            --secondary-blue: #2c6cb0;
            --light-blue: #e8f2fc;
            --golden-yellow: #f9a825;
            --dark-text: #2c3e50;
            --light-text: #6c757d;
            --border-color: #e0e0e0;
        }
        
        body { 
            background-color: #f8f9fa;
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif; 
            padding: 1rem 0;
        }
        
        .container { 
            max-width: 1400px; 
        }
        
        .header-section { 
            display: flex; 
            justify-content: space-between; 
            align-items: center; 
            margin-bottom: 1.5rem; 
        }
        
        .page-title { 
            color: var(--dark-text); 
            font-weight: 600; 
            margin: 0;
            font-size: 1.5rem;
        }
        
        /* Updated Button Styles to match theme */
        .btn-outline-primary, .action-btn-outline { 
            border-color: var(--primary-blue); 
            color: var(--primary-blue); 
            border-radius: 6px; 
            font-weight: 500; 
            padding: 0.5rem 1rem; 
        }
        
        .btn-outline-primary:hover, .action-btn-outline:hover { 
            background-color: var(--primary-blue); 
            color: white; 
        }
        
        .action-btn-outline {
            padding: 0.3rem 0.6rem; /* Make it smaller for the table */
            font-size: 0.85rem;
            text-decoration: none; /* Ensure link decoration is gone */
        }

        .btn-primary { 
            background-color: var(--primary-blue);
            border: none; 
            border-radius: 6px; 
            font-weight: 500; 
            padding: 0.5rem 1rem; 
        }
        
        .btn-primary:hover { 
            background-color: var(--secondary-blue);
        }
        
        .table-container { 
            background-color: white; 
            border-radius: 8px; 
            box-shadow: 0 1px 3px rgba(0,0,0,0.1); 
            overflow: hidden; 
        }
        
        .table { 
            margin-bottom: 0; 
            font-size: 0.9rem; 
        }
        
        .table thead th { 
            background-color: #f8f9fa;
            color: var(--dark-text); 
            font-weight: 600; 
            padding: 1rem 0.75rem; 
            border-bottom: 2px solid var(--border-color);
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .table tbody td { 
            padding: 0.875rem 0.75rem; 
            border-color: var(--border-color); 
            vertical-align: middle; 
        }
        
        .table tbody tr:hover { 
            background-color: #f8fafc; 
        }
        
        .status-badge { 
            font-size: 0.75rem; 
            font-weight: 500; 
            padding: 0.25rem 0.5rem;
            border-radius: 4px;
        }
        
        .status-pending {
            background-color: rgba(249, 168, 37, 0.1);
            color: var(--golden-yellow);
        }
        
        .status-in-progress {
            background-color: rgba(26, 79, 140, 0.1);
            color: var(--primary-blue);
        }
        
        .status-resolved {
            background-color: rgba(40, 167, 69, 0.1);
            color: #28a745;
        }
        
        .empty-state { 
            padding: 3rem 1rem; 
            color: var(--light-text);
            text-align: center;
        }
        
        .pagination { 
            margin-top: 1.5rem; 
        }
        
        .page-link { 
            color: var(--primary-blue); 
            border-color: var(--border-color); 
        }
        
        .page-item.active .page-link { 
            background-color: var(--primary-blue); 
            border-color: var(--primary-blue); 
        }
        
        .issue-title {
            max-width: 200px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
        
        @media (max-width: 768px) {
            .header-section { 
                flex-direction: column; 
                align-items: flex-start;
                gap: 1rem;
            }
            .header-actions { 
                width: 100%;
                display: flex;
                gap: 0.5rem;
            }
            .table-container { 
                overflow-x: auto; 
            }
            .issue-title {
                max-width: 150px;
            }
        }
    </style>
</head>
<body>
    <div class="container mt-4">
        <div class="header-section">
            <h2 class="page-title">Reported Maintenance Issues</h2>
            <div class="header-actions">
                <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-primary">Back to Dashboard</a>
                <a href="{{ route('admin.issues.index') }}" class="btn btn-primary">Refresh</a>
            </div>
        </div>

        <div class="table-container">
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Location</th>
                        <th>Issue Title</th>
                        <th>Category</th>
                        <th>Status</th>
                        <th>Reported On</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($issues as $issue)
                    <tr>
                        <td class="fw-medium">{{ $issue->id }}</td>
                        <td>{{ $issue->location ?? 'N/A' }}</td>
                        <td>
                            <div class="issue-title" title="{{ $issue->title }}">
                                {{ $issue->title }}
                            </div>
                        </td>
                        <td>{{ $issue->category }}</td>
                        <td>
                            <span class="status-badge 
                                @if($issue->status == 'Pending') status-pending
                                @elseif($issue->status == 'In Progress') status-in-progress
                                @elseif($issue->status == 'Resolved') status-resolved
                                @endif">
                                {{ $issue->status }}
                            </span>
                        </td>
                        <td>{{ $issue->created_at->format('M d, Y') }}</td>
                        <td>
                            {{-- Consolidated View/Update Button (linked to edit route) --}}
                            <a href="{{ route('admin.issues.edit', $issue->id) }}" class="btn action-btn-outline">
                                View/Update
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="empty-state">
                            No issue reports found
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if(isset($issues) && method_exists($issues, 'count') && $issues->count() > 0)
        <div class="mt-3">
            {{ $issues->links('pagination::bootstrap-5') }}
        </div>
        @endif
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Note: Tooltip initialization script is kept but won't trigger for the action link 
        // as the 'title' attribute was removed from the <a> tag.
        document.addEventListener('DOMContentLoaded', function() {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[title]'));
            var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                // Ensure tooltips are only initialized if the element has a title (e.g., the truncated issue title)
                if(tooltipTriggerEl.title) {
                    return new bootstrap.Tooltip(tooltipTriggerEl);
                }
            });
        });
    </script>
</body>
</html>