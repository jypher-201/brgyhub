<?php

namespace App\Http\Controllers;

use App\Models\Suggestion;
use Illuminate\Http\Request;
use App\Models\Notification; // Added Notification model

class AdminSuggestionController extends Controller
{
    /**
     * Display all resident suggestions, applying real-time filtering based on query parameters.
     */
    public function index(Request $request) // Must accept Request object
    {
        // Start building the query with user relationship
        $query = Suggestion::with('user');

        // Filter by Status (Suggestions typically use Pending, Reviewed, Responded)
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Search by Title or Content (Real-time search uses these fields)
        if ($request->filled('search')) {
            $search = '%' . $request->search . '%';
            $query->where(function ($q) use ($search) {
                // Search in both the suggestion title and the content
                $q->where('title', 'like', $search)
                  ->orWhere('content', 'like', $search);
            });
        }

        // Apply ordering and pagination
        $suggestions = $query->latest()->paginate(10); // 10 per page
        
        // Ensure pagination links carry the current filter parameters
        $suggestions->appends($request->all());

        // Pass the paginated results to the view
        return view('admin.suggestions.index', compact('suggestions'));
    }

    /**
     * Show a specific suggestion.
     */
    public function show($id)
    {
        $suggestion = Suggestion::findOrFail($id);
        return view('admin.suggestions.show', compact('suggestion'));
    }

    /**
     * Show form to edit a suggestion.
     */
    public function edit($id)
    {
        $suggestion = Suggestion::findOrFail($id);
        return view('admin.suggestions.edit', compact('suggestion'));
    }

    /**
    * Update suggestion with admin response and status.
    */
    public function update(Request $request, $id)
    {
        $suggestion = Suggestion::findOrFail($id);
        
        // Store old values to check what changed
        $oldStatus = $suggestion->status;
        $hadResponse = !empty($suggestion->admin_response);

        $request->validate([
            'status' => 'required|in:pending,reviewed,responded',
            'admin_response' => 'nullable|string|max:500',
        ]);

        $suggestion->status = $request->status;
        $suggestion->admin_response = $request->admin_response;
        $suggestion->save();

        // Create notification if status changed OR admin added a response
        $statusChanged = ($oldStatus !== $suggestion->status);
        $newResponse = (!$hadResponse && !empty($request->admin_response));
        
        if ($statusChanged || $newResponse) {
            // Determine the notification message
            if ($newResponse) {
                $message = "Admin has responded to your suggestion: \"" . \Illuminate\Support\Str::limit($suggestion->content, 50) . "\"";
            } else {
                $message = "Your suggestion status has been updated from " . ucfirst($oldStatus) . " to " . ucfirst($suggestion->status) . ".";
            }
            
            Notification::create([
                'user_id' => $suggestion->user_id,
                'report_id' => null,
                'suggestion_id' => $suggestion->id,
                'message' => $message,
                'status' => 'Unread',
            ]);
        }

        return redirect()->route('admin.suggestions.index')
                         ->with('success', 'Suggestion updated successfully.');
    }
}