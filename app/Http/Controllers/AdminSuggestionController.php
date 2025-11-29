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
    public function update(Request $request, $id)
    {
        $suggestion = Suggestion::findOrFail($id);

        $request->validate([
            'status' => 'required|in:pending,reviewed,responded',
            'admin_response' => 'nullable|string|max:500',
        ]);

        $suggestion->status = $request->status;
        $suggestion->admin_response = $request->admin_response;
        $suggestion->save();

        return redirect()->route('admin.suggestions.index')
                         ->with('success', 'Suggestion updated successfully.');
    }
}