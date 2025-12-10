<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>BrgyHub - Barangay E-Concerns System</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="shortcut icon" type="image/jpg" href="{{ asset('images/brgyhub_logo.jpg') }}">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Custom Configuration -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Poppins', 'sans-serif'],
                    },
                    colors: {
                        'brgy-blue': '#1e3a8a',
                        'brgy-gold': '#fbbf24',
                    }
                }
            }
        }
    </script>

    <style>
        .bg-animate {
            background-size: 400% 400%;
            animation: gradientBG 15s ease infinite;
        }
        @keyframes gradientBG {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        .fade-in {
            animation: fadeIn 1s ease-in;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .float {
            animation: float 3s ease-in-out infinite;
        }
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }
    </style>
</head>

<body class="bg-gradient-to-br from-slate-900 via-brgy-blue to-slate-900 bg-animate min-h-screen w-full overflow-x-hidden">

    <!-- Background Overlay Pattern -->
    <div class="fixed inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-10 pointer-events-none"></div>

    <!-- Navigation Bar -->
    <nav class="relative z-50 bg-white/5 backdrop-blur-md border-b border-white/10 sticky top-0">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-white rounded-full flex items-center justify-center shadow-lg">
                        <img src="{{ asset('images/brgyhub_logo.png') }}" alt="Logo" class="w-6 h-6">
                    </div>
                    <span class="text-white font-bold text-xl">BRGY<span class="text-brgy-gold">HUB</span></span>
                </div>
                
                <!-- Nav Buttons -->
                <div class="flex items-center space-x-4">
                    <a href="{{ route('login') }}" 
                       class="px-4 py-2 text-sm font-semibold text-white hover:text-brgy-gold transition">
                        Login
                    </a>
                    <a href="{{ route('register') }}" 
                       class="px-5 py-2 bg-brgy-gold hover:bg-yellow-500 text-white text-sm font-bold rounded-lg shadow-lg transition transform hover:-translate-y-0.5">
                        Get Started
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="relative z-10 pt-20 pb-32 px-4">
        <div class="max-w-6xl mx-auto text-center fade-in">
            <!-- Logo Circle -->
            <div class="flex justify-center mb-6">
                <div class="w-24 h-24 bg-white rounded-full flex items-center justify-center shadow-2xl border-4 border-white/30 float">
                    <img src="{{ asset('images/brgyhub_logo.png') }}" alt="BrgyHub Logo" class="w-14 h-14">
                </div>
            </div>

            <h1 class="text-5xl md:text-6xl font-bold text-white mb-4 drop-shadow-lg">
                Welcome to <span class="text-brgy-gold">BrgyHub</span>
            </h1>
            <p class="text-xl md:text-2xl text-blue-100 mb-6 font-light">
                Digital Barangay E-Concerns System
            </p>
            <p class="text-lg text-blue-200 max-w-3xl mx-auto mb-12 leading-relaxed">
                Report community concerns like broken streetlights, flooding, and vandalism. Track your reports and stay updated—anytime, anywhere.
            </p>

            <!-- CTA Buttons -->
            <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                <a href="{{ route('register') }}" 
                   class="px-8 py-4 bg-brgy-gold hover:bg-yellow-500 text-white font-bold rounded-lg shadow-xl transition transform hover:-translate-y-1 hover:shadow-2xl">
                    Create Your Account
                </a>
                <a href="{{ route('login') }}" 
                   class="px-8 py-4 bg-white/10 backdrop-blur-sm border-2 border-white/40 text-white font-semibold rounded-lg hover:bg-white hover:text-brgy-blue transition">
                    Sign In
                </a>
            </div>
        </div>
    </section>

    <!-- Key Features Section -->
    <section class="relative z-10 py-20 px-4">
        <div class="max-w-6xl mx-auto">
            <h2 class="text-3xl md:text-4xl font-bold text-white text-center mb-16">
                What You Can Do
            </h2>

            <div class="grid md:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="bg-white/10 backdrop-blur-md border border-white/20 rounded-2xl p-8 shadow-xl hover:bg-white/15 transition transform hover:-translate-y-2">
                    <div class="w-16 h-16 bg-brgy-gold rounded-full flex items-center justify-center mb-6 shadow-lg">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-3">Report Issues</h3>
                    <p class="text-blue-200">
                        Submit concerns about broken streetlights, flooding, vandalism, and other community problems. Add photos and location details to your report.
                    </p>
                </div>

                <!-- Feature 2 -->
                <div class="bg-white/10 backdrop-blur-md border border-white/20 rounded-2xl p-8 shadow-xl hover:bg-white/15 transition transform hover:-translate-y-2">
                    <div class="w-16 h-16 bg-brgy-gold rounded-full flex items-center justify-center mb-6 shadow-lg">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-3">Track Progress</h3>
                    <p class="text-blue-200">
                        Monitor your reports from Pending to In Progress to Resolved. Stay informed with updates from barangay officials.
                    </p>
                </div>

                <!-- Feature 3 -->
                <div class="bg-white/10 backdrop-blur-md border border-white/20 rounded-2xl p-8 shadow-xl hover:bg-white/15 transition transform hover:-translate-y-2">
                    <div class="w-16 h-16 bg-brgy-gold rounded-full flex items-center justify-center mb-6 shadow-lg">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-3">Share Ideas</h3>
                    <p class="text-blue-200">
                        Submit suggestions and feedback for community improvement. Help make our barangay a better place for everyone.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works Section -->
    <section class="relative z-10 py-20 px-4 bg-white/5">
        <div class="max-w-5xl mx-auto">
            <h2 class="text-3xl md:text-4xl font-bold text-white text-center mb-16">
                How It Works
            </h2>

            <div class="grid md:grid-cols-3 gap-8">
                <!-- Step 1 -->
                <div class="text-center">
                    <div class="flex justify-center mb-4">
                        <div class="w-20 h-20 bg-brgy-gold rounded-full flex items-center justify-center text-white text-2xl font-bold shadow-xl">
                            1
                        </div>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-3">Create Account</h3>
                    <p class="text-blue-200">Register as a barangay resident and verify your account to get started.</p>
                </div>

                <!-- Step 2 -->
                <div class="text-center">
                    <div class="flex justify-center mb-4">
                        <div class="w-20 h-20 bg-brgy-gold rounded-full flex items-center justify-center text-white text-2xl font-bold shadow-xl">
                            2
                        </div>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-3">Submit Report</h3>
                    <p class="text-blue-200">File your concern with details, location, and photos through our easy platform.</p>
                </div>

                <!-- Step 3 -->
                <div class="text-center">
                    <div class="flex justify-center mb-4">
                        <div class="w-20 h-20 bg-brgy-gold rounded-full flex items-center justify-center text-white text-2xl font-bold shadow-xl">
                            3
                        </div>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-3">Get Updates</h3>
                    <p class="text-blue-200">Track status changes and receive updates until your concern is resolved.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="relative z-10 py-8 px-4 border-t border-white/10">
        <div class="max-w-6xl mx-auto text-center">
            <p class="text-blue-200/70 text-sm">
                &copy; {{ date('Y') }} {{ config('app.name', 'BrgyHub') }} System. All rights reserved.
            </p>
        </div>
    </footer>

</body>
</html>