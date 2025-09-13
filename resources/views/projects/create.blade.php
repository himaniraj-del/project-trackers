@extends('layouts.app')
@section('content')
<h1>Create Project</h1>
<form method="POST" action="{{ route('projects.store') }}">
    @csrf
    <div class="mb-3">
        <label class="form-label">Name</label>
        <input name="name" class="form-control" value="{{ old('name') }}">
        @error('name')<div class="text-danger">{{ $message }}</div>@enderror
    </div>
    <div class="mb-3">
        <label class="form-label">Description</label>
        <textarea name="description" class="form-control">{{ old('description') }}</textarea>
    </div>
    <button class="btn btn-primary">Create</button>
</form>
@endsection
