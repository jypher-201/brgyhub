<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submit Suggestion / Feedback - BarangayHub</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        :root {
            --primary-blue: #1a4f8c;
            --secondary-blue: #2c6cb0;
            --light-blue: #e8f2fc;
            --golden-yellow: #f9a825;
            --dark-gold: #d18c00;
            --light-gold: #fff8e1;
            --dark-text: #2c3e50;
            --light-text: #6c757d;
            --border-color: #e0e0e0;
        }
        
        body { 
            background: linear-gradient(135deg, #f5f7fa 0%, #e8f2fc 100%);
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif; 
            min-height: 100vh;
            padding: 2rem 0;
        }
        
        .container { 
            max-width: 900px; 
        }
        
        .header-section { 
            display: flex; 
            justify-content: space-between; 
            align-items: center; 
            margin-bottom: 1.5rem; 
            flex-wrap: wrap; 
            gap: 1rem; 
            padding: 1.5rem 0;
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
            color: var(--golden-yellow);
            background: var(--light-gold);
            padding: 10px;
            border-radius: 50%;
        }
        
        .btn-outline-primary { 
            border-color: var(--primary-blue); 
            color: var(--primary-blue); 
            border-radius: 6px; 
            font-weight: 500; 
            padding: 0.5rem 1.25rem; 
            transition: all 0.2s ease; 
        }
        
        .btn-outline-primary:hover { 
            background-color: var(--primary-blue); 
            color: white; 
            transform: translateY(-2px); 
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        
        .btn-primary { 
            background: linear-gradient(to right, var(--primary-blue), var(--secondary-blue));
            border: none; 
            border-radius: 6px; 
            font-weight: 500; 
            padding: 0.75rem 1.5rem; 
            transition: all 0.2s ease; 
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        
        .btn-primary:hover { 
            background: linear-gradient(to right, var(--secondary-blue), var(--primary-blue));
            transform: translateY(-2px); 
            box-shadow: 0 4px 8px rgba(0,0,0,0.15);
        }
        
        .btn-warning {
            background-color: var(--golden-yellow);
            border: none;
            border-radius: 6px;
            font-weight: 500;
            padding: 0.75rem 1.5rem;
            transition: all 0.2s ease;
            color: white;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        
        .btn-warning:hover {
            background-color: var(--dark-gold);
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.15);
            color: white;
        }
        
        .form-container { 
            background-color: white; 
            border-radius: 12px; 
            box-shadow: 0 5px 15px rgba(0,0,0,0.08); 
            overflow: hidden; 
            padding: 2rem;
            border-top: 4px solid var(--golden-yellow);
        }
        
        .form-label {
            font-weight: 600;
            color: var(--dark-text);
            margin-bottom: 0.75rem;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .form-control {
            border: 1px solid var(--border-color);
            border-radius: 8px;
            padding: 0.75rem;
            transition: border-color 0.2s ease, box-shadow 0.2s ease;
            font-size: 1rem;
        }
        
        .form-control:focus {
            border-color: var(--secondary-blue);
            box-shadow: 0 0 0 0.2rem rgba(44, 108, 176, 0.25);
        }
        
        .text-danger {
            font-size: 0.875rem;
            margin-top: 0.25rem;
            display: block;
            font-weight: 500;
        }
        
        .alert-success {
            background-color: rgba(40, 167, 69, 0.15);
            border: 1px solid rgba(40, 167, 69, 0.3);
            color: #155724;
            border-radius: 8px;
            padding: 0.75rem 1rem;
            border-left: 4px solid #28a745;
        }
        
        .suggestion-icon {
            display: flex;
            justify-content: center;
            margin-bottom: 1.5rem;
        }
        
        .suggestion-icon i {
            font-size: 3rem;
            color: var(--golden-yellow);
            background: var(--light-gold);
            padding: 20px;
            border-radius: 50%;
        }
        
        .btn-group {
            display: flex;
            gap: 1rem;
            margin-top: 1.5rem;
        }
        
        .footer {
            margin-top: 3rem;
            padding: 1.5rem 0;
            text-align: center;
            color: var(--light-text);
            font-size: 0.9rem;
            border-top: 1px solid var(--border-color);
        }
        
        @media (max-width: 768px) {
            .header-section { 
                flex-direction: column; 
                align-items: flex-start; 
            }
            .header-actions { 
                width: 100%; 
            }
            .btn-group {
                flex-direction: column;
            }
            .btn-group .btn {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="container mt-4">
        <div class="header-section">
            <h2 class="page-title">
                <i class="fas fa-lightbulb"></i>
                Submit Suggestion / Feedback
            </h2>
            <div class="header-actions">
                <a href="{{ route('resident.dashboard') }}" class="btn btn-outline-primary">
                    <i class="fas fa-arrow-left me-2"></i>Back to Dashboard
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            </div>
        @endif

        <div class="form-container">
            <div class="suggestion-icon">
                <i class="fas fa-comment-alt"></i>
            </div>
            
            <form action="{{ route('resident.suggestions.store') }}" method="POST">
                @csrf
                
                {{-- NEW: Title Input Box --}}
                <div class="mb-4">
                    <label for="title" class="form-label">
                        <i class="fas fa-heading"></i>
                        Suggestion Title
                    </label>
                    <input type="text" name="title" class="form-control" required placeholder="A short title for your suggestion (e.g., Community Garden Project)" value="{{ old('title') }}">
                    @error('title') 
                        <span class="text-danger">
                            <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                        </span> 
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="content" class="form-label">
                        <i class="fas fa-pencil-alt"></i>
                        Your Suggestion
                    </label>
                    <textarea name="content" class="form-control" rows="6" required placeholder="Share your ideas, feedback, or suggestions to help improve our barangay...">{{ old('content') }}</textarea>
                    @error('content') 
                        <span class="text-danger">
                            <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                        </span> 
                    @enderror
                </div>

                <div class="btn-group">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-paper-plane me-2"></i>Submit Suggestion
                    </button>
                    <a href="{{ route('resident.suggestions.index') }}" class="btn btn-warning">
                        <i class="fas fa-list me-2"></i>View My Suggestions
                    </a>
                </div>
            </form>
        </div>
        
        <div class="footer">
            <p>BarangayHub Suggestion System &copy; 2023. All rights reserved.</p>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <!-- SweetAlert2 for success messages -->
    @if(session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Suggestion Submitted!',
            text: '{{ session("success") }}',
            timer: 2000,
            showConfirmButton: false,
            width: '350px',
            background: '#f8f9fa',
            color: '#2c3e50'
        });
    </script>
    @endif
</body>
</html>