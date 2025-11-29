<?php

namespace App\Http\Controllers;

use App\Models\Suggestion;
use Illuminate\Http\Request;
use App\Models\Notification;

class AdminSuggestionController extends Controller
{
    /**
     * Display all suggestions for admin.
     */
    public function index()
    {
        $suggestions = Suggestion::latest()->paginate(10);
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