<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BrgyHub Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-blue: #1e40af;
            --light-blue: #3b82f6;
            --dark-blue: #1e3a8a;
            --golden-yellow: #f59e0b;
            --light-yellow: #fbbf24;
            --dark-gray: #4b5563;
            --light-gray: #f3f4f6;
            --white: #ffffff;
            --border-radius: 8px;
            --shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            --sidebar-width: 250px; /* Define sidebar width as a variable */
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-color: #f9fafb;
            color: var(--dark-gray);
            /* Removed display: flex; from body, as flex is now managed differently for fixed layout */
            min-height: 100vh;
            display: block; /* Ensure body takes full document height/width */
        }
        
        /* ---------------------------------------------------- */
        /* START: FIXED SIDEBAR STYLES */
        /* ---------------------------------------------------- */

        /* Sidebar Styles - FIXED POSITION */
        .sidebar {
            width: var(--sidebar-width);
            background: var(--primary-blue);
            color: var(--white);
            padding: 20px 0;
            transition: all 0.3s;
            box-shadow: var(--shadow);
            
            /* KEY STYLES FOR FIXING THE SIDEBAR */
            position: fixed;
            top: 0;
            left: 0;
            height: 100%; /* Make it take up the full viewport height */
            overflow-y: auto; /* Allow scrolling within the sidebar if navigation links are too long */
        }

        /* Main Content Styles - PUSHED TO THE RIGHT */
        .main-content {
            /* Pushes the content away from the fixed sidebar */
            margin-left: var(--sidebar-width);
            flex: 1;
            padding: 20px;
            overflow-y: auto;
            min-height: 100vh; /* Ensure content section is at least full height */
        }
        
        /* ---------------------------------------------------- */
        /* END: FIXED SIDEBAR STYLES */
        /* ---------------------------------------------------- */


        .logo {
            display: flex;
            align-items: center;
            padding: 0 20px 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            margin-bottom: 20px;
        }

        .logo i {
            color: var(--golden-yellow);
            font-size: 24px;
            margin-right: 10px;
        }

        .logo h1 {
            font-size: 20px;
            font-weight: 600;
        }

        .nav-links {
            list-style: none;
            padding: 0 15px;
        }

        .nav-links li {
            margin-bottom: 10px;
        }

        .nav-links a {
            display: flex;
            align-items: center;
            padding: 12px 15px;
            color: var(--white);
            text-decoration: none;
            border-radius: var(--border-radius);
            transition: all 0.3s;
        }

        .nav-links a:hover, .nav-links a.active {
            background: rgba(255, 255, 255, 0.1);
            color: var(--light-yellow);
        }

        .nav-links i {
            margin-right: 10px;
            font-size: 18px;
        }

        /* --- STYLES FOR NOTIFICATION BADGE --- */
        .nav-link-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-grow: 1;
        }

        .notification-badge {
            background-color: #ef4444; /* Red badge */
            color: var(--white);
            font-size: 10px;
            font-weight: 700;
            padding: 2px 6px;
            border-radius: 9999px;
            min-width: 20px;
            text-align: center;
            line-height: 1.2;
            margin-left: 10px;
        }
        /* -------------------------------------------------------- */

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            padding-bottom: 15px;
            border-bottom: 1px solid #e5e7eb;
        }

        .header h2 {
            color: var(--primary-blue);
            font-weight: 600;
        }

        /* Dashboard Stats */
        .stats-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: var(--white);
            border-radius: var(--border-radius);
            padding: 20px;
            box-shadow: var(--shadow);
            border-top: 4px solid var(--primary-blue);
        }

        .stat-card:nth-child(2) {
            border-top-color: var(--golden-yellow);
        }

        .stat-card:nth-child(3) {
            border-top-color: var(--light-blue);
        }

        .stat-card:nth-child(4) {
            border-top-color: #10b981;
        }

        .stat-card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }

        .stat-card-header h3 {
            font-size: 14px;
            font-weight: 500;
            color: var(--dark-gray);
        }

        .stat-card-header i {
            font-size: 20px;
            color: var(--primary-blue);
        }

        .stat-card-value {
            font-size: 28px;
            font-weight: 700;
            color: var(--primary-blue);
            margin-bottom: 5px;
        }

        .stat-card-desc {
            font-size: 12px;
            color: var(--dark-gray);
        }

        /* Tables */
        .table-container {
            background: var(--white);
            border-radius: var(--border-radius);
            box-shadow: var(--shadow);
            padding: 20px;
            margin-bottom: 30px;
        }

        .table-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .table-header h3 {
            color: var(--primary-blue);
            font-weight: 600;
        }

        .filter-options {
            display: flex;
            gap: 10px;
        }

        .filter-options select, .filter-options input {
            padding: 8px 12px;
            border: 1px solid #d1d5db;
            border-radius: var(--border-radius);
            font-size: 14px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #e5e7eb;
            vertical-align: top;
        }

        th {
            color: var(--primary-blue);
            font-weight: 600;
        }

        .status {
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
        }

        .status.pending {
            background: #fef3c7;
            color: #d97706;
        }

        .status.in-progress, .status.reviewed {
            background: #dbeafe;
            color: var(--primary-blue);
        }

        .status.resolved, .status.responded {
            background: #d1fae5;
            color: #065f46;
        }

        .action-btn {
            background: var(--primary-blue);
            color: white;
            border: none;
            padding: 6px 12px;
            border-radius: var(--border-radius);
            cursor: pointer;
            font-size: 12px;
            transition: background 0.3s;
            text-decoration: none;
            display: inline-block;
        }

        .action-btn:hover {
            background: var(--dark-blue);
            color: white;
        }

        .text-center {
            text-align: center;
            padding: 20px;
            color: var(--dark-gray);
        }

        /* Responsive */
        @media (max-width: 768px) {
            
            /* Remove fixed positioning on mobile */
            .sidebar {
                position: relative;
                width: 100%;
                height: auto;
                overflow-y: visible;
            }

            /* Remove margin-left when sidebar is not fixed */
            .main-content {
                margin-left: 0;
            }
            
            .stats-container {
                grid-template-columns: 1fr;
            }

            .filter-options {
                flex-direction: column;
            }
        }

        .sidebar form button {
            background: none;
            border: none;
            color: white;
            width: 100%;
            text-align: left;
            padding: 12px 15px;
            border-radius: 8px;
            cursor: pointer;
            display: flex;
            align-items: center;
        }

        .sidebar form button:hover {
            background: rgba(255, 255, 255, 0.1);
            color: var(--light-yellow);
        }

        .sidebar form button i {
            margin-right: 10px;
            font-size: 18px;
        }

    </style>
</head>
<body>
    <div class="sidebar">
        <div class="logo">
            <i class="fas fa-city"></i>
            <h1>BrgyHub Admin</h1>
        </div>
        <ul class="nav-links">
            <li><a href="{{ route('admin.dashboard') }}" class="active"><i class="fas fa-home"></i> Dashboard</a></li>
            <li>
                <a href="{{ route('admin.issues.index') }}">
                    <i class="fas fa-exclamation-circle"></i> 
                    <span class="nav-link-content">
                        Issue Reports
                        @if (isset($newReportsCount) && $newReportsCount > 0)
                            <span class="notification-badge">{{ $newReportsCount }}</span>
                        @endif
                    </span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.suggestions.index') }}">
                    <i class="fas fa-lightbulb"></i> 
                    <span class="nav-link-content">
                        Suggestions
                        @if (isset($newSuggestionsCount) && $newSuggestionsCount > 0)
                            <span class="notification-badge">{{ $newSuggestionsCount }}</span>
                        @endif
                    </span>
                </a>
            </li>
            <li><a href="{{ route('admin.users.index') }}"><i class="fas fa-users"></i> User Management</a></li>
            <li>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </button>
                </form>
            </li>
        </ul>
    </div>

    <div class="main-content">
        <div class="header">
            <h2>Dashboard Overview</h2>
        </div>

        <div class="stats-container">
            <div class="stat-card">
                <div class="stat-card-header">
                    <h3>Total Reports</h3>
                    <i class="fas fa-file-alt"></i>
                </div>
                <div class="stat-card-value">{{ $totalReportsCount ?? 0 }}</div> 
                <div class="stat-card-desc">+12 from last week</div>
            </div>
            <div class="stat-card">
                <div class="stat-card-header">
                    <h3>Pending Reports</h3>
                    <i class="fas fa-clock"></i>
                </div>
                <div class="stat-card-value">{{ $pendingReportsCount ?? 0 }}</div>
                <div class="stat-card-desc">Require attention</div>
            </div>
            <div class="stat-card">
                <div class="stat-card-header">
                    <h3>Resolved Issues</h3>
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="stat-card-value">{{ $resolvedReportsCount ?? 0 }}</div>
                <div class="stat-card-desc">+5 this week</div>
            </div>
            <div class="stat-card">
                <div class="stat-card-header">
                    <h3>User Suggestions</h3>
                    <i class="fas fa-lightbulb"></i>
                </div>
                <div class="stat-card-value">{{ $totalSuggestionsCount ?? 0 }}</div>
                <div class="stat-card-desc">New ideas for improvement</div>
            </div>
        </div>

        <div class="table-container">
            <div class="table-header">
                <h3>Recent Issue Reports</h3>
                <div class="filter-options">
                    <select id="reportCategoryFilter">
                        <option value="">All Categories</option>
                        <option value="streetlight">Streetlight</option>
                        <option value="flooding">Flooding</option>
                        <option value="vandalism">Vandalism</option>
                        <option value="others">Others</option>
                    </select>
                    <select id="reportStatusFilter">
                        <option value="">All Status</option>
                        <option value="pending">Pending</option>
                        <option value="in progress">In Progress</option>
                        <option value="resolved">Resolved</option>
                    </select>
                    <input type="text" placeholder="Search..." id="reportSearch">
                </div>
            </div>
            <table id="reportsTable">
                <thead>
                    <tr>
                        <th>Report ID</th>
                        <th>Title</th>
                        <th>Category</th>
                        <th>Submitted By</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($reports as $report)
                    <tr>
                        <td>#BR-{{ $report->id }}</td>
                        <td>{{ Str::limit($report->title, 50) }}</td>
                        <td>{{ $report->category }}</td>
                        <td>{{ $report->user->name ?? 'Resident' }}</td>
                        <td>{{ $report->created_at->format('M d, Y') }}</td>
                        <td>
                            <span class="status {{ strtolower(str_replace(' ', '-', $report->status)) }}">
                                {{ $report->status }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('admin.issues.edit', $report->id) }}" class="action-btn">
                                View/Update
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center">No issue reports found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="table-container">
            <div class="table-header">
                <h3>Recent Suggestions</h3>
                <div class="filter-options">
                    <select id="suggestionStatusFilter">
                        <option value="">All Status</option>
                        <option value="pending">Pending</option>
                        <option value="reviewed">Reviewed</option>
                        <option value="responded">Responded</option>
                    </select>
                    <input type="text" placeholder="Search suggestions..." id="suggestionSearch">
                </div>
            </div>
            <table id="suggestionsTable">
                <thead>
                    <tr>
                        <th>Suggestion ID</th>
                        <th>Title</th>
                        <th>Submitted By</th>
                        <th>Date</th>
                        <th>Response Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($suggestions as $suggestion)
                    <tr>
                        <td>#SG-{{ $suggestion->id }}</td>
                        <td>{{ Str::limit($suggestion->title ?? 'N/A', 50) }}</td>
                        <td>{{ $suggestion->user->name ?? 'Resident' }}</td> 
                        <td>{{ $suggestion->created_at->format('M d, Y') }}</td>
                        <td>
                            <span class="status {{ strtolower($suggestion->status ?? 'pending') }}">
                                {{ ucfirst($suggestion->status ?? 'Pending') }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('admin.suggestions.edit', $suggestion->id) }}" class="action-btn">
                                View/Update
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center">No suggestions submitted yet.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <script>
document.addEventListener("DOMContentLoaded", () => {

    // --- ISSUE REPORTS FILTER/SEARCH LOGIC ---

    const reportCategoryFilter = document.getElementById("reportCategoryFilter");
    const reportStatusFilter = document.getElementById("reportStatusFilter");
    const reportSearchInput = document.getElementById("reportSearch");
    const reportRows = document.querySelectorAll("#reportsTable tbody tr");

    function filterReports() {
        const category = reportCategoryFilter.value.toLowerCase();
        const status = reportStatusFilter.value.toLowerCase();
        const search = reportSearchInput.value.toLowerCase();

        reportRows.forEach(row => {
            // Check if this is the empty state row
            if (row.children.length === 1 && row.children[0].classList.contains('text-center')) {
                return; // Skip filtering the empty state row
            }

            const rowCategory = row.children[2].innerText.toLowerCase();
            const rowStatus = row.children[5].querySelector('.status').innerText.toLowerCase();

            let match = true;

            // Filter by category
            if (category && rowCategory !== category) {
                match = false;
            }

            // Filter by status
            if (status && rowStatus !== status) {
                match = false;
            }

            // Search filter
            if (search) {
                let rowText = '';
                for (let i = 0; i < row.children.length - 1; i++) {
                    rowText += row.children[i].innerText.toLowerCase() + ' ';
                }

                if (!rowText.includes(search)) {
                    match = false;
                }
            }

            row.style.display = match ? "" : "none";
        });
    }

    // Trigger filter on changes for Reports
    reportCategoryFilter.addEventListener("change", filterReports);
    reportStatusFilter.addEventListener("change", filterReports);
    reportSearchInput.addEventListener("keyup", filterReports);


    // --- SUGGESTIONS FILTER/SEARCH LOGIC ---

    const suggestionStatusFilter = document.getElementById("suggestionStatusFilter");
    const suggestionSearchInput = document.getElementById("suggestionSearch");
    const suggestionRows = document.querySelectorAll("#suggestionsTable tbody tr");

    function filterSuggestions() {
        const status = suggestionStatusFilter.value.toLowerCase();
        const search = suggestionSearchInput.value.toLowerCase();

        suggestionRows.forEach(row => {
            // Check if this is the empty state row
            if (row.children.length === 1 && row.children[0].classList.contains('text-center')) {
                return; // Skip filtering the empty state row
            }

            const rowStatus = row.children[4].querySelector('.status').innerText.toLowerCase();

            let match = true;

            // Filter by status
            if (status && rowStatus !== status) {
                match = false;
            }

            // Search filter
            if (search) {
                let rowText = '';
                // Adjusted loop bounds to match table structure (now 6 columns, index 0-5)
                for (let i = 0; i < row.children.length - 1; i++) {
                    rowText += row.children[i].innerText.toLowerCase() + ' ';
                }

                if (!rowText.includes(search)) {
                    match = false;
                }
            }

            row.style.display = match ? "" : "none";
        });
    }

    // Trigger filter on changes for Suggestions
    suggestionStatusFilter.addEventListener("change", filterSuggestions);
    suggestionSearchInput.addEventListener("keyup", filterSuggestions);
});
</script>

</body>
</html>