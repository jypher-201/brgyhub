<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Suggestions - BarangayHub</title>
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
            max-width: 1200px; 
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
        }
        
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
        }
        
        .table tbody td { 
            padding: 0.875rem 0.75rem; 
            border-color: var(--border-color); 
            vertical-align: middle; 
        }
        
        /* Added cursor pointer to indicate clickability */
        .table tbody tr {
            cursor: pointer;
            transition: background-color 0.2s ease;
        }

        .table tbody tr:hover { 
            background-color: #f1f5f9; 
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
        
        .status-reviewed {
            background-color: rgba(26, 79, 140, 0.1);
            color: var(--primary-blue);
        }
        
        .status-implemented {
            background-color: rgba(40, 167, 69, 0.1);
            color: #28a745;
        }
        
        .suggestion-content {
            /* Reduced max-width slightly to accommodate the new Title column */
            max-width: 300px; 
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        /* NEW: Style for the Title column to ensure prominence */
        .suggestion-title {
            font-weight: 600;
            color: var(--dark-text);
            /* Ensure title wraps if necessary, unlike the content snippet */
            white-space: normal;
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
            .suggestion-content {
                max-width: 150px; /* Adjust for smaller screens */
            }
        }
    </style>
</head>
<body>
    <div class="container mt-4">
        <div class="header-section">
            <h2 class="page-title">My Suggestions</h2>
            <div class="header-actions">
                <a href="{{ route('resident.dashboard') }}" class="btn btn-outline-primary">Back to Dashboard</a>
                <a href="{{ route('resident.suggestions.create') }}" class="btn btn-primary">New Suggestion</a>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success mb-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="table-container">
            <table class="table">
                <thead>
                    <tr>
                        {{-- ADDED: New Title Column Header --}}
                        <th>Title</th>
                        <th>Content Snippet</th>
                        <th>Status</th>
                        <th>Admin Response</th>
                        <th>Submitted At</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($suggestions as $suggestion)
                    <tr onclick="window.location='{{ route('resident.suggestions.show', $suggestion->id) }}'">
                        
                        {{-- ADDED: Title Column Data --}}
                        <td>
                            <div class="suggestion-title">
                                {{ $suggestion->title ?? 'N/A' }}
                            </div>
                        </td>
                        
                        {{-- Content Column (Renamed header, kept logic) --}}
                        <td>
                            <div class="suggestion-content" title="{{ $suggestion->content }}">
                                {{ \Illuminate\Support\Str::limit($suggestion->content, 50) }} 
                            </div>
                        </td>
                        <td>
                            <span class="status-badge 
                                @if($suggestion->status == 'Pending') status-pending
                                @elseif($suggestion->status == 'Reviewed' || $suggestion->status == 'Under Review') status-reviewed
                                @elseif($suggestion->status == 'Implemented') status-implemented
                                @else status-pending @endif">
                                {{ $suggestion->status ?? 'Pending' }}
                            </span>
                        </td>
                        <td>{{ $suggestion->admin_response ?? '-' }}</td>
                        <td>{{ $suggestion->created_at->format('M d, Y') }}</td>
                    </tr>
                    @empty
                    <tr style="cursor: default;">
                        <td colspan="5" class="empty-state">
                            No suggestions submitted yet
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($suggestions->count() > 0)
        <div class="mt-3">
            {{ $suggestions->links('pagination::bootstrap-5') }}
        </div>
        @endif
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <!-- SweetAlert2 for success messages -->
    @if(session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: '{{ session("success") }}',
            timer: 1800,
            showConfirmButton: false,
            width: '300px',
        });
    </script>
    @endif

    <!-- Tooltip initialization -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[title]'));
            var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        });
    </script>
</body>
</html>