@extends('layouts.app')

@section('title', $product->name . ' | Sondhi')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <!-- Breadcrumbs -->
    <nav class="flex items-center space-x-2 text-xs text-gray-500 mb-8">
        <a href="{{ route('shop.index') }}" class="hover:text-brand-600">Home</a>
        <span>/</span>
        <a href="{{ route('shop.index', ['category' => $product->category ? $product->category->slug : '']) }}" class="hover:text-brand-600">
            {{ $product->category ? $product->category->name : 'Catalog' }}
        </a>
        <span>/</span>
        <span class="text-gray-800 font-bold truncate">{{ $product->name }}</span>
    </nav>

    <!-- Main Detail Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-12 bg-white p-8 rounded-3xl shadow-sm border border-gray-100 mb-16">
        <!-- Product Image -->
        <div class="space-y-4">
            <div class="aspect-square bg-gray-100 rounded-3xl overflow-hidden border border-gray-100 shadow-inner">
                <img src="{{ $product->image_path }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
            </div>
        </div>

        <!-- Details & Add to Cart Action -->
        <div class="space-y-6 flex flex-col justify-between">
            <div class="space-y-4">
                <span class="px-3 py-1 bg-brand-50 text-brand-700 font-bold text-xs rounded-full uppercase tracking-wider">
                    {{ $product->category ? $product->category->name : 'Artisan Products' }}
                </span>

                <h1 class="font-serif text-3xl sm:text-4xl font-bold text-gray-900 leading-tight">{{ $product->name }}</h1>

                <!-- Price Breakdown -->
                <div class="flex items-baseline space-x-4">
                    <span class="text-3xl font-bold text-gray-900">₹{{ number_format($product->price, 2) }}</span>
                </div>

                <p class="text-sm text-gray-600 leading-relaxed pt-2 border-t border-gray-100">
                    {{ $product->description }}
                </p>

                <!-- Stock Indicator -->
                <div class="flex items-center space-x-2 text-xs font-bold">
                    <span class="w-2.5 h-2.5 rounded-full {{ $product->stock_quantity > 0 ? 'bg-emerald-500' : 'bg-rose-500' }}"></span>
                    <span class="{{ $product->stock_quantity > 0 ? 'text-emerald-700' : 'text-rose-700' }}">
                        {{ $product->stock_quantity > 0 ? "In Stock ({$product->stock_quantity} units available)" : "Out of Stock" }}
                    </span>
                </div>
            </div>

            <!-- Form: Quantity & Customization -->
            <form action="{{ route('cart.add') }}" method="POST" class="space-y-6 pt-6 border-t border-gray-100">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">

                <div>
                    <label for="custom_options" class="block text-xs font-bold uppercase text-gray-600 mb-1">
                        <i class="fa-solid fa-pen-nib text-brand-600 mr-1"></i> Custom Packaging / Label Note (Optional)
                    </label>
                    <input type="text" name="custom_options" id="custom_options" placeholder="e.g. Add custom text 'Happy Wedding Aarav & Ananya'" 
                           class="w-full px-4 py-3 rounded-xl bg-gray-50 border border-gray-200 text-xs focus:ring-2 focus:ring-brand-500">
                </div>

                <div class="flex items-center space-x-4">
                    <div class="w-32">
                        <label for="quantity" class="block text-xs font-bold uppercase text-gray-600 mb-1">Quantity</label>
                        <input type="number" name="quantity" id="quantity" value="1" min="1" max="{{ $product->stock_quantity }}" required 
                               class="w-full px-4 py-3 rounded-xl bg-gray-50 border border-gray-200 text-sm font-bold text-center focus:ring-2 focus:ring-brand-500">
                    </div>

                    <div class="flex-grow pt-5">
                        <button type="submit" class="w-full py-3.5 px-6 bg-brand-600 hover:bg-brand-700 text-white font-bold text-sm rounded-xl shadow-lg shadow-brand-500/25 transition-all flex items-center justify-center space-x-2">
                            <i class="fa-solid fa-bag-shopping"></i>
                            <span>Add Product to Cart</span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Related Products -->
    @if($relatedProducts->count() > 0)
        <div class="space-y-6">
            <h3 class="font-serif text-2xl font-bold text-gray-900">You Might Also Like</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($relatedProducts as $rel)
                    <div class="bg-white rounded-3xl overflow-hidden shadow-sm hover:shadow-md border border-gray-100 transition-all flex flex-col group">
                        <div class="aspect-square bg-gray-100 overflow-hidden">
                            <img src="{{ $rel->image_path }}" alt="{{ $rel->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        </div>
                        <div class="p-4 flex-grow flex flex-col justify-between">
                            <div>
                                <h4 class="font-bold text-sm text-gray-900 line-clamp-1">
                                    <a href="{{ route('shop.show', $rel->slug) }}">{{ $rel->name }}</a>
                                </h4>
                                <span class="text-xs text-gray-500 mt-1 block">₹{{ number_format($rel->price, 2) }}</span>
                            </div>
                            <a href="{{ route('shop.show', $rel->slug) }}" class="mt-3 block text-center py-2 bg-brand-50 text-brand-700 font-bold text-xs rounded-xl hover:bg-brand-600 hover:text-white transition-colors">
                                View Details
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>
@endsection
