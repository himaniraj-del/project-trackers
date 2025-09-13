@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center">
    <h1>Projects</h1>
     @if(auth()->user()->role === 'admin')
        <a href="{{ route('projects.create') }}" class="btn btn-success">New Project</a>
    @endif
</div>

<table class="table mt-3">
    <thead>
        <tr>
            <th>Name</th>
            <th>Tasks</th>
            <th>Overdue</th>
            @if(auth()->user()->role === 'admin')
                <th>Actions</th>
            @endif
        </tr>
    </thead>
    <tbody>
        @foreach($projects as $project)
            <tr>
                <td><a href="{{ route('projects.show', $project) }}">{{ $project->name }}</a></td>
                <td>{{ $project->tasks_count }}</td>
                <td>
                    @if($project->overdue_tasks_count > 0)
                        <span class="badge bg-danger">{{ $project->overdue_tasks_count }}</span>
                    @else
                        <span class="text-muted">0</span>
                    @endif
                </td>
                @if(auth()->user()->role === 'admin')
                    <td>
                        <a href="{{ route('projects.edit', $project) }}" class="btn btn-sm btn-outline-secondary">Edit</a>
                        <form method="POST" action="{{ route('projects.destroy', $project) }}" style="display:inline">@csrf @method('DELETE')<button class="btn btn-sm btn-danger">Delete</button></form>
                    </td>
                @endif
            </tr>
        @endforeach
    </tbody>
</table>

{{ $projects->links() }}
@endsection
