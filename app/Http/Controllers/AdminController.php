<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\IssueReport;
use App\Models\Suggestion;

class AdminController extends Controller
{
    public function index()
    {
        // 1. --- Calculate Statistics for the Stat Cards ---

        // Counts for Issue Reports
        $totalReportsCount = IssueReport::count();
        $pendingReportsCount = IssueReport::where('status', 'Pending')->count();
        $resolvedReportsCount = IssueReport::where('status', 'Resolved')->count();
        
        // Counts for Suggestions
        $totalSuggestionsCount = Suggestion::count();
        
        // 2. --- Fetch Recent Data for Tables ---
        
        // Fetch recent issue reports (e.g., 10 latest)
        $reports = IssueReport::with('user')
                            ->latest()
                            ->take(10)
                            ->get();

        // Fetch recent suggestions (e.g., 5 latest)
        $suggestions = Suggestion::with('user')
                                ->latest()
                                ->take(5)
                                ->get();
        
        // 3. --- Return the view with all necessary data ---
        return view('admin.dashboard', [
            // Statistics data for stat cards
            'totalReportsCount' => $totalReportsCount,
            'pendingReportsCount' => $pendingReportsCount,
            'resolvedReportsCount' => $resolvedReportsCount,
            'totalSuggestionsCount' => $totalSuggestionsCount,
            
            // Table data
            'reports' => $reports, // Used for the "Recent Issue Reports" table
            'suggestions' => $suggestions, // Used for the "Recent Suggestions" table
        ]);
    }

    public function users()
    {
        $users = \App\Models\User::latest()->paginate(20);
        return view('admin.users.index', compact('users'));
    }

    public function destroyUser($id)
    {
        $user = \App\Models\User::findOrFail($id);
        
        // Prevent deleting yourself
        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot delete your own account.');
        }
        
        // Prevent deleting other admins (optional)
        if ($user->role === 'admin') {
            return back()->with('error', 'Cannot delete admin users.');
        }
        
        $user->delete();
        
        // CHANGED: Use back() to stay on the same page (preserves pagination/search)
        return back()->with('success', 'User deleted successfully.');
    }

    public function storeUser(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'role' => 'required|in:admin,resident',
            'contact_number' => 'nullable|string',
        ]);

        \App\Models\User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => $request->role,
            'contact_number' => $request->contact_number,
        ]);

        // CHANGED: Use back() to stay on the User Management page
        return back()->with('success', 'User created successfully!');
    }

    public function updateUser(Request $request, $id)
    {
        $user = \App\Models\User::findOrFail($id);

        $request->validate([
            'role' => 'required|in:admin,resident',
        ]);

        $user->update([
            'role' => $request->role,
        ]);

        // CHANGED: Use back() so it doesn't redirect you to a new URL, 
        // it just reloads the current page with the success message.
        return back()->with('success', 'User role updated successfully!');
    }
}