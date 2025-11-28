<?php

namespace App\Http\Controllers;

use App\Models\Suggestion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SuggestionController extends Controller
{
    // Show all suggestions submitted by the logged-in user
    public function index()
    {
        $suggestions = Auth::user()->suggestions()->latest()->paginate(10);
        return view('resident.suggestions.index', compact('suggestions'));
    }

    // Show form to create a new suggestion
    public function create()
    {
        return view('resident.suggestions.create');
    }

    // Store a new suggestion
    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        Suggestion::create([
            'user_id' => Auth::id(),
            'content' => $request->content,
        ]);

        return redirect()->route('resident.suggestions.index')->with('success', 'Suggestion submitted successfully!');
    }

    // Optional: Admin view all suggestions
    public function adminIndex()
    {
        $suggestions = Suggestion::latest()->paginate(20);
        return view('admin.suggestions', compact('suggestions'));
    }

    // Optional: Admin respond to suggestion
    public function respond(Request $request, Suggestion $suggestion)
    {
        $request->validate([
            'admin_response' => 'required|string|max:500',
        ]);

        $suggestion->update([
            'admin_response' => $request->admin_response,
        ]);

        return redirect()->back()->with('success', 'Response submitted successfully!');
    }
}
