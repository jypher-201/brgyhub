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
        .gradient-submit { background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%); }
        .form-styled { border-width: 3px; @apply border-gold-500 rounded-xl shadow-sm p-4 transition duration-200; }
        .form-styled:focus { @apply border-blue-600 ring-4 ring-blue-500/50 outline-none; }
        .file-upload-box:hover { border-color: #3b82f6; }
    </style>
</head>

<body class="bg-slate-100 min-h-screen">
    
    <div class="w-full mx-auto max-w-5xl px-4 sm:px-6 lg:px-8 py-10">

        <div class="mb-6 flex justify-between items-center">
            <a href="{{ url('/dashboard') }}" class="flex items-center text-slate-600 hover:text-blue-700 font-medium transition-colors p-2 -ml-2 rounded-lg hover:bg-slate-200">
                <i class="fas fa-arrow-left mr-2"></i>
                Back to Dashboard
            </a>
        </div>
        
        <header class="mb-10 text-center">
            <h1 class="text-4xl font-extrabold text-slate-900 mb-2">New Issue Report</h1>
            <p class="text-slate-600 text-lg">Please provide details to submit your maintenance or community concern.</p>
        </header>

        {{-- Success/Error Messages --}}
        @if(session('success'))
            <div class="mb-6 p-4 bg-green-100 border border-green-300 text-green-800 rounded-xl">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-6 p-4 bg-red-100 border border-red-300 text-red-800 rounded-xl">
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
            
            <form action="{{ route('resident.issues.store') }}" method="POST" enctype="multipart/form-data" class="p-8">
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
                    <label for="photo" class="block text-lg font-semibold text-slate-800 mb-4 flex items-center">
                        <i class="fas fa-camera text-gold-500 mr-2"></i>
                        Upload Photo (Optional)
                    </label>
                    <div class="file-upload-box flex justify-center px-6 pt-5 pb-6 border-2 border-blue-300 border-dashed rounded-lg transition-all duration-200 cursor-pointer">
                        <div class="space-y-1 text-center">
                            <i class="fas fa-cloud-upload-alt text-blue-400 text-4xl"></i>
                            <div class="flex text-sm text-slate-600">
                                <label for="photo-upload" class="relative cursor-pointer bg-slate-50 rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500">
                                    <span>Click to upload photo(s)</span>
                                    <input id="photo-upload" name="photo" type="file" class="sr-only" multiple accept="image/*">
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
    
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const fileUploadBox = document.querySelector('.file-upload-box');
            const fileInput = document.getElementById('photo-upload');
            
            fileUploadBox.addEventListener('click', function() { fileInput.click(); });
            fileUploadBox.addEventListener('dragover', function(e) { e.preventDefault(); this.classList.add('border-blue-500','bg-blue-100/50'); });
            fileUploadBox.addEventListener('dragleave', function() { this.classList.remove('border-blue-500','bg-blue-100/50'); });
            fileUploadBox.addEventListener('drop', function(e) {
                e.preventDefault();
                this.classList.remove('border-blue-500','bg-blue-100/50');
                if(e.dataTransfer.files.length) fileInput.files = e.dataTransfer.files;
            });
        });
    </script>
    @if(session('success'))
<script>
    Swal.fire({
        title: 'Success!',
        text: '{{ session('success') }}',
        icon: 'success',
        confirmButtonColor: '#2563eb', // blue
        timer: 2500,
        timerProgressBar: true
    });
</script>
@endif

</body>
</html>

@endsection

