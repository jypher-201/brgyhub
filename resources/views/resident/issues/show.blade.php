<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Issue Report Details - BarangayHub</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --primary-blue: #1a4f8c;
            --secondary-blue: #2c6cb0;
            --golden-yellow: #f9a825;
            --dark-text: #2c3e50;
            --light-text: #6c757d;
        }

        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', system-ui, sans-serif;
            padding: 1.5rem 0;
        }

        .container {
            max-width: 1000px;
        }

        .info-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            padding: 2rem;
            margin-bottom: 1.5rem;
            border-left: 5px solid var(--golden-yellow);
        }

        .status-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            padding: 2rem;
            margin-bottom: 1.5rem;
            border-left: 5px solid var(--primary-blue);
        }

        .card-header-custom {
            display: flex;
            align-items: center;
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid #f1f3f5;
        }

        .card-header-custom i {
            font-size: 1.5rem;
            margin-right: 0.75rem;
            color: var(--golden-yellow);
        }

        .status-card .card-header-custom i {
            color: var(--primary-blue);
        }

        .card-header-custom h5 {
            margin: 0;
            font-weight: 600;
            color: var(--dark-text);
            font-size: 1.3rem;
        }

        .info-row {
            display: grid;
            grid-template-columns: 150px 1fr;
            gap: 1rem;
            padding: 0.75rem 0;
            border-bottom: 1px solid #f1f3f5;
        }

        .info-row:last-child {
            border-bottom: none;
        }

        .info-label {
            font-weight: 600;
            color: var(--dark-text);
            font-size: 0.9rem;
        }

        .info-value {
            color: var(--light-text);
            word-wrap: break-word;
        }

        .status-badge {
            font-size: 0.875rem;
            font-weight: 600;
            padding: 0.5rem 1rem;
            border-radius: 6px;
            display: inline-block;
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
            color: #28a745;
        }

        .photos-section {
            margin-top: 1.5rem;
            padding-top: 1.5rem;
            border-top: 2px solid #f1f3f5;
        }

        .photos-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 1rem;
            margin-top: 1rem;
        }

        .photo-item {
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            overflow: hidden;
            transition: transform 0.2s;
        }

        .photo-item:hover {
            transform: scale(1.02);
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }

        .photo-item img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }

        .admin-remarks-box {
            background-color: #f8f9fa;
            border-left: 4px solid var(--primary-blue);
            padding: 1rem;
            border-radius: 6px;
            margin-top: 1rem;
        }

        .no-remarks {
            font-style: italic;
            color: var(--light-text);
            text-align: center;
            padding: 2rem;
            background-color: #f8f9fa;
            border-radius: 6px;
        }

        .btn-outline-secondary {
            border-color: var(--light-text);
            color: var(--light-text);
        }

        .btn-outline-secondary:hover {
            background-color: var(--light-text);
            color: white;
        }

        @media (max-width: 768px) {
            .info-row {
                grid-template-columns: 1fr;
                gap: 0.25rem;
            }
            
            .photos-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>
    <div class="container">

        <h2 class="mb-4 text-center fw-bold" style="color: var(--dark-text);">
            <i class="fas fa-file-alt text-primary me-2"></i>Issue Report Details
        </h2>

        <div class="mb-3 d-flex gap-2">
            <a href="{{ route('resident.issues.index') }}" class="btn btn-outline-primary">
                <i class="fas fa-arrow-left"></i> Back to My Reports
            </a>
            <a href="{{ route('resident.dashboard') }}" class="btn btn-outline-secondary">
                <i class="fas fa-home"></i> Dashboard
            </a>
        </div>

        {{-- ISSUE INFORMATION --}}
        <div class="info-card">
            <div class="card-header-custom">
                <i class="fas fa-info-circle"></i>
                <h5>Report Information</h5>
            </div>

            <div class="info-row">
                <div class="info-label">Report ID</div>
                <div class="info-value">#{{ $report->id }}</div>
            </div>

            <div class="info-row">
                <div class="info-label">Issue Title</div>
                <div class="info-value fw-bold text-dark">{{ $report->title }}</div>
            </div>

            <div class="info-row">
                <div class="info-label">Category</div>
                <div class="info-value">
                    <span class="badge bg-secondary">{{ ucfirst($report->category) }}</span>
                </div>
            </div>

            <div class="info-row">
                <div class="info-label">Description</div>
                <div class="info-value">{{ $report->description }}</div>
            </div>

            <div class="info-row">
                <div class="info-label">Location</div>
                <div class="info-value">
                    <i class="fas fa-map-marker-alt text-danger me-1"></i>
                    {{ $report->location ?? 'Not specified' }}
                </div>
            </div>

            <div class="info-row">
                <div class="info-label">Submitted On</div>
                <div class="info-value">
                    <i class="far fa-calendar me-1"></i>
                    {{ $report->created_at->format('F d, Y') }} at {{ $report->created_at->format('h:i A') }}
                </div>
            </div>

            {{-- PHOTOS --}}
            @php
                $photos = is_string($report->photos) ? json_decode($report->photos, true) : $report->photos;
                $photos = is_array($photos) ? $photos : [];
            @endphp

            @if(!empty($photos))
            <div class="photos-section">
                <div class="info-label mb-2">
                    <i class="fas fa-camera me-2"></i>Attached Photos ({{ count($photos) }})
                </div>
                <div class="photos-grid">
                    @foreach($photos as $path)
                    <a href="{{ asset('storage/' . $path) }}" target="_blank" class="photo-item">
                        <img src="{{ asset('storage/' . $path) }}" 
                             alt="Issue Photo"
                             onerror="this.parentElement.style.display='none';">
                    </a>
                    @endforeach
                </div>
            </div>
            @endif
        </div>

        {{-- STATUS & ADMIN RESPONSE --}}
        <div class="status-card">
            <div class="card-header-custom">
                <i class="fas fa-tasks"></i>
                <h5>Status & Admin Response</h5>
            </div>

            <div class="info-row">
                <div class="info-label">Current Status</div>
                <div class="info-value">
                    <span class="status-badge 
                        @if($report->status == 'Pending') status-pending
                        @elseif($report->status == 'In Progress') status-in-progress
                        @elseif($report->status == 'Resolved') status-resolved
                        @endif">
                        <i class="fas fa-circle me-1" style="font-size: 0.5rem;"></i>
                        {{ $report->status }}
                    </span>
                </div>
            </div>

            <div class="info-row">
                <div class="info-label">Last Updated</div>
                <div class="info-value">
                    <i class="far fa-clock me-1"></i>
                    {{ $report->updated_at->diffForHumans() }}
                </div>
            </div>

            <div class="mt-3">
                <div class="info-label mb-2">
                    <i class="fas fa-comment-dots me-2"></i>Admin Notes / Remarks
                </div>
                @if($report->admin_remarks)
                    <div class="admin-remarks-box">
                        {{ $report->admin_remarks }}
                    </div>
                @else
                    <div class="no-remarks">
                        <i class="fas fa-inbox fa-2x mb-2 text-muted"></i>
                        <p class="mb-0">No admin remarks yet. We'll update you once your report is reviewed.</p>
                    </div>
                @endif
            </div>
        </div>

    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>