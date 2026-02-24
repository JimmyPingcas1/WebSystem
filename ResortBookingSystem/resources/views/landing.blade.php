<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DJs Resort · effortless bookings</title>
    <!-- Font & Tailwind -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,400..700;1,14..32,400..700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: 'Inter', sans-serif; }
        .tagline-badge {
            background: rgba(255,255,255,0.15);
            backdrop-filter: blur(4px);
            padding: 0.4rem 1.4rem;
            border-radius: 40px;
            display: inline-block;
            border: 1px solid rgba(255,255,255,0.25);
            font-weight: 500;
            margin-bottom: 1.2rem;
            font-size: 0.75rem;
            color: white;
            text-shadow: 0 1px 2px rgba(0,0,0,0.2);
        }
        .hero-text-shadow { text-shadow: 0 2px 4px rgba(0,0,0,0.3); }
        .hero-image {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center;
        }
        .hero-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(to top, rgba(13, 59, 79, 0.3), rgba(20, 94, 122, 0.2), rgba(31, 122, 156, 0.1));
        }
    </style>
</head>
<body class="bg-slate-50 text-gray-800 antialiased">

<!-- ================= NAVBAR ================= -->
<header class="absolute top-0 left-0 w-full z-40 pt-5">
    <div class="max-w-7xl mx-auto px-6 md:px-8 flex justify-between items-center">
        <!-- LOGO -->
        <div class="flex items-center text-white hero-text-shadow">
            <span class="text-2xl font-bold tracking-tight">LOGO</span>
        </div>

        <!-- About + Tenant Login/Register -->
        <div class="flex items-center gap-8">
            <a href="#" class="text-white text-base font-medium hover:underline hero-text-shadow hidden md:block">About Us</a>
            <div class="flex items-center gap-3">
                     <!-- Tenant Login -->
                     <a href="{{ route('tenant.select.login') }}" 
                         class="text-white text-sm font-semibold px-4 py-2 rounded-lg border-2 border-white/40 hover:bg-white/20 transition shadow-md hero-text-shadow">
                         Tenant Login
                     </a>
                     <!-- Tenant Register -->
                     <a href="{{ route('tenant.select.register') }}"
                         class="bg-[#0f6b7e] text-white text-sm font-semibold px-5 py-2 rounded-lg hover:bg-[#0c5a6b] transition shadow-lg border border-white/20">
                         Tenant Register
                     </a>
            </div>
        </div>
    </div>
</header>

<!-- ================= HERO SECTION ================= -->
<section class="relative min-h-screen w-full overflow-hidden flex items-center" style="height: 100vh; max-height: 1200px;">
    <div class="absolute inset-0 w-full h-full">
        <img src="{{ asset('images/background.jpg') }}" 
             onerror="this.style.display='none'; this.parentNode.style.backgroundColor='#0b3d4f';"
             class="hero-image"
             alt="Resort background">
        <div class="hero-overlay"></div>
    </div>

    <div class="relative z-10 max-w-5xl mx-auto px-6 md:px-8 pt-16 text-white w-full">
        <!-- badge -->
        <div class="tagline-badge uppercase tracking-wider hero-text-shadow">✦ resort owners · worldwide</div>
        
        <!-- main headline -->
        <h1 class="text-4xl md:text-6xl font-extrabold leading-tight max-w-3xl hero-text-shadow">
            Your Resort, Your Rules.<br>
            <span class="text-white">Manage Bookings Effortlessly</span>
        </h1>

        <!-- subline -->
        <p class="text-base md:text-lg text-white/95 mt-4 max-w-xl hero-text-shadow">
            All‑in‑one SaaS for independent resorts · multi‑tenant, customizable, powerful.
        </p>

        <!-- CTA button -->
        <div class="flex flex-wrap gap-3 mt-8">
            <a href="{{ route('tenants.index') }}" 
               class="bg-[#1f7a9c] text-white px-6 py-2 rounded-lg font-semibold text-base shadow-xl hover:bg-[#176582] transition shadow-lg border border-white/20">
               Explore Tenants
            </a>
        </div>
    </div>
</section>

