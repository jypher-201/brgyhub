<?php

namespace App\Http\Controllers;

use App\Models\IssueReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ResidentController extends Controller
{
    public function index()
    {
        $reports = IssueReport::where('user_id', Auth::id())
                    ->latest()
                    ->take(5) // or paginate if you want
                    ->get();

        return view('resident.dashboard', compact('reports')); // pass $reports to the view
    }
}
