<?php

namespace App\Http\Controllers;

use App\Models\IssueReport;
use Illuminate\Http\Request;

class AdminIssueController extends Controller
{
    /**
     * Display all issue submissions for admin.
     */
    public function index() {
    $issues = IssueReport::latest()->paginate(10); // 10 per page
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
    $request->validate([
        'status' => 'required|in:Pending,In Progress,Resolved',
        'admin_remarks' => 'nullable|string|max:500',
    ]);
    $issue->status = $request->status;
    $issue->admin_remarks = $request->admin_remarks;
    $issue->save();

    return redirect()->route('admin.issues.index')->with('success', 'Issue updated successfully.');
}

}
