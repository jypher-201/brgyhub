@extends('layouts.app')

@section('title', 'New Issue Report')

@section('content')
    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Issue Reporting Module - Responsive Design</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="icon" type="image/jpeg" href="{{ asset('images/brgyhub_logo.jpg') }}">
    <link rel="shortcut icon" type="image/jpeg" href="{{ asset('images/brgyhub_logo.jpg') }}">
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        blue: {50:'#eff6ff',100:'#dbeafe',500:'#3b82f6',600:'#2563eb',700:'#1d4ed8',800:'#1e40af',900:'#1e3a8a'},
                        gold: {50:'#fffbeb',100:'#fef3c7',400:'#fbbf24',500:'#f59e0b',600:'#d97706',700:'#b45309'},
                        slate: {50:'#f8fafc',100:'#f1f5f9',200:'#e2e8f0',300:'#cbd5e1',400:'#94a3b8',500:'#64748b',600:'#475569',700:'#334155',800:'#1e293b',900:'#0f172a'}
                    },
                    fontFamily: { sans: ['Inter','system-ui','sans-serif'] },
                    boxShadow: {
                        smooth: '0 4px 6px -1px rgba(0,0,0,0.05),0 2px 4px -1px rgba(0,0,0,0.03)',
                        'smooth-lg': '0 10px 15px -3px rgba(0,0,0,0.05),0 4px 6px -2px rgba(0,0,0,0.025)',
                    }
                }
            }
        }
    </script>
    
    <style>
        body { font-family: 'Inter', sans-serif; }
        
        /* --- Custom Variables & Button Styles --- */
        :root {
            --primary-blue: #1a4f8c;
            --secondary-blue: #2c6cb0;
            --golden-yellow: #f9a825;
            --dark-gold: #d18c00;
        }

        .btn-outline-primary { 
            border: 1px solid var(--primary-blue); 
            color: var(--primary-blue); 
            border-radius: 6px; 
            font-weight: 500; 
            padding: 0.5rem 1.25rem; 
            transition: all 0.2s ease; 
            display: inline-flex;
            align-items: center;
            background-color: white;
            text-decoration: none;
        }
        
        .btn-outline-primary:hover { 
            background-color: var(--primary-blue); 
            color: white; 
            transform: translateY(-2px); 
            box-shadow: 0 4px 8px rgba(0,0,0,0.1); 
        }

        /* ----------------------------------------- */

        .gradient-submit { background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%); }
        .form-styled { border-width: 3px; @apply border-gold-500 rounded-xl shadow-sm p-4 transition duration-200; }
        .form-styled:focus { @apply border-blue-600 ring-4 ring-blue-500/50 outline-none; }
        .file-upload-box:hover { border-color: #3b82f6; }

        .preview-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(100px, 1fr)); 
            gap: 1rem;
            padding: 1rem; 
            justify-items: center;
        }

        .image-preview-item {
            position: relative;
            width: 100px; 
            height: 100px; 
            border: 1px solid #cbd5e1; 
            border-radius: 0.5rem;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #f1f5f9; 
        }

        .image-preview-item img {
            width: 100%;
            height: 100%;
            object-fit: contain; 
        }

        .remove-photo-btn {
            position: absolute;
            top: 2px;
            right: 2px;
            background-color: rgba(239, 68, 68, 0.8); 
            color: white;
            border-radius: 50%;
            width: 24px;
            height: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.75rem;
            cursor: pointer;
            border: none;
            z-index: 10;
            transition: background-color 0.2s;
        }

        .remove-photo-btn:hover {
            background-color: rgba(239, 68, 68, 1); 
        }

        /* Compact SweetAlert Styles */
        .swal-compact {
            font-size: 0.9rem;
        }
        .swal-title-compact {
            font-size: 1.25rem !important;
            padding: 0.5rem 0 !important;
        }
        .swal-text-compact {
            font-size: 0.875rem !important;
            margin: 0.5rem 0 !important;
        }
    </style>
</head>

