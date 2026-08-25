<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sondhi | Handcrafted Luxury Candles & Fragrances')</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Playfair+Display:ital,wght@0,600;0,700;1,600&display=swap" rel="stylesheet">
    
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            50: '#fffdfa',
                            100: '#fdf6ea',
                            200: '#f9e7cc',
                            300: '#f4d2a1',
                            400: '#ebb571',
                            500: '#e19445',
                            600: '#d27933',
                            700: '#af5a29',
                            800: '#8c4828',
                            900: '#713c23',
                        },
                        amberGold: '#D4AF37',
                        obsidian: '#121212',
                    },
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                        serif: ['"Playfair Display"', 'serif'],
                    }
                }
            }
        }
    </script>
    <style>
        .glass-nav {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
        }
        .gradient-brand {
            background: linear-gradient(135deg, #121212 0%, #2a201b 50%, #713c23 100%);
        }
    </style>
</head>
<body class="bg-gray-50 text-gray-800 font-sans flex flex-col min-h-screen">

    <!-- Navigation Header -->
    <header class="bg-[#FAF8F5]/90 backdrop-blur-md sticky top-0 z-40 border-b border-gray-200 transition-all">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                <!-- Logo -->
                <a href="{{ route('shop.index') }}" class="flex items-center space-x-2">
                    <span class="font-serif text-2xl sm:text-3xl tracking-widest font-normal text-gray-900 uppercase">SONDHI</span>
                </a>

                <!-- Centered Navigation Links -->
                <nav class="hidden md:flex items-center space-x-3 text-[11px] font-medium tracking-widest text-gray-800 uppercase">
                    <a href="{{ route('shop.index') }}" class="hover:text-black transition-colors">HOME</a>
                    <span class="text-gray-300">|</span>
                    <a href="{{ route('shop.index') }}#catalog" class="hover:text-black transition-colors">SHOP ALL</a>
                    <span class="text-gray-300">|</span>
                    <a href="{{ route('shop.index') }}#catalog" class="hover:text-black transition-colors">NEW ARRIVALS</a>
                    <span class="text-gray-300">|</span>
                    <a href="{{ route('about') }}" class="hover:text-black transition-colors">ABOUT</a>
                </nav>

                <!-- Header Icons (Search, User Account, Cart) -->
                <div class="flex items-center space-x-5 text-gray-700">
                    <!-- Search Icon Trigger -->
                    <button onclick="document.getElementById('searchModal').classList.toggle('hidden')" class="hover:text-black transition-colors p-1" title="Search">
                        <i class="fa-solid fa-magnifying-glass text-base sm:text-lg"></i>
                    </button>

                    <!-- User Account / Auth Dropdown -->
                    <div class="relative group">
                        <a href="{{ Auth::check() ? route('profile') : route('login') }}" class="hover:text-black transition-colors p-1 inline-block" title="Account">
                            <i class="fa-regular fa-user text-base sm:text-lg"></i>
                        </a>
                        @auth
                            <div class="absolute right-0 mt-2 w-52 bg-white border border-gray-200 shadow-md py-2 hidden group-hover:block transition-all z-50 text-xs tracking-normal">
                                <div class="px-4 py-2 border-b border-gray-100 font-medium">
                                    <p class="text-[10px] text-gray-400 uppercase tracking-widest">Signed in as</p>
                                    <p class="font-semibold text-gray-900 truncate">{{ Auth::user()->name }}</p>
                                </div>
                                <a href="{{ route('profile') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-50"><i class="fa-solid fa-user-gear mr-2"></i> Account Profile</a>
                                <a href="{{ route('orders.index') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-50"><i class="fa-solid fa-box-open mr-2"></i> My Orders</a>
                                @if(Auth::user()->isAdmin())
                                    <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-amber-800 font-bold hover:bg-amber-50"><i class="fa-solid fa-gauge-high mr-2"></i> Admin Panel</a>
                                @endif
                                <form action="{{ route('logout') }}" method="POST" class="border-t border-gray-100">
                                    @csrf
                                    <button type="submit" class="w-full text-left px-4 py-2 text-red-600 hover:bg-red-50"><i class="fa-solid fa-arrow-right-from-bracket mr-2"></i> Logout</button>
                                </form>
                            </div>
                        @else
                            <div class="absolute right-0 mt-2 w-40 bg-white border border-gray-200 shadow-md py-2 hidden group-hover:block transition-all z-50 text-xs tracking-normal">
                                <a href="{{ route('login') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-50"><i class="fa-solid fa-right-to-bracket mr-2"></i> Login</a>
                                <a href="{{ route('register') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-50"><i class="fa-solid fa-user-plus mr-2"></i> Register</a>
                            </div>
                        @endauth
                    </div>

                    <!-- Cart Drawer Icon -->
                    @php
                        $cartCount = array_sum(array_column(session('cart', []), 'quantity'));
                    @endphp
                    <a href="{{ route('cart.index') }}" class="relative hover:text-black transition-colors p-1" title="Cart">
                        <i class="fa-solid fa-bag-shopping text-base sm:text-lg"></i>
                        @if($cartCount > 0)
                            <span class="absolute -top-1 -right-2 inline-flex items-center justify-center w-4 h-4 text-[9px] font-bold text-white bg-[#98A5A2] rounded-full">
                                {{ $cartCount }}
                            </span>
                        @endif
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- Search Modal Popover -->
    <div id="searchModal" class="hidden bg-[#FAF8F5] border-b border-gray-200 p-4 shadow-inner">
        <div class="max-w-xl mx-auto">
            <form action="{{ route('shop.index') }}" method="GET" class="flex items-center space-x-2">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search candles, reed diffusers..." 
                       class="w-full px-4 py-2 text-xs border border-gray-300 bg-white focus:outline-none focus:border-gray-900">
                <button type="submit" class="px-5 py-2 bg-gray-900 text-white text-xs tracking-widest uppercase font-medium">Search</button>
            </form>
        </div>
    </div>

    <!-- Flash Messages Toast -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
        @if(session('success'))
            <div class="p-4 mb-4 text-sm text-emerald-800 bg-emerald-50 rounded-2xl border border-emerald-200 flex items-center shadow-sm">
                <i class="fa-solid fa-circle-check text-emerald-600 text-lg mr-3"></i>
                <span class="font-medium">{{ session('success') }}</span>
            </div>
        @endif

        @if(session('error'))
            <div class="p-4 mb-4 text-sm text-rose-800 bg-rose-50 rounded-2xl border border-rose-200 flex items-center shadow-sm">
                <i class="fa-solid fa-circle-exclamation text-rose-600 text-lg mr-3"></i>
                <span class="font-medium">{{ session('error') }}</span>
            </div>
        @endif

        @if(session('warning'))
            <div class="p-4 mb-4 text-sm text-amber-800 bg-amber-50 rounded-2xl border border-amber-200 flex items-center shadow-sm">
                <i class="fa-solid fa-triangle-exclamation text-amber-600 text-lg mr-3"></i>
                <span class="font-medium">{{ session('warning') }}</span>
            </div>
        @endif
    </div>

    <!-- Main Body Content -->
    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-obsidian text-gray-400 mt-20 pt-16 pb-12 border-t border-gray-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-10 pb-12 border-b border-gray-800">
                <div class="space-y-4">
                    <div class="flex items-center space-x-2">
                        <div class="w-8 h-8 rounded-lg bg-brand-600 flex items-center justify-center text-white">
                            <i class="fa-solid fa-fire text-sm"></i>
                        </div>
                        <span class="font-serif text-xl font-bold text-white">Sondhi</span>
                    </div>
                    <p class="text-sm leading-relaxed text-gray-400">
                        Handcrafted scented candles, organic reed diffusers, and curated luxury gift sets tailored for home ambiance and special celebrations.
                    </p>
                </div>

                <div>
                    <h4 class="font-bold text-white text-sm uppercase tracking-wider mb-4">Quick Links</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="{{ route('shop.index') }}" class="hover:text-brand-400 transition-colors">All Products</a></li>
                        <li><a href="{{ route('about') }}" class="hover:text-brand-400 transition-colors">Our Brand Story</a></li>
                        <li><a href="{{ route('support.index') }}" class="hover:text-brand-400 transition-colors">Help Center & FAQs</a></li>
                        <li><a href="{{ route('cart.index') }}" class="hover:text-brand-400 transition-colors">Shopping Cart</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="font-bold text-white text-sm uppercase tracking-wider mb-4">Customer Account</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="{{ route('profile') }}" class="hover:text-brand-400 transition-colors">My Profile & Addresses</a></li>
                        <li><a href="{{ route('orders.index') }}" class="hover:text-brand-400 transition-colors">Order Tracking</a></li>
                        <li><a href="{{ route('support.index') }}" class="hover:text-brand-400 transition-colors">Support Tickets</a></li>
                        <li><a href="{{ route('admin.login') }}" class="hover:text-amber-400 transition-colors"><i class="fa-solid fa-lock text-xs mr-1"></i> Admin Portal Login</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="font-bold text-white text-sm uppercase tracking-wider mb-4">Need Assistance?</h4>
                    <p class="text-sm text-gray-400 mb-2"><i class="fa-solid fa-envelope mr-2 text-brand-500"></i> support@sondhi.com</p>
                    <p class="text-sm text-gray-400 mb-4"><i class="fa-solid fa-phone mr-2 text-brand-500"></i> +91 9939628020</p>
                    <div class="flex space-x-3 text-lg text-gray-400">
                        <a href="#" class="hover:text-brand-400"><i class="fa-brands fa-instagram"></i></a>
                        <a href="#" class="hover:text-brand-400"><i class="fa-brands fa-facebook"></i></a>
                        <a href="#" class="hover:text-brand-400"><i class="fa-brands fa-whatsapp"></i></a>
                    </div>
                </div>
            </div>

            <div class="pt-8 flex flex-col md:flex-row justify-between items-center text-xs text-gray-500">
                <p>&copy; {{ date('Y') }} Sondhi. All Rights Reserved.</p>
                <div class="flex space-x-4 mt-4 md:mt-0">
                    <span>Privacy Policy</span>
                    <span>Terms of Service</span>
                    <span>Shipping Policy</span>
                </div>
            </div>
        </div>
    </footer>

</body>
</html>
