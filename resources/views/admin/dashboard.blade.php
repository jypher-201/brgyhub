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
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar Styles */
        .sidebar {
            width: 250px;
            background: var(--primary-blue);
            color: var(--white);
            padding: 20px 0;
            transition: all 0.3s;
            box-shadow: var(--shadow);
        }

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

        /* Main Content Styles */
        .main-content {
            flex: 1;
            padding: 20px;
            overflow-y: auto;
        }

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

        .user-info {
            display: flex;
            align-items: center;
        }

        .user-info img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin-right: 10px;
            background-color: var(--light-blue);
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

        .status.in-progress {
            background: #dbeafe;
            color: var(--primary-blue);
        }

        .status.resolved {
            background: #d1fae5;
            color: #065f46;
        }
        
        /* New Status for Suggestions */
        .status.reviewed {
             background: #ffe4e6; /* Light Red/Pink */
             color: #dc2626; /* Dark Red */
        }
        .status.responded {
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
        }

        .action-btn:hover {
            background: var(--dark-blue);
        }

        /* Responsive */
        @media (max-width: 768px) {
            body {
                flex-direction: column;
            }
            
            .sidebar {
                width: 100%;
                height: auto;
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
}

.sidebar form button:hover {
    background: rgba(255, 255, 255, 0.1);
    color: var(--light-yellow);
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
            <li><a href="#" class="active"><i class="fas fa-home"></i> Dashboard</a></li>
            <li><a href="#"><i class="fas fa-exclamation-circle"></i> Issue Reports</a></li>
            <li><a href="#"><i class="fas fa-lightbulb"></i> Suggestions</a></li>
            <li><a href="#"><i class="fas fa-users"></i> User Management</a></li>
            <li>
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="flex items-center w-full text-left p-3 rounded hover:bg-gray-700">
            <i class="fas fa-sign-out-alt mr-2"></i> Logout
        </button>
    </form>
</li>

        </ul>
    </div>

    <div class="main-content">
        <div class="header">
            <h2>Dashboard Overview</h2>
            <div class="user-info">
                <img src="#" alt="Admin Avatar">
                <span>Barangay Admin</span>
            </div>
        </div>

        <div class="stats-container">
            <div class="stat-card">
                <div class="stat-card-header">
                    <h3>Total Reports</h3>
                    <i class="fas fa-file-alt"></i>
                </div>
                <div class="stat-card-value">142</div>
                <div class="stat-card-desc">+12 from last week</div>
            </div>
            <div class="stat-card">
                <div class="stat-card-header">
                    <h3>Pending Reports</h3>
                    <i class="fas fa-clock"></i>
                </div>
                <div class="stat-card-value">24</div>
                <div class="stat-card-desc">Require attention</div>
            </div>
            <div class="stat-card">
                <div class="stat-card-header">
                    <h3>Resolved Issues</h3>
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="stat-card-value">98</div>
                <div class="stat-card-desc">+5 this week</div>
            </div>
            <div class="stat-card">
                <div class="stat-card-header">
                    <h3>User Suggestions</h3>
                    <i class="fas fa-lightbulb"></i>
                </div>
                <div class="stat-card-value">36</div>
                <div class="stat-card-desc">New ideas for improvement</div>
            </div>
        </div>

        <div class="table-container">
            <div class="table-header">
                <h3>Recent Issue Reports</h3>
                <div class="filter-options">
                    <select id="reportCategoryFilter">
                        <option value="">All Categories</option>
                        <option value="Streetlight">Streetlight</option>
                        <option value="Flooding">Flooding</option>
                        <option value="Vandalism">Vandalism</option>
                        <option value="Others">Others</option>
                    </select>
                    <select id="reportStatusFilter">
                        <option value="">All Status</option>
                        <option value="Pending">Pending</option>
                        <option value="In Progress">In Progress</option>
                        <option value="Resolved">Resolved</option>
                    </select>
                    <input type="text" placeholder="Search..." id="reportSearch">
                </div>
            </div>
            <table>
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
                    {{-- PHP/Blade Loop for Reports goes here --}}
@foreach ($reports as $report)
    <tr>
        <td>#BR-{{ $report->id }}</td>
        <td>{{ $report->title }}</td>
        <td>{{ $report->category }}</td>
        <td>{{ $report->user->name ?? 'Resident' }}</td>
        <td>{{ $report->created_at->format('M d, Y') }}</td>

        <td>
            <span class="status 
                {{ $report->status == 'Pending' ? 'pending' : '' }}
                {{ $report->status == 'In Progress' ? 'in-progress' : '' }}
                {{ $report->status == 'Resolved' ? 'resolved' : '' }}
            ">
                {{ $report->status }}
            </span>
        </td>

        <td>
            <button class="action-btn"
                onclick="openReport({{ $report->id }})">
                View
            </button>
        </td>
    </tr>
@endforeach

                </tbody>
            </table>
        </div>

        <div class="table-container">
            <div class="table-header">
                <h3>Recent Suggestions</h3>
                <div class="filter-options">
                    <select id="suggestionStatusFilter">
                        <option value="">All Status</option>
                        <option value="Pending">Pending</option>
                        <option value="Reviewed">Reviewed</option>
                        <option value="Responded">Responded</option>
                    </select>
                    <input type="text" placeholder="Search suggestions..." id="suggestionSearch">
                </div>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>Suggestion ID</th>
                        <th>Content</th>
                        <th>Submitted By</th>
                        <th>Date</th>
                        <th>Response Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>#SG-2023-021</td>
                        <td>Install more benches in the park</td>
                        <td>Ana Torres</td>
                        <td>Oct 11, 2023</td>
                        <td><span class="status pending">Pending</span></td>
                        <td><button class="action-btn">Respond</button></td>
                    </tr>
                    <tr>
                        <td>#SG-2023-020</td>
                        <td>Weekly community clean-up drive</td>
                        <td>Luis Mendoza</td>
                        <td>Oct 9, 2023</td>
                        <td><span class="status reviewed">Reviewed</span></td>
                        <td><button class="action-btn">Respond</button></td>
                    </tr>
                    <tr>
                        <td>#SG-2023-019</td>
                        <td>Extend barangay hall operating hours</td>
                        <td>Sofia Ramirez</td>
                        <td>Oct 6, 2023</td>
                        <td><span class="status responded">Responded</span></td>
                        <td><button class="action-btn">View</button></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <script>
document.addEventListener("DOMContentLoaded", () => {

    const categoryFilter = document.getElementById("reportCategoryFilter");
    const statusFilter = document.getElementById("reportStatusFilter");
    const searchInput = document.getElementById("reportSearch");
    const rows = document.querySelectorAll("tbody tr");

    function filterReports() {
        const category = categoryFilter.value.toLowerCase();
        const status = statusFilter.value.toLowerCase();
        const search = searchInput.value.toLowerCase();

        rows.forEach(row => {
            // Skip placeholder rows (which have static IDs)
            const isPlaceholder = row.querySelector("td")?.innerText.includes("#BR-2023");
            // If you want to keep filtering placeholders, remove this:
            // if (isPlaceholder) return;

            const rowCategory = row.children[2].innerText.toLowerCase();
            const rowUser = row.children[3].innerText.toLowerCase();
            const rowTitle = row.children[1].innerText.toLowerCase();
            const rowStatus = row.children[5].innerText.toLowerCase();

            let match = true;

            // Filter by category
            if (category && rowCategory !== category) {
                match = false;
            }

            // Filter by status
            if (status && rowStatus !== status) {
                match = false;
            }

            // Search filter (title, user, category)
            if (search &&
                !rowTitle.includes(search) &&
                !rowUser.includes(search) &&
                !rowCategory.includes(search)
            ) {
                match = false;
            }

            row.style.display = match ? "" : "none";
        });
    }

    // Trigger filter on changes
    categoryFilter.addEventListener("change", filterReports);
    statusFilter.addEventListener("change", filterReports);
    searchInput.addEventListener("keyup", filterReports);
});
</script>

</body>
</html>