<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Suggestion Details - BarangayHub</title>

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

        .status-reviewed {
            background-color: rgba(40, 167, 69, 0.15);
            color: #28a745;
        }

        .status-implemented {
            background-color: rgba(26, 79, 140, 0.1);
            color: var(--primary-blue);
        }

        .admin-response-box {
            background-color: #f8f9fa;
            border-left: 4px solid var(--primary-blue);
            padding: 1rem;
            border-radius: 6px;
            margin-top: 1rem;
        }

        .no-response {
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
        }
    </style>
</head>

<body>
    <div class="container">

        <h2 class="mb-4 text-center fw-bold" style="color: var(--dark-text);">
            <i class="fas fa-lightbulb text-warning me-2"></i>Suggestion Details
        </h2>

        <div class="mb-3 d-flex gap-2">
            <a href="{{ route('resident.suggestions.index') }}" class="btn btn-outline-primary">
                <i class="fas fa-arrow-left"></i> Back to My Suggestions
            </a>
            <a href="{{ route('resident.dashboard') }}" class="btn btn-outline-secondary">
                <i class="fas fa-home"></i> Dashboard
            </a>
        </div>

        {{-- SUGGESTION INFORMATION --}}
        <div class="info-card">
            <div class="card-header-custom">
                <i class="fas fa-info-circle"></i>
                <h5>Suggestion Information</h5>
            </div>

            <div class="info-row">
                <div class="info-label">Suggestion ID</div>
                <div class="info-value">#{{ $suggestion->id }}</div>
            </div>

            <div class="info-row">
                <div class="info-label">My Idea</div>
                <div class="info-value" style="white-space: pre-line;">{{ $suggestion->content }}</div>
            </div>

            <div class="info-row">
                <div class="info-label">Submitted On</div>
                <div class="info-value">
                    <i class="far fa-calendar me-1"></i>
                    {{ $suggestion->created_at->format('F d, Y') }} at {{ $suggestion->created_at->format('h:i A') }}
                </div>
            </div>
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
                        @if($suggestion->status == 'Pending') status-pending
                        @elseif($suggestion->status == 'Reviewed') status-reviewed
                        @elseif($suggestion->status == 'Implemented') status-implemented
                        @else status-pending
                        @endif">
                        <i class="fas fa-circle me-1" style="font-size: 0.5rem;"></i>
                        {{ $suggestion->status ?? 'Pending' }}
                    </span>
                </div>
            </div>

            <div class="info-row">
                <div class="info-label">Last Updated</div>
                <div class="info-value">
                    <i class="far fa-clock me-1"></i>
                    {{ $suggestion->updated_at->diffForHumans() }}
                </div>
            </div>

            <div class="mt-3">
                <div class="info-label mb-2">
                    <i class="fas fa-comment-dots me-2"></i>Barangay Response
                </div>
                @if($suggestion->admin_response)
                    <div class="admin-response-box">
                        {{ $suggestion->admin_response }}
                    </div>
                @else
                    <div class="no-response">
                        <i class="fas fa-inbox fa-2x mb-2 text-muted"></i>
                        <p class="mb-0">The Barangay Council has not yet provided a response to this suggestion.</p>
                    </div>
                @endif
            </div>
        </div>

    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>