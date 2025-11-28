<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\IssueReport;
use App\Models\Suggestion; // Assuming you have a Suggestion model

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
}