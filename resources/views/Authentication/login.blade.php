<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - LAB-CHECK</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;900&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>

<body class="bg-slate-50 flex h-screen items-center justify-center font-sans px-4">

    <div
        class="bg-white p-8 lg:p-12 rounded-[2.5rem] shadow-2xl shadow-slate-200/60 w-full max-w-md text-center border border-slate-100">

        {{-- Branding --}}
        <div class="mb-8">
            <div class="text-teal-700 font-black text-3xl tracking-tighter italic mb-1">LAB-CHECK</div>
            <p class="text-slate-400 text-xs font-bold uppercase tracking-[3px]">Authentication</p>
        </div>

        {{-- Error Alert --}}
        @if ($errors->any())
            <div
                class="bg-red-50 border border-red-100 text-red-600 px-4 py-3 rounded-2xl mb-6 text-sm font-bold text-left flex items-start gap-2">
                <span>⚠️</span>
                <span>{{ $errors->first() }}</span>
            </div>
        @endif

        <form action="{{ route('login') }}" method="POST" class="space-y-5 text-left">
            @csrf

            {{-- Email Input --}}
            <div>
                <label class="block text-xs font-black uppercase tracking-widest text-slate-500 mb-2 ml-1">E-Mail
                    Address</label>
                <input type="email" name="email" value="{{ old('email') }}"
                    class="w-full px-5 py-4 rounded-2xl border border-slate-200 focus:outline-none focus:border-teal-600 focus:ring-4 focus:ring-teal-600/10 transition-all placeholder:text-slate-300"
                    placeholder="name@uic.edu.ph" required autofocus>
            </div>

            {{-- Password Input --}}
            <div>
                <div class="flex justify-between items-center mb-2 ml-1">
                    <label class="text-xs font-black uppercase tracking-widest text-slate-500">Password</label>
                </div>
                <input type="password" name="password"
                    class="w-full px-5 py-4 rounded-2xl border border-slate-200 focus:outline-none focus:border-teal-600 focus:ring-4 focus:ring-teal-600/10 transition-all placeholder:text-slate-300"
                    placeholder="••••••••" required>
            </div>

            {{-- Remember Me --}}
            <div class="flex items-center ml-1">
                <input id="remember_me" type="checkbox" name="remember"
                    class="rounded border-slate-300 text-teal-600 focus:ring-teal-600">
                <label for="remember_me"
                    class="ml-2 text-sm text-slate-500 font-medium cursor-pointer selection:bg-none">Remember this
                    device</label>
            </div>

            <button type="submit"
                class="w-full py-4 bg-teal-700 hover:bg-teal-800 text-white font-black rounded-2xl shadow-xl shadow-teal-900/20 transition-all active:scale-[0.97] mt-2 uppercase tracking-widest text-sm">
                Sign In
            </button>
        </form>

        <div class="mt-10 pt-8 border-t border-slate-50 text-sm text-slate-400 font-medium">
            New to the lab?
            <a href="/register" class="text-teal-700 font-bold hover:text-teal-900 ml-1 transition-colors">Create
                Account</a>
        </div>

    </div>

</body>

</html>