<body class="bg-slate-100 min-h-screen">
    
    <div class="w-full mx-auto max-w-5xl px-4 sm:px-6 lg:px-8 py-10">

        <div class="mb-6 flex justify-between items-center">
            {{-- UPDATED: Back to Dashboard Button using your specific CSS class --}}
            <a href="{{ route('resident.dashboard') }}" class="btn-outline-primary">
                <i class="fas fa-arrow-left mr-2"></i>
                Back to Dashboard
            </a>
        </div>
        
        <header class="mb-10 text-center">
            <h1 class="text-4xl font-extrabold text-slate-900 mb-2">New Issue Report</h1>
            <p class="text-slate-600 text-lg">Please provide details to submit your maintenance or community concern.</p>
        </header>

        @if ($errors->any())
            <div class="mb-6 p-4 bg-red-100 border border-red-300 text-red-800 rounded-xl" id="validation-errors">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="bg-white rounded-2xl shadow-smooth-lg overflow-hidden border border-slate-200">
            <div class="border-b border-slate-200 p-6 bg-gradient-to-r from-blue-50 to-slate-50">
                <h2 class="text-xl font-bold text-slate-800 flex items-center">
                    <i class="fas fa-exclamation-triangle text-blue-600 mr-3"></i>
                    Report Details
                </h2>
                <p class="text-slate-600 mt-1">Fields marked with an asterisk (<span class="text-red-500">*</span>) are required.</p>
            </div>
            
            <form action="{{ route('resident.issues.store') }}" method="POST" enctype="multipart/form-data" class="p-8" id="issue-report-form">
                @csrf
                
                <div class="mb-8">
                    <label for="title" class="block text-lg font-semibold text-slate-800 mb-3 flex items-center">
                        <i class="fas fa-heading text-gold-500 mr-2"></i>
                        Issue Title <span class="text-red-500 ml-1">*</span>
                    </label>
                    <input type="text" name="title" id="title" required
                            class="w-full form-styled"
                            placeholder="A brief, clear summary of the problem (e.g., Broken Streetlight)" value="{{ old('title') }}">
                </div>

                <div class="mb-8">
                    <label for="description" class="block text-lg font-semibold text-slate-800 mb-3 flex items-center">
                        <i class="fas fa-comment-alt text-gold-500 mr-2"></i>
                        Detailed Description <span class="text-red-500 ml-1">*</span>
                    </label>
                    <textarea name="description" id="description" rows="5" required
                                    class="w-full form-styled"
                                    placeholder="Describe the issue, noting its severity, time it started, and exact location.">{{ old('description') }}</textarea>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                    <div>
                        <label for="category" class="block text-lg font-semibold text-slate-800 mb-3 flex items-center">
                            <i class="fas fa-tag text-gold-500 mr-2"></i>
                            Issue Category <span class="text-red-500 ml-1">*</span>
                        </label>
                        <select id="category" name="category" required
                                    class="w-full form-styled appearance-none bg-white">
                            <option value="" disabled {{ old('category') ? '' : 'selected' }}>Select a Category (Required)</option>
                            <option value="streetlight" {{ old('category')=='streetlight' ? 'selected' : '' }}>💡 Streetlight Issue</option>
                            <option value="flooding" {{ old('category')=='flooding' ? 'selected' : '' }}>🌊 Flooding/Drainage</option>
                            <option value="vandalism" {{ old('category')=='vandalism' ? 'selected' : '' }}>🖌️ Vandalism</option>
                            <option value="sanitation" {{ old('category')=='sanitation' ? 'selected' : '' }}>🗑️ Sanitation/Garbage</option>
                            <option value="road" {{ old('category')=='road' ? 'selected' : '' }}>🛣️ Road Condition</option>
                            <option value="noise" {{ old('category')=='noise' ? 'selected' : '' }}>🔊 Noise Complaint</option>
                            <option value="other" {{ old('category')=='other' ? 'selected' : '' }}>❓ Other Issue</option>
                        </select>
                    </div>

                    <div>
                        <label for="location" class="block text-lg font-semibold text-slate-800 mb-3 flex items-center">
                            <i class="fas fa-map-pin text-gold-500 mr-2"></i>
                            Specific Location <span class="text-red-500 ml-1">*</span>
                        </label>
                        <input type="text" name="location" id="location" required
                                    class="w-full form-styled"
                                    placeholder="e.g., Main Street corner Sampaguita St." value="{{ old('location') }}">
                    </div>
                </div>

                <div class="mb-10 p-6 bg-slate-50 rounded-xl border border-slate-200">
                    <label for="photo-upload" class="block text-lg font-semibold text-slate-800 mb-4 flex items-center">
                        <i class="fas fa-camera text-gold-500 mr-2"></i>
                        Upload Photo(s) (Optional)
                    </label>
                    <div id="file-upload-box" class="file-upload-box relative border-2 border-blue-300 border-dashed rounded-lg transition-all duration-200 cursor-pointer min-h-[150px]">
                        
                        <div id="image-preview-container" class="preview-grid hidden">
                        </div>
                        
                        <div id="upload-prompt" class="absolute inset-0 flex flex-col items-center justify-center space-y-1 text-center p-4">
                            <i class="fas fa-cloud-upload-alt text-blue-400 text-4xl"></i>
                            <div class="flex text-sm text-slate-600">
                                <label for="photo-upload" class="relative cursor-pointer bg-slate-50 rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500">
                                    <span>Click to upload photo(s)</span>
                                    <input id="photo-upload" name="photos[]" type="file" class="sr-only" multiple accept="image/*" onchange="previewImages(event)">
                                </label>
                                <p class="pl-1 text-slate-400">or drag and drop here</p>
                            </div>
                            <p class="text-xs text-slate-500">PNG, JPG, JPEG up to 5MB each</p>
                        </div>
                    </div>
                </div>

                <div class="mt-8">
                    <button type="submit"
                                    class="w-full text-center gradient-submit text-white font-bold text-lg py-4 px-4 rounded-xl hover:opacity-90 transition-opacity shadow-lg shadow-blue-600/50 flex items-center justify-center tracking-wider">
                        <i class="fas fa-paper-plane mr-3"></i>
                        SUBMIT OFFICIAL REPORT
                    </button>
                </div>
            </form>
        </div>

        <div class="bg-blue-50 rounded-xl p-6 mt-8 border border-blue-300">
            <div class="flex items-start">
                <div class="bg-blue-100 p-3 rounded-lg mr-4 border border-blue-300">
                    <i class="fas fa-info-circle text-blue-800 text-xl"></i>
                </div>
                <div>
                    <h3 class="font-bold text-blue-900 text-lg mb-1">Need Assistance?</h3>
                    <p class="text-blue-800 text-sm">For urgent issues or questions about your report, please contact us directly.</p>
                </div>
            </div>
        </div>

    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <script>
        let uploadedFiles = [];

        function renderPreviews() {
            const previewContainer = document.getElementById('image-preview-container');
            const uploadPrompt = document.getElementById('upload-prompt');
            previewContainer.innerHTML = '';

            if (uploadedFiles.length > 0) {
                uploadedFiles.forEach((file, index) => {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const previewItem = document.createElement('div');
                        previewItem.classList.add('image-preview-item');
                        previewItem.setAttribute('data-index', index);

                        previewItem.innerHTML = `
                            <img src="${e.target.result}" alt="Photo Preview">
                            <button type="button" class="remove-photo-btn" data-index="${index}" title="Remove Photo">
                                <i class="fas fa-times"></i>
                            </button>
                        `;
                        previewContainer.appendChild(previewItem);
                    };
                    reader.readAsDataURL(file);
                });
                previewContainer.classList.remove('hidden');
                uploadPrompt.classList.add('hidden');
            } else {
                previewContainer.classList.add('hidden');
                uploadPrompt.classList.remove('hidden');
            }
        }

        function previewImages(event) {
            const newFiles = Array.from(event.target.files);
            
            const validFiles = newFiles.filter(file => {
                if (file.size > 5 * 1024 * 1024) {
                    Swal.fire({
                        title: 'File Too Large',
                        text: `${file.name} is over the 5MB limit and was skipped.`,
                        icon: 'warning',
                        width: '400px',
                        padding: '1.5rem',
                        customClass: {
                            popup: 'swal-compact',
                            title: 'swal-title-compact',
                            htmlContainer: 'swal-text-compact'
                        }
                    });
                    return false;
                }
                if (!file.type.match('image/(jpeg|jpg|png)')) {
                    Swal.fire({
                        title: 'Invalid File Type',
                        text: `${file.name} is not a valid image type (JPG, PNG).`,
                        icon: 'warning',
                        width: '400px',
                        padding: '1.5rem',
                        customClass: {
                            popup: 'swal-compact',
                            title: 'swal-title-compact',
                            htmlContainer: 'swal-text-compact'
                        }
                    });
                    return false;
                }
                return true;
            });
            
            uploadedFiles = uploadedFiles.concat(validFiles); 
            renderPreviews();
            event.target.value = '';
        }

        function removeFile(indexToRemove) {
            uploadedFiles.splice(indexToRemove, 1); 
            renderPreviews();
        }
        
        function clearErrors() {
            const errorDiv = document.getElementById('validation-errors');
            if(errorDiv) {
                errorDiv.remove();
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            const fileUploadBox = document.getElementById('file-upload-box');
            const fileInput = document.getElementById('photo-upload');
            const previewContainer = document.getElementById('image-preview-container');

            fileUploadBox.addEventListener('click', function(e) { 
                if (!e.target.closest('.remove-photo-btn') && !e.target.closest('.image-preview-item')) {
                    fileInput.click(); 
                }
            });

            previewContainer.addEventListener('click', function(e) {
                if (e.target.closest('.remove-photo-btn')) {
                    const button = e.target.closest('.remove-photo-btn');
                    const index = parseInt(button.dataset.index);
                    removeFile(index);
                }
            });
            
            fileUploadBox.addEventListener('dragover', function(e) { 
                e.preventDefault(); 
                this.classList.add('border-blue-500','bg-blue-100/50'); 
            });
            
            fileUploadBox.addEventListener('dragleave', function() { 
                this.classList.remove('border-blue-500','bg-blue-100/50'); 
            });
            
            fileUploadBox.addEventListener('drop', function(e) {
                e.preventDefault();
                this.classList.remove('border-blue-500','bg-blue-100/50');
                
                if(e.dataTransfer.files.length) {
                    uploadedFiles = uploadedFiles.concat(Array.from(e.dataTransfer.files));
                    renderPreviews();
                }
            });

            document.getElementById('issue-report-form').addEventListener('submit', async function(e) {
                e.preventDefault(); 

                const form = this;
                const formData = new FormData(form);
                
                clearErrors(); 

                uploadedFiles.forEach((file) => {
                    formData.append('photos[]', file, file.name);
                });

                const submitButton = form.querySelector('button[type="submit"]');
                const originalButtonText = submitButton.innerHTML;
                submitButton.disabled = true;
                submitButton.innerHTML = '<i class="fas fa-circle-notch fa-spin mr-3"></i> Submitting...';

                try {
                    const response = await fetch(form.action, {
                        method: form.method,
                        body: formData, 
                    });

                    if (response.ok) {
                        const data = await response.json(); 

                        if (data.success) {
                            // Just redirect immediately without SweetAlert
                            window.location.href = data.redirect_url; 
                            return; 
                        }
                    }
                    
                    if (response.status === 422) {
                        const errorData = await response.json();
                        
                        let errorHtml = '<ul class="list-disc pl-5">';
                        
                        if (errorData.errors) {
                            for (const key in errorData.errors) {
                                const errorMessage = errorData.errors[key].join('<br>');
                                const cleanKey = key.replace(/\.[\d]+/, ''); 
                                
                                const displayKey = cleanKey.charAt(0).toUpperCase() + cleanKey.slice(1);

                                if (cleanKey === 'photos') {
                                    errorHtml += `<li>**Attached Image Error:** ${errorMessage}</li>`;
                                } else {
                                    errorHtml += `<li>**${displayKey}:** ${errorMessage}</li>`;
                                }
                            }
                        }
                        errorHtml += '</ul>';

                        Swal.fire({
                            title: 'Validation Failed',
                            html: errorHtml,
                            icon: 'error',
                            confirmButtonColor: '#ef4444',
                            width: '450px',
                            padding: '1.5rem',
                            customClass: {
                                popup: 'swal-compact',
                                title: 'swal-title-compact',
                                htmlContainer: 'swal-text-compact'
                            }
                        });
                        
                    } else if (response.status !== 422) {
                        throw new Error(`Server responded with status: ${response.status}`);
                    }

                } catch (error) {
                    console.error('Submission Error:', error);
                    Swal.fire({
                        title: 'Submission Error',
                        text: 'An unexpected network error occurred. Please check your connection and try again.',
                        icon: 'error',
                        confirmButtonColor: '#ef4444',
                        width: '400px',
                        padding: '1.5rem',
                        customClass: {
                            popup: 'swal-compact',
                            title: 'swal-title-compact',
                            htmlContainer: 'swal-text-compact'
                        }
                    });
                } finally {
                    submitButton.disabled = false;
                    submitButton.innerHTML = originalButtonText;
                }
            });

        });
    </script>

</body>
</html>

@endsection