<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ResidentController extends Controller
{
    public function index()
    {
        return view('resident.dashboard'); // create this Blade view
    }
}
