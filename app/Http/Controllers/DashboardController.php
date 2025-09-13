<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalProjects = Project::count();
        $pendingTasks = Task::where('status','!=','done')->count();
        $overdueTasks = Task::where('due_date','<',now())->where('status','!=','done')->count();
        $flaggedOverdueTasks = Task::flaggedOverdue()->count();

        return view('dashboard.index', compact('totalProjects','pendingTasks','overdueTasks','flaggedOverdueTasks'));
    }
}
