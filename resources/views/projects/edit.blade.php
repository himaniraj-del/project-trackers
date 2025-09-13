@extends('layouts.app')
@section('content')
<h1>Edit Project</h1>
<form method="POST" action="{{ route('projects.update', $project) }}">
    @csrf @method('PUT')
    <div class="mb-3">
        <label class="form-label">Name</label>
        <input name="name" class="form-control" value="{{ old('name', $project->name) }}">
        @error('name')<div class="text-danger">{{ $message }}</div>@enderror
    </div>
    <div class="mb-3">
        <label class="form-label">Description</label>
        <textarea name="description" class="form-control">{{ old('description', $project->description) }}</textarea>
    </div>
    <button class="btn btn-primary">Update</button>
</form>
@endsection
