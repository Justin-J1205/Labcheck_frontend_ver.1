<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to LAB-CHECK</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700;900&display=swap" rel="stylesheet">
    <style>
        [x-cloak] {
            display: none !important;
        }

        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>

<body
    class="bg-gradient-to-br from-[#004d4d] to-[#008080] min-h-screen flex items-center justify-center antialiased overflow-hidden">

    <div class="max-w-7xl w-11/12 flex flex-col lg:flex-row items-center justify-between gap-12 lg:gap-20">

        <div class="flex-1 max-w-xl text-center lg:text-left">
            {{-- Main Branding with a subtle shine effect --}}
            <h1
                class="text-6xl lg:text-7xl font-black tracking-tighter mb-6 bg-gradient-to-r from-white to-teal-200 bg-clip-text text-transparent drop-shadow-sm">
                LAB-CHECK
            </h1>

            <p class="text-lg lg:text-xl text-teal-50/90 leading-relaxed mb-10 font-medium">
                Step into a smarter, safer, and more efficient laboratory. From real-time chemical tracking to seamless
                equipment booking, we provide the tools you need. <span </p>

                    <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                        <a href="/login"
                            class="inline-flex items-center justify-center px-10 py-5 bg-white text-[#004d4d] rounded-2xl font-black text-lg transition-all duration-300 hover:-translate-y-1 hover:shadow-[0_20px_40px_rgba(0,0,0,0.3)] active:scale-95 group">
                            Get Started
                            <svg class="w-5 h-5 ml-2 transition-transform group-hover:translate-x-1" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M14 5l7 7m0 0l-7 7m7-7H3" />
                            </svg>
                        </a>
                    </div>
        </div>

        <div class="flex-1 w-full lg:w-auto group">
            <div class="relative">
                {{-- Decorative glow behind the image --}}
                <div
                    class="absolute -inset-4 bg-teal-400/20 rounded-[40px] blur-2xl group-hover:bg-teal-400/30 transition-all duration-500">
                </div>

                {{-- The Image Card with Glass Border --}}
                <div
                    class="relative bg-white/10 backdrop-blur-sm p-2 lg:p-3 rounded-[35px] border border-white/20 shadow-2xl overflow-hidden transform transition-all duration-500 group-hover:scale-[1.05] group-hover:-translate-y-3">
                    <img src="{{ asset('images/LAB-CHECK.png') }}" alt="LAB-CHECK logo here"
                        class="w-full h-[300px] lg:h-[500px] object-cover rounded-[28px] shadow-inner">
                </div>
            </div>
        </div>

    </div>

</body>

</html>
