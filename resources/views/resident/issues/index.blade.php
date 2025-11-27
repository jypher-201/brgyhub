<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Issue Reports</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body { background-color: #f8f9fa; font-family: 'Segoe UI', system-ui, -apple-system, sans-serif; }
        .container { max-width: 1200px; }
        .header-section { display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; flex-wrap: wrap; gap: 1rem; }
        .page-title { color: #2c3e50; font-weight: 600; margin: 0; }
        .btn-outline-primary { border-color: #3498db; color: #3498db; border-radius: 6px; font-weight: 500; padding: 0.5rem 1.25rem; transition: all 0.2s ease; }
        .btn-outline-primary:hover { background-color: #3498db; color: white; transform: translateY(-1px); }
        .btn-primary { background-color: #3498db; border: none; border-radius: 6px; font-weight: 500; padding: 0.5rem 1.25rem; transition: all 0.2s ease; }
        .btn-primary:hover { background-color: #2980b9; transform: translateY(-1px); }
        .table-container { background-color: white; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); overflow: hidden; }
        .table { margin-bottom: 0; font-size: 0.9rem; }
        .table thead th { background-color: #f8f9fa; border-bottom: 2px solid #e9ecef; color: #495057; font-weight: 600; padding: 1rem 0.75rem; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.5px; }
        .table tbody td { padding: 0.875rem 0.75rem; border-color: #f1f3f4; vertical-align: middle; color: #495057; }
        .table tbody tr:hover { background-color: #f8fafc; }
        .status-badge { font-size: 0.75rem; font-weight: 500; }
        .empty-state { padding: 2.5rem 1rem; color: #6c757d; }
        .pagination { margin-top: 1.5rem; }
        .page-link { color: #3498db; border-color: #e9ecef; padding: 0.5rem 0.75rem; }
        .page-item.active .page-link { background-color: #3498db; border-color: #3498db; }
        @media (max-width: 768px) {
            .header-section { flex-direction: column; align-items: flex-start; }
            .header-actions { width: 100%; display: flex; justify-content: space-between; }
            .table-container { overflow-x: auto; }
            .table { font-size: 0.8rem; }
        }
    </style>
</head>
<body>
    <div class="container mt-4">
        <div class="header-section">
            <h2 class="page-title">My Issue Reports</h2>
            <div class="header-actions">
                <a href="{{ route('dashboard') }}" class="btn btn-outline-primary">← Back to Dashboard</a>
                <a href="{{ route('resident.issues.create') }}" class="btn btn-primary">+ Create Another Report</a>
            </div>
        </div>

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
                            <span class="status-badge px-2 py-1 rounded" 
                                  style="background-color: 
                                    @if($report->status == 'Pending') rgba(255, 193, 7, 0.15); color: #856404;
                                    @elseif($report->status == 'In Progress') rgba(0, 123, 255, 0.15); color: #004085;
                                    @elseif($report->status == 'Resolved') rgba(40, 167, 69, 0.15); color: #155724;
                                    @else #f8f9fa; color: #495057;
                                    @endif">
                                {{ $report->status }}
                            </span>
                        </td>
                        <td>{{ $report->admin_remarks ?? '-' }}</td>
                        <td>{{ $report->created_at->format('M d, Y H:i') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted py-4">No reports submitted yet.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            {{ $reports->links('pagination::bootstrap-5') }}
        </div>
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
            width: '300px',  // make SweetAlert smaller
        });
    </script>
    @endif
</body>
</html>
