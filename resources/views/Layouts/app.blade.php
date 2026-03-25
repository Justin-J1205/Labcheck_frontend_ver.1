<!DOCTYPE html>
<html>

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

        .search {
            padding: 10px 20px;
            width: 300px;
            border-radius: 25px;
            border: 1px solid #e2e8f0;
        }

        .btn-logout {
            color: #ef4444;
            border: none;
            background: none;
            cursor: pointer;
            padding: 12px;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="sidebar">
        <div class="logo">LAB-CHECK</div>
        <nav>
            <a href="/dashboard" class="nav-link active">Home</a>
            <a href="#" class="nav-link">Experiments</a>
            <a href="#" class="nav-link">Catalog</a>

            @if (Auth::user()->role == 'admin' || Auth::user()->role == 'staff')
                <div class="staff-label">Staff Features</div>
                <a href="/equipment" class="nav-link">Equipment Management</a>
                <a href="/inventory" class="nav-link">Inventory Control</a>
            @endif

            <a href="#" class="nav-link">Settings</a>
            <button class="btn-logout">Log out</button>
        </nav>
    </div>

    <div class="main-wrapper">
        <div class="header">
            <h2 style="margin: 0;">Good day, {{ Auth::user()->name ?? 'User' }}</h2>
            <input type="text" class="search" placeholder="Find a chemical...">
        </div>
        @yield('content')
    </div>
</body>

</html>
