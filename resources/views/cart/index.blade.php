@extends('layouts.app')

@section('title', 'Your Shopping Cart | Sondhi')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <h1 class="font-serif text-3xl font-bold text-gray-900 mb-8 flex items-center">
        <i class="fa-solid fa-bag-shopping text-brand-600 mr-3"></i> Shopping Cart
    </h1>

    @if(count($cart) > 0)
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
            <!-- Cart Items List -->
            <div class="lg:col-span-2 space-y-4">
                <div class="bg-white rounded-3xl shadow-sm border border-gray-100 divide-y divide-gray-100 overflow-hidden">
                    @foreach($cart as $item)
                        <div class="p-6 flex flex-col sm:flex-row items-center justify-between gap-4">
                            <!-- Product Image & Details -->
                            <div class="flex items-center space-x-4 w-full sm:w-auto">
                                <img src="{{ $item['image_path'] }}" alt="{{ $item['name'] }}" class="w-20 h-20 object-cover rounded-2xl bg-gray-100 flex-shrink-0">
                                <div>
                                    <h3 class="font-bold text-gray-900 text-base">
                                        <a href="{{ route('shop.show', $item['slug']) }}" class="hover:text-brand-600 transition-colors">{{ $item['name'] }}</a>
                                    </h3>
                                    <p class="text-xs text-gray-500 mt-0.5">Unit Price: ₹{{ number_format($item['price'], 2) }}</p>
                                    @if(!empty($item['custom_options']))
                                        <p class="text-[11px] text-amber-800 bg-amber-50 px-2 py-0.5 rounded mt-1 inline-block"><i class="fa-solid fa-pen-nib mr-1"></i> {{ $item['custom_options'] }}</p>
                                    @endif
                                </div>
                            </div>

                            <!-- Quantity Adjuster Form -->
                            <div class="flex items-center space-x-4">
                                <form action="{{ route('cart.update') }}" method="POST" class="flex items-center border border-gray-200 rounded-xl overflow-hidden bg-gray-50">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $item['id'] }}">
                                    <button type="submit" name="quantity" value="{{ max(1, $item['quantity'] - 1) }}" class="px-3 py-1.5 text-gray-600 hover:bg-gray-200 font-bold text-sm">-</button>
                                    <span class="px-3 py-1.5 text-xs font-bold text-gray-900 min-w-[2.5rem] text-center">{{ $item['quantity'] }}</span>
                                    <button type="submit" name="quantity" value="{{ $item['quantity'] + 1 }}" class="px-3 py-1.5 text-gray-600 hover:bg-gray-200 font-bold text-sm">+</button>
                                </form>

                                <div class="text-right min-w-[5rem]">
                                    <span class="font-bold text-gray-900 text-base">₹{{ number_format($item['price'] * $item['quantity'], 2) }}</span>
                                </div>

                                <form action="{{ route('cart.remove') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $item['id'] }}">
                                    <button type="submit" class="p-2 text-gray-400 hover:text-rose-600 transition-colors" title="Remove item">
                                        <i class="fa-solid fa-trash-can text-sm"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="flex justify-between items-center pt-2">
                    <a href="{{ route('shop.index') }}" class="text-xs font-bold text-brand-600 hover:underline">
                        &larr; Continue Shopping
                    </a>
                    <form action="{{ route('cart.clear') }}" method="POST">
                        @csrf
                        <button type="submit" class="text-xs font-semibold text-rose-600 hover:underline">
                            Clear Cart
                        </button>
                    </form>
                </div>
            </div>

            <!-- Order Summary Column -->
            <div class="space-y-6">
                <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 space-y-4">
                    <h3 class="font-serif text-lg font-bold text-gray-900 pb-3 border-b border-gray-100">Order Summary</h3>

                    <div class="space-y-2 text-sm text-gray-600">
                        <div class="flex justify-between">
                            <span>Subtotal</span>
                            <span class="font-bold text-gray-900">₹{{ number_format($total, 2) }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Estimated Shipping</span>
                            <span class="font-bold text-emerald-700">{{ $total > 1500 ? 'FREE' : '₹99.00' }}</span>
                        </div>
                    </div>

                    @if($total <= 1500)
                        <div class="p-3 bg-amber-50 rounded-xl text-[11px] text-amber-800 border border-amber-200">
                            💡 Add ₹{{ number_format(1501 - $total, 2) }} more to qualify for <strong>FREE Shipping</strong>!
                        </div>
                    @endif

                    <div class="pt-3 border-t border-gray-100 flex justify-between items-baseline">
                        <span class="font-bold text-base text-gray-900">Total</span>
                        <span class="font-serif text-2xl font-bold text-brand-600">₹{{ number_format($total + ($total > 1500 ? 0 : 99), 2) }}</span>
                    </div>

                    <a href="{{ route('checkout.index') }}" class="w-full block text-center py-3.5 px-4 bg-brand-600 hover:bg-brand-700 text-white font-bold text-sm rounded-xl shadow-lg shadow-brand-500/25 transition-all">
                        Proceed to Checkout &rarr;
                    </a>
                </div>
            </div>
        </div>
    @else
        <div class="bg-white rounded-3xl p-12 text-center border border-gray-100 shadow-sm max-w-lg mx-auto">
            <i class="fa-solid fa-bag-shopping text-6xl text-gray-200 mb-4"></i>
            <h2 class="font-serif text-2xl font-bold text-gray-800">Your cart is empty</h2>
            <p class="text-xs text-gray-500 mt-2">Looks like you haven't added any products to your shopping bag yet.</p>
            <a href="{{ route('shop.index') }}" class="inline-block mt-6 px-8 py-3.5 bg-brand-600 hover:bg-brand-700 text-white font-bold text-sm rounded-full shadow-md">
                Browse Products Now
            </a>
        </div>
    @endif
</div>
@endsection
