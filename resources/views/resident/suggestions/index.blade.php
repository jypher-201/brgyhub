<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            My Issue Reports
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-4 p-4 bg-green-200 text-green-800 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <table class="min-w-full bg-white border rounded">
                <thead>
                    <tr>
                        <th class="px-4 py-2 border">Title</th>
                        <th class="px-4 py-2 border">Category</th>
                        <th class="px-4 py-2 border">Status</th>
                        <th class="px-4 py-2 border">Admin Remarks</th>
                        <th class="px-4 py-2 border">Submitted At</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($reports as $report)
                        <tr>
                            <td class="px-4 py-2 border">{{ $report->title }}</td>
                            <td class="px-4 py-2 border">{{ $report->category }}</td>
                            <td class="px-4 py-2 border">{{ $report->status }}</td>
                            <td class="px-4 py-2 border">{{ $report->admin_remarks ?? '-' }}</td>
                            <td class="px-4 py-2 border">{{ $report->created_at->format('Y-m-d') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-2 text-center border">No reports submitted yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="mt-4">
                {{ $reports->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
