<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Http\Requests\StoreProjectRequest;
use Illuminate\Http\Request;
use App\Models\UserLog;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $projects = Project::withCount([
            'tasks',
            'tasks as overdue_tasks_count' => function ($query) {
                $query->where('due_date', '<', now())
                      ->whereIn('status', ['todo', 'in_progress']);
            }
        ])->paginate(10);
        return view('projects.index', compact('projects'));
    }

    public function create()
    {
        return view('projects.create');
    }

    public function store(StoreProjectRequest $request)
    {
        $project = Project::create($request->validated());

        // Log the project creation
        UserLog::create([
            'user_id' => Auth::id(),
            'action' => 'create_project',
            'description' => 'Created project: ' . $project->name,
            'ip_address' => $request->ip(),
        ]);

        return redirect()->route('projects.show', $project)->with('success', 'Project created.');
    }

    public function show(Project $project)
    {
        $project->load('tasks');
        return view('projects.show', compact('project'));
    }

    public function edit(Project $project)
    {
        return view('projects.edit', compact('project'));
    }

    public function update(StoreProjectRequest $request, Project $project)
    {
        $oldName = $project->name;
        $project->update($request->validated());

        // Log the project update
        UserLog::create([
            'user_id' => Auth::id(),
            'action' => 'update_project',
            'description' => 'Updated project: ' . $oldName . ' to ' . $project->name,
            'ip_address' => $request->ip(),
        ]);

        return redirect()->route('projects.show', $project)->with('success', 'Project updated.');
    }

    public function destroy(Project $project)
    {
        $projectName = $project->name;
        $project->delete();

        // Log the project deletion
        UserLog::create([
            'user_id' => Auth::id(),
            'action' => 'delete_project',
            'description' => 'Deleted project: ' . $projectName,
            'ip_address' => request()->ip(),
        ]);

        return redirect()->route('projects.index')->with('success','Project deleted.');
    }
}
