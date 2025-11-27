<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\IssueReport;

class AdminController extends Controller
{
    public function index()
    {
        // Fetch all issue reports for admin dashboard
        $reports = IssueReport::with('user')
                    ->latest()
                    ->take(10)
                    ->get();

        return view('admin.dashboard', compact('reports'));
    }
}
