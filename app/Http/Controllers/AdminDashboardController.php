<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\IssueReport;
use Illuminate\Http\Request;

class AdminIssueController extends Controller
{
    public function index(Request $request)
    {
        $query = IssueReport::with('user');

        // Filtering
        if ($request->status) {
            $query->where('status', $request->status);
        }

        if ($request->category) {
            $query->where('category', $request->category);
        }

        if ($request->search) {
            $query->where('title', 'like', '%'.$request->search.'%');
        }

        $reports = $query->latest()->paginate(10);

        return view('admin.issues.index', compact('reports'));
    }

    public function show($id)
    {
        $report = IssueReport::with('user')->findOrFail($id);
        return view('admin.issues.show', compact('report'));
    }

    public function updateStatus(Request $request, $id)
    {
        $report = IssueReport::findOrFail($id);

        $report->status = $request->status;
        $report->remarks = $request->remarks;
        $report->save();

        return back()->with('success', 'Issue updated successfully!');
    }
}
