<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Suggestion - BarangayHub</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --primary-blue: #1a4f8c;
            --secondary-blue: #2c6cb0;
            --light-blue: #e8f2fc;
            --golden-yellow: #f9a825;
            --dark-gold: #d18c00;
            --dark-text: #2c3e50;
            --light-text: #6c757d;
            --border-color: #e0e0e0;
            --success-green: #28a745;
        }

        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', system-ui, sans-serif;
            padding: 1.5rem 0;
            min-height: 100vh;
        }

        .container {
            max-width: 900px;
        }

        .section-title {
            font-weight: 600;
            color: var(--dark-text);
            border-left: 4px solid var(--primary-blue); 
            padding-left: .75rem;
            margin-bottom: 1rem;
            font-size: 1.25rem;
        }

        .card {
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.08);
            border: none;
        }

        .suggestion-card {
            border-top: 5px solid var(--golden-yellow) !important;
        }
        .suggestion-card .section-title {
            border-left-color: var(--golden-yellow);
        }

        .admin-card {
            border-top: 5px solid var(--primary-blue) !important;
        }
        .admin-card .section-title {
            border-left-color: var(--primary-blue);
        }

        .form-control:disabled, .form-select:disabled {
            background-color: #f1f3f5;
            border-color: #e0e0e0;
            color: var(--dark-text);
            opacity: 1;
            cursor: not-allowed;
        }

        .label-text {
            font-weight: 600;
            color: var(--dark-text);
            margin-bottom: 0.25rem;
            display: block;
        }

        .btn-primary {
            background-color: var(--primary-blue);
            border: none;
        }

        .btn-primary:hover {
            background-color: var(--secondary-blue);
        }
        
        .status-badge {
            font-weight: 700;
            padding: 0.4rem 0.8rem;
            border-radius: 5px;
            display: inline-block;
            white-space: nowrap;
        }

        .status-badge.pending { background-color: #fff8e1; color: var(--dark-gold); } 
        .status-badge.reviewed { background-color: var(--light-blue); color: var(--primary-blue); } 
        .status-badge.responded { background-color: rgba(40, 167, 69, 0.15); color: var(--success-green); }
    </style>
</head>

<body>
    <div class="container">

        <h2 class="mb-4 text-center fw-bold" style="color: var(--dark-text);">
            Edit Suggestion
        </h2>

        <div class="mb-3">
            <a href="{{ route('admin.suggestions.index') }}" class="btn btn-outline-primary">
                <i class="fas fa-arrow-left"></i> Back to List
            </a>
        </div>
        
        {{-- Display success message --}}
        @if(session('success'))
            <div class="alert alert-success mb-4">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            </div>
        @endif

        {{-- Display error message --}}
        @if(session('error'))
            <div class="alert alert-danger mb-4">
                <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
            </div>
        @endif

        {{-- SUGGESTION DETAILS --}}
        <div class="card p-4 mb-4 suggestion-card">
            <h5 class="section-title">Suggestion Details</h5>

            <div class="mb-3">
                <label class="label-text">Suggestion Content</label>
                <textarea class="form-control" rows="4" disabled>{{ $suggestion->content }}</textarea>
            </div>

            <div class="row">
                <div class="col-md-4 mb-3 mb-md-0">
                    <label class="label-text">Submitted By</label>
                    <input type="text" class="form-control" value="{{ $suggestion->user->name ?? 'Anonymous' }}" disabled>
                </div>

                <div class="col-md-4 mb-3 mb-md-0">
                    <label class="label-text">Submitted On</label>
                    <input type="text" class="form-control" value="{{ $suggestion->created_at->format('M d, Y h:i A') }}" disabled>
                </div>
                
                <div class="col-md-4">
                    <label class="label-text">Current Status</label>
                    <div>
                        @php
                            $statusClass = strtolower($suggestion->status ?? 'pending');
                            if ($statusClass === 'in-progress') $statusClass = 'reviewed';
                            if ($statusClass === 'resolved' || $statusClass === 'rejected') $statusClass = 'responded';
                            
                            $statusDisplay = ucwords(str_replace('-', ' ', $statusClass));
                        @endphp
                        <span class="status-badge {{ $statusClass }}">
                            {{ $statusDisplay }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        {{-- ADMIN ACTION --}}
        <div class="card p-4 admin-card">
            <h5 class="section-title">Admin Action</h5>

            <form action="{{ route('admin.suggestions.update', $suggestion->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row mb-3">
                    <div class="col-md-6 mb-3 mb-md-0">
                        <label class="label-text" for="status">Update Status</label>
                        <select class="form-select" id="status" name="status" required>
                            <option value="pending" {{ ($suggestion->status ?? 'pending') === 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="reviewed" {{ ($suggestion->status ?? '') === 'reviewed' ? 'selected' : '' }}>Reviewed</option>
                            <option value="responded" {{ ($suggestion->status ?? '') === 'responded' ? 'selected' : '' }}>Responded</option>
                        </select>
                        @error('status') 
                            <span class="text-danger small mt-1"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</span> 
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="label-text">Current Action Time</label>
                        <input type="text" class="form-control" value="{{ now()->format('M d, Y h:i A') }}" disabled>
                    </div>
                </div>
                
                <div class="mb-4">
                    <label class="label-text" for="admin_response">Admin Response (optional)</label>
                    <textarea 
                        class="form-control" 
                        id="admin_response" 
                        name="admin_response"
                        rows="4"
                        placeholder="Write your response... (optional)">{{ $suggestion->admin_response ?? '' }}</textarea>
                    @error('admin_response') 
                        <span class="text-danger small mt-1"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</span> 
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary px-4">
                    <i class="fas fa-save"></i> Save Changes
                </button>
            </form>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>