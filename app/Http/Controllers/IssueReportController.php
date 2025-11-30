<?php

namespace App\Http\Controllers;

use App\Models\IssueReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IssueReportController extends Controller
{
    // Show all reports of logged-in user
    public function index(Request $request)
{
    $reports = Auth::user()->reports()->latest()->paginate(10);
    
    // Check if redirected after successful submission
    if ($request->query('success') == '1') {
        session()->flash('success', 'Issue report submitted successfully!');
    }
    
    return view('resident.issues.index', compact('reports'));
}

    // Show form to create a new report
    public function create()
    {
        return view('resident.issues.create');
    }

    // Store a new issue report
    // IssueReportController.php (Updated store method)
public function store(Request $request)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'required|string',
        'category' => 'required|string',
        'location' => 'required|string',
        'photos.*' => 'nullable|image|mimes:jpeg,jpg,png|max:5120', 
    ]);

    $data = $request->only(['title', 'description', 'category', 'location']);
    $data['user_id'] = Auth::id();
    $data['status'] = 'Pending';

    if ($request->hasFile('photos')) {
        $uploadedPhotos = [];
        foreach ($request->file('photos') as $photo) {
            $uploadedPhotos[] = $photo->store('reports', 'public');
        }
        $data['photos'] = json_encode($uploadedPhotos);
    }

    IssueReport::create($data);

    // Just return redirect URL without showing SweetAlert
    return response()->json([
        'success' => true,
        'redirect_url' => route('resident.issues.index') . '?success=1'
    ], 200);
}



    // Admin view all reports
    public function adminIndex()
    {
        $reports = IssueReport::latest()->paginate(20);
        return view('admin.reports', compact('reports'));
    }

    // Admin update status & remarks
    public function updateStatus(Request $request, IssueReport $issueReport)
    {
        $request->validate([
            'status'        => 'required|in:Pending,In Progress,Resolved',
            'admin_remarks' => 'nullable|string|max:500',
        ]);

        $issueReport->update([
            'status'        => $request->status,
            'admin_remarks' => $request->admin_remarks,
        ]);

        return redirect()->back()->with('success', 'Report updated successfully!');
    }

    public function show($id)
{
    $report = IssueReport::where('user_id', Auth::id())->findOrFail($id);
    return view('resident.issues.show', compact('report'));
}
}
