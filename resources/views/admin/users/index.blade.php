<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management - BarangayHub</title>

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
            --success-green: #28a745;
            --danger-red: #dc3545;
        }

        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', system-ui, sans-serif;
            padding: 1.5rem 0;
            min-height: 100vh;
        }

        .container {
            max-width: 1200px;
        }

        .header-section {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .page-title {
            color: var(--dark-text);
            font-weight: 700;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .page-title i {
            color: var(--primary-blue);
            background: var(--light-blue);
            padding: 10px;
            border-radius: 50%;
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

        .btn-outline-secondary {
            border-color: #6c757d;
            color: #6c757d;
            border-radius: 6px;
        }

        .btn-outline-secondary:hover {
            background-color: #6c757d;
            color: white;
        }

        .card {
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.08);
            border: none;
            overflow: hidden;
        }

        .user-card {
            border-top: 5px solid var(--primary-blue) !important;
        }

        .table thead th {
            background-color: #f8f9fa;
            color: var(--dark-text);
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.85rem;
            border-bottom: 2px solid var(--border-color);
            padding: 1rem;
        }

        .table tbody td {
            vertical-align: middle;
            padding: 1rem;
            color: var(--dark-text);
        }

        .table-hover tbody tr:hover {
            background-color: #f1f5f9;
        }

        .role-badge {
            padding: 0.35em 0.65em;
            font-size: 0.75em;
            font-weight: 700;
            border-radius: 4px;
            text-transform: uppercase;
        }

        .role-admin {
            background-color: rgba(26, 79, 140, 0.15);
            color: var(--primary-blue);
            border: 1px solid rgba(26, 79, 140, 0.2);
        }

        .role-resident {
            background-color: rgba(40, 167, 69, 0.15);
            color: var(--success-green);
            border: 1px solid rgba(40, 167, 69, 0.2);
        }

        .action-btn-group {
            display: flex;
            gap: 5px;
        }

        .btn-sm-action {
            padding: 0.25rem 0.5rem;
            font-size: 0.875rem;
            border-radius: 4px;
            border: none;
            color: white;
        }

        .btn-edit { background-color: var(--golden-yellow); color: var(--dark-text); }
        .btn-edit:hover { background-color: #e0a800; }

        .btn-delete { background-color: var(--danger-red); }
        .btn-delete:hover { background-color: #c82333; }

        .modal-header {
            background-color: var(--primary-blue);
            color: white;
        }
        .modal-title { font-weight: 600; }
        .btn-close { filter: invert(1); }
    </style>
</head>
<body>

    <div class="container mt-4">
        
        <div class="header-section">
            <h2 class="page-title">
                <i class="fas fa-users-cog"></i>
                User Management
            </h2>
            <div class="d-flex gap-2">
                <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-primary">
                    <i class="fas fa-arrow-left me-1"></i>Back to Dashboard
                </a>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal">
                    <i class="fas fa-user-plus me-1"></i>Add New User
                </button>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card user-card">
            <div class="card-body p-0">
                
                <div class="p-3 border-bottom d-flex gap-2 bg-light">
                    <input type="text" id="searchInput" class="form-control" placeholder="Search by Username, Email..." style="max-width: 300px;">
                    <select id="roleFilter" class="form-select" style="max-width: 200px;">
                        <option value="">All Roles</option>
                        <option value="admin">Admin</option>
                        <option value="resident">Resident</option>
                    </select>
                    <button class="btn btn-outline-secondary" onclick="filterUsers()"><i class="fas fa-search"></i></button>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover mb-0" id="usersTable">
                        <thead>
                            <tr>
                                <th>User ID</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Contact Info</th>
                                <th>Registered</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($users as $user)
                            <tr>
                                <td>#{{ $user->id }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="rounded-circle bg-light d-flex justify-content-center align-items-center me-2" style="width: 35px; height: 35px; border: 1px solid #ddd;">
                                            <i class="fas fa-user text-secondary"></i>
                                        </div>
                                        <span class="fw-bold">{{ $user->name }}</span>
                                    </div>
                                </td>
                                <td>{{ $user->email ?? 'N/A' }}</td>
                                <td>
                                    <span class="role-badge {{ $user->role == 'admin' ? 'role-admin' : 'role-resident' }}">
                                        {{ ucfirst($user->role) }}
                                    </span>
                                </td>
                                <td>
                                    <div class="small">
                                        <i class="fas fa-phone text-muted me-1"></i> {{ $user->contact_number ?? 'N/A' }}
                                    </div>
                                </td>
                                <td>{{ $user->created_at->format('M d, Y') }}</td>
                                <td>
                                    <div class="action-btn-group">
                                        <button class="btn btn-sm-action btn-edit" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#editUserModal"
                                                onclick='populateEditModal(@json($user))'>
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        
                                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm-action btn-delete">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center py-4 text-muted">
                                    <i class="fas fa-users-slash fa-2x mb-2"></i><br>
                                    No users found.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                <div class="p-3 border-top">
                    @if(method_exists($users, 'links'))
                        {{ $users->links('pagination::bootstrap-5') }}
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="addUserModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-user-plus me-2"></i>Add New User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('admin.users.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Role <span class="text-danger">*</span></label>
                                <select name="role" class="form-select" required>
                                    <option value="resident" selected>Resident</option>
                                    <option value="admin">Admin (Official)</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Email <span class="text-danger">*</span></label>
                                <input type="email" name="email" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Password <span class="text-danger">*</span></label>
                                <input type="password" name="password" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Contact Number</label>
                                <input type="text" name="contact_number" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer bg-light">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Create User</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editUserModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-user-edit me-2"></i>Edit User Role</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editUserForm" action="" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <input type="hidden" id="edit_user_id" name="user_id">
                        
                        <div class="mb-3">
                            <label class="form-label fw-bold">Username</label>
                            <input type="text" id="edit_name" class="form-control" disabled>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Email</label>
                            <input type="email" id="edit_email" class="form-control" disabled>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Role <span class="text-danger">*</span></label>
                            <select id="edit_role" name="role" class="form-select" required>
                                <option value="resident">Resident</option>
                                <option value="admin">Admin (Official)</option>
                            </select>
                            <div class="form-text">Change the user's role to grant or remove admin privileges.</div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Contact Number</label>
                            <input type="text" id="edit_contact_number" class="form-control" disabled>
                        </div>
                    </div>
                    <div class="modal-footer bg-light">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Update Role</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Existing Edit Modal Logic
        function populateEditModal(user) {
            document.getElementById('edit_user_id').value = user.id;
            document.getElementById('edit_name').value = user.name;
            document.getElementById('edit_email').value = user.email || '';
            document.getElementById('edit_contact_number').value = user.contact_number || '';
            document.getElementById('edit_role').value = user.role;

            const form = document.getElementById('editUserForm');
            form.action = `/admin/users/${user.id}`;
        }

        // Existing Filter Logic
        function filterUsers() {
            const searchValue = document.getElementById('searchInput').value.toLowerCase();
            const roleValue = document.getElementById('roleFilter').value.toLowerCase();
            const table = document.getElementById('usersTable');
            const rows = table.getElementsByTagName('tbody')[0].getElementsByTagName('tr');

            for (let i = 0; i < rows.length; i++) {
                const row = rows[i];
                if (row.cells.length === 1) continue; // Skip empty state row

                const name = row.cells[1].textContent.toLowerCase();
                const username = row.cells[2].textContent.toLowerCase(); // Note: index 2 is email in table head, check indexing
                const role = row.cells[3].textContent.toLowerCase();
                const email = row.cells[2].textContent.toLowerCase(); // adjusted based on your table layout

                const matchesSearch = !searchValue || 
                    name.includes(searchValue) || 
                    email.includes(searchValue);

                const matchesRole = !roleValue || role.includes(roleValue);

                row.style.display = matchesSearch && matchesRole ? '' : 'none';
            }
        }

        document.getElementById('searchInput').addEventListener('keyup', filterUsers);
        document.getElementById('roleFilter').addEventListener('change', filterUsers);

        // --- NEW: SweetAlert2 Delete Confirmation ---
        document.addEventListener('DOMContentLoaded', function() {
            // Select all forms with the class 'delete-form'
            const deleteForms = document.querySelectorAll('.delete-form');

            deleteForms.forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault(); // Stop the form from submitting immediately

                    Swal.fire({
                        title: 'Delete User?',
                        text: "This cannot be undone!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#dc3545',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: 'Yes, delete',
                        cancelButtonText: 'Cancel',
                        width: '300px', // Sets the width to be smaller
                        padding: '1rem',
                        customClass: {
                            title: 'fs-5', // Bootstrap font-size class for title
                            content: 'fs-6' // Bootstrap font-size class for content
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // If user confirmed, submit the form programmatically
                            this.submit();
                        }
                    });
                });
            });
        });
    </script>
</body>
</html>