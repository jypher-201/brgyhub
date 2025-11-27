@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Submit Suggestion / Feedback</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('resident.suggestions.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="content" class="form-label">Suggestion</label>
            <textarea name="content" class="form-control" rows="5" required>{{ old('content') }}</textarea>
            @error('content') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <button type="submit" class="btn btn-primary">Submit Suggestion</button>
        <a href="{{ route('resident.suggestions') }}" class="btn btn-secondary">Back to My Suggestions</a>
    </form>
</div>
@endsection