<!-- ================= OFFER SECTION ================= -->
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-6 md:px-8">
        <div class="text-center mb-16">
            <h2 class="text-3xl md:text-4xl font-bold mb-3 text-gray-800">What We Offer</h2>
            <p class="text-gray-500 max-w-2xl mx-auto text-base md:text-lg">
                A complete ecosystem for resort owners and guests — designed for efficiency, flexibility, and scalability.
            </p>
        </div>

        <div class="grid md:grid-cols-2 gap-10">
            <!-- Tenant card -->
            <div class="bg-slate-50/90 rounded-2xl p-8 border border-gray-200 shadow-md hover:shadow-xl transition">
                <h3 class="text-2xl font-semibold mb-6 text-[#1f7a9c] flex items-center gap-2">
                    <span class="text-2xl">🏨</span> Tenant Features
                </h3>
                <ul class="space-y-3 text-gray-700 text-base leading-relaxed">
                    <li class="flex items-start gap-2"><span class="text-[#1f7a9c] text-lg">•</span> Customizable layout, logo, colors, branding</li>
                    <li class="flex items-start gap-2"><span class="text-[#1f7a9c] text-lg">•</span> Independent dashboard per resort</li>
                    <li class="flex items-start gap-2"><span class="text-[#1f7a9c] text-lg">•</span> Room, cottage, amenity, and pricing management</li>
                    <li class="flex items-start gap-2"><span class="text-[#1f7a9c] text-lg">•</span> Booking calendar and reservation tracking</li>
                    <li class="flex items-start gap-2"><span class="text-[#1f7a9c] text-lg">•</span> Staff and admin role management</li>
                    <li class="flex items-start gap-2"><span class="text-[#1f7a9c] text-lg">•</span> Reports and booking analytics</li>
                </ul>
            </div>

            <!-- Customer card -->
            <div class="bg-slate-50/90 rounded-2xl p-8 border border-gray-200 shadow-md hover:shadow-xl transition">
                <h3 class="text-2xl font-semibold mb-6 text-[#0f6b7e] flex items-center gap-2">
                    <span class="text-2xl">🌊</span> Customer Features
                </h3>
                <ul class="space-y-3 text-gray-700 text-base leading-relaxed">
                    <li class="flex items-start gap-2"><span class="text-[#0f6b7e] text-lg">•</span> Browse resorts and available accommodations</li>
                    <li class="flex items-start gap-2"><span class="text-[#0f6b7e] text-lg">•</span> Online booking and reservation system</li>
                    <li class="flex items-start gap-2"><span class="text-[#0f6b7e] text-lg">•</span> View pricing, availability, and details</li>
                    <li class="flex items-start gap-2"><span class="text-[#0f6b7e] text-lg">•</span> Secure booking confirmation</li>
                    <li class="flex items-start gap-2"><span class="text-[#0f6b7e] text-lg">•</span> Booking history and tracking</li>
                </ul>
            </div>
        </div>
    </div>
</section>

<!-- ================= CTA ================= -->
<section class="py-20 bg-gradient-to-r from-[#1f7a9c] to-[#0f6b7e] text-white text-center">
    <div class="max-w-2xl mx-auto px-6">
        <h2 class="text-3xl md:text-4xl font-bold mb-4">Ready to Elevate Your Resort?</h2>
        <p class="mb-8 text-lg text-[#e1f0f5]">Start managing bookings, guests, and operations with confidence.</p>
        <a href="{{ route('tenants.index') }}" 
           class="px-6 py-3 bg-[#f39c12] text-white rounded-full font-semibold text-base hover:bg-[#e08e0b] transition shadow-xl border border-white/20 inline-block">Explore Resorts</a>
    </div>
</section>

<!-- ================= FOOTER ================= -->
<footer class="bg-[#0b3d4f] text-gray-300 py-10">
    <div class="max-w-7xl mx-auto px-6 md:px-8 flex flex-col md:flex-row justify-between items-center gap-4">
        <p class="text-xs">© 2025 DJs Resort System. All rights reserved.</p>
        <p class="text-xs text-gray-400">Powered by Laravel & Tailwind CSS</p>
    </div>
</footer>

</body>
</html>
