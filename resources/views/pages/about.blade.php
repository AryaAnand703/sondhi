@extends('layouts.app')

@section('title', 'Our Brand Story & Philosophy | Sondhi')

@section('content')
<!-- Hero Section -->
<div class="gradient-brand text-white py-20 lg:py-28 px-4 sm:px-6 lg:px-8 shadow-2xl relative overflow-hidden mb-16">
    <!-- Ambient Background Glow Accents -->
    <div class="absolute top-0 left-1/3 w-[500px] h-[500px] bg-amber-500/10 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute bottom-0 right-10 w-96 h-96 bg-brand-400/15 rounded-full blur-3xl pointer-events-none"></div>

    <div class="max-w-5xl mx-auto text-center relative z-10 space-y-6">
        <span class="inline-block px-4 py-1.5 bg-amber-500/20 text-amber-300 rounded-full text-xs font-bold uppercase tracking-[0.2em] border border-amber-400/30">
            ✨ Our Brand Philosophy
        </span>

        <h1 class="font-serif text-4xl sm:text-6xl font-bold tracking-tight leading-tight">
            Inspired by the Essence of <span class="text-amber-400 italic">First Rain.</span>
        </h1>

        <p class="text-brand-100 text-base sm:text-xl font-light leading-relaxed max-w-3xl mx-auto">
            <strong class="font-semibold text-white">Sondhi</strong> (सौंधी) embodies the intoxicating, comforting scent of rain kissing warm earth. We craft artisan candles and botanical room fragrances designed to create peaceful sanctuaries in modern homes.
        </p>

        <div class="pt-4 flex justify-center">
            <a href="{{ route('shop.index') }}#catalog" class="px-8 py-4 bg-amber-500 hover:bg-amber-600 text-white font-bold text-xs uppercase tracking-widest rounded-full shadow-xl shadow-amber-500/30 transition-all hover:scale-105">
                Explore Collection
            </a>
        </div>
    </div>
</div>

<!-- Brand Story Narrative Section -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-20">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
        <!-- Story Image -->
        <div class="lg:col-span-6 relative">
            <div class="relative rounded-3xl overflow-hidden shadow-2xl border border-gray-100 aspect-[4/5] group">
                <img src="https://images.unsplash.com/photo-1603006905003-be475563bc59?auto=format&fit=crop&w=1000&q=80" 
                     alt="Sondhi Artisan Candle Hand-Pouring" 
                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent flex items-end p-8 text-white">
                    <div>
                        <p class="text-xs uppercase tracking-widest text-amber-300 font-bold">Small-Batch Artisan Production</p>
                        <h3 class="font-serif text-2xl font-bold mt-1">Hand-Poured with Intention</h3>
                    </div>
                </div>
            </div>
            <!-- Floating Decorative Card -->
            <div class="absolute -bottom-6 -right-6 hidden sm:flex items-center space-x-3 bg-white p-5 rounded-2xl shadow-xl border border-gray-100 max-w-xs">
                <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center text-2xl shrink-0">
                    <i class="fa-solid fa-leaf"></i>
                </div>
                <div>
                    <h4 class="font-bold text-xs text-gray-900">100% Eco-Friendly</h4>
                    <p class="text-[10px] text-gray-500 mt-0.5">Non-toxic soy wax & lead-free cotton wicks</p>
                </div>
            </div>
        </div>

        <!-- Story Content -->
        <div class="lg:col-span-6 space-y-6">
            <span class="text-xs font-bold text-brand-600 uppercase tracking-widest">Heritage & Artistry</span>
            <h2 class="font-serif text-3xl sm:text-4xl font-bold text-gray-900 leading-tight">
                Slow Living, Mindful Aromas, Uncompromised Purity.
            </h2>

            <p class="text-gray-600 text-sm sm:text-base leading-relaxed">
                At <strong class="text-gray-900">Sondhi</strong>, we believe fragrance is a powerful anchor for memory, emotion, and tranquility. In a fast-paced world, lighting a candle is a quiet ritual of pausing and returning to oneself.
            </p>

            <p class="text-gray-600 text-sm sm:text-base leading-relaxed">
                Every Sondhi creation is meticulously hand-poured in small batches using 100% natural, biodegradable soy wax derived from renewable soy crops. We combine pure botanical essential oils and fine perfume-grade fragrance blends to deliver clean, long-lasting aroma throws that soothe without overwhelming.
            </p>

            <!-- Key Highlights List -->
            <div class="pt-4 grid grid-cols-2 gap-4">
                <div class="p-4 rounded-2xl bg-amber-50/60 border border-amber-100">
                    <h4 class="font-bold text-xs uppercase tracking-wider text-amber-900">Zero Toxins</h4>
                    <p class="text-[11px] text-gray-600 mt-1">Free from paraffin, phthalates, parabens, and lead.</p>
                </div>
                <div class="p-4 rounded-2xl bg-brand-50/60 border border-brand-100">
                    <h4 class="font-bold text-xs uppercase tracking-wider text-brand-900">Sustainable Design</h4>
                    <p class="text-[11px] text-gray-600 mt-1">Reusable glass vessels & plastic-free packaging.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Core Pillars Grid -->
<div class="bg-gray-100/70 py-16 border-y border-gray-200/70 mb-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-2xl mx-auto mb-12">
            <span class="text-xs font-bold text-brand-600 uppercase tracking-widest">Why Choose Sondhi</span>
            <h2 class="font-serif text-3xl font-bold text-gray-900 mt-1">Our Core Pillars</h2>
            <p class="text-xs sm:text-sm text-gray-500 mt-2">Built on craftsmanship, environmental responsibility, and sensory excellence.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Pillar 1 -->
            <div class="bg-white p-8 rounded-3xl border border-gray-200/60 shadow-sm hover:shadow-md transition-all text-center space-y-4">
                <div class="w-16 h-16 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center text-2xl mx-auto">
                    <i class="fa-solid fa-fire-flame-curved"></i>
                </div>
                <h3 class="font-serif text-xl font-bold text-gray-900">Artisanal Small Batches</h3>
                <p class="text-xs text-gray-600 leading-relaxed">
                    Each candle is individually inspected and poured by skilled artisans to guarantee uniform scent distribution and smooth tops.
                </p>
            </div>

            <!-- Pillar 2 -->
            <div class="bg-white p-8 rounded-3xl border border-gray-200/60 shadow-sm hover:shadow-md transition-all text-center space-y-4">
                <div class="w-16 h-16 rounded-2xl bg-purple-50 text-purple-600 flex items-center justify-center text-2xl mx-auto">
                    <i class="fa-solid fa-droplet"></i>
                </div>
                <h3 class="font-serif text-xl font-bold text-gray-900">Pure Essential Aromas</h3>
                <p class="text-xs text-gray-600 leading-relaxed">
                    Our scents are layered with top, heart, and base notes inspired by nature — from serene French lavender to warm royal amber and oud.
                </p>
            </div>

            <!-- Pillar 3 -->
            <div class="bg-white p-8 rounded-3xl border border-gray-200/60 shadow-sm hover:shadow-md transition-all text-center space-y-4">
                <div class="w-16 h-16 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-2xl mx-auto">
                    <i class="fa-solid fa-gift"></i>
                </div>
                <h3 class="font-serif text-xl font-bold text-gray-900">Personalized Luxury</h3>
                <p class="text-xs text-gray-600 leading-relaxed">
                    We specialize in custom candle favors for weddings, corporate events, and bespoke luxury gift hampers with handwritten notes.
                </p>
            </div>
        </div>
    </div>
</div>

<!-- Newsletter / Join Community Banner -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-16">
    <div class="gradient-brand p-8 sm:p-12 rounded-3xl text-white shadow-xl text-center space-y-4">
        <span class="px-3 py-1 bg-amber-500/20 text-amber-300 rounded-full text-xs font-bold uppercase tracking-wider border border-amber-400/30">
            ✨ Bring Sondhi Home
        </span>
        <h3 class="font-serif text-3xl font-bold">Elevate Your Living Space Today</h3>
        <p class="text-xs sm:text-sm text-brand-100 max-w-xl mx-auto">
            Explore our curated catalog of soy wax candles, glass apothecary jars, and luxury gift boxes.
        </p>
        <div class="pt-2">
            <a href="{{ route('shop.index') }}" class="px-8 py-3.5 bg-amber-500 hover:bg-amber-600 text-white font-bold text-xs uppercase tracking-widest rounded-full shadow-lg transition-all inline-block">
                View Full Collection
            </a>
        </div>
    </div>
</div>
@endsection
