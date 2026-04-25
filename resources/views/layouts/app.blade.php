<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Salon Manager') }} - @yield('title', 'Dashboard')</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background: #f5f5f5; color: #333; }
        .navbar {
            background: #6b3fa0; color: white; padding: 12px 24px;
            display: flex; justify-content: space-between; align-items: center;
        }
        .navbar a { color: white; text-decoration: none; font-weight: bold; font-size: 18px; }
        .nav-links { display: flex; gap: 20px; align-items: center; }
        .nav-links a {
            color: #e0d0f5; text-decoration: none; padding: 6px 12px;
            border-radius: 4px; font-size: 14px;
        }
        .nav-links a:hover, .nav-links a.active { background: rgba(255,255,255,0.2); color: white; }
        .nav-links form button {
            background: rgba(255,255,255,0.15); color: #e0d0f5; border: none;
            padding: 6px 12px; border-radius: 4px; cursor: pointer; font-size: 14px;
        }
        .nav-links form button:hover { background: rgba(255,255,255,0.3); color: white; }
        .container { max-width: 1100px; margin: 24px auto; padding: 0 16px; }
        .card { background: white; border-radius: 6px; box-shadow: 0 1px 4px rgba(0,0,0,0.1); padding: 24px; margin-bottom: 20px; }
        .card-title { font-size: 18px; font-weight: bold; margin-bottom: 16px; color: #6b3fa0; border-bottom: 2px solid #f0e6ff; padding-bottom: 8px; }
        .btn { display: inline-block; padding: 8px 16px; border-radius: 4px; font-size: 14px; cursor: pointer; text-decoration: none; border: none; }
        .btn-primary { background: #6b3fa0; color: white; }
        .btn-primary:hover { background: #5a3490; }
        .btn-success { background: #28a745; color: white; }
        .btn-success:hover { background: #218838; }
        .btn-danger { background: #dc3545; color: white; }
        .btn-danger:hover { background: #c82333; }
        .btn-warning { background: #ffc107; color: #212529; }
        .btn-warning:hover { background: #e0a800; }
        .btn-secondary { background: #6c757d; color: white; }
        .btn-secondary:hover { background: #5a6268; }
        .btn-sm { padding: 4px 10px; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; font-size: 14px; }
        table th { background: #f8f0ff; color: #6b3fa0; padding: 10px 12px; text-align: left; font-weight: bold; border-bottom: 2px solid #e0d0f5; }
        table td { padding: 10px 12px; border-bottom: 1px solid #eee; vertical-align: middle; }
        table tr:hover td { background: #fdf8ff; }
        .badge { display: inline-block; padding: 3px 10px; border-radius: 12px; font-size: 12px; font-weight: bold; }
        .badge-success { background: #d4edda; color: #155724; }
        .badge-danger { background: #f8d7da; color: #721c24; }
        .badge-warning { background: #fff3cd; color: #856404; }
        .badge-info { background: #d1ecf1; color: #0c5460; }
        .form-group { margin-bottom: 16px; }
        .form-group label { display: block; margin-bottom: 4px; font-size: 14px; font-weight: bold; color: #555; }
        .form-control { width: 100%; padding: 8px 12px; border: 1px solid #ccc; border-radius: 4px; font-size: 14px; }
        .form-control:focus { outline: none; border-color: #6b3fa0; box-shadow: 0 0 0 2px rgba(107,63,160,0.15); }
        .form-row { display: flex; gap: 16px; }
        .form-row .form-group { flex: 1; }
        .alert { padding: 10px 16px; border-radius: 4px; margin-bottom: 16px; font-size: 14px; }
        .alert-success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .alert-danger { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        .stat-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px; margin-bottom: 24px; }
        .stat-card { background: white; border-radius: 6px; padding: 20px; box-shadow: 0 1px 4px rgba(0,0,0,0.1); text-align: center; }
        .stat-card .number { font-size: 32px; font-weight: bold; color: #6b3fa0; }
        .stat-card .label { font-size: 13px; color: #888; margin-top: 4px; }
        .action-bar { display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px; }
        .errors { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; border-radius: 4px; padding: 10px 16px; margin-bottom: 16px; font-size: 13px; }
        .errors ul { margin-left: 16px; }
        @media(max-width:768px) { .stat-grid { grid-template-columns: repeat(2,1fr); } .form-row { flex-direction: column; } }
    </style>
</head>
<body>
    @auth
    <nav class="navbar">
        <a href="{{ route('dashboard') }}">💅 Salon Manager</a>
        <div class="nav-links">
            <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">Dashboard</a>
            <a href="{{ route('services.index') }}" class="{{ request()->routeIs('services.*') ? 'active' : '' }}">Services</a>
            <a href="{{ route('appointments.index') }}" class="{{ request()->routeIs('appointments.*') ? 'active' : '' }}">Appointments</a>
            <a href="{{ route('payments.index') }}" class="{{ request()->routeIs('payments.*') ? 'active' : '' }}">Payments</a>
            <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                @csrf
                <button type="submit">Logout ({{ Auth::user()->name }})</button>
            </form>
        </div>
    </nav>
    @endauth

    <div class="container">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        @yield('content')
    </div>
</body>
</html>
