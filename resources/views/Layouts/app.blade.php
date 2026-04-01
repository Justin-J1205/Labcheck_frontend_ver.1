<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>LAB-CHECK</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            display: flex;
            margin: 0;
            background: #f8fafc;
            color: #334155;
        }

        .sidebar {
            width: 240px;
            background: white;
            height: 100vh;
            border-right: 1px solid #e2e8f0;
            padding: 25px;
            position: fixed;
        }

        .main-wrapper {
            margin-left: 290px;
            flex: 1;
            padding: 40px;
            min-height: 100vh;
        }

        .logo {
            color: #0d9488;
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 40px;
        }

        .nav-link {
            display: block;
            padding: 12px;
            color: #64748b;
            text-decoration: none;
            border-radius: 8px;
            margin-bottom: 5px;
            transition: all 0.2s;
        }

        .nav-link:hover,
        .nav-link.active {
            background: #f1f5f9;
            color: #0d9488;
            font-weight: 600;
        }

        .staff-label {
            font-size: 11px;
            color: #94a3b8;
            font-weight: bold;
            margin: 20px 0 10px 12px;
            text-transform: uppercase;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .search-form {
            position: relative;
        }

        .search {
            padding: 10px 20px;
            width: 300px;
            border-radius: 25px;
            border: 1px solid #e2e8f0;
            outline: none;
        }

        .search:focus {
            border-color: #0d9488;
        }

        .btn-logout {
            color: #ef4444;
            border: none;
            background: none;
            cursor: pointer;
            padding: 12px;
            font-weight: bold;
            width: 100%;
            text-align: left;
            font-family: inherit;
            font-size: 16px;
        }

        .btn-logout:hover {
            background: #fef2f2;
            border-radius: 8px;
        }
    </style>
</head>

<body>
    <div class="sidebar">
        <div class="logo">LAB-CHECK</div>
        <nav>
            {{-- Using Request::is to highlight active links --}}
            <a href="{{ url('/dashboard') }}" class="nav-link {{ Request::is('dashboard') ? 'active' : '' }}">Home</a>
            <a href="{{ url('/experiments') }}" class="nav-link {{ Request::is('experiments*') ? 'active' : '' }}">Experiments</a>
            <a href="{{ url('/catalog') }}" class="nav-link {{ Request::is('catalog*') ? 'active' : '' }}">Catalog</a>

            @if (Auth::user()->role == 'admin' || Auth::user()->role == 'staff')
                <div class="staff-label">Staff Features</div>
                <a href="{{ url('/equipment-management') }}" class="nav-link {{ Request::is('equipment-management*') ? 'active' : '' }}">Equipment Management</a>
                <a href="{{ url('/inventory-control') }}" class="nav-link {{ Request::is('inventory-control*') ? 'active' : '' }}">Inventory Control</a>
            @endif

            <a href="{{ url('/settings') }}" class="nav-link {{ Request::is('settings*') ? 'active' : '' }}">Settings</a>

            {{-- Logout must be a POST form for Laravel security --}}
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn-logout">Log out</button>
            </form>
        </nav>
    </div>

    <div class="main-wrapper">
        <div class="header">
            {{-- Changed 'name' to 'full_name' to match your database --}}
            <h2 style="margin: 0; color: #1e293b;">Good day, {{ Auth::user()->full_name }}</h2>
            
            <form action="{{ url('/catalog') }}" method="GET" class="search-form">
                <input type="text" name="search" class="search" placeholder="Find a chemical..." value="{{ request('search') }}">
            </form>
        </div>

        {{-- Dynamic content from other pages injected here --}}
        @yield('content')
    </div>
</body>

</html>