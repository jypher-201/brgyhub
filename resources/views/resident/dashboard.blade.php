<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resident Action Center</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        blue: {
                            50: '#eff6ff', 100: '#dbeafe', 500: '#3b82f6', 600: '#2563eb',
                            700: '#1d4ed8', 800: '#1e40af', 900: '#1e3a8a',
                        },
                        amber: {
                            50: '#fffbeb', 100: '#fef3c7', 400: '#fbbf24', 500: '#f59e0b',
                            600: '#d97706', 700: '#b45309',
                        },
                        slate: {
                            50: '#f8fafc', 100: '#f1f5f9', 200: '#e2e8f0', 300: '#cbd5e1',
                            400: '#94a3b8', 500: '#64748b', 600: '#475569', 700: '#334155',
                            800: '#1e293b', 900: '#0f172a',
                        }
                    },
                    fontFamily: {
                        sans: ['Inter', 'system-ui', 'sans-serif'],
                    },
                }
            }
        }
    </script>

    <style>
        body { font-family: 'Inter', sans-serif; }
        .card-hover { transition: all 0.3s ease; }
        .card-hover:hover { transform: translateY(-5px); }
        .gradient-blue { background: linear-gradient(135deg, #1e40af 0%, #1e3a8a 100%); }
        .gradient-amber { background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); }
    </style>
</head>

<body class="bg-slate-50 min-h-screen">

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

        {{-- HEADER --}}
        <header class="mb-12 border-b border-slate-200 pb-6">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-3xl font-bold text-slate-800">
                        BrgyHub <span class="text-blue-700">Report Center</span>
                    </h1>
                    <p class="text-slate-500 mt-1">
                        Welcome back, {{ auth()->user()->name }}
                    </p>
                </div>

                {{-- NAVIGATION BUTTONS --}}
                <div class="flex items-center gap-3">
                    
                    {{-- Issue Reports Direct Link --}}
                    <a href="{{ route('resident.issues.index') }}" 
                       class="inline-flex justify-center rounded-full border-2 border-transparent shadow-sm p-2 bg-white text-sm font-medium text-slate-700 hover:bg-slate-100 transition-colors hover:text-blue-600"
                       title="View Issue Reports">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                        </svg>
                    </a>

                    {{-- Suggestions Direct Link --}}
                    <a href="{{ route('resident.suggestions.index') }}" 
                       class="inline-flex justify-center rounded-full border-2 border-transparent shadow-sm p-2 bg-white text-sm font-medium text-slate-700 hover:bg-slate-100 transition-colors hover:text-amber-600"
                       title="View Suggestions">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                        </svg>
                    </a>

                    {{-- Notifications Direct Link --}}
                    <a href="{{ route('resident.notifications.index') }}" 
                       class="relative inline-flex justify-center rounded-full border-2 border-transparent shadow-sm p-2 bg-white text-sm font-medium text-slate-700 hover:bg-slate-100 transition-colors hover:text-blue-600"
                       title="Notifications">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>
                        
                        {{-- Red Dot Notification Badge --}}
                        @if(isset($unreadCount) && $unreadCount > 0)
                            <span class="absolute top-0 right-0 block h-3 w-3 rounded-full bg-red-500 border-2 border-white"></span>
                        @endif
                    </a>

                    {{-- Profile Dropdown (Only for Profile/Logout) --}}
                    <div class="relative inline-block text-left" x-data="{ open: false }">
                        <button @click="open = !open" 
                                class="inline-flex justify-center w-full rounded-full border-2 border-transparent shadow-sm p-2 bg-white text-sm font-medium text-slate-700 hover:bg-slate-100 transition-colors"
                                title="Profile Menu">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </button>

                        <div x-show="open" @click.away="open = false"
                             x-transition
                             class="origin-top-right absolute right-0 mt-2 w-56 rounded-lg shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-10">
                            <div class="py-1">
                                <div class="px-4 py-3 border-b border-slate-100">
                                    <p class="text-sm font-medium text-slate-800">{{ auth()->user()->name }}</p>
                                    <p class="text-xs text-slate-500">{{ auth()->user()->email }}</p>
                                </div>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit"
                                            class="flex items-center w-full text-left px-4 py-2 text-sm text-slate-700 hover:bg-slate-50 hover:text-red-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                        </svg>
                                        Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        {{-- MAIN BUTTON GRID --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

            {{-- REPORT --}}
            <div class="gradient-blue rounded-xl shadow-lg card-hover overflow-hidden">
                <div class="p-8 flex flex-col justify-between h-full">
                    <div>
                        <div class="h-14 w-14 bg-white/20 rounded-full flex items-center justify-center mb-4 backdrop-blur-sm border border-white/30">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>

                        <h3 class="text-2xl font-bold text-white mb-3">Report an Issue</h3>
                        <p class="text-blue-100 text-sm">
                            Spot a maintenance issue or urgent concern? Submit a detailed report immediately.
                        </p>
                    </div>

                    <a href="{{ route('resident.issues.create') }}"
                       class="mt-8 w-full text-center bg-white text-blue-700 font-semibold py-3 px-4 rounded-lg hover:bg-blue-50 transition-colors shadow-lg shadow-blue-900/50">
                        Submit New Report
                    </a>
                </div>
            </div>

            {{-- SUGGESTION --}}
            <div class="bg-white rounded-xl shadow-lg card-hover overflow-hidden border border-slate-100">
                <div class="p-8 flex flex-col justify-between h-full">
                    <div>
                        <div class="h-14 w-14 bg-amber-100 rounded-full flex items-center justify-center mb-4 border border-amber-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                            </svg>
                        </div>

                        <h3 class="text-2xl font-bold text-slate-800 mb-3">Make a Suggestion</h3>
                        <p class="text-slate-600 text-sm">
                            Have an idea to improve the community? Share your thoughts and suggestions with us.
                        </p>
                    </div>

                    <a href="{{ route('resident.suggestions.create') }}"
                       class="mt-8 w-full text-center gradient-amber text-white font-semibold py-3 px-4 rounded-lg hover:opacity-90 transition-opacity shadow-lg shadow-amber-600/50">
                        Share Idea
                    </a>
                </div>
            </div>

        </div>

        {{-- ACTIVITY HISTORY LOGIC --}}
        @php
            if (!isset($reports)) $reports = collect();
            if (!isset($suggestions)) $suggestions = collect();

            $allActivities = $reports->merge($suggestions);
            $sortedActivities = $allActivities->sortByDesc('created_at');
        @endphp
        
        {{-- ACTIVITY HISTORY TABLE --}}
        <div class="mt-12">
            <h2 class="text-xl font-semibold text-slate-700 border-l-4 border-amber-500 pl-3 mb-6">
                Activity History
            </h2>

            <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-slate-100">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-slate-200 bg-slate-50">
                                <th class="text-left py-3 px-6 text-slate-600 text-sm">Type</th>
                                <th class="text-left py-3 px-6 text-slate-600 text-sm">Title</th>
                                <th class="text-left py-3 px-6 text-slate-600 text-sm">Status</th>
                                <th class="text-left py-3 px-6 text-slate-600 text-sm">Date</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($sortedActivities as $activity)
                                @php
                                    $isReport = $activity instanceof \App\Models\IssueReport;
                                    $isSuggestion = $activity instanceof \App\Models\Suggestion;

                                    $categoryOrType = $isReport ? $activity->category : 'Suggestion';
                                    $status = $activity->status ?? 'Pending';
                                    
                                    $statusClass = 'bg-gray-100 text-gray-800'; 
                                    
                                    if ($isReport) {
                                        if ($status == 'Resolved') {
                                            $statusClass = 'bg-green-100 text-green-800';
                                        } elseif ($status == 'In Progress') {
                                            $statusClass = 'bg-amber-100 text-amber-800';
                                        } else { 
                                            $statusClass = 'bg-blue-100 text-blue-800';
                                        }
                                    } elseif ($isSuggestion) {
                                        if ($status == 'Reviewed' || $status == 'Implemented') {
                                            $statusClass = 'bg-green-100 text-green-800';
                                        } else { 
                                            $statusClass = 'bg-amber-100 text-amber-800';
                                        }
                                    }

                                    $link = $isReport ? route('resident.issues.show', $activity->id) : route('resident.suggestions.show', $activity->id);
                                @endphp
                                <tr class="border-b border-slate-100 hover:bg-blue-50/50 cursor-pointer" onclick="window.location='{{ $link }}'">
                                    <td class="py-4 px-6">
                                        <span class="px-2.5 py-0.5 rounded-full text-xs font-medium {{ $isReport ? 'bg-blue-100 text-blue-800' : 'bg-amber-100 text-amber-700' }}">
                                            {{ $categoryOrType }}
                                        </span>
                                    </td>
                                    <td class="py-4 px-6 text-slate-700 font-medium">{{ $activity->title }}</td>
                                    <td class="py-4 px-6">
                                        <span class="px-2.5 py-0.5 rounded-full text-xs font-medium {{ $statusClass }}">
                                            {{ $status }}
                                        </span>
                                    </td>
                                    <td class="py-4 px-6 text-slate-500 text-sm">{{ $activity->created_at->diffForHumans() }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="py-4 px-6 text-center text-slate-500">No activity yet.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    @if(session('success'))
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: '{{ session("success") }}',
            timer: 2000,
            showConfirmButton: false,
            width: '400px',
            padding: '1.5rem',
            customClass: {
                popup: 'swal-compact',
                title: 'swal-title-compact',
                htmlContainer: 'swal-text-compact'
            }
        });
    </script>
    <style>
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
    @endif

</body>
</html>