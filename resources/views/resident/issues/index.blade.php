<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Issue Reports - BarangayHub</title>
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
        }
    </style>
</head>
<body>
    <div class="container mt-4">
        <div class="header-section">
            <h2 class="page-title">My Issue Reports</h2>
            <div class="header-actions">
                <a href="{{ route('dashboard') }}" class="btn btn-outline-primary">Back to Dashboard</a>
                <a href="{{ route('resident.issues.create') }}" class="btn btn-primary">Create New Report</a>
            </div>
        </div>

        <!-- Success alert banner -->
@if(session('success'))
    <div class="alert alert-success mb-4">
        {{ session('success') }}
    </div>
@endif


        <div class="table-container">
            <table class="table">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Category</th>
                        <th>Status</th>
                        <th>Admin Remarks</th>
                        <th>Submitted At</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($reports as $report)
                    <tr>
                        <td>{{ $report->title }}</td>
                        <td>{{ $report->category }}</td>
                        <td>
                            <span class="status-badge 
                                @if($report->status == 'Pending') status-pending
                                @elseif($report->status == 'In Progress') status-in-progress
                                @elseif($report->status == 'Resolved') status-resolved
                                @endif">
                                {{ $report->status }}
                            </span>
                        </td>
                        <td>{{ $report->admin_remarks ?? '-' }}</td>
                        <td>{{ $report->created_at->format('M d, Y H:i') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="empty-state">
                            No reports submitted yet
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($reports->count() > 0)
        <div class="mt-3">
            {{ $reports->links('pagination::bootstrap-5') }}
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
</body>
</html>