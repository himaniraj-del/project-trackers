@extends('layouts.app')
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
@section('content')

<h1>{{ $project->name }}</h1>
<div class="d-flex justify-content-between align-items-center">
<p>{{ $project->description }}</p>
<a href="{{ route('projects.index') }}" class="btn btn-success">view Project</a>
</div>

<h4>Tasks</h4>
<table class="table">
<thead>
    <tr>
        <th>Title</th>
        <th>Status</th>
        <th>Due</th>
        <th>Priority</th>
        <th>Actions</th>
    </tr>
</thead>
<tbody>
    @foreach($project->tasks as $task)
        <tr @if($task->is_flagged_overdue) class="table-danger" @elseif($task->due_date && $task->due_date < now()) class="table-warning" @endif>
            <td>
                {{ $task->title }}
                @if($task->is_flagged_overdue)
                    <span class="badge bg-danger ms-2">OVERDUE</span>
                @endif
            </td>
            <td>{{ ucfirst(str_replace('_',' ', $task->status)) }}</td>
            <td>{{ $task->due_date ? \Carbon\Carbon::parse($task->due_date)->format('Y-m-d') : '' }}</td>

            <td>{{ ucfirst($task->priority) }}</td>
           <td>
                <!-- Edit Icon -->
                <a href="#" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editTaskModal{{ $task->id }}">
                    <i class="bi bi-pencil-square"></i>
                </a>

                <!-- Delete Icon -->
                <form method="POST" action="{{ route('tasks.destroy', $task) }}" style="display:inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-outline-danger">
                        <i class="bi bi-trash"></i>
                    </button>
                </form>
            </td>
        </tr>

        <!-- Edit Modal (inside loop!) -->
        <div class="modal fade" id="editTaskModal{{ $task->id }}" tabindex="-1" aria-labelledby="editTaskLabel{{ $task->id }}" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="editTaskLabel{{ $task->id }}">Edit Task</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <div class="mb-3">
                    <label for="taskTitle{{ $task->id }}" class="form-label">Title</label>
                    <input type="text" class="form-control" id="taskTitle{{ $task->id }}" value="{{ $task->title }}">
                  </div>
                  <div class="mb-3">
                    <label for="status{{ $task->id }}" class="form-label">Status</label>
                    <select class="form-select" id="status{{ $task->id }}">
                      <option value="todo" {{ $task->status == 'todo' ? 'selected' : '' }}>To Do</option>
                      <option value="in_progress" {{ $task->status == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                      <option value="done" {{ $task->status == 'done' ? 'selected' : '' }}>Done</option>
                    </select>
                  </div>
                  <div class="mb-3">
                    <label for="dueDate{{ $task->id }}" class="form-label">Due Date</label>
                    <input type="date" class="form-control" id="dueDate{{ $task->id }}" value="{{ $task->due_date ? \Carbon\Carbon::parse($task->due_date)->format('Y-m-d') : '' }}">
                  </div>
                  <div class="mb-3">
                    <label for="priority{{ $task->id }}" class="form-label">Priority</label>
                    <select class="form-select" id="priority{{ $task->id }}">
                      <option value="low" {{ $task->priority == 'low' ? 'selected' : '' }}>Low</option>
                      <option value="medium" {{ $task->priority == 'medium' ? 'selected' : '' }}>Medium</option>
                      <option value="high" {{ $task->priority == 'high' ? 'selected' : '' }}>High</option>
                    </select>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                  <button type="button" class="btn btn-success saveTaskBtn" data-id="{{ $task->id }}">Save Changes</button>
                </div>
            </div>
          </div>
        </div>
    @endforeach
</tbody>
</table>

<h5>Add Task</h5>
<form method="POST" action="{{ route('projects.tasks.store', $project) }}">
    @csrf
    <div class="row">
        <div class="col-md-4 mb-2">
            <input name="title" placeholder="Task title" class="form-control">
        </div>
        <div class="col-md-2 mb-2">
            <select name="status" class="form-select">
                <option value="todo">To Do</option>
                <option value="in_progress">In Progress</option>
                <option value="done">Done</option>
            </select>
        </div>
        <div class="col-md-2 mb-2">
            <input type="date" name="due_date" class="form-control">
        </div>
        <div class="col-md-2 mb-2">
            <select name="priority" class="form-select">
                <option value="low">Low</option>
                <option value="medium" selected>Medium</option>
                <option value="high">High</option>
            </select>
        </div>
        <div class="col-md-2 mb-2">
            <button class="btn btn-primary">Add</button>
        </div>
    </div>
</form>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).on('click', '.saveTaskBtn', function () {
    let taskId = $(this).data('id');
    let title = $('#taskTitle' + taskId).val();
    let status = $('#status' + taskId).val();
    let dueDate = $('#dueDate' + taskId).val();
    let priority = $('#priority' + taskId).val();

    $.ajax({
        url: '/tasks/' + taskId + '/status',   // Use the updateStatus route
        type: 'POST',
        data: {
            _token: '{{ csrf_token() }}',
            title: title,
            status: status,
            due_date: dueDate,
            priority: priority
        },
        success: function (response) {
            // Close modal
            $('#editTaskModal' + taskId).modal('hide');

            // Reload the page to show updated status
            location.reload();
        },
        error: function (xhr) {
            alert('Something went wrong ❌');
        }
    });
});
</script>


@endsection
