<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BrgyHub</title>

    <!-- Tailwind CSS -->
    @vite('resources/css/app.css')

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f1f5f9; /* light slate background */
            color: #1e293b; /* dark text */
        }
        header {
            background-color: #1e40af; /* blue */
            color: #facc15; /* yellow gold */
            padding: 1rem 2rem;
        }
        footer {
            text-align: center;
            font-size: 0.875rem;
            color: #6b7280;
            padding: 1rem;
        }
    </style>
</head>
<body class="min-h-screen flex flex-col">

    <!-- Header -->
    <header class="shadow-md rounded-b-lg">
        <div class="max-w-7xl mx-auto flex flex-col md:flex-row justify-between items-center">
            <div>
                <h1 class="text-3xl font-extrabold text-blue-900">
                    Resident <span class="text-amber-500">Hub</span>
                </h1>
                <p class="text-sm text-slate-200 mt-1">
                    Welcome back, {{ auth()->user()->name }} — Quick access to your community tools.
                </p>
            </div>
            <div class="flex items-center space-x-4 mt-4 md:mt-0">
                <span class="px-4 py-2 rounded-full bg-blue-100 text-blue-800 text-xs font-semibold uppercase tracking-wider hidden sm:inline-block">
                    Resident Access
                </span>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="flex items-center space-x-2 text-sm font-semibold text-white bg-blue-700 hover:bg-blue-800 py-2 px-4 rounded-xl shadow-lg transition">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                        </svg>
                        <span class="hidden sm:inline">Logout</span>
                    </button>
                </form>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-1 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @yield('content')
        </div>
    </main>

    <!-- Footer -->
    <footer>
        &copy; {{ date('Y') }} BrgyHub. All rights reserved.
    </footer>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Display success alert -->
    @if(session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: "{{ session('success') }}",
            showConfirmButton: false,
            timer: 1800
        });
    </script>
    @endif

</body>
</html>