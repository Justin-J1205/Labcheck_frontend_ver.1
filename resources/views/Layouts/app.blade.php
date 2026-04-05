<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LAB-CHECK</title>

    {{-- Core Scripts --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="//unpkg.com/alpinejs" defer></script>

    {{-- Modern Font --}}
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        [x-cloak] {
            display: none !important;
        }
    </style>
</head>

<body class="bg-slate-50 antialiased" x-data="{ sidebarOpen: true }">

    {{-- 1. TOP NAVIGATION BAR --}}
    <header class="h-[70px] bg-[#1e3a8a] flex items-center px-6 sticky top-0 z-[100] shadow-md">

        <div class="flex items-center gap-6 flex-1">
            {{-- Sidebar Toggle Button --}}
            <button @click="sidebarOpen = !sidebarOpen"
                class="bg-white/10 hover:bg-white/20 border-none rounded-xl px-4 py-2 text-white cursor-pointer font-bold flex items-center gap-2 transition-all active:scale-95">
                <span x-text="sidebarOpen ? '✕' : '☰'"></span>
                <span class="hidden sm:inline text-xs uppercase tracking-widest">Menu</span>
            </button>

            {{-- Clean Text Greeting --}}
            <div class="flex items-center text-white border-l border-white/20 ml-2 pl-6 h-8">
                <div class="text-sm">
                    <span class="opacity-70 font-medium italic">Good day,</span>
                    <span class="font-bold tracking-tight text-teal-300 ml-1">
                        {{ Auth::user()->full_name ?? 'User' }}!
                    </span>
                </div>
            </div>
        </div>

    </header>

    <div class="flex h-[calc(100vh-70px)]">

        {{-- 2. THE SIDEBAR (Collapsible) --}}
        <aside x-show="sidebarOpen" x-cloak x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0"
            x-transition:leave="transition ease-in duration-200" x-transition:leave-start="translate-x-0"
            x-transition:leave-end="-translate-x-full"
            class="w-[260px] bg-white border-r border-slate-200 p-8 flex flex-col shrink-0 z-40">

            {{-- Sidebar Branding --}}
            <div class="mb-10">
                <h1 class="text-[#0d9488] font-black text-2xl tracking-tighter">LAB-CHECK</h1>
                <p class="text-[10px] text-slate-400 font-bold uppercase tracking-[2px] mt-1">Inventory System</p>
            </div>

            {{-- Navigation Links --}}
            <nav class="flex-grow">
                <ul class="space-y-1.5 p-0 m-0 list-none">
                    @php
                        $navItems = [
                            ['route' => 'dashboard', 'label' => 'Home', 'pattern' => 'dashboard'],
                            ['route' => 'experiments.index', 'label' => 'Experiments', 'pattern' => 'experiments*'],
                            ['route' => 'catalog.index', 'label' => 'Catalog', 'pattern' => 'catalog*'],
                            // FIXED: Added 's' to route and pattern to match web.php resource
                            ['route' => 'equipments.index', 'label' => 'Equipment', 'pattern' => 'equipments*'],
                        ];
                    @endphp

                    @foreach ($navItems as $item)
                        <li>
                            <a href="{{ route($item['route']) }}"
                                class="flex items-center px-4 py-3 rounded-xl no-underline font-bold transition-all duration-200 
                            {{ Request::is($item['pattern'])
                                ? 'bg-teal-50 text-teal-700 shadow-sm'
                                : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900' }}">
                                {{ $item['label'] }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </nav>

            {{-- Sign Out Button --}}
            <div class="pt-6 border-t border-slate-100">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit"
                        class="flex items-center gap-2 w-full px-4 py-3 text-red-500 font-extrabold bg-transparent border-none cursor-pointer hover:bg-red-50 rounded-xl transition-colors text-sm uppercase tracking-widest">
                        Logout
                    </button>
                </form>
            </div>
        </aside>

        {{-- 3. MAIN CONTENT AREA --}}
        <main class="flex-grow overflow-y-auto bg-slate-50">
            <div class="p-0">
                @yield('content')
            </div>
        </main>
    </div>

</body>

</html>
