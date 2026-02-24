<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DJs Resort · Book Your Stay</title>

    <!-- Font & Tailwind -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,400..700;1,14..32,400..700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        body { font-family: 'Inter', sans-serif; }
        .hero-text-shadow { text-shadow: 0 2px 4px rgba(0,0,0,0.3); }
        .hero-image {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .hero-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(
                to top,
                rgba(13, 59, 79, 0.6),
                rgba(20, 94, 122, 0.4),
                rgba(31, 122, 156, 0.2)
            );
        }
    </style>
</head>

<body class="bg-slate-50 text-gray-800 antialiased">

<!-- ================= NAVBAR ================= -->
<header class="absolute top-0 left-0 w-full z-40 pt-5">
    <div class="max-w-7xl mx-auto px-6 md:px-8 flex justify-between items-center">

        <!-- LOGO -->
        <div class="text-white text-2xl font-bold hero-text-shadow">
            DJs Resort
        </div>

        <!-- TENANT AUTH -->
        <div class="flex items-center gap-4">
            <!-- LOGIN -->
            <a href="{{ route('tenant.user.login', ['tenant_slug' => request()->route('tenant_slug')]) }}"
               class="text-white text-sm font-semibold px-4 py-2 rounded-lg border border-white/40 hover:bg-white/20 transition hero-text-shadow">
                Login
            </a>

            <!-- REGISTER -->
            <a href="{{ route('tenant.user.register', ['tenant_slug' => request()->route('tenant_slug')]) }}"
               class="bg-[#0f6b7e] text-white text-sm font-semibold px-5 py-2 rounded-lg hover:bg-[#0c5a6b] transition shadow-lg">
                Register
            </a>
        </div>

    </div>
</header>

<!-- ================= HERO SECTION ================= -->
<section class="relative min-h-screen flex items-center justify-center overflow-hidden">

    <!-- Background -->
    <img src="{{ asset('images/background.jpg') }}"
         onerror="this.style.display='none'; this.parentNode.style.backgroundColor='#0b3d4f';"
         class="hero-image"
         alt="Resort background">

    <div class="hero-overlay"></div>

    <!-- CONTENT -->
    <div class="relative z-10 max-w-3xl mx-auto px-6 text-center text-white">

        <h1 class="text-4xl md:text-6xl font-extrabold mb-4 hero-text-shadow">
            Book Your Perfect Resort Getaway
        </h1>

        <p class="text-base md:text-lg text-white/90 mb-8 hero-text-shadow">
            Discover beautiful resorts, check availability, and reserve your stay in just a few clicks.
        </p>

        <!-- ACTION BUTTONS -->
        <div class="flex flex-col sm:flex-row justify-center gap-4">
            <a href="#resorts"
               class="bg-[#f39c12] px-8 py-3 rounded-lg font-semibold text-base hover:bg-[#e08e0b] transition shadow-xl">
                Browse Resorts
            </a>

            <a href="#resorts"
               class="bg-white/20 border border-white/40 px-8 py-3 rounded-lg font-semibold text-base hover:bg-white/30 transition">
                Check Availability
            </a>
        </div>
    </div>
</section>

<!-- ================= RESORT LIST ================= -->
<section id="resorts" class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-6 md:px-8 text-center">
        <h2 class="text-3xl md:text-4xl font-bold mb-4 text-gray-800">
            Available Resorts
        </h2>

        <p class="text-gray-500 max-w-2xl mx-auto mb-12">
            Browse resorts, view amenities, and book your next vacation.
        </p>

        <div class="border-2 border-dashed border-gray-300 rounded-xl p-12 text-gray-400">
            Resort listing & booking system goes here
        </div>
    </div>
</section>

<!-- ================= FOOTER ================= -->
<footer class="bg-[#0b3d4f] text-gray-300 py-8">
    <div class="max-w-7xl mx-auto px-6 md:px-8 flex flex-col md:flex-row justify-between items-center gap-3">
        <p class="text-xs">© 2025 DJs Resort System. All rights reserved.</p>
        <p class="text-xs text-gray-400">Powered by Laravel & Tailwind CSS</p>
    </div>
</footer>

</body>
</html>
