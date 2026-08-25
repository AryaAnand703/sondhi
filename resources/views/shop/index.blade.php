@extends('layouts.app')

@section('title', 'Artisan Handcrafted Soy Candles & Fragrances | Sondhi')

@section('content')
<!-- Hero Section -->
<div class="gradient-brand text-white py-16 lg:py-24 px-4 sm:px-6 lg:px-8 shadow-2xl mb-12 relative overflow-hidden">
    <!-- Ambient Background Glow Accents -->
    <div class="absolute top-0 left-1/4 w-96 h-96 bg-amber-500/10 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute bottom-0 right-10 w-80 h-80 bg-brand-400/20 rounded-full blur-3xl pointer-events-none"></div>

    <div class="max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-12 gap-12 items-center relative z-10">
        <!-- Hero Text & CTAs -->
        <div class="lg:col-span-7 space-y-6 text-center lg:text-left">
            <div class="inline-flex items-center space-x-2 px-4 py-1.5 bg-amber-500/20 text-amber-300 rounded-full text-xs font-bold uppercase tracking-wider border border-amber-400/30 shadow-sm">
                <i class="fa-solid fa-sparkles text-amber-400"></i>
                <span>100% Pure Soy Wax & Essential Oils</span>
            </div>

            <h1 class="font-serif text-4xl sm:text-5xl lg:text-6xl font-bold leading-tight tracking-tight">
                Illuminating Moments with <span class="text-amber-400 italic">Handcrafted Luxury.</span>
            </h1>

            <p class="text-brand-100 text-sm sm:text-base lg:text-lg leading-relaxed max-w-2xl mx-auto lg:mx-0 font-light">
                Discover our curated collection of luxury scented candles, botanical wax tablets, and organic reed diffusers. Thoughtfully handcrafted to create warm, inviting ambiances.
            </p>

            <div class="flex flex-wrap items-center justify-center lg:justify-start gap-4 pt-2">
                <a href="#catalog" class="px-8 py-4 bg-amber-500 hover:bg-amber-600 text-white font-bold text-sm rounded-full shadow-xl shadow-amber-500/30 transition-all hover:scale-105 transform flex items-center space-x-2">
                    <span>Explore Full Catalog</span>
                    <i class="fa-solid fa-arrow-right text-xs"></i>
                </a>
                <a href="#bestsellers" class="px-8 py-4 bg-white/10 hover:bg-white/20 text-white font-bold text-sm rounded-full border border-white/20 transition-all hover:scale-105 transform">
                    <i class="fa-solid fa-fire text-amber-400 mr-2"></i> View Bestsellers
                </a>
            </div>

            <!-- Trust Highlights Badges -->
            <div class="pt-6 border-t border-white/10 grid grid-cols-3 gap-4 max-w-lg mx-auto lg:mx-0 text-center lg:text-left">
                <div>
                    <span class="block text-xl lg:text-2xl font-bold text-amber-400">4.9 ★</span>
                    <span class="text-[11px] text-brand-200 uppercase tracking-wider font-semibold">5,000+ Ratings</span>
                </div>
                <div>
                    <span class="block text-xl lg:text-2xl font-bold text-amber-400">100%</span>
                    <span class="text-[11px] text-brand-200 uppercase tracking-wider font-semibold">Non-Toxic Soy</span>
                </div>
                <div>
                    <span class="block text-xl lg:text-2xl font-bold text-amber-400">Pan-India</span>
                    <span class="text-[11px] text-brand-200 uppercase tracking-wider font-semibold">Free Shipping ₹999+</span>
                </div>
            </div>
        </div>

        <!-- Hero Showcase Card -->
        <div class="lg:col-span-5 relative flex justify-center">
            <div class="relative">
                <div class="w-72 sm:w-80 h-96 bg-gray-100 rounded-3xl overflow-hidden shadow-2xl ring-8 ring-white/10 transform -rotate-2 hover:rotate-0 transition-all duration-500 group">
                    <img src="https://images.unsplash.com/photo-1603006905003-be475563bc59?auto=format&fit=crop&w=800&q=80" 
                         alt="Luxury Artisan Candle" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-transparent to-transparent flex flex-col justify-end p-6 text-white">
                        <span class="px-3 py-1 bg-amber-500 text-white font-bold text-[10px] uppercase rounded-full w-max shadow mb-2">Signature Blend</span>
                        <h3 class="font-serif text-xl font-bold">French Lavender & Amber Jar</h3>
                        <p class="text-xs text-amber-200 mt-0.5">45+ Hours Clean Burn Time</p>
                    </div>
                </div>
                <!-- Floating Badge -->
                <div class="absolute -bottom-6 -left-6 bg-white p-4 rounded-2xl shadow-xl border border-gray-100 flex items-center space-x-3 text-gray-900 animate-bounce-slow">
                    <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-lg">
                        <i class="fa-solid fa-leaf"></i>
                    </div>
                    <div>
                        <p class="text-xs font-bold">Eco-Friendly Packaging</p>
                        <p class="text-[10px] text-gray-500">Recyclable Glass & Cotton Wick</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Brand Value Propositions Grid -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-16">
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Feature 1 -->
        <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm hover:shadow-md transition-all flex items-start space-x-4">
            <div class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center text-xl shrink-0">
                <i class="fa-solid fa-seedling"></i>
            </div>
            <div>
                <h4 class="font-bold text-sm text-gray-900">100% Organic Soy Wax</h4>
                <p class="text-xs text-gray-500 mt-1 leading-relaxed">Clean burning, lead-free cotton wicks, completely toxin-free.</p>
            </div>
        </div>

        <!-- Feature 2 -->
        <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm hover:shadow-md transition-all flex items-start space-x-4">
            <div class="w-12 h-12 rounded-2xl bg-purple-50 text-purple-600 flex items-center justify-center text-xl shrink-0">
                <i class="fa-solid fa-droplet"></i>
            </div>
            <div>
                <h4 class="font-bold text-sm text-gray-900">Pure Essential Oils</h4>
                <p class="text-xs text-gray-500 mt-1 leading-relaxed">Hand-blended aromatic oils for long-lasting soothing throw.</p>
            </div>
        </div>

        <!-- Feature 3 -->
        <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm hover:shadow-md transition-all flex items-start space-x-4">
            <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-xl shrink-0">
                <i class="fa-solid fa-truck-fast"></i>
            </div>
            <div>
                <h4 class="font-bold text-sm text-gray-900">Pan-India Express Delivery</h4>
                <p class="text-xs text-gray-500 mt-1 leading-relaxed">Safe bubble-padded boxes with free delivery above ₹999.</p>
            </div>
        </div>

        <!-- Feature 4 -->
        <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm hover:shadow-md transition-all flex items-start space-x-4">
            <div class="w-12 h-12 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center text-xl shrink-0">
                <i class="fa-solid fa-gift"></i>
            </div>
            <div>
                <h4 class="font-bold text-sm text-gray-900">Bespoke Gift Packaging</h4>
                <p class="text-xs text-gray-500 mt-1 leading-relaxed">Free handwritten note & signature satin ribbons included.</p>
            </div>
        </div>
    </div>
</div>

<!-- Category Spotlight Showcase -->
@if($categories->count() > 0)
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-16">
    <div class="flex justify-between items-end mb-8">
        <div>
            <span class="text-xs font-bold text-brand-600 uppercase tracking-wider">Curated Collections</span>
            <h2 class="font-serif text-3xl font-bold text-gray-900 mt-1">Shop by Category</h2>
        </div>
        <a href="#catalog" class="text-xs font-bold text-brand-600 hover:text-brand-700 flex items-center space-x-1">
            <span>View All</span>
            <i class="fa-solid fa-chevron-right text-[10px]"></i>
        </a>
    </div>

    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 sm:gap-6">
        @foreach($categories as $category)
            <a href="{{ route('shop.index', ['category' => $category->slug]) }}" 
               class="group relative h-48 sm:h-56 rounded-3xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col justify-end p-5 text-white">
                <!-- Background Category Accent -->
                <div class="absolute inset-0 bg-gradient-to-t from-slate-900/85 via-slate-900/40 to-transparent z-10 transition-opacity group-hover:from-slate-900/90"></div>
                <img src="{{ $category->image_path ?: 'https://images.unsplash.com/photo-1603006905003-be475563bc59?auto=format&fit=crop&w=600&q=80' }}" 
                     alt="{{ $category->name }}" class="absolute inset-0 w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                
                <div class="relative z-20">
                    <span class="text-[10px] font-bold uppercase tracking-wider text-amber-400">{{ $category->products_count }} Products</span>
                    <h3 class="font-serif text-lg font-bold text-white group-hover:text-amber-300 transition-colors">{{ $category->name }}</h3>
                </div>
            </a>
        @endforeach
    </div>
</div>
@endif

<!-- Bestseller Spotlight Section -->
@if(isset($featuredProducts) && $featuredProducts->count() > 0)
<div id="bestsellers" class="bg-amber-50/50 py-16 border-y border-amber-100/60 mb-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-2xl mx-auto mb-12">
            <span class="inline-block px-3 py-1 bg-amber-100 text-amber-800 rounded-full text-xs font-bold uppercase tracking-wider">🌟 Customer Favorites</span>
            <h2 class="font-serif text-3xl sm:text-4xl font-bold text-gray-900 mt-2">Bestselling Fragrances</h2>
            <p class="text-xs sm:text-sm text-gray-600 mt-2">Handpicked by our scent artisans and loved by thousands of candle enthusiasts.</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($featuredProducts as $featured)
                <div class="bg-white rounded-3xl overflow-hidden shadow-sm hover:shadow-xl border border-amber-100 transition-all duration-300 flex flex-col justify-between group">
                    <div class="relative overflow-hidden bg-gray-100 aspect-square">
                        <img src="{{ $featured->image_path }}" alt="{{ $featured->name }}" 
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        <span class="absolute top-3 left-3 px-3 py-1 bg-amber-500 text-white font-bold text-[10px] uppercase rounded-full shadow">★ BESTSELLER</span>
                    </div>

                    <div class="p-5 flex-grow flex flex-col justify-between space-y-3">
                        <div>
                            <div class="flex items-center space-x-1 text-amber-400 text-xs mb-1">
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <span class="text-[10px] text-gray-400 font-bold ml-1">(4.9)</span>
                            </div>
                            <h3 class="font-bold text-gray-900 text-base group-hover:text-brand-600 transition-colors line-clamp-1">
                                <a href="{{ route('shop.show', $featured->slug) }}">{{ $featured->name }}</a>
                            </h3>
                            <p class="text-xs text-gray-500 mt-1 line-clamp-2 leading-relaxed">{{ $featured->description }}</p>
                        </div>

                        <div class="pt-3 border-t border-gray-100 flex items-center justify-between">
                            <div>
                                <span class="text-lg font-bold text-gray-900">₹{{ number_format($featured->price, 2) }}</span>
                            </div>

                            <form action="{{ route('cart.add') }}" method="POST">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $featured->id }}">
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit" class="px-4 py-2 rounded-xl bg-amber-500 text-white hover:bg-amber-600 font-bold text-xs shadow-md shadow-amber-500/20 transition-all flex items-center space-x-1">
                                    <i class="fa-solid fa-cart-plus mr-1"></i>
                                    <span>Add</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endif

<!-- Main Catalog Container -->
<div id="catalog" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-16">
    <!-- Catalog Header & Search/Sort controls -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 pb-4 border-b border-gray-200 gap-4">
        <div>
            <h2 class="font-serif text-2xl sm:text-3xl font-bold text-gray-900">
                @if(request('search'))
                    Search Results for "<span class="text-brand-600">{{ request('search') }}</span>"
                @elseif(request('category'))
                    Category: <span class="text-brand-600">{{ ucfirst(str_replace('-', ' ', request('category'))) }}</span>
                @else
                    Entire Artisan Collection
                @endif
            </h2>
            <p class="text-xs text-gray-500 mt-1">Showing {{ $products->total() }} premium products</p>
        </div>

        <!-- Sort Filter Dropdown -->
        <form action="{{ route('shop.index') }}" method="GET" class="flex flex-wrap items-center gap-3">
            @if(request('category')) <input type="hidden" name="category" value="{{ request('category') }}"> @endif
            @if(request('search')) <input type="hidden" name="search" value="{{ request('search') }}"> @endif
            
            <label class="text-xs font-bold uppercase text-gray-500">Sort By:</label>
            <select name="sort" onchange="this.form.submit()" class="px-4 py-2 rounded-xl bg-white border border-gray-200 text-xs font-medium focus:ring-2 focus:ring-brand-500 shadow-sm">
                <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest Arrivals</option>
                <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
            </select>
        </form>
    </div>

    <!-- Category Pills Filter Bar -->
    <div class="flex items-center space-x-3 overflow-x-auto pb-4 mb-8 scrollbar-none">
        <a href="{{ route('shop.index') }}" 
           class="px-5 py-2.5 rounded-full text-xs font-bold whitespace-nowrap transition-all {{ !request('category') ? 'bg-brand-600 text-white shadow-md' : 'bg-white text-gray-700 hover:bg-gray-100 border border-gray-200' }}">
            All Categories
        </a>
        @foreach($categories as $cat)
            <a href="{{ route('shop.index', ['category' => $cat->slug]) }}" 
               class="px-5 py-2.5 rounded-full text-xs font-bold whitespace-nowrap transition-all {{ request('category') == $cat->slug ? 'bg-brand-600 text-white shadow-md' : 'bg-white text-gray-700 hover:bg-gray-100 border border-gray-200' }}">
                {{ $cat->name }} ({{ $cat->products_count }})
            </a>
        @endforeach
    </div>

    <!-- Product Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        @forelse($products as $product)
            <div class="bg-white rounded-3xl overflow-hidden shadow-sm hover:shadow-xl border border-gray-100 transition-all duration-300 flex flex-col justify-between group">
                <!-- Image Wrapper -->
                <div class="relative overflow-hidden bg-gray-100 aspect-square">
                    <img src="{{ $product->image_path }}" alt="{{ $product->name }}" 
                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    
                    @if($product->is_featured)
                        <span class="absolute top-3 left-3 px-3 py-1 bg-amber-500 text-white font-bold text-[10px] uppercase rounded-full shadow">BESTSELLER</span>
                    @endif
                </div>

                <!-- Product Info -->
                <div class="p-5 flex-grow flex flex-col justify-between space-y-3">
                    <div>
                        <div class="flex items-center justify-between text-[10px] font-bold uppercase tracking-wider text-brand-600 mb-1">
                            <span>{{ $product->category ? $product->category->name : 'Candles' }}</span>
                            <span class="text-amber-500"><i class="fa-solid fa-star mr-0.5"></i>4.9</span>
                        </div>
                        <h3 class="font-bold text-gray-900 text-base group-hover:text-brand-600 transition-colors line-clamp-1">
                            <a href="{{ route('shop.show', $product->slug) }}">{{ $product->name }}</a>
                        </h3>
                        <p class="text-xs text-gray-500 mt-1 line-clamp-2 leading-relaxed">{{ $product->description }}</p>
                    </div>

                    <div class="pt-3 border-t border-gray-100 flex items-center justify-between">
                        <div>
                            <span class="text-lg font-bold text-gray-900">₹{{ number_format($product->price, 2) }}</span>
                        </div>

                        <form action="{{ route('cart.add') }}" method="POST" class="flex items-center space-x-2">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <input type="hidden" name="quantity" value="1">
                            <button type="submit" class="w-10 h-10 rounded-2xl bg-brand-50 text-brand-600 hover:bg-brand-600 hover:text-white flex items-center justify-center transition-all shadow-sm">
                                <i class="fa-solid fa-cart-plus text-sm"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full py-16 text-center bg-white rounded-3xl border border-gray-100 shadow-sm">
                <i class="fa-solid fa-box-open text-5xl text-gray-300 mb-3"></i>
                <h3 class="font-serif text-xl font-bold text-gray-700">No products found</h3>
                <p class="text-xs text-gray-500 mt-1">Try resetting your search filter or checking back later.</p>
                <a href="{{ route('shop.index') }}" class="inline-block mt-4 px-6 py-2.5 bg-brand-600 text-white font-bold text-xs rounded-full shadow">Reset Filters</a>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="mt-12">
        {{ $products->links() }}
    </div>
</div>

<!-- About Our Brand Section -->
<div id="about" class="bg-amber-50/40 border-y border-amber-100 py-16 mb-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-center">
            <div class="lg:col-span-6 space-y-5">
                <span class="inline-block px-3 py-1 bg-amber-100 text-amber-900 rounded-full text-xs font-bold uppercase tracking-widest">
                    ✨ About Sondhi
                </span>
                <h2 class="font-serif text-3xl sm:text-4xl font-bold text-gray-900 leading-tight">
                    Crafted with Purity, Inspired by Earth's First Rain.
                </h2>
                <p class="text-xs sm:text-sm text-gray-600 leading-relaxed">
                    <strong class="text-gray-900 font-bold">Sondhi</strong> is born from the timeless fragrance of monsoon rain touching warm soil. We handcraft luxury soy wax candles, apothecary glass candles, and essential oil blends designed to bring calm and warmth into your home.
                </p>
                <div class="grid grid-cols-2 gap-4 pt-2">
                    <div class="p-3.5 bg-white rounded-2xl border border-amber-100 shadow-sm">
                        <span class="block text-lg font-bold text-amber-600">100% Organic</span>
                        <span class="text-[11px] text-gray-500">Pure Soy Wax & Lead-Free Wicks</span>
                    </div>
                    <div class="p-3.5 bg-white rounded-2xl border border-amber-100 shadow-sm">
                        <span class="block text-lg font-bold text-amber-600">Small Batch</span>
                        <span class="text-[11px] text-gray-500">Artisan Hand-Poured in India</span>
                    </div>
                </div>
                <div class="pt-2">
                    <a href="{{ route('about') }}" class="inline-flex items-center space-x-2 px-6 py-3 bg-amber-500 hover:bg-amber-600 text-white font-bold text-xs uppercase tracking-wider rounded-full shadow transition-all">
                        <span>Read Our Full Story</span>
                        <i class="fa-solid fa-arrow-right text-[10px]"></i>
                    </a>
                </div>
            </div>

            <div class="lg:col-span-6 flex justify-center">
                <div class="relative w-full max-w-md aspect-[4/3] rounded-3xl overflow-hidden shadow-xl border border-amber-100 group">
                    <img src="https://images.unsplash.com/photo-1596435707659-ae86628b0751?auto=format&fit=crop&w=800&q=80" 
                         alt="Sondhi Artisan Candle" 
                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/50 via-transparent to-transparent flex items-end p-6 text-white">
                        <p class="font-serif text-lg font-bold">"Sondhi — Transform Your Living Space."</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Customer Testimonials Section -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-16">
    <div class="text-center max-w-xl mx-auto mb-10">
        <span class="text-xs font-bold text-brand-600 uppercase tracking-wider">What Our Customers Say</span>
        <h2 class="font-serif text-3xl font-bold text-gray-900 mt-1">Loved Across Homes</h2>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Review 1 -->
        <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm space-y-4">
            <div class="flex items-center space-x-1 text-amber-400 text-xs">
                <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
            </div>
            <p class="text-xs text-gray-600 leading-relaxed italic">
                "The French Lavender jar candle fills my living room with the most soothing fragrance without being overwhelming. The soy wax burns so cleanly!"
            </p>
            <div class="flex items-center space-x-3 pt-2 border-t border-gray-100">
                <div class="w-9 h-9 rounded-full bg-amber-100 text-amber-800 font-bold text-xs flex items-center justify-center">
                    AN
                </div>
                <div>
                    <h4 class="font-bold text-xs text-gray-900">Ananya Verma</h4>
                    <span class="text-[10px] text-emerald-600 font-semibold"><i class="fa-solid fa-circle-check mr-1"></i> Verified Buyer</span>
                </div>
            </div>
        </div>

        <!-- Review 2 -->
        <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm space-y-4">
            <div class="flex items-center space-x-1 text-amber-400 text-xs">
                <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
            </div>
            <p class="text-xs text-gray-600 leading-relaxed italic">
                "Ordered gift boxes for my sister's housewarming party. The custom packaging was stunning and arrived completely intact!"
            </p>
            <div class="flex items-center space-x-3 pt-2 border-t border-gray-100">
                <div class="w-9 h-9 rounded-full bg-purple-100 text-purple-800 font-bold text-xs flex items-center justify-center">
                    RK
                </div>
                <div>
                    <h4 class="font-bold text-xs text-gray-900">Rohan Kapoor</h4>
                    <span class="text-[10px] text-emerald-600 font-semibold"><i class="fa-solid fa-circle-check mr-1"></i> Verified Buyer</span>
                </div>
            </div>
        </div>

        <!-- Review 3 -->
        <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm space-y-4">
            <div class="flex items-center space-x-1 text-amber-400 text-xs">
                <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
            </div>
            <p class="text-xs text-gray-600 leading-relaxed italic">
                "The Botanical Reed Diffusers last so long! It has been 4 weeks and my workspace still smells like fresh lemongrass and eucalyptus."
            </p>
            <div class="flex items-center space-x-3 pt-2 border-t border-gray-100">
                <div class="w-9 h-9 rounded-full bg-blue-100 text-blue-800 font-bold text-xs flex items-center justify-center">
                    PM
                </div>
                <div>
                    <h4 class="font-bold text-xs text-gray-900">Pooja Mehta</h4>
                    <span class="text-[10px] text-emerald-600 font-semibold"><i class="fa-solid fa-circle-check mr-1"></i> Verified Buyer</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Ambiance Club Newsletter Signup Banner -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-16">
    <div class="gradient-brand p-8 sm:p-12 rounded-3xl text-white shadow-xl flex flex-col md:flex-row items-center justify-between gap-8 relative overflow-hidden">
        <div class="space-y-2 text-center md:text-left relative z-10">
            <span class="px-3 py-1 bg-amber-500/20 text-amber-300 rounded-full text-xs font-bold uppercase tracking-wider border border-amber-400/30">✨ Sondhi Ambiance Club</span>
            <h3 class="font-serif text-2xl sm:text-3xl font-bold">Enjoy 10% Off Your First Order</h3>
            <p class="text-xs sm:text-sm text-brand-100 max-w-lg">Subscribe to receive exclusive fragrance releases, candle care tips, and VIP secret sale invitations.</p>
        </div>

        <form onsubmit="event.preventDefault(); alert('Thank you for subscribing to the Sondhi Ambiance Club!');" class="w-full md:w-auto flex flex-col sm:flex-row gap-3 relative z-10">
            <input type="email" placeholder="Enter your email address..." required 
                   class="px-5 py-3.5 rounded-full bg-white/10 text-white placeholder-brand-200 border border-white/20 text-xs focus:outline-none focus:ring-2 focus:ring-amber-400 min-w-[260px]">
            <button type="submit" class="px-7 py-3.5 bg-amber-500 hover:bg-amber-600 text-white font-bold text-xs rounded-full shadow-lg transition-all whitespace-nowrap">
                Join Club
            </button>
        </form>
    </div>
</div>
@endsection
