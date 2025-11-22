<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register - {{ config('app.name', 'BrgyHub') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Config -->
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

<body class="bg-gradient-to-br from-slate-900 via-brgy-blue to-slate-900 bg-animate min-h-screen w-full overflow-x-hidden flex flex-col items-center justify-center relative py-10">

    <!-- Background Pattern -->
    <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-10 pointer-events-none"></div>

    <!-- Main Card -->
    <div class="relative z-10 bg-white/10 backdrop-blur-md border border-white/20 rounded-2xl shadow-2xl w-full max-w-md p-8 mx-4 my-6">

        <!-- Logo Section -->
        <div class="flex flex-col items-center justify-center mb-6">
            <div class="w-20 h-20 bg-white rounded-full flex items-center justify-center shadow-lg mb-3 border-4 border-white/30">
                <!-- Logo Placeholder -->
                <img src="{{ asset('images/brgyhub_logo.png') }}" alt="BrgyHub Logo" class="w-12 h-12 opacity-90">
            </div>
            <h1 class="text-2xl font-bold text-white tracking-wide">BRGY<span class="text-brgy-gold">HUB</span></h1>
            <p class="text-blue-200 text-xs uppercase tracking-wider">Create Resident Account</p>
        </div>

        <!-- Validation Errors -->
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

        <!-- Register Form -->
        <form method="POST" action="{{ route('register') }}" class="space-y-4">
            @csrf

            <!-- Name -->
            <div>
                <label for="name" class="block text-sm font-medium text-blue-100 mb-1">Full Name</label>
                <div class="relative">
                    <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name"
                        class="w-full px-4 py-3 rounded-lg bg-white/80 border border-transparent focus:border-brgy-gold focus:bg-white focus:ring-0 text-gray-900 placeholder-gray-500 transition-all" 
                        placeholder="Enter your full name">
                </div>
            </div>

            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-medium text-blue-100 mb-1">Email Address</label>
                <div class="relative">
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username"
                        class="w-full px-4 py-3 rounded-lg bg-white/80 border border-transparent focus:border-brgy-gold focus:bg-white focus:ring-0 text-gray-900 placeholder-gray-500 transition-all" 
                        placeholder="Enter your email">
                </div>
            </div>

            <!-- Password -->
            <div>
                <label for="password" class="block text-sm font-medium text-blue-100 mb-1">Password</label>
                <div class="relative">
                    <input id="password" type="password" name="password" required autocomplete="new-password"
                        class="w-full px-4 py-3 rounded-lg bg-white/80 border border-transparent focus:border-brgy-gold focus:bg-white focus:ring-0 text-gray-900 placeholder-gray-500 transition-all" 
                        placeholder="Create a password">
                </div>
            </div>

            <!-- Confirm Password -->
            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-blue-100 mb-1">Confirm Password</label>
                <div class="relative">
                    <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                        class="w-full px-4 py-3 rounded-lg bg-white/80 border border-transparent focus:border-brgy-gold focus:bg-white focus:ring-0 text-gray-900 placeholder-gray-500 transition-all" 
                        placeholder="Confirm your password">
                </div>
            </div>

            <!-- Terms and Conditions (Jetstream Feature) -->
            @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                <div class="mt-4">
                    <label for="terms" class="flex items-start">
                        <div class="flex items-center h-5">
                            <input type="checkbox" name="terms" id="terms" required class="rounded border-gray-300 text-brgy-gold focus:ring-brgy-gold bg-white/90">
                        </div>
                        <div class="ml-3 text-sm text-blue-200">
                            {!! __('I agree to the :terms_of_service and :privacy_policy', [
                                    'terms_of_service' => '<a target="_blank" href="'.route('terms.show').'" class="underline hover:text-brgy-gold text-white font-semibold transition">'.__('Terms of Service').'</a>',
                                    'privacy_policy' => '<a target="_blank" href="'.route('policy.show').'" class="underline hover:text-brgy-gold text-white font-semibold transition">'.__('Privacy Policy').'</a>',
                            ]) !!}
                        </div>
                    </label>
                </div>
            @endif

            <!-- Register Button -->
            <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-md text-sm font-bold text-white bg-brgy-gold hover:bg-yellow-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 transform transition hover:-translate-y-0.5 mt-6">
                REGISTER
            </button>

            <!-- Already Registered Link -->
            <div class="flex items-center justify-center mt-4">
                <a class="text-sm text-blue-200 hover:text-white transition underline" href="{{ route('login') }}">
                    {{ __('Already registered? Login here') }}
                </a>
            </div>
        </form>
    </div>

    <!-- Footer -->
    <div class="relative text-blue-200/50 text-xs mt-4 pb-4">
        &copy; {{ date('Y') }} BrgyHub. All rights reserved.
    </div>

</body>
</html>