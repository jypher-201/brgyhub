<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - {{ config('app.name', 'BrgyHub') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Poppins', 'sans-serif'] },
                    colors: {
                        'brgy-blue': '#1e3a8a',
                        'brgy-gold': '#fbbf24',
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

<body class="bg-gradient-to-br from-slate-900 via-brgy-blue to-slate-900 bg-animate h-screen w-full overflow-hidden flex flex-col items-center justify-center relative">

    <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-10 pointer-events-none"></div>

    <div class="relative z-10 bg-white/10 backdrop-blur-md border border-white/20 rounded-2xl shadow-2xl w-full max-w-md p-8 mx-4">

        <div class="flex flex-col items-center justify-center mb-6">
            <div class="w-20 h-20 bg-white rounded-full flex items-center justify-center shadow-lg mb-3 border-4 border-white/30">
                <img src="{{ asset('images/brgyhub_logo.png') }}" alt="BrgyHub Logo" class="w-12 h-12 opacity-90">
            </div>
            <h1 class="text-2xl font-bold text-white tracking-wide">BRGY<span class="text-brgy-gold">HUB</span></h1>
            <p class="text-blue-200 text-xs uppercase tracking-wider">Authorized Access Only</p>
        </div>

        @if ($errors->any())
            <div class="mb-4 bg-red-500/20 border border-red-500/50 rounded-lg p-3 text-sm text-red-100">
                <div class="font-medium">Whoops! Something went wrong.</div>
                <ul class="mt-1 list-disc list-inside text-xs">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('status'))
            <div class="mb-4 font-medium text-sm text-green-400">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}" class="space-y-5">
            @csrf

            <div>
                <label for="email" class="block text-sm font-medium text-blue-100 mb-1">Email Address</label>
                <div class="relative">
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus 
                        class="w-full px-4 py-3 rounded-lg bg-white/80 border border-transparent focus:border-brgy-gold focus:bg-white focus:ring-0 text-gray-900 placeholder-gray-500 transition-all" 
                        placeholder="Enter your email">
                </div>
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-blue-100 mb-1">Password</label>
                <div class="relative">
                    <input 
                        id="password" 
                        type="password" 
                        name="password" 
                        required 
                        autocomplete="current-password"
                        class="w-full px-4 py-3 rounded-lg bg-white/80 border border-transparent focus:border-brgy-gold focus:bg-white focus:ring-0 text-gray-900 placeholder-gray-500 transition-all pr-10" 
                        placeholder="Enter your password"
                    >
                    
                    <button type="button" id="password-toggle" 
                            class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-500 hover:text-brgy-blue transition-colors focus:outline-none">
                        
                        <svg id="eye-open-icon" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>

                        <svg id="eye-closed-icon" class="h-5 w-5 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 20c-4.478 0-8.268-2.943-9.542-7a9.7 9.7 0 011.583-2.61L.707 1.5l1.414 1.414L3 4.414l.849.849M12 20c2.81 0 5.3-1.03 7.236-2.686l-1.428-1.428A7.75 7.75 0 0012 17a7.75 7.75 0 00-6.19-3.04l-1.637-1.637A10.05 10.05 0 0112 4c4.478 0 8.268 2.943 9.542 7l-.423.423M20.293 21.707l-1.414-1.414" />
                        </svg>
                    </button>
                </div>
            </div>

            <div class="flex items-center justify-between text-sm">
                <label for="remember_me" class="flex items-center cursor-pointer text-blue-100 hover:text-white">
                    <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-brgy-gold shadow-sm focus:ring-brgy-gold" name="remember">
                    <span class="ml-2">Remember me</span>
                </label>

                @if (Route::has('password.request'))
                    <a class="text-brgy-gold hover:text-yellow-300 font-semibold transition" href="{{ route('password.request') }}">
                        Forgot Password?
                    </a>
                @endif
            </div>

            <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-md text-sm font-bold text-white bg-brgy-gold hover:bg-yellow-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 transform transition hover:-translate-y-0.5">
                LOG IN
            </button>
        </form>

        <div class="mt-6 text-center">
            <p class="text-sm text-blue-200">
                Don't have an account? 
                <a href="{{ route('register') }}" class="font-semibold text-white hover:underline">Register here</a>
            </p>
        </div>
    </div>

    <div class="absolute bottom-4 text-blue-200/50 text-xs">
        &copy; {{ date('Y') }} BrgyHub. All rights reserved.
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const passwordInput = document.getElementById('password');
            const toggleButton = document.getElementById('password-toggle');
            const openIcon = document.getElementById('eye-open-icon');
            const closedIcon = document.getElementById('eye-closed-icon');

            if (passwordInput && toggleButton) {
                toggleButton.addEventListener('click', function() {
                    // Check if the input is currently password type
                    const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                    
                    // Toggle the type attribute
                    passwordInput.setAttribute('type', type);

                    // Toggle the icon visibility to switch between open and closed eye
                    openIcon.classList.toggle('hidden');
                    closedIcon.classList.toggle('hidden');
                });
            }
        });
    </script>
</body>
</html>