<?php

namespace App\Http\Controllers;

use App\Models\Suggestion;
use Illuminate\Http\Request;

class AdminSuggestionController extends Controller
{
    /**
     * Display all suggestions for admin.
     */
    public function index()
    {
        // Use paginate instead of get()
        $suggestions = Suggestion::latest()->paginate(10); // 10 per page
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
     * Show form to respond to a suggestion.
     */
    public function edit($id)
    {
        $suggestion = Suggestion::findOrFail($id);
        return view('admin.suggestions.edit', compact('suggestion'));
    }

    /**
     * Save admin response to a suggestion.
     */
    public function respond(Request $request, $id)
    {
        $suggestion = Suggestion::findOrFail($id);

        $request->validate([
            'admin_response' => 'required|string|max:500',
        ]);

        $suggestion->admin_response = $request->admin_response;
        $suggestion->save();

        return redirect()->route('admin.suggestions.index')
                         ->with('success', 'Response saved successfully.');
    }
}

