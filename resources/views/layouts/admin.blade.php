<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel | Sondhi')</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

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
                            500: '#e19445',
                            600: '#d27933',
                            700: '#af5a29',
                        },
                        adminDark: '#0f172a',
                        adminCard: '#1e293b',
                    },
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gray-100 font-sans text-gray-800 flex min-h-screen">

    <!-- Sidebar Navigation -->
    <aside class="w-64 bg-adminDark text-gray-300 flex flex-col flex-shrink-0 min-h-screen">
        <div class="p-6 border-b border-slate-800 flex items-center space-x-3">
            <div class="w-9 h-9 rounded-lg bg-gradient-to-tr from-brand-600 to-amber-400 flex items-center justify-center text-white font-bold">
                <i class="fa-solid fa-crown text-sm"></i>
            </div>
            <div>
                <h1 class="font-bold text-white text-lg tracking-tight">Sondhi<span class="text-amber-400">Admin</span></h1>
                <span class="text-[10px] text-slate-400 font-semibold tracking-widest uppercase">Management Suite</span>
            </div>
        </div>

        <nav class="flex-grow p-4 space-y-1">
            <div class="px-3 text-[10px] font-bold uppercase tracking-wider text-slate-400 mb-2">Core Overview</div>
            
            <a href="{{ route('admin.dashboard') }}" class="flex items-center px-3 py-2.5 rounded-xl font-medium text-sm transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-brand-600 text-white shadow-md shadow-brand-600/30' : 'hover:bg-slate-800 hover:text-white' }}">
                <i class="fa-solid fa-gauge-high w-6 text-center text-base mr-2"></i> Dashboard
            </a>

            <div class="px-3 text-[10px] font-bold uppercase tracking-wider text-slate-400 mt-6 mb-2">E-Commerce Storefront</div>
            
            <a href="{{ route('admin.products.index') }}" class="flex items-center px-3 py-2.5 rounded-xl font-medium text-sm transition-colors {{ request()->routeIs('admin.products.*') ? 'bg-brand-600 text-white shadow-md shadow-brand-600/30' : 'hover:bg-slate-800 hover:text-white' }}">
                <i class="fa-solid fa-box-open w-6 text-center text-base mr-2"></i> Products Catalog
            </a>

            <a href="{{ route('admin.categories.index') }}" class="flex items-center px-3 py-2.5 rounded-xl font-medium text-sm transition-colors {{ request()->routeIs('admin.categories.*') ? 'bg-brand-600 text-white shadow-md shadow-brand-600/30' : 'hover:bg-slate-800 hover:text-white' }}">
                <i class="fa-solid fa-layer-group w-6 text-center text-base mr-2"></i> Categories
            </a>

            <a href="{{ route('admin.orders.index') }}" class="flex items-center px-3 py-2.5 rounded-xl font-medium text-sm transition-colors {{ request()->routeIs('admin.orders.*') ? 'bg-brand-600 text-white shadow-md shadow-brand-600/30' : 'hover:bg-slate-800 hover:text-white' }}">
                <i class="fa-solid fa-receipt w-6 text-center text-base mr-2"></i> Orders Pipeline
            </a>

            <div class="px-3 text-[10px] font-bold uppercase tracking-wider text-slate-400 mt-6 mb-2">Customer Relations</div>

            <a href="{{ route('admin.support.index') }}" class="flex items-center px-3 py-2.5 rounded-xl font-medium text-sm transition-colors {{ request()->routeIs('admin.support.*') ? 'bg-brand-600 text-white shadow-md shadow-brand-600/30' : 'hover:bg-slate-800 hover:text-white' }}">
                <i class="fa-solid fa-headset w-6 text-center text-base mr-2"></i> Support Tickets
            </a>

            <a href="{{ route('admin.customers.index') }}" class="flex items-center px-3 py-2.5 rounded-xl font-medium text-sm transition-colors {{ request()->routeIs('admin.customers.*') ? 'bg-brand-600 text-white shadow-md shadow-brand-600/30' : 'hover:bg-slate-800 hover:text-white' }}">
                <i class="fa-solid fa-users w-6 text-center text-base mr-2"></i> Customers Directory
            </a>
        </nav>

        <div class="p-4 border-t border-slate-800">
            <a href="{{ route('shop.index') }}" target="_blank" class="flex items-center justify-center w-full py-2 px-3 rounded-xl bg-slate-800 hover:bg-slate-700 text-xs font-bold text-slate-200 transition-colors">
                <i class="fa-solid fa-up-right-from-square mr-2"></i> View Customer Storefront
            </a>
        </div>
    </aside>

    <!-- Main Content Area -->
    <div class="flex-grow flex flex-col min-w-0">
        <!-- Top Bar -->
        <header class="bg-white border-b border-gray-200 h-16 px-6 flex items-center justify-between shadow-sm">
            <div class="flex items-center space-x-3 text-sm text-gray-500">
                <span class="font-bold text-gray-800">Admin Control Desk</span>
                <span>/</span>
                <span class="text-brand-600 font-semibold">@yield('title')</span>
            </div>

            <div class="flex items-center space-x-4">
                <div class="flex items-center space-x-3 border-l pl-4 border-gray-200">
                    <div class="w-8 h-8 rounded-full bg-amber-500 text-white font-bold flex items-center justify-center text-xs shadow-sm">
                        AD
                    </div>
                    <div class="text-xs">
                        <p class="font-bold text-gray-800">{{ Auth::user()->name }}</p>
                        <p class="text-gray-400">Super Admin</p>
                    </div>
                </div>

                <form action="{{ route('admin.logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="p-2 text-gray-400 hover:text-rose-600 transition-colors" title="Admin Logout">
                        <i class="fa-solid fa-power-off text-base"></i>
                    </button>
                </form>
            </div>
        </header>

        <!-- Main Body -->
        <main class="p-6 flex-grow">
            @if(session('success'))
                <div class="p-4 mb-6 text-sm text-emerald-800 bg-emerald-50 rounded-2xl border border-emerald-200 flex items-center shadow-sm">
                    <i class="fa-solid fa-circle-check text-emerald-600 text-lg mr-3"></i>
                    <span class="font-medium">{{ session('success') }}</span>
                </div>
            @endif

            @if(session('error'))
                <div class="p-4 mb-6 text-sm text-rose-800 bg-rose-50 rounded-2xl border border-rose-200 flex items-center shadow-sm">
                    <i class="fa-solid fa-circle-exclamation text-rose-600 text-lg mr-3"></i>
                    <span class="font-medium">{{ session('error') }}</span>
                </div>
            @endif

            @yield('content')
        </main>
    </div>

</body>
</html>
