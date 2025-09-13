<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Project Tracker</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container">
    <a class="navbar-brand" href="{{ route('dashboard') }}" style="color: blue;">Project Tracker</a>
    @auth
    @if(auth()->user()->role === 'admin')
        <a class="navbar-brand" href="{{ route('admin.dashboard') }}" style="color: blue;">Admin Dashboard</a>
    @endif
    @endauth
    <div>
      @auth
        <a href="#" class="me-2">{{ auth()->user()->name }}</a>
        <form method="POST" action="{{ route('logout') }}" style="display:inline">@csrf<button class="btn btn-sm btn-outline-secondary">Logout</button></form>
      @endauth
      @guest
        <a href="/login" class="btn btn-sm btn-primary">Login</a>
      @endguest
    </div>
  </div>
</nav>
<div class="container mt-4">
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @yield('content')
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
