<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - LAB-CHECK</title>
    <link rel="icon" type="image/png" href="{{ asset('images/LAB-CHECK.png') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;900&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>

<body class="bg-slate-50 flex min-h-screen items-center justify-center font-sans py-12 px-4">

    <div
        class="bg-white p-8 lg:p-12 rounded-[2.5rem] shadow-2xl shadow-slate-200/60 w-full max-w-xl text-center border border-slate-100">

        {{-- Branding --}}
        <div class="mb-8">
            <div class="text-teal-700 font-black text-3xl tracking-tighter italic mb-1">LAB-CHECK</div>
            <p class="text-slate-400 text-xs font-bold uppercase tracking-[3px]">Create Account</p>
        </div>

        <h2 class="text-2xl font-black text-slate-800 tracking-tight mb-8">Join the Lab</h2>

        {{-- Error List --}}
        @if ($errors->any())
            <div
                class="bg-red-50 border border-red-100 text-red-600 px-5 py-4 rounded-2xl mb-8 text-sm font-bold text-left">
                <div class="flex items-center gap-2 mb-2">
                    <span>⚠️</span>
                    <span>Please fix the following:</span>
                </div>
                <ul class="list-disc list-inside space-y-1 opacity-90 font-medium ml-2">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('register') }}" method="POST" class="space-y-6 text-left">
            @csrf

            {{-- Full Name --}}
            <div>
                <label class="block text-xs font-black uppercase tracking-widest text-slate-500 mb-2 ml-1">Full
                    Name</label>
                <input type="text" name="full_name" value="{{ old('full_name') }}"
                    class="w-full px-5 py-4 rounded-2xl border border-slate-200 focus:outline-none focus:border-teal-600 focus:ring-4 focus:ring-teal-600/10 transition-all placeholder:text-slate-300"
                    placeholder="John Doe" required>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Birth Date --}}
                <div>
                    <label class="block text-xs font-black uppercase tracking-widest text-slate-500 mb-2 ml-1">Birth
                        Date</label>
                    <input type="date" name="date_of_birth" value="{{ old('date_of_birth') }}"
                        class="w-full px-5 py-4 rounded-2xl border border-slate-200 focus:outline-none focus:border-teal-600 focus:ring-4 focus:ring-teal-600/10 transition-all text-slate-700"
                        required>
                </div>
                {{-- Role Selection --}}
                <div>
                    <label class="block text-xs font-black uppercase tracking-widest text-slate-500 mb-2 ml-1">I am
                        a:</label>
                    <select name="role"
                        class="w-full px-5 py-4 rounded-2xl border border-slate-200 focus:outline-none focus:border-teal-600 focus:ring-4 focus:ring-teal-600/10 transition-all bg-white text-slate-700 font-semibold cursor-pointer appearance-none">
                        <option value="student" {{ old('role') == 'student' ? 'selected' : '' }}>Student</option>
                        <option value="staff" {{ old('role') == 'staff' ? 'selected' : '' }}>Staff</option>
                    </select>
                </div>
            </div>

            {{-- Email --}}
            <div>
                <label class="block text-xs font-black uppercase tracking-widest text-slate-500 mb-2 ml-1">E-Mail
                    Address</label>
                <input type="email" name="email" value="{{ old('email') }}"
                    class="w-full px-5 py-4 rounded-2xl border border-slate-200 focus:outline-none focus:border-teal-600 focus:ring-4 focus:ring-teal-600/10 transition-all placeholder:text-slate-300"
                    placeholder="example@uic.edu.ph" required>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Password --}}
                <div>
                    <label
                        class="block text-xs font-black uppercase tracking-widest text-slate-500 mb-2 ml-1">Password</label>
                    <input type="password" name="password"
                        class="w-full px-5 py-4 rounded-2xl border border-slate-200 focus:outline-none focus:border-teal-600 focus:ring-4 focus:ring-teal-600/10 transition-all placeholder:text-slate-300"
                        placeholder="Min. 8 chars" required>
                </div>
                {{-- Confirm Password --}}
                <div>
                    <label
                        class="block text-xs font-black uppercase tracking-widest text-slate-500 mb-2 ml-1">Confirm</label>
                    <input type="password" name="password_confirmation"
                        class="w-full px-5 py-4 rounded-2xl border border-slate-200 focus:outline-none focus:border-teal-600 focus:ring-4 focus:ring-teal-600/10 transition-all placeholder:text-slate-300"
                        placeholder="Repeat it" required>
                </div>
            </div>

            <button type="submit"
                class="w-full py-5 bg-teal-700 hover:bg-teal-800 text-white font-black rounded-2xl shadow-xl shadow-teal-900/20 transition-all active:scale-[0.97] mt-4 uppercase tracking-widest text-sm">
                Register Account
            </button>
        </form>

        <div class="mt-10 pt-8 border-t border-slate-50 text-sm text-slate-400 font-medium">
            Already have an account?
            <a href="{{ route('login') }}"
                class="text-teal-700 font-bold hover:text-teal-900 ml-1 transition-colors">Login here!</a>
        </div>
    </div>

</body>

</html>
