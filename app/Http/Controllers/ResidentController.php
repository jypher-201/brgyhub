<?php

namespace App\Http\Controllers;

use App\Models\IssueReport;
use App\Models\Suggestion; // Ensure this is imported
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ResidentController extends Controller
{
    public function index()
    {
        $userId = Auth::id();
        
        // 1. Fetch Issue Reports
        $reports = IssueReport::where('user_id', $userId)
                             ->latest()
                             ->take(5)
                             ->get();

        // 2. Fetch Suggestions (FIXED: Added this missing logic)
        $suggestions = Suggestion::where('user_id', $userId)
                                 ->latest()
                                 ->take(5) // Limit to match reports, adjust as needed
                                 ->get();
        
        // Get unread notifications
        $notifications = Notification::where('user_id', $userId)
            ->where('status', 'Unread')
            ->latest()
            ->get();
        
        $unreadCount = $notifications->count();

        // 3. Pass both 'reports' AND 'suggestions' to the view (FIXED)
        return view('resident.dashboard', compact('reports', 'suggestions', 'notifications', 'unreadCount'));
    }

    public function notifications()
    {
        $notifications = Notification::where('user_id', Auth::id())
            ->latest()
            ->paginate(20);
        
        return view('resident.notifications', compact('notifications'));
    }

    public function markAsRead($id)
    {
        $notification = Notification::where('user_id', Auth::id())
            ->findOrFail($id);
        
        $notification->update(['status' => 'Read']);
        
        // Redirect based on notification type
        if ($notification->report_id) {
            return redirect()->route('resident.issues.index');
        } else {
            return redirect()->route('resident.suggestions.index');
        }
    }

    public function markAllAsRead()
    {
        Notification::where('user_id', Auth::id())
            ->where('status', 'Unread')
            ->update(['status' => 'Read']);
        
        return back()->with('success', 'All notifications marked as read.');
    }
}