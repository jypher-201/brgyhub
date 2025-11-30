<?php

namespace App\Http\Controllers;

use App\Models\IssueReport;
use App\Models\Notification;
use Illuminate\Http\Request;

class AdminIssueController extends Controller
{
    /**
     * Display all issue submissions for admin, with real-time filtering capabilities.
     */
    public function index(Request $request)
    {
        // Start building the query with user relationship
        $query = IssueReport::with('user');

        // Filter by Category
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        // Filter by Status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Search by Title or Location (Real-time search uses these fields)
        if ($request->filled('search')) {
            $search = '%' . $request->search . '%';
            $query->where(function ($q) use ($search) {
                // Search in both the issue title and the reported location
                $q->where('title', 'like', $search)
                  ->orWhere('location', 'like', $search);
            });
        }

        // Apply ordering and pagination
        $issues = $query->latest()->paginate(10); // 10 per page
        
        // Pass the paginated results to the view
        return view('admin.issues.index', compact('issues'));
    }

    public function show($id) {
        $issue = IssueReport::findOrFail($id);
        return view('admin.issues.show', compact('issue'));
    }

    public function edit($id) {
        $issue = IssueReport::findOrFail($id);
        return view('admin.issues.edit', compact('issue'));
    }

    public function update(Request $request, $id) {
        $issue = IssueReport::findOrFail($id);
        
        // Store old status to check if it changed
        $oldStatus = $issue->status;
        
        $request->validate([
            'status' => 'required|in:Pending,In Progress,Resolved',
            'admin_remarks' => 'nullable|string|max:500',
        ]);
        
        $issue->status = $request->status;
        $issue->admin_remarks = $request->admin_remarks;
        $issue->save();

        // Create notification if status changed
        if ($oldStatus !== $issue->status) {
            Notification::create([
                'user_id' => $issue->user_id,
                'report_id' => $issue->id,
                'message' => "Your issue report '{$issue->title}' status has been updated from {$oldStatus} to {$issue->status}.",
                'status' => 'Unread',
            ]);
        }

        return redirect()->route('admin.issues.index')->with('success', 'Issue updated successfully.');
    }
}