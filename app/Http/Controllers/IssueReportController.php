<?php

namespace App\Http\Controllers;

use App\Models\IssueReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IssueReportController extends Controller
{
    // Show all reports submitted by the logged-in user
    public function index()
    {
    $reports = Auth::user()->reports()->latest()->paginate(10);
    return view('resident.issues.index', compact('reports'));
    }

    // Show form to create a new report
    public function create()
    {
        return view('resident.issues.create');
    }

    // Store a new issue report
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|string',
            'location' => 'required|string',
            'photo' => 'nullable|image|max:2048', // optional photo
        ]);

        $data = $request->only(['title','description','category','location']);
        $data['user_id'] = Auth::id();
        $data['status'] = 'Pending'; // default status

        // Handle photo upload if exists
        if($request->hasFile('photo')){
            $data['photo'] = $request->file('photo')->store('reports','public');
        }

        IssueReport::create($data);

        return redirect()->route('resident.issues.index')->with('success', 'Report submitted successfully!');

    }

    // Optional: Admin view all reports (you can also put in AdminController)
    public function adminIndex()
    {
        $reports = IssueReport::latest()->paginate(20);
        return view('admin.reports', compact('reports'));
    }

    // Optional: Admin update status & remarks
    public function updateStatus(Request $request, IssueReport $issueReport)
    {
        $request->validate([
            'status' => 'required|in:Pending,In Progress,Resolved',
            'admin_remarks' => 'nullable|string|max:500',
        ]);

        $issueReport->update([
            'status' => $request->status,
            'admin_remarks' => $request->admin_remarks,
        ]);

        return redirect()->back()->with('success', 'Report updated successfully!');
    }
}
