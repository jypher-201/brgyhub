<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'BrgyHub') }}</title>

    <!-- 1. Google Fonts for a modern look -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">

    <!-- 2. Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- 3. Custom Configuration for Brand Colors -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Poppins', 'sans-serif'],
                    },
                    colors: {
                        'brgy-blue': '#1e3a8a',   // Deep Blue
                        'brgy-gold': '#fbbf24',   // Gold/Yellow
                    }
                }
            }
        }
    </script>

    <style>
        /* Background animation */
        .bg-animate {
            background-size: 400% 400%;
            animation: gradientBG 15s ease infinite;
        }
        @keyframes gradientBG {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
    </style>
</head>

<!-- Main Body: Full Screen, Centered Content -->
<body class="bg-gradient-to-br from-slate-900 via-brgy-blue to-slate-900 bg-animate h-screen w-full overflow-hidden flex flex-col items-center justify-center relative">

    <!-- Background Overlay Pattern -->
    <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-10 pointer-events-none"></div>

    <!-- Main Card Container -->
    <div class="relative z-10 bg-white/10 backdrop-blur-md border border-white/20 rounded-2xl shadow-2xl w-full max-w-md p-8 mx-4 transform transition-all hover:scale-[1.01]">
        
        <!-- 1. Logo Section (Centered Above) -->
        <div class="flex flex-col items-center justify-center mb-8">
            <div class="w-24 h-24 bg-white rounded-full flex items-center justify-center shadow-lg mb-4 border-4 border-white/30">
                <!-- REPLACE THIS IMAGE SOURCE WITH YOUR LOGO -->
                <!-- Example: src="{{ asset('images/logo.png') }}" -->
                <img src="{{ asset('images/brgyhub_logo.png') }}" alt="BrgyHub Logo" class="w-14 h-14 opacity-90">
            </div>
            
            <h1 class="text-3xl font-bold text-white tracking-wide drop-shadow-md">BRGY<span class="text-brgy-gold">HUB</span></h1>
            <p class="text-blue-100 text-sm mt-1 font-light tracking-wider uppercase">Barangay E-Concerns System</p>
        </div>

        <!-- 2. Buttons Section (Center Middle) -->
        <div class="space-y-4">
            
            <!-- Login Button -->
            <a href="{{ route('login') }}" 
               class="group relative w-full flex justify-center py-3.5 px-4 border border-transparent text-sm font-bold rounded-lg text-white bg-brgy-gold hover:bg-yellow-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-400 shadow-lg transition-all duration-200 ease-in-out transform hover:-translate-y-1">
                <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                    <!-- Icon -->
                    <svg class="h-5 w-5 text-yellow-800 group-hover:text-white transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                    </svg>
                </span>
                LOGIN
            </a>

            <!-- Divider -->
            <div class="relative flex py-1 items-center">
                <div class="flex-grow border-t border-blue-200/30"></div>
                <span class="flex-shrink-0 mx-4 text-blue-100 text-xs uppercase">or</span>
                <div class="flex-grow border-t border-blue-200/30"></div>
            </div>

            <!-- Register Button -->
            <a href="{{ route('register') }}" 
               class="w-full flex items-center justify-center px-4 py-3.5 border-2 border-white/40 text-sm font-semibold rounded-lg text-white hover:bg-white hover:text-brgy-blue focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200 backdrop-blur-sm">
               CREATE ACCOUNT
            </a>

        </div>

        <!-- Helper Links (UPDATED HERE) -->
        <div class="mt-6 text-center">
            <!-- Uses standard Laravel route 'password.request' which maps to /forgot-password -->
            <a href="{{ route('password.request') }}" class="text-xs text-blue-200 hover:text-white hover:underline transition">
                Forgot Password?
            </a>
        </div>
    </div>

    <!-- Footer Copyright -->
    <div class="absolute bottom-6 text-blue-200/50 text-xs">
        &copy; {{ date('Y') }} {{ config('app.name', 'BrgyHub') }} System. All rights reserved.
    </div>

</body>
</html>