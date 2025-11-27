@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>My Issue Reports</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('resident.issues.create') }}" class="btn btn-primary mb-3">Submit New Report</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Title</th>
                <th>Category</th>
                <th>Status</th>
                <th>Admin Remarks</th>
                <th>Submitted At</th>
            </tr>
        </thead>
        <tbody>
            @forelse($reports as $report)
            <tr>
                <td>{{ $report->title }}</td>
                <td>{{ $report->category }}</td>
                <td>{{ $report->status }}</td>
                <td>{{ $report->admin_remarks ?? '-' }}</td>
                <td>{{ $report->created_at->format('M d, Y H:i') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center">No reports submitted yet.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    {{ $reports->links() }} <!-- Pagination links -->
</div>
@endsection
