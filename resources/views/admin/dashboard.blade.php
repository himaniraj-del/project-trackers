@extends('layouts.app')

@section('content')

<div class="container">
    <h2>Admin Dashboard - User Logs</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>User</th>
                <th>Action</th>
                <th>Description</th>
                <th>IP Address</th>
                <th>Time</th>
            </tr>
        </thead>
        <tbody>
            @foreach($logs as $log)
            <tr>
                <td>{{ $log->user->name ?? 'Deleted User' }}</td>
                <td>{{ $log->action }}</td>
                <td>{{ $log->description }}</td>
                <td>{{ $log->ip_address }}</td>
                <td>{{ $log->created_at->format('d-m-Y H:i:s') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Pagination -->
    <div class="d-flex justify-content-center">
        {{ $logs->links() }}
    </div>
</div>

@endsection
