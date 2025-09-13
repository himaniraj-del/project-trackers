<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Project;
use App\Http\Requests\StoreTaskRequest;
use Illuminate\Http\Request;
use App\Models\UserLog;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(StoreTaskRequest $request, Project $project)
    {
        $data = $request->validated();
        $data['project_id'] = $project->id;
        $task = Task::create($data);

        // Log the task creation
        UserLog::create([
            'user_id' => Auth::id(),
            'action' => 'create_task',
            'description' => 'Created task: ' . $task->title . ' in project: ' . $project->name,
            'ip_address' => $request->ip(),
        ]);

        return redirect()->route('projects.show', $project)->with('success','Task added.');
    }

    public function update(StoreTaskRequest $request, Task $task)
    {
        $oldTitle = $task->title;
        $task->update($request->validated());

        // Log the task update
        UserLog::create([
            'user_id' => Auth::id(),
            'action' => 'update_task',
            'description' => 'Updated task: ' . $oldTitle . ' to ' . $task->title,
            'ip_address' => $request->ip(),
        ]);

        return redirect()->route('projects.show', $task->project)->with('success','Task updated.');
    }

    public function destroy(Task $task)
    {
        $project = $task->project;
        $taskTitle = $task->title;
        $task->delete();

        // Log the task deletion
        UserLog::create([
            'user_id' => Auth::id(),
            'action' => 'delete_task',
            'description' => 'Deleted task: ' . $taskTitle,
            'ip_address' => request()->ip(),
        ]);

        return redirect()->route('projects.show', $project)->with('success','Task deleted.');
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'status' => 'required|in:todo,in_progress,done',
            'due_date' => 'nullable|date',
            'priority' => 'required|in:low,medium,high',
        ]);

        $task = Task::findOrFail($id);
        $oldStatus = $task->status;
        $task->update([
            'title' => $request->title,
            'status' => $request->status,
            'due_date' => $request->due_date,
            'priority' => $request->priority,
        ]);

        // Log the task status update
        UserLog::create([
            'user_id' => Auth::id(),
            'action' => 'update_task_status',
            'description' => 'Updated task status: ' . $task->title . ' from ' . $oldStatus . ' to ' . $task->status,
            'ip_address' => $request->ip(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Task updated successfully',
            'task' => $task
        ]);
    }
}
