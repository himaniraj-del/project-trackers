<?php

namespace App\Http\Controllers;
use App\Models\UserLog;

use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'checkrole:admin']); // protect with middleware
    }

    public function index()
    {
        $logs = UserLog::with('user')->latest()->paginate(10);

        return view('admin.dashboard', compact('logs'));
    }
}
