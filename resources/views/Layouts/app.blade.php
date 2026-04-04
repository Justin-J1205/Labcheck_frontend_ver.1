<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LAB-CHECK</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="//unpkg.com/alpinejs" defer></script>
</head>

<body style="margin: 0; font-family: 'Segoe UI', sans-serif; background: #f8fafc;" x-data="{ sidebarOpen: true }">

    {{-- 1. CLEAN BLUE TOP BAR (No Search) --}}
    <div
        style="height: 70px; background: #1e3a8a; display: flex; align-items: center; padding: 0 30px; position: sticky; top: 0; z-index: 100;">

        {{-- LEFT SECTION: Menu + Dynamic Greeting --}}
        <div style="display: flex; align-items: center; gap: 20px; flex: 1;">
            {{-- MENU TOGGLE --}}
            <button @click="sidebarOpen = !sidebarOpen"
                style="background: rgba(255,255,255,0.2); border: none; border-radius: 8px; padding: 8px 15px; color: white; cursor: pointer; font-weight: 700; display: flex; align-items: center; gap: 8px;">
                <span x-show="!sidebarOpen">☰</span>
                <span x-show="sidebarOpen">✕</span>
                <span>Menu</span>
            </button>

            {{-- DYNAMIC GREETING WITH FALLBACK --}}
            <div style="color: white; font-size: 16px; white-space: nowrap;">
                Good day,
                <span style="font-weight: 700;">
                    {{ Auth::user()->full_name ?? 'User' }}
                </span>! 
            </div>
        </div>

    </div>
    <div style="display: flex; height: calc(100vh - 70px);">
        {{-- 2. THE SIDEBAR (Toggleable) --}}
        <div x-show="sidebarOpen" x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0"
            style="width: 260px; background: white; border-right: 1px solid #e2e8f0; padding: 30px 20px; display: flex; flex-direction: column; flex-shrink: 0;">

            <div style="margin-bottom: 40px;">
                <h1 style="color: #0d9488; font-weight: 800; font-size: 22px; margin: 0;">LAB-CHECK</h1>
            </div>

            <nav style="flex-grow: 1;">
                <ul style="list-style: none; padding: 0; margin: 0;">
                    <li style="margin-bottom: 8px;">
                        <a href="{{ route('dashboard') }}"
                            style="display: block; padding: 12px 15px; border-radius: 12px; text-decoration: none; font-weight: 600; color: {{ Request::is('dashboard') ? '#0d9488' : '#64748b' }}; background: {{ Request::is('dashboard') ? '#f0fdfa' : 'transparent' }};">
                            Home
                        </a>
                    </li>
                    <li style="margin-bottom: 8px;">
                        <a href="{{ route('experiments.index') }}"
                            style="display: block; padding: 12px 15px; border-radius: 12px; text-decoration: none; font-weight: 600; color: {{ Request::is('experiments*') ? '#0d9488' : '#64748b' }}; background: {{ Request::is('experiments*') ? '#f0fdfa' : 'transparent' }};">
                            Experiments
                        </a>
                    </li>
                    <li style="margin-bottom: 8px;">
                        <a href="{{ route('catalog.index') }}"
                            style="display: block; padding: 12px 15px; border-radius: 12px; text-decoration: none; font-weight: 600; color: {{ Request::is('catalog*') ? '#0d9488' : '#64748b' }}; background: {{ Request::is('catalog*') ? '#f0fdfa' : 'transparent' }};">
                            Catalog
                        </a>
                    </li>
                    <li style="margin-bottom: 8px;">
                        <a href="{{ route('equipment.index') }}"
                            style="display: block; padding: 12px 15px; border-radius: 12px; text-decoration: none; font-weight: 600; color: {{ Request::is('equipment*') ? '#0d9488' : '#64748b' }}; background: {{ Request::is('equipment*') ? '#f0fdfa' : 'transparent' }};">
                            Equipment
                        </a>
                    </li>
                </ul>
            </nav>

            <div style="margin-top: auto;">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit"
                        style="color: #ef4444; font-weight: 700; background: none; border: none; cursor: pointer; padding: 10px 15px; width: 100%; text-align: left;">
                        Log out
                    </button>
                </form>
            </div>
        </div>

        {{-- 3. MAIN CONTENT AREA --}}
        <div style="flex-grow: 1; overflow-y: auto; background: #f8fafc;">
            @yield('content')
        </div>
    </div>

</body>

</html>
