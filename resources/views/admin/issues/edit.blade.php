<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Issue Report - BarangayHub</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

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
            font-family: 'Segoe UI', system-ui, sans-serif;
            padding: 1.5rem 0;
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

        /* Golden Yellow Border for Issue Details Panel */
        .issue-card {
            border-top: 5px solid var(--golden-yellow) !important;
        }
        .issue-card .section-title {
            border-left-color: var(--golden-yellow);
        }

        /* Primary Blue Border for Admin Action Panel */
        .admin-card {
            border-top: 5px solid var(--primary-blue) !important;
        }
        .admin-card .section-title {
            border-left-color: var(--primary-blue);
        }

        /* Styling for the disabled read-only fields */
        .form-control:disabled, .form-select:disabled {
            background-color: #f1f3f5;
            border-color: #e0e0e0;
            color: var(--dark-text);
            opacity: 1;
        }
        
        .form-control, .form-select {
            border-radius: 6px;
            border-color: #ced4da;
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

        .image-preview-container {
            border: 1px solid #ddd;
            border-radius: 6px;
            padding: 5px;
            display: inline-block;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        }
        
        .image-preview {
            max-width: 300px;
            max-height: 300px;
            width: auto;
            height: auto;
            border-radius: 4px;
            display: block;
        }
        
        @media (max-width: 768px) {
            .image-preview {
                max-width: 100%;
                height: auto;
            }
        }
    </style>
</head>

<body>
    <div class="container">

        <h2 class="mb-4 text-center fw-bold" style="color: var(--dark-text);">
            Edit Issue Report
        </h2>

        <div class="mb-3">
            <a href="{{ route('admin.issues.index') }}" class="btn btn-outline-primary">
                <i class="fas fa-arrow-left"></i> Back to List
            </a>
        </div>

        {{-- ISSUE DETAILS (INFO CARD) --}}
        <div class="card p-4 mb-4 issue-card"> 
            <h5 class="section-title">Issue Details</h5>

            <div class="row mb-3">
                <div class="col-md-6 mb-3 mb-md-0">
                    <label class="label-text">Issue Title</label>
                    <input type="text" class="form-control" value="{{ $issue->title }}" disabled>
                </div>
                <div class="col-md-6">
                    <label class="label-text">Category</label>
                    <input type="text" class="form-control" value="{{ $issue->category }}" disabled>
                </div>
            </div>

            <div class="mb-3">
                <label class="label-text">Description</label>
                <textarea class="form-control" rows="4" disabled>{{ $issue->description }}</textarea>
            </div>

            <div class="row mb-3">
                <div class="col-md-6 mb-3 mb-md-0">
                    <label class="label-text">Location</label>
                    <input type="text" class="form-control" value="{{ $issue->location ?? 'Not specified' }}" disabled>
                </div>
                <div class="col-md-6">
                    <label class="label-text">Reported By</label>
                    <input type="text" class="form-control" value="{{ $issue->user->name ?? 'Anonymous' }}" disabled>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6">
                    <label class="label-text">Reported On</label>
                    <input type="text" class="form-control" value="{{ $issue->created_at->format('M d, Y h:i A') }}" disabled>
                </div>
            </div>
            
            {{-- PHOTO SHOW (Displays ALL Photos from JSON Column) --}}
            @if(!empty($issue->photos) && count($issue->photos) > 0)
            <hr class="my-4">
            <div class="mb-3">
                <h6 class="label-text">Attached Image(s) (Proof of Issue)</h6>
                
                <div class="d-flex flex-wrap gap-3">
                    @foreach($issue->photos as $path)
                    <div class="image-preview-container">
                        <a href="{{ asset('storage/' . $path) }}" target="_blank" title="View Full Image">
                            <img src="{{ asset('storage/' . $path) }}" 
                                 class="image-preview" 
                                 alt="Attached Issue Photo"
                                 onerror="this.parentElement.parentElement.style.display='none';">
                        </a>
                    </div>
                    @endforeach
                </div>
                <p class="text-muted mt-2 small">Total photos attached: {{ count($issue->photos) }}</p>
            </div>
            @else
            <hr class="my-4">
            <div class="mb-3">
                <p class="text-muted fst-italic">No photos were attached to this report.</p>
            </div>
            @endif
            {{-- END PHOTO SHOW --}}
        </div>

        {{-- ADMIN ACTION --}}
        <div class="card p-4 admin-card">
            <h5 class="section-title">Admin Action</h5>

            <form action="{{ route('admin.issues.update', $issue->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row mb-3">
                    <div class="col-md-6 mb-3 mb-md-0">
                        <label class="label-text" for="status">Status</label>
                        <select class="form-select" id="status" name="status" required>
                            <option value="Pending" {{ $issue->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                            <option value="In Progress" {{ $issue->status == 'In Progress' ? 'selected' : '' }}>In Progress</option>
                            <option value="Resolved" {{ $issue->status == 'Resolved' ? 'selected' : '' }}>Resolved</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="label-text">Current System Time</label>
                        <input type="text" class="form-control" value="{{ now()->format('M d, Y h:i A') }}" disabled>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="label-text" for="admin_remarks">Admin Notes (optional)</label>
                    <textarea class="form-control" id="admin_remarks" name="admin_remarks" rows="4">{{ $issue->admin_remarks }}</textarea>
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