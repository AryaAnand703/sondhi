<!doctype html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Atelier Operations & Financial Admin | Sondhi</title>
    <meta name="description" content="Store operations, candle catalog management, order fulfillment, and merchant billing portal for Sondhi Atelier.">

    <!-- Theme Early Pre-paint Initializer (Avoids FOUC, defaults to Light Theme) -->
    <meta name="color-scheme" content="light dark">
    <script>
        (function () {
            var theme = localStorage.getItem('sondhi_theme') || 'light';
            if (theme === 'dark') {
                document.documentElement.classList.add('dark');
                document.documentElement.setAttribute('data-theme', 'dark');
            } else {
                document.documentElement.classList.remove('dark');
                document.documentElement.setAttribute('data-theme', 'light');
            }
        })();
    </script>

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        atelier: {
                            base: 'rgb(var(--atelier-base-rgb) / <alpha-value>)',
                            surface: 'rgb(var(--atelier-surface-rgb) / <alpha-value>)',
                            card: 'rgb(var(--atelier-card-rgb) / <alpha-value>)',
                            hover: 'rgb(var(--atelier-hover-rgb) / <alpha-value>)',
                            border: 'var(--atelier-border)',
                            cream: 'rgb(var(--atelier-cream-rgb) / <alpha-value>)',
                            muted: 'rgb(var(--atelier-muted-rgb) / <alpha-value>)',
                            dim: 'rgb(var(--atelier-dim-rgb) / <alpha-value>)'
                        },
                        flame: {
                            glow: 'rgb(var(--flame-glow-rgb) / <alpha-value>)',
                            amber: 'rgb(var(--flame-amber-rgb) / <alpha-value>)',
                            soft: 'var(--flame-soft)'
                        },
                        luxe: {
                            gold: 'rgb(var(--luxe-gold-rgb) / <alpha-value>)',
                            rose: '#D89797',
                            sage: '#8FA189'
                        }
                    },
                    fontFamily: {
                        display: ['"Cormorant Garamond"', 'Georgia', 'serif'],
                        sans: ['"Plus Jakarta Sans"', '-apple-system', 'sans-serif']
                    }
                }
            }
        };
    </script>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,500;0,600;0,700;1,400;1,600&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <!-- Custom Atelier Styles & Theme Variables -->
    <style>
        :root {
            color-scheme: light;
            --atelier-base-rgb: 250 247 242;       /* #FAF7F2 Warm Alabaster Linen Base */
            --atelier-surface-rgb: 255 255 255;    /* #FFFFFF Crisp Porcelain Surface */
            --atelier-card-rgb: 255 255 255;       /* #FFFFFF Pure Ivory Card */
            --atelier-hover-rgb: 244 239 232;      /* #F4EFE8 Subtle Warm Parchment Hover */
            --atelier-cream-rgb: 28 22 19;         /* #1C1613 Deep Warm Charcoal Espresso (Primary Text) */
            --atelier-muted-rgb: 104 92 81;        /* #685C51 Refined Warm Stone (Secondary Text) */
            --atelier-dim-rgb: 152 138 124;        /* #988A7C Subtle Warm Mineral (Tertiary Text) */

            --luxe-gold-rgb: 180 120 32;           /* #B47820 Rich Burnished Molten Gold */
            --flame-glow-rgb: 217 119 6;           /* #D97706 Radiant Amber Flame */
            --flame-amber-rgb: 180 83 9;           /* #B45309 Warm Terracotta Flame */

            --atelier-border: rgba(44, 34, 26, 0.09);
            --flame-soft: rgba(217, 119, 6, 0.08);

            --header-bg: rgba(250, 247, 242, 0.88);
            --header-border: rgba(44, 34, 26, 0.08);
            --card-bg: rgba(255, 255, 255, 0.96);
            --card-border: rgba(44, 34, 26, 0.08);
            --card-hover-border: rgba(180, 120, 32, 0.35);

            --scrollbar-track: #FAF7F2;
            --scrollbar-thumb: #D8CFBF;
            --scrollbar-thumb-hover: #B47820;

            --tab-active-color: #B47820;
            --tab-active-bg: rgba(180, 120, 32, 0.08);
            --shadow-atelier-card: 0 4px 20px -2px rgba(44, 34, 26, 0.05), 0 1px 3px rgba(44, 34, 26, 0.03);
        }

        html.dark {
            color-scheme: dark;
            --atelier-base-rgb: 13 11 10;          /* #0D0B0A */
            --atelier-surface-rgb: 21 18 16;       /* #151210 */
            --atelier-card-rgb: 28 24 21;          /* #1C1815 */
            --atelier-hover-rgb: 38 33 29;         /* #26211D */
            --atelier-cream-rgb: 250 247 242;      /* #FAF7F2 */
            --atelier-muted-rgb: 166 156 143;      /* #A69C8F */
            --atelier-dim-rgb: 110 101 91;         /* #6E655B */

            --luxe-gold-rgb: 229 195 120;          /* #E5C378 */
            --flame-glow-rgb: 245 158 11;          /* #F59E0B */
            --flame-amber-rgb: 217 119 6;          /* #D97706 */

            --atelier-border: rgba(255, 255, 255, 0.08);
            --flame-soft: rgba(245, 158, 11, 0.12);

            --header-bg: rgba(13, 11, 10, 0.9);
            --header-border: rgba(255, 255, 255, 0.08);
            --card-bg: rgba(28, 24, 21, 0.75);
            --card-border: rgba(255, 255, 255, 0.08);
            --card-hover-border: rgba(229, 195, 120, 0.3);

            --scrollbar-track: #0D0B0A;
            --scrollbar-thumb: #26211D;
            --scrollbar-thumb-hover: #E5C378;

            --tab-active-color: #E5C378;
            --tab-active-bg: rgba(229, 195, 120, 0.05);
            --shadow-atelier-card: 0 4px 20px -2px rgba(0, 0, 0, 0.4);
        }

        body {
            background-color: rgb(var(--atelier-base-rgb));
            color: rgb(var(--atelier-cream-rgb));
            overflow-x: hidden;
            transition: background-color 250ms ease, color 250ms ease;
        }

        .glass-header {
            background: var(--header-bg);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--header-border);
            transition: background 250ms ease, border-color 250ms ease;
        }

        .glass-card {
            background: var(--card-bg);
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
            border: 1px solid var(--card-border);
            box-shadow: var(--shadow-atelier-card);
            transition: all 250ms ease;
        }

        .glass-card:hover {
            border-color: var(--card-hover-border);
        }

        .tab-btn.active {
            color: var(--tab-active-color);
            border-bottom-color: var(--tab-active-color);
            background: var(--tab-active-bg);
        }

        .portal-pill {
            transition: all 0.2s ease;
        }
        .portal-pill:hover {
            transform: translateY(-1px);
        }

        ::-webkit-scrollbar {
            width: 6px;
        }
        ::-webkit-scrollbar-track {
            background: var(--scrollbar-track);
        }
        ::-webkit-scrollbar-thumb {
            background: var(--scrollbar-thumb);
            border-radius: 999px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: var(--scrollbar-thumb-hover);
        }

        /* Light theme adaptive overrides */
        html:not(.dark) [class*="border-white/5"] {
            border-color: rgba(44, 34, 26, 0.06) !important;
        }
        html:not(.dark) [class*="border-white/10"] {
            border-color: rgba(44, 34, 26, 0.09) !important;
        }
        html:not(.dark) [class*="border-white/15"] {
            border-color: rgba(44, 34, 26, 0.13) !important;
        }
        html:not(.dark) [class*="border-white/20"] {
            border-color: rgba(44, 34, 26, 0.18) !important;
        }
        html:not(.dark) [class*="border-white/30"] {
            border-color: rgba(44, 34, 26, 0.25) !important;
        }

        html:not(.dark) [class*="bg-white/5"] {
            background-color: rgba(44, 34, 26, 0.035) !important;
        }
        html:not(.dark) [class*="bg-white/10"] {
            background-color: rgba(44, 34, 26, 0.06) !important;
        }
        html:not(.dark) [class*="bg-white/20"] {
            background-color: rgba(44, 34, 26, 0.1) !important;
        }
        html:not(.dark) [class*="bg-white/[0.02]"] {
            background-color: rgba(44, 34, 26, 0.02) !important;
        }

        html:not(.dark) .hover\:text-white:hover {
            color: #1C1613 !important;
        }
        html:not(.dark) .hover\:bg-white:hover {
            background-color: #1C1613 !important;
            color: #FAF7F2 !important;
        }
        html:not(.dark) .hover\:bg-white\/10:hover {
            background-color: rgba(44, 34, 26, 0.08) !important;
        }
        html:not(.dark) .hover\:border-white\/30:hover {
            border-color: rgba(44, 34, 26, 0.3) !important;
        }
        html:not(.dark) .bg-atelier-card {
            box-shadow: 0 4px 18px -2px rgba(44, 34, 26, 0.05), 0 1px 3px rgba(44, 34, 26, 0.03);
        }
    </style>
</head>
<body class="font-sans antialiased text-atelier-cream bg-atelier-base min-h-screen flex flex-col">

    <!-- Universal Portal Switcher Banner -->
    <div class="bg-atelier-card/90 border-b border-white/10 px-4 py-2 text-xs">
        <div class="max-w-7xl mx-auto flex flex-wrap items-center justify-between gap-3">
            <div class="flex items-center gap-2 text-atelier-muted" id="portal-user-badge">
                <span class="inline-flex items-center justify-center w-2 h-2 rounded-full bg-flame-amber animate-pulse"></span>
                <span class="text-[11px] uppercase tracking-wider font-semibold text-flame-glow">Atelier Operations:</span>
                <span class="text-[11px] text-atelier-cream">Active Role — <strong class="text-white">Store Admin / Master Artisan</strong></span>
            </div>
            <div class="flex items-center gap-2 sm:gap-3 flex-wrap">
                <span class="text-[10px] uppercase tracking-widest text-atelier-dim hidden sm:inline">Switch Workspace:</span>
                <a href="{{ route('home') }}" class="portal-pill inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-semibold tracking-wider uppercase border border-white/10 text-atelier-muted hover:text-white hover:border-white/30">
                    <i class="fa-solid fa-store text-[9px]"></i> Storefront
                </a>
                <a href="{{ route('profile.index') }}" class="portal-pill inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-semibold tracking-wider uppercase border border-white/10 text-atelier-muted hover:text-white hover:border-luxe-gold/50">
                    <i class="fa-solid fa-user text-[9px]"></i> Client Profile
                </a>
                <a href="{{ route('admin.index') }}" class="portal-pill inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-semibold tracking-wider uppercase border border-flame-glow bg-flame-soft text-flame-glow font-bold">
                    <i class="fa-solid fa-shield-halved text-[9px]"></i> Atelier Admin
                </a>
                <a href="{{ route('superadmin.index') }}" class="portal-pill inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-semibold tracking-wider uppercase border border-white/10 text-atelier-muted hover:text-white hover:border-flame-amber">
                    <i class="fa-solid fa-crown text-[9px] text-flame-glow"></i> Super Admin
                </a>
            </div>
        </div>
    </div>

    <!-- Main Admin Navigation Header -->
    <header class="glass-header sticky top-0 z-40">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
            <a href="{{ route('home') }}" class="group flex items-center gap-3">
                <span class="text-flame-glow text-xl">
                    <i class="fa-solid fa-fire-flame-curved"></i>
                </span>
                <div class="flex flex-col">
                    <span class="font-display text-2xl font-bold tracking-[0.25em] text-atelier-cream group-hover:text-luxe-gold transition">
                        SONDHI
                    </span>
                    <span class="text-[9px] tracking-[0.3em] uppercase text-flame-glow">Atelier Operations Cockpit</span>
                </div>
            </a>

            <!-- Quick Action Shortcuts -->
            <div class="flex items-center gap-3">
                <button id="theme-toggle-btn" onclick="toggleAtelierTheme()" class="theme-toggle-btn p-2 rounded-lg bg-atelier-card border border-white/15 text-atelier-muted hover:text-luxe-gold text-xs transition" title="Switch to Dark Theme" aria-label="Toggle Theme">
                    <i class="fa-solid fa-moon text-xs theme-moon-icon text-amber-700"></i>
                    <i class="fa-solid fa-sun text-xs theme-sun-icon text-amber-400 hidden"></i>
                </button>
                <button onclick="openNewCandleModal()" class="hidden sm:inline-flex items-center gap-2 px-3.5 py-2 rounded-lg bg-luxe-gold text-atelier-base text-xs font-bold uppercase tracking-wider hover:bg-white transition shadow-lg shadow-luxe-gold/10">
                    <i class="fa-solid fa-plus"></i> Add Fragrance
                </button>
                <button onclick="switchAdminTab('billing')" class="inline-flex items-center gap-2 px-3.5 py-2 rounded-lg bg-atelier-card border border-white/15 text-xs font-semibold text-luxe-gold hover:border-luxe-gold transition">
                    <i class="fa-solid fa-coins"></i> Payouts: ₹1.84L
                </button>
                <div class="h-10 w-10 rounded-full border border-flame-glow/50 bg-flame-soft flex items-center justify-center text-flame-glow font-bold text-sm">
                    ADM
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content Area -->
    <main class="flex-1 max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <!-- Atelier Pulse KPI Grid -->
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 mb-8">
            <div class="glass-card rounded-2xl p-5 relative overflow-hidden">
                <div class="flex items-center justify-between text-xs text-atelier-muted">
                    <span class="uppercase tracking-wider font-semibold">Today's Revenue</span>
                    <i class="fa-solid fa-chart-line text-luxe-gold"></i>
                </div>
                <div class="font-display text-2xl sm:text-3xl font-bold text-atelier-cream mt-2" id="kpi-today-rev">₹48,240</div>
                <div class="text-[11px] text-luxe-sage mt-1 flex items-center gap-1">
                    <i class="fa-solid fa-arrow-trend-up"></i> +18.4% vs yesterday
                </div>
            </div>

            <div class="glass-card rounded-2xl p-5 relative overflow-hidden">
                <div class="flex items-center justify-between text-xs text-atelier-muted">
                    <span class="uppercase tracking-wider font-semibold">Active Pours & Curing</span>
                    <i class="fa-solid fa-fire text-flame-glow"></i>
                </div>
                <div class="font-display text-2xl sm:text-3xl font-bold text-flame-glow mt-2" id="kpi-active-pours">14 Batches</div>
                <div class="text-[11px] text-atelier-dim mt-1">420kg soy wax resting</div>
            </div>

            <div class="glass-card rounded-2xl p-5 relative overflow-hidden">
                <div class="flex items-center justify-between text-xs text-atelier-muted">
                    <span class="uppercase tracking-wider font-semibold">Orders Pending Dispatch</span>
                    <i class="fa-solid fa-box-open text-blue-400"></i>
                </div>
                <div class="font-display text-2xl sm:text-3xl font-bold text-atelier-cream mt-2" id="kpi-pending-orders">7 Orders</div>
                <div class="text-[11px] text-amber-400 mt-1 flex items-center gap-1">
                    <i class="fa-solid fa-clock"></i> 3 VIP orders priority
                </div>
            </div>

            <div class="glass-card rounded-2xl p-5 relative overflow-hidden">
                <div class="flex items-center justify-between text-xs text-atelier-muted">
                    <span class="uppercase tracking-wider font-semibold">Net Merchant Balance</span>
                    <i class="fa-solid fa-building-columns text-emerald-400"></i>
                </div>
                <div class="font-display text-2xl sm:text-3xl font-bold text-luxe-gold mt-2" id="kpi-payout-bal">₹1,84,520</div>
                <div class="text-[11px] text-atelier-dim mt-1">Next payout scheduled Friday</div>
            </div>
        </div>

        <!-- Navigation Tabs -->
        <div class="flex overflow-x-auto border-b border-white/10 gap-1 sm:gap-2 mb-8 no-scrollbar">
            <button onclick="switchAdminTab('orders')" id="tab-admin-orders" class="tab-btn active px-4 sm:px-6 py-3 border-b-2 border-transparent text-xs sm:text-sm font-semibold tracking-wider uppercase whitespace-nowrap transition flex items-center gap-2">
                <i class="fa-solid fa-clipboard-list text-xs"></i> Orders & Fulfillment
            </button>
            <button onclick="switchAdminTab('products')" id="tab-admin-products" class="tab-btn px-4 sm:px-6 py-3 border-b-2 border-transparent text-xs sm:text-sm font-semibold tracking-wider uppercase whitespace-nowrap transition flex items-center gap-2">
                <i class="fa-solid fa-wand-magic-sparkles text-xs"></i> Candle Catalog
            </button>
            <button onclick="switchAdminTab('billing')" id="tab-admin-billing" class="tab-btn px-4 sm:px-6 py-3 border-b-2 border-transparent text-xs sm:text-sm font-semibold tracking-wider uppercase whitespace-nowrap transition flex items-center gap-2 text-luxe-gold">
                <i class="fa-solid fa-wallet text-xs"></i> Store Billing & Payouts
            </button>
            <button onclick="switchAdminTab('supplies')" id="tab-admin-supplies" class="tab-btn px-4 sm:px-6 py-3 border-b-2 border-transparent text-xs sm:text-sm font-semibold tracking-wider uppercase whitespace-nowrap transition flex items-center gap-2">
                <i class="fa-solid fa-leaf text-xs"></i> Raw Botanicals & Supplies
            </button>
            <button onclick="switchAdminTab('concierge')" id="tab-admin-concierge" class="tab-btn px-4 sm:px-6 py-3 border-b-2 border-transparent text-xs sm:text-sm font-semibold tracking-wider uppercase whitespace-nowrap transition flex items-center gap-2">
                <i class="fa-solid fa-comments text-xs"></i> Custom Blends Desk
            </button>
        </div>

        <!-- TAB 1: ORDERS & FULFILLMENT -->
        <section id="section-admin-orders" class="tab-content space-y-6">
            <div class="glass-card rounded-2xl p-6">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 border-b border-white/10 pb-4 mb-6">
                    <div>
                        <h2 class="font-display text-xl font-semibold text-atelier-cream">Candle Pouring & Dispatch Pipeline</h2>
                        <p class="text-xs text-atelier-muted">Manage commissions through artisan hand-pouring, 7-day curing, and white-glove packaging</p>
                    </div>
                    <!-- Status Filter Buttons -->
                    <div class="flex flex-wrap gap-2 text-xs" id="order-filter-btns">
                        <button onclick="filterOrdersByStatus('all')" class="px-3 py-1.5 rounded-lg bg-luxe-gold/20 text-luxe-gold border border-luxe-gold font-semibold uppercase text-[10px]">All Orders</button>
                        <button onclick="filterOrdersByStatus('Pending')" class="px-3 py-1.5 rounded-lg bg-atelier-surface hover:bg-white/10 text-atelier-muted border border-white/10 font-semibold uppercase text-[10px]">Pending</button>
                        <button onclick="filterOrdersByStatus('Pouring & Curing')" class="px-3 py-1.5 rounded-lg bg-atelier-surface hover:bg-white/10 text-atelier-muted border border-white/10 font-semibold uppercase text-[10px]">Pouring & Curing</button>
                        <button onclick="filterOrdersByStatus('Dispatched')" class="px-3 py-1.5 rounded-lg bg-atelier-surface hover:bg-white/10 text-atelier-muted border border-white/10 font-semibold uppercase text-[10px]">Dispatched</button>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs">
                        <thead>
                            <tr class="border-b border-white/10 text-atelier-muted uppercase tracking-wider text-[10px]">
                                <th class="pb-3 font-semibold">Order ID</th>
                                <th class="pb-3 font-semibold">Patron / Client</th>
                                <th class="pb-3 font-semibold">Candle Commission</th>
                                <th class="pb-3 font-semibold">Total</th>
                                <th class="pb-3 font-semibold">Current State</th>
                                <th class="pb-3 font-semibold text-right">Advance Workflow</th>
                            </tr>
                        </thead>
                        <tbody id="admin-orders-table-body" class="divide-y divide-white/5">
                            <!-- Injected by admin.js -->
                        </tbody>
                    </table>
                </div>
            </div>
        </section>

        <!-- TAB 2: PRODUCT & CANDLE CATALOG -->
        <section id="section-admin-products" class="tab-content hidden space-y-6">
            <div class="glass-card rounded-2xl p-6">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-white/10 pb-4 mb-6">
                    <div>
                        <h2 class="font-display text-xl font-semibold text-atelier-cream">Fragrance Catalog Management</h2>
                        <p class="text-xs text-atelier-muted">Maintain formulation descriptions, inventory counts, pricing, and active gallery status</p>
                    </div>
                    <button onclick="openNewCandleModal()" class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-luxe-gold text-atelier-base text-xs font-bold uppercase tracking-wider hover:bg-white transition">
                        <i class="fa-solid fa-plus"></i> Add New Candle
                    </button>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs">
                        <thead>
                            <tr class="border-b border-white/10 text-atelier-muted uppercase tracking-wider text-[10px]">
                                <th class="pb-3 font-semibold">Candle Fragrance</th>
                                <th class="pb-3 font-semibold">Category</th>
                                <th class="pb-3 font-semibold">Vessel & Size</th>
                                <th class="pb-3 font-semibold">Price (INR)</th>
                                <th class="pb-3 font-semibold">Units In Stock</th>
                                <th class="pb-3 font-semibold">Status</th>
                                <th class="pb-3 font-semibold text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="admin-products-table-body" class="divide-y divide-white/5">
                            <!-- Populated by admin.js -->
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="glass-card rounded-2xl p-6">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-white/10 pb-4 mb-4">
                    <div>
                        <h2 class="font-display text-xl font-semibold text-atelier-cream">New Product Requests</h2>
                        <p class="text-xs text-atelier-muted">Submit a proposed product for approval before it enters the live catalog.</p>
                    </div>
                    <button onclick="openModal('modal-product-request')" class="inline-flex items-center gap-2 px-4 py-2 rounded-lg border border-luxe-gold/50 text-luxe-gold text-xs font-bold uppercase tracking-wider hover:bg-luxe-gold hover:text-atelier-base transition">
                        <i class="fa-solid fa-file-circle-plus"></i> Request Product
                    </button>
                </div>
                <div id="product-requests-list" class="space-y-3"></div>
            </div>
        </section>

        <!-- TAB 3: STORE BILLING & PAYOUTS (REQUESTED CORE SECTION) -->
        <section id="section-admin-billing" class="tab-content hidden space-y-8">
            <!-- Payout & Gateway Overview -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="glass-card rounded-2xl p-6 border border-luxe-gold/40 relative overflow-hidden">
                    <div class="absolute -right-8 -bottom-8 w-32 h-32 bg-luxe-gold/10 rounded-full blur-2xl pointer-events-none"></div>
                    <span class="text-xs font-semibold uppercase tracking-wider text-atelier-muted">Settlement Balance</span>
                    <div class="font-display text-3xl font-bold text-luxe-gold mt-2">₹1,84,520</div>
                    <p class="text-xs text-atelier-muted mt-1">Available for immediate manual transfer or weekly cycle</p>
                    <div class="mt-4 pt-4 border-t border-white/10 flex items-center justify-between">
                        <button onclick="requestPayoutModal()" class="px-4 py-2 rounded-lg bg-luxe-gold text-atelier-base text-xs font-bold uppercase tracking-wider hover:bg-white transition">
                            <i class="fa-solid fa-paper-plane mr-1"></i> Trigger Payout
                        </button>
                        <span class="text-[10px] text-atelier-dim">Auto: Every Friday</span>
                    </div>
                </div>

                <div class="glass-card rounded-2xl p-6 flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between mb-3">
                            <span class="text-xs font-semibold uppercase tracking-wider text-atelier-muted">Depository Bank Account</span>
                            <i class="fa-solid fa-building-columns text-emerald-400 text-lg"></i>
                        </div>
                        <div class="text-sm font-bold text-atelier-cream">HDFC Bank Ltd · Current Account</div>
                        <div class="font-mono text-xs text-atelier-muted mt-1">A/C: •••••••••• 9942</div>
                        <div class="text-[11px] text-atelier-dim">IFSC: HDFC0000060 (Fort, Mumbai)</div>
                    </div>
                    <div class="mt-4 pt-4 border-t border-white/10 flex items-center justify-between text-xs">
                        <span class="text-luxe-sage"><i class="fa-solid fa-shield-check mr-1"></i> KYC Verified</span>
                        <button onclick="showToast('Depository routing modifications require Super Admin approval.', true)" class="text-luxe-gold hover:underline font-semibold text-[11px]">
                            Manage
                        </button>
                    </div>
                </div>

                <div class="glass-card rounded-2xl p-6 flex flex-col justify-between">
                    <div>
                        <span class="text-xs font-semibold uppercase tracking-wider text-atelier-muted">Payment Processing Gateway</span>
                        <div class="mt-3 flex items-center gap-3">
                            <div class="px-3 py-1.5 rounded-lg bg-white/5 border border-white/10 text-xs font-bold text-atelier-cream">
                                Stripe Live
                            </div>
                            <span class="inline-flex items-center gap-1 text-[11px] text-luxe-sage">
                                <span class="w-1.5 h-1.5 rounded-full bg-luxe-sage"></span> 100% Operational
                            </span>
                        </div>
                        <div class="mt-3 text-xs text-atelier-muted">
                            Average processing fee: <strong>1.95% + ₹3</strong>
                        </div>
                    </div>
                    <div class="mt-4 pt-4 border-t border-white/10 flex items-center justify-between text-xs">
                        <span class="text-atelier-dim">Gross sales MTD: ₹6,42,800</span>
                        <button onclick="downloadAdminBillingLedger()" class="text-luxe-gold hover:underline flex items-center gap-1 font-semibold text-[11px]">
                            <i class="fa-solid fa-file-excel"></i> Export Ledger
                        </button>
                    </div>
                </div>
            </div>

            <!-- Merchant Transactions & Refund Management -->
            <div class="glass-card rounded-2xl p-6">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-white/10 pb-4 mb-6">
                    <div>
                        <h2 class="font-display text-xl font-semibold text-atelier-cream">Customer Billing & Payment Ledger</h2>
                        <p class="text-xs text-atelier-muted">Real-time payment captures, 3D secure authentications, and refund requests</p>
                    </div>
                    <div class="flex items-center gap-3">
                        <input type="text" id="admin-billing-search" placeholder="Search by customer or txn ID" onkeyup="filterAdminBilling()" class="bg-atelier-surface border border-white/10 rounded-lg px-3 py-1.5 text-xs text-atelier-cream focus:border-luxe-gold outline-none">
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs">
                        <thead>
                            <tr class="border-b border-white/10 text-atelier-muted uppercase tracking-wider text-[10px]">
                                <th class="pb-3 font-semibold">Transaction ID</th>
                                <th class="pb-3 font-semibold">Timestamp</th>
                                <th class="pb-3 font-semibold">Patron Name</th>
                                <th class="pb-3 font-semibold">Method</th>
                                <th class="pb-3 font-semibold">Gross</th>
                                <th class="pb-3 font-semibold">Net Atelier</th>
                                <th class="pb-3 font-semibold">Status</th>
                                <th class="pb-3 font-semibold text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="admin-billing-table-body" class="divide-y divide-white/5">
                            <!-- Populated by admin.js -->
                        </tbody>
                    </table>
                </div>
            </div>
        </section>

        <!-- TAB 4: RAW BOTANICALS & SUPPLIES -->
        <section id="section-admin-supplies" class="tab-content hidden space-y-6">
            <div class="glass-card rounded-2xl p-6">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-white/10 pb-4 mb-6">
                    <div>
                        <h2 class="font-display text-xl font-semibold text-atelier-cream">Botanical Wax & Fragrance Raw Materials</h2>
                        <p class="text-xs text-atelier-muted">Monitor raw supply levels for soy wax flakes, wooden wicks, glass and terracotta vessels</p>
                    </div>
                    <button onclick="restockSuppliesPrompt()" class="px-4 py-2 rounded-lg bg-luxe-gold text-atelier-base text-xs font-bold uppercase tracking-wider hover:bg-white transition">
                        <i class="fa-solid fa-cart-flatbed mr-1"></i> Order Raw Materials
                    </button>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6" id="supplies-grid">
                    <!-- Supplies populated by admin.js -->
                </div>
            </div>
        </section>

        <!-- TAB 5: CONCIERGE & BESPOKE REQUESTS -->
        <section id="section-admin-concierge" class="tab-content hidden space-y-6">
            <div class="glass-card rounded-2xl p-6">
                <div class="border-b border-white/10 pb-4 mb-6">
                    <h2 class="font-display text-xl font-semibold text-atelier-cream">Bespoke Atelier Studio Commisions Desk</h2>
                    <p class="text-xs text-atelier-muted">Custom formula reviews crafted by online patrons requiring artisan sign-off</p>
                </div>

                <div id="concierge-inquiries-container" class="space-y-4">
                    <!-- Concierge queue -->
                </div>
            </div>
        </section>

    </main>

    <!-- FOOTER -->
    <footer class="mt-auto border-t border-white/10 bg-atelier-surface py-6 text-center text-xs text-atelier-muted">
        <div class="max-w-7xl mx-auto px-4 flex flex-col sm:flex-row items-center justify-between gap-4">
            <span class="font-display tracking-widest uppercase">Sondhi Botanicals Atelier · Operations Admin</span>
            <div class="flex items-center gap-4 text-xs text-atelier-dim">
                <a href="{{ route('home') }}" class="hover:text-atelier-cream">Storefront</a>
                <span>•</span>
                <a href="{{ route('profile.index') }}" class="hover:text-atelier-cream">Client Profile</a>
                <span>•</span>
                <a href="{{ route('superadmin.index') }}" class="hover:text-atelier-cream">Super Admin Governance</a>
            </div>
        </div>
    </footer>

    <!-- MODAL: ADD NEW CANDLE -->
    <div id="modal-new-candle" class="fixed inset-0 z-50 bg-black/80 backdrop-blur-md opacity-0 pointer-events-none transition-opacity duration-300 flex items-center justify-center p-4">
        <div class="relative w-full max-w-lg rounded-2xl bg-atelier-surface border border-luxe-gold/30 p-6 sm:p-8 shadow-2xl scale-95 transition-transform duration-300 max-h-[90vh] overflow-y-auto">
            <div class="flex items-center justify-between border-b border-white/10 pb-4 mb-5">
                <h3 class="font-display text-xl font-semibold text-atelier-cream">Introduce New Fragrance</h3>
                <button onclick="closeModal('modal-new-candle')" class="text-atelier-muted hover:text-white">
                    <i class="fa-solid fa-xmark text-base"></i>
                </button>
            </div>

            <form id="new-candle-form" onsubmit="event.preventDefault(); submitNewCandle();" class="space-y-4 text-xs">
                <div>
                    <label class="block uppercase font-semibold tracking-wider text-atelier-muted mb-1">Fragrance Name</label>
                    <input type="text" id="candle-name" required placeholder="e.g. Saffron & Golden Vetiver" class="w-full bg-atelier-card border border-white/10 rounded-lg px-3 py-2 text-sm text-atelier-cream focus:border-luxe-gold outline-none">
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block uppercase font-semibold tracking-wider text-atelier-muted mb-1">Olfactory Category</label>
                        <select id="candle-category" class="w-full bg-atelier-card border border-white/10 rounded-lg px-3 py-2 text-sm text-atelier-cream focus:border-luxe-gold outline-none">
                            <option value="Woody">Woody & Oud</option>
                            <option value="Floral">Floral & Rose</option>
                            <option value="Warm">Warm & Spiced</option>
                            <option value="Fresh">Fresh & Botanical</option>
                        </select>
                    </div>
                    <div>
                        <label class="block uppercase font-semibold tracking-wider text-atelier-muted mb-1">Price (INR)</label>
                        <input type="number" id="candle-price" required min="400" step="50" value="999" class="w-full bg-atelier-card border border-white/10 rounded-lg px-3 py-2 text-sm text-atelier-cream focus:border-luxe-gold outline-none">
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block uppercase font-semibold tracking-wider text-atelier-muted mb-1">Burn Time</label>
                        <input type="text" id="candle-burn" value="50 Hours" class="w-full bg-atelier-card border border-white/10 rounded-lg px-3 py-2 text-sm text-atelier-cream focus:border-luxe-gold outline-none">
                    </div>
                    <div>
                        <label class="block uppercase font-semibold tracking-wider text-atelier-muted mb-1">Initial Batch Units</label>
                        <input type="number" id="candle-stock" min="1" value="35" class="w-full bg-atelier-card border border-white/10 rounded-lg px-3 py-2 text-sm text-atelier-cream focus:border-luxe-gold outline-none">
                    </div>
                </div>
                <div>
                    <label class="block uppercase font-semibold tracking-wider text-atelier-muted mb-1">Sensory Notes Description</label>
                    <textarea id="candle-desc" rows="2" placeholder="Sensory story and throw description..." class="w-full bg-atelier-card border border-white/10 rounded-lg px-3 py-2 text-sm text-atelier-cream focus:border-luxe-gold outline-none"></textarea>
                </div>
                <div class="pt-4 flex gap-3">
                    <button type="button" onclick="closeModal('modal-new-candle')" class="flex-1 py-2.5 rounded-lg border border-white/10 text-atelier-muted hover:text-white uppercase font-semibold tracking-wider">Cancel</button>
                    <button type="submit" class="flex-1 py-2.5 rounded-lg bg-luxe-gold text-atelier-base font-bold uppercase tracking-wider hover:bg-white transition">Add to Collection</button>
                </div>
            </form>
        </div>
    </div>

    <div id="modal-product-request" class="fixed inset-0 z-50 bg-black/80 backdrop-blur-md opacity-0 pointer-events-none transition-opacity duration-300 flex items-center justify-center p-4">
        <div class="relative w-full max-w-lg rounded-2xl bg-atelier-surface border border-luxe-gold/30 p-6 sm:p-8 shadow-2xl scale-95 transition-transform duration-300 max-h-[90vh] overflow-y-auto">
            <div class="flex items-center justify-between border-b border-white/10 pb-4 mb-5">
                <h3 class="font-display text-xl font-semibold text-atelier-cream">Request New Product</h3>
                <button onclick="closeModal('modal-product-request')" class="text-atelier-muted hover:text-white" aria-label="Close product request form">
                    <i class="fa-solid fa-xmark text-base"></i>
                </button>
            </div>
            <form id="product-request-form" onsubmit="event.preventDefault(); submitProductRequest();" class="space-y-4 text-xs">
                <div>
                    <label class="block uppercase font-semibold tracking-wider text-atelier-muted mb-1" for="request-product-name">Product Name</label>
                    <input id="request-product-name" type="text" required placeholder="e.g. Monsoon Saffron Reserve" class="w-full bg-atelier-card border border-white/10 rounded-lg px-3 py-2 text-sm text-atelier-cream focus:border-luxe-gold outline-none">
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block uppercase font-semibold tracking-wider text-atelier-muted mb-1" for="request-product-category">Category</label>
                        <select id="request-product-category" class="w-full bg-atelier-card border border-white/10 rounded-lg px-3 py-2 text-sm text-atelier-cream focus:border-luxe-gold outline-none">
                            <option value="Woody">Woody & Oud</option>
                            <option value="Floral">Floral & Rose</option>
                            <option value="Warm">Warm & Spiced</option>
                            <option value="Fresh">Fresh & Botanical</option>
                        </select>
                    </div>
                    <div>
                        <label class="block uppercase font-semibold tracking-wider text-atelier-muted mb-1" for="request-product-price">Target Price (INR)</label>
                        <input id="request-product-price" type="number" min="0" required value="999" class="w-full bg-atelier-card border border-white/10 rounded-lg px-3 py-2 text-sm text-atelier-cream focus:border-luxe-gold outline-none">
                    </div>
                </div>
                <div>
                    <label class="block uppercase font-semibold tracking-wider text-atelier-muted mb-1" for="request-product-notes">Request Notes</label>
                    <textarea id="request-product-notes" rows="3" placeholder="Vessel, fragrance notes, initial batch size, or reason for the request..." class="w-full bg-atelier-card border border-white/10 rounded-lg px-3 py-2 text-sm text-atelier-cream focus:border-luxe-gold outline-none"></textarea>
                </div>
                <div class="pt-4 flex gap-3">
                    <button type="button" onclick="closeModal('modal-product-request')" class="flex-1 py-2.5 rounded-lg border border-white/10 text-atelier-muted hover:text-white uppercase font-semibold tracking-wider">Cancel</button>
                    <button type="submit" class="flex-1 py-2.5 rounded-lg bg-luxe-gold text-atelier-base font-bold uppercase tracking-wider hover:bg-white transition">Send Request</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Toast -->
    <div id="toast" class="fixed bottom-6 right-6 z-50 flex items-center gap-3 rounded-xl bg-atelier-surface border border-luxe-gold px-4 py-3 shadow-2xl text-xs text-atelier-cream opacity-0 pointer-events-none transition-all duration-300">
        <i class="fa-solid fa-circle-check text-luxe-gold text-sm" id="toast-icon"></i>
        <span id="toast-message">Operation successful</span>
    </div>

    <!-- Core Auth & Admin Logic -->
    <script src="{{ asset('js/auth.js') }}"></script>
    <script src="{{ asset('js/admin.js') }}"></script>
</body>
</html>
