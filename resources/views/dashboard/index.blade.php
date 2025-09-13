@extends('layouts.app')

@section('content')
<h1>Dashboard</h1>
<div class="row">
    <div class="col-md-4">
        <div class="card p-3">
            <h5>Total Projects</h5>
            <h2>{{ $totalProjects }}</h2>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card p-3">
            <h5>Pending Tasks</h5>
            <h2>{{ $pendingTasks }}</h2>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card p-3">
            <h5>Overdue Tasks</h5>
            <h2>{{ $overdueTasks }}</h2>
        </div>
    </div>
    {{-- <div class="col-md-3">
        <div class="card p-3 border-danger">
            <h5 class="text-danger">Flagged Overdue</h5>
            <h2 class="text-danger">{{ $flaggedOverdueTasks }}</h2>
        </div>
    </div> --}}
</div>

<div class="mt-4">
    <a href="{{ route('projects.index') }}" class="btn btn-primary">View Projects</a>
</div>
@endsection
