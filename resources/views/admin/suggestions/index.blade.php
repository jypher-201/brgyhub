<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Suggestions Management - BarangayHub</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        :root {
            --primary-blue: #1a4f8c;
            --secondary-blue: #2c6cb0;
        }

        body { 
            background-color: #f8f9fa; 
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif; 
            padding: 2rem 0;
        }

        .container { 
            max-width: 1200px; 
            margin: auto;
        }

        .header-section { 
            display: flex; 
            justify-content: space-between; 
            align-items: center; 
            margin-bottom: 1.5rem; 
            flex-wrap: wrap;
        }

        .page-title { 
            font-size: 1.8rem; 
            font-weight: 600; 
            color: #2c3e50; 
            margin: 0; 
        }

        /* Standard Button Styles */
        .btn-outline-primary { 
            border-color: var(--primary-blue); 
            color: var(--primary-blue); 
            border-radius: 6px; 
            font-weight: 500; 
            padding: 0.5rem 1rem; 
        }

        .btn-outline-primary:hover { 
            background-color: var(--primary-blue); 
            color: white; 
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

        /* Action Button Style (New/Modified) */
        .action-btn-outline {
            padding: 0.3rem 0.6rem; /* Make it smaller for the table */
            font-size: 0.85rem;
            text-decoration: none;
            border-color: var(--primary-blue);
            color: var(--primary-blue);
            border-radius: 6px;
            font-weight: 500;
            border: 1px solid;
            transition: background-color 0.2s, color 0.2s;
        }

        .action-btn-outline:hover {
            background-color: var(--primary-blue);
            color: white;
        }

        .table-container { 
            background-color: white; 
            border-radius: 8px; 
            box-shadow: 0 2px 8px rgba(0,0,0,0.1); 
            overflow-x: auto; 
        }

        .table thead th { 
            background-color: #f1f3f5; 
            font-weight: 600; 
            font-size: 0.85rem; 
            text-transform: uppercase; 
            border-bottom: 2px solid #e0e0e0;
        }

        .table tbody td { 
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

        .status-pending { background-color: rgba(249, 168, 37, 0.1); color: #f9a825; }
        .status-reviewed { background-color: rgba(26, 79, 140, 0.1); color: #1a4f8c; }
        .status-implemented { background-color: rgba(40, 167, 69, 0.1); color: #28a745; }

        .empty-state { 
            text-align: center; 
            padding: 2rem; 
            color: #6c757d; 
        }

        /* Removed .action-link, using action-btn-outline now */

        .suggestion-content { 
            max-width: 300px; 
            overflow: hidden; 
            text-overflow: ellipsis; 
            white-space: nowrap; 
        }

        @media (max-width: 768px) {
            .header-section { flex-direction: column; align-items: flex-start; gap: 1rem; }
            .suggestion-content { max-width: 200px; }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header-section">
            <h2 class="page-title">Resident Suggestions</h2>
            <div class="d-flex gap-2">
                <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-primary">Back to Dashboard</a>
                <a href="{{ route('admin.suggestions.index') }}" class="btn btn-primary">Refresh</a>
            </div>
        </div>

        <div class="table-container">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Suggestion Content</th>
                        <th>Status</th>
                        <th>Admin Response</th>
                        <th>Submitted At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($suggestions as $suggestion)
                    <tr>
                        <td>{{ $suggestion->id }}</td>
                        <td title="{{ $suggestion->content }}">
                            <div class="suggestion-content">{{ $suggestion->content }}</div>
                        </td>
                        <td>
                            <span class="status-badge 
                                @if($suggestion->status == 'Pending') status-pending
                                @elseif($suggestion->status == 'Under Review') status-reviewed
                                @elseif($suggestion->status == 'Implemented') status-implemented
                                @else status-pending @endif">
                                {{ $suggestion->status ?? 'Pending' }}
                            </span>
                        </td>
                        <td>
                            @if($suggestion->admin_response)
                                <div class="suggestion-content" title="{{ $suggestion->admin_response }}">
                                    {{ $suggestion->admin_response }}
                                </div>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>{{ $suggestion->created_at->format('M d, Y') }}</td>
                        <td>
                            {{-- Consolidated View/Update Button (linked to edit route/respond route) --}}
                            <a href="{{ route('admin.suggestions.edit', $suggestion->id) }}" class="action-btn-outline">
                                View/Update
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="empty-state">No suggestions found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if(isset($suggestions) && method_exists($suggestions, 'count') && $suggestions->count())
        <div class="mt-3">
            {{ $suggestions->links('pagination::bootstrap-5') }}
        </div>
        @endif
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Note: The action button does not have a 'title' attribute, so no hover info appears.
    </script>
</body>
</html>