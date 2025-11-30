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
            --golden-yellow: #f9a825;
            --success-green: #28a745;
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

        .action-btn-outline {
            padding: 0.3rem 0.6rem;
            font-size: 0.85rem;
            text-decoration: none;
            border-color: var(--primary-blue);
            color: var(--primary-blue);
            border-radius: 6px;
            font-weight: 500;
            border: 1px solid;
            transition: background-color 0.2s, color 0.2s;
            display: inline-block;
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
            font-weight: 600; 
            padding: 0.35rem 0.65rem; 
            border-radius: 4px; 
            display: inline-block;
            text-transform: capitalize;
        }

        .status-pending { 
            background-color: #fff8e1; 
            color: #d18c00; 
        }
        
        .status-in-progress { 
            background-color: rgba(26, 79, 140, 0.1); 
            color: var(--primary-blue); 
        }
        
        .status-resolved { 
            background-color: rgba(40, 167, 69, 0.15); 
            color: var(--success-green); 
        }

        .empty-state { 
            text-align: center; 
            padding: 2rem; 
            color: #6c757d; 
        }

        .issue-title { 
            max-width: 300px; 
            overflow: hidden; 
            text-overflow: ellipsis; 
            white-space: nowrap; 
        }

        .alert {
            border-radius: 8px;
            border: none;
        }

        /* Styling for the new filter row */
        .filter-row {
            padding: 1rem 0;
            border-bottom: 1px solid #e9ecef;
            margin-bottom: 1.5rem;
        }

        @media (max-width: 768px) {
            .header-section { 
                flex-direction: column; 
                align-items: flex-start; 
                gap: 1rem; 
            }
            .issue-title { 
                max-width: 200px; 
            }
            .filter-row .d-flex {
                flex-direction: column;
                gap: 0.5rem;
            }
            .filter-row .d-flex > * {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header-section">
            <h2 class="page-title">Reported Maintenance Issues</h2>
            <div class="d-flex gap-2">
                <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-primary">
                    <i class="fas fa-arrow-left me-1"></i>Back to Dashboard
                </a>
                <!-- Removed Refresh button as filtering replaces it -->
            </div>
        </div>

        {{-- Success Message --}}
        @if(session('success'))
            <div class="alert alert-success mb-4">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            </div>
        @endif

        {{-- Error Message --}}
        @if(session('error'))
            <div class="alert alert-danger mb-4">
                <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
            </div>
        @endif
        
        <!-- Filter Form Section - Now submits instantly -->
        <div class="filter-row bg-white rounded p-3 mb-4 shadow-sm">
            <!-- Added ID for JavaScript submission -->
            <form id="filterForm" method="GET" action="{{ route('admin.issues.index') }}">
                <div class="d-flex flex-wrap align-items-center gap-3">
                    <div class="flex-grow-1">
                        <label for="search" class="form-label visually-hidden">Search</label>
                        <input type="text" name="search" id="search" class="form-control" placeholder="Search by title or location..." value="{{ request('search') }}">
                    </div>

                    <div class="flex-shrink-0">
                        <label for="category" class="form-label visually-hidden">Filter by Category</label>
                        <select name="category" id="category" class="form-select">
                            <option value="">All Categories</option>
                            <option value="Streetlight" {{ request('category') == 'Streetlight' ? 'selected' : '' }}>Streetlight</option>
                            <option value="Flooding" {{ request('category') == 'Flooding' ? 'selected' : '' }}>Flooding</option>
                            <option value="Vandalism" {{ request('category') == 'Vandalism' ? 'selected' : '' }}>Vandalism</option>
                            <option value="Garbage" {{ request('category') == 'Garbage' ? 'selected' : '' }}>Garbage Collection</option>
                            <option value="Others" {{ request('category') == 'Others' ? 'selected' : '' }}>Others</option>
                        </select>
                    </div>

                    <div class="flex-shrink-0">
                        <label for="status" class="form-label visually-hidden">Filter by Status</label>
                        <select name="status" id="status" class="form-select">
                            <option value="">All Status</option>
                            <option value="Pending" {{ request('status') == 'Pending' ? 'selected' : '' }}>Pending</option>
                            <option value="In Progress" {{ request('status') == 'In Progress' ? 'selected' : '' }}>In Progress</option>
                            <option value="Resolved" {{ request('status') == 'Resolved' ? 'selected' : '' }}>Resolved</option>
                        </select>
                    </div>
                    
                    <!-- Removed explicit Submit button -->

                    <!-- Clear Filters link only shown when a filter is applied -->
                    @if (request()->hasAny(['search', 'category', 'status']))
                        <a href="{{ route('admin.issues.index') }}" class="btn btn-outline-secondary flex-shrink-0">
                            <i class="fas fa-times me-1"></i> Clear Filters
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <div class="table-container">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Issue Title</th>
                        <th>Category</th>
                        <th>Location</th>
                        <th>Status</th>
                        <th>Reported On</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($issues as $issue)
                    <tr>
                        <td>{{ $issue->id }}</td>
                        <td title="{{ $issue->title }}">
                            <div class="issue-title">{{ $issue->title }}</div>
                        </td>
                        <td>{{ $issue->category }}</td>
                        <td>{{ $issue->location ?? 'Not specified' }}</td>
                        <td>
                            @php
                                $status = strtolower(str_replace(' ', '-', $issue->status ?? 'pending'));
                                $statusClass = 'status-' . $status;
                                $statusDisplay = $issue->status ?? 'Pending';
                            @endphp
                            <span class="status-badge {{ $statusClass }}">
                                {{ $statusDisplay }}
                            </span>
                        </td>
                        <td>{{ $issue->created_at->format('M d, Y h:i A') }}</td>
                        <td>
                            <a href="{{ route('admin.issues.edit', $issue->id) }}" class="action-btn-outline">
                                <i class="fas fa-edit me-1"></i>View/Update
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="empty-state">
                            <i class="fas fa-inbox fa-2x mb-2 text-muted"></i>
                            <p class="mb-0">No issue reports found matching your criteria.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if(isset($issues) && method_exists($issues, 'links'))
        <div class="mt-3">
            {{ $issues->appends(request()->except('page'))->links('pagination::bootstrap-5') }}
        </div>
        @endif
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.getElementById('filterForm');
            const searchInput = document.getElementById('search');
            const categorySelect = document.getElementById('category');
            const statusSelect = document.getElementById('status');
            let searchTimeout;

            // Function to submit the form
            const submitForm = () => {
                form.submit();
            };

            // Event listener for Category and Status (instant submission on change)
            categorySelect.addEventListener('change', submitForm);
            statusSelect.addEventListener('change', submitForm);

            // Event listener for Search Input (with debounce for better performance)
            searchInput.addEventListener('input', function() {
                // Clear the previous timeout
                clearTimeout(searchTimeout);

                // Set a new timeout (e.g., 300ms) before submitting
                searchTimeout = setTimeout(() => {
                    submitForm();
                }, 300); 
            });

            // Prevent the default Enter key submission to avoid duplicate requests 
            // if the user quickly types and hits Enter.
            form.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    clearTimeout(searchTimeout); // Ensure instant submission on Enter
                    submitForm();
                }
            });
        });
    </script>
</body>
</html>