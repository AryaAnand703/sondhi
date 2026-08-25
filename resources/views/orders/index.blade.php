@extends('layouts.app')

@section('title', 'My Orders & Tracking | Sondhi Luxury Fragrances')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">

    <!-- Page Header & Banner -->
    <div class="relative overflow-hidden bg-gradient-to-r from-obsidian via-gray-900 to-[#2a201b] rounded-3xl p-8 sm:p-10 mb-10 text-white shadow-xl">
        <div class="absolute -right-10 -bottom-10 opacity-10 pointer-events-none">
            <i class="fa-solid fa-box-open text-[180px]"></i>
        </div>
        <div class="relative z-10 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-6">
            <div>
                <span class="inline-flex items-center space-x-2 text-brand-400 font-semibold tracking-widest text-xs uppercase mb-2">
                    <i class="fa-solid fa-gem text-xs"></i> <span>Customer Account</span>
                </span>
                <h1 class="font-serif text-3xl sm:text-4xl font-bold tracking-tight text-white">My Orders & Live Tracking</h1>
                <p class="text-xs sm:text-sm text-gray-300 mt-2 max-w-xl leading-relaxed">
                    Track the real-time fulfillment status of your luxury candles, view item details, and print past invoices.
                </p>
            </div>
            <a href="{{ route('shop.index') }}" class="px-6 py-3 bg-gradient-to-r from-brand-500 to-brand-600 hover:from-brand-600 hover:to-brand-700 text-white font-bold text-xs rounded-2xl shadow-lg hover:shadow-brand-500/20 transition-all transform hover:-translate-y-0.5 flex items-center space-x-2">
                <i class="fa-solid fa-cart-plus"></i>
                <span>Browse Store</span>
            </a>
        </div>
    </div>

    <!-- Status Filter Tabs Header -->
    <div class="flex flex-wrap items-center justify-between gap-4 mb-8 border-b border-gray-200 pb-4">
        <div class="flex items-center space-x-2 overflow-x-auto pb-1 sm:pb-0">
            <a href="{{ route('orders.index', ['status' => 'all']) }}" 
               class="px-5 py-2.5 rounded-2xl text-xs font-bold transition-all flex items-center space-x-2 {{ $activeStatus === 'all' ? 'bg-gray-900 text-white shadow-md' : 'bg-white text-gray-600 hover:bg-gray-100 border border-gray-200' }}">
                <span>All Orders</span>
                <span class="px-2 py-0.5 rounded-full text-[10px] {{ $activeStatus === 'all' ? 'bg-brand-500 text-white' : 'bg-gray-100 text-gray-700' }}">
                    {{ $stats['all'] }}
                </span>
            </a>

            <a href="{{ route('orders.index', ['status' => 'in_progress']) }}" 
               class="px-5 py-2.5 rounded-2xl text-xs font-bold transition-all flex items-center space-x-2 {{ $activeStatus === 'in_progress' ? 'bg-gray-900 text-white shadow-md' : 'bg-white text-gray-600 hover:bg-gray-100 border border-gray-200' }}">
                <i class="fa-solid fa-spinner text-amber-500"></i>
                <span>In Progress</span>
                <span class="px-2 py-0.5 rounded-full text-[10px] {{ $activeStatus === 'in_progress' ? 'bg-amber-500 text-white' : 'bg-gray-100 text-gray-700' }}">
                    {{ $stats['in_progress'] }}
                </span>
            </a>

            <a href="{{ route('orders.index', ['status' => 'delivered']) }}" 
               class="px-5 py-2.5 rounded-2xl text-xs font-bold transition-all flex items-center space-x-2 {{ $activeStatus === 'delivered' ? 'bg-gray-900 text-white shadow-md' : 'bg-white text-gray-600 hover:bg-gray-100 border border-gray-200' }}">
                <i class="fa-solid fa-circle-check text-emerald-500"></i>
                <span>Delivered</span>
                <span class="px-2 py-0.5 rounded-full text-[10px] {{ $activeStatus === 'delivered' ? 'bg-emerald-500 text-white' : 'bg-gray-100 text-gray-700' }}">
                    {{ $stats['delivered'] }}
                </span>
            </a>

            <a href="{{ route('orders.index', ['status' => 'cancelled']) }}" 
               class="px-5 py-2.5 rounded-2xl text-xs font-bold transition-all flex items-center space-x-2 {{ $activeStatus === 'cancelled' ? 'bg-gray-900 text-white shadow-md' : 'bg-white text-gray-600 hover:bg-gray-100 border border-gray-200' }}">
                <i class="fa-solid fa-circle-xmark text-rose-500"></i>
                <span>Cancelled</span>
                <span class="px-2 py-0.5 rounded-full text-[10px] {{ $activeStatus === 'cancelled' ? 'bg-rose-500 text-white' : 'bg-gray-100 text-gray-700' }}">
                    {{ $stats['cancelled'] }}
                </span>
            </a>
        </div>
    </div>

    <!-- Orders Cards List -->
    @if($orders->count() > 0)
        <div class="space-y-6">
            @foreach($orders as $order)
                <div class="bg-white rounded-3xl p-6 sm:p-8 shadow-sm hover:shadow-xl border border-gray-100 transition-all duration-300 relative group overflow-hidden">
                    <div class="absolute top-0 left-0 w-2 h-full {{ $order->status === 'Delivered' ? 'bg-emerald-500' : ($order->status === 'Cancelled' ? 'bg-rose-500' : 'bg-brand-500') }}"></div>

                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center pb-5 border-b border-gray-100 gap-4 pl-3">
                        <div>
                            <div class="flex items-center space-x-3">
                                <span class="font-mono text-xl font-bold text-gray-900">#{{ $order->order_number }}</span>
                                <span class="text-xs text-gray-400">
                                    <i class="fa-regular fa-clock mr-1"></i> {{ $order->created_at->format('M d, Y \a\t h:i A') }}
                                </span>
                            </div>
                            <p class="text-xs text-gray-500 mt-1">
                                Payment: <strong class="text-gray-800">{{ $order->payment_method }}</strong> 
                                <span class="ml-1 inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold {{ $order->payment_status === 'Paid' ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-amber-50 text-amber-700 border border-amber-200' }}">
                                    {{ $order->payment_status }}
                                </span>
                            </p>
                        </div>

                        <div class="flex items-center space-x-3 w-full md:w-auto justify-between md:justify-end">
                            <span class="px-4 py-1.5 text-xs font-bold rounded-full flex items-center space-x-1.5 shadow-sm
                                {{ $order->status === 'Delivered' ? 'bg-emerald-100 text-emerald-800 border border-emerald-200' : 
                                  ($order->status === 'Cancelled' ? 'bg-rose-100 text-rose-800 border border-rose-200' : 'bg-amber-100 text-amber-800 border border-amber-200') }}">
                                <i class="fa-solid {{ $order->status === 'Delivered' ? 'fa-circle-check' : ($order->status === 'Cancelled' ? 'fa-ban' : 'fa-truck-fast') }}"></i>
                                <span>{{ $order->status }}</span>
                            </span>

                            <a href="{{ route('orders.show', $order->id) }}" class="px-5 py-2.5 bg-gray-900 hover:bg-brand-600 text-white font-bold text-xs rounded-2xl shadow transition-all flex items-center space-x-2">
                                <span>View Details</span>
                                <i class="fa-solid fa-arrow-right text-xs"></i>
                            </a>
                        </div>
                    </div>

                    <!-- Itemized Preview Grid -->
                    <div class="py-5 pl-3">
                        <h4 class="text-[11px] font-bold uppercase tracking-wider text-gray-400 mb-3">Items in this shipment ({{ $order->items->count() }})</h4>
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
                            @foreach($order->items as $item)
                                <div class="flex items-center space-x-3 text-xs bg-gray-50/80 p-3 rounded-2xl border border-gray-100">
                                    <div class="w-12 h-12 rounded-xl bg-gray-200 flex-shrink-0 overflow-hidden shadow-inner">
                                        <img src="{{ $item->product && $item->product->image_path ? $item->product->image_path : 'https://images.unsplash.com/photo-1603006905003-be475563bc59?auto=format&fit=crop&w=300&q=80' }}" alt="{{ $item->product_name }}" class="w-full h-full object-cover">
                                    </div>
                                    <div class="truncate">
                                        <p class="font-bold text-gray-900 truncate">{{ $item->product_name }}</p>
                                        <p class="text-gray-500 mt-0.5">Qty: {{ $item->quantity }} &bull; <strong class="text-gray-800">₹{{ number_format($item->price, 2) }}</strong></p>
                                        @if($item->custom_options)
                                            <span class="text-[9px] text-amber-800 bg-amber-50 px-1.5 py-0.5 rounded font-semibold inline-block truncate max-w-[150px]">
                                                <i class="fa-solid fa-pen-nib mr-0.5"></i> {{ $item->custom_options }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Card Summary Footer -->
                    <div class="pt-4 border-t border-gray-100 flex flex-col sm:flex-row justify-between items-start sm:items-center pl-3 gap-3">
                        <div class="text-xs text-gray-500 flex items-center space-x-2">
                            <i class="fa-solid fa-location-dot text-gray-400"></i>
                            <span>Ship to: <strong class="text-gray-800">{{ $order->shipping_address['recipient_name'] ?? 'Recipient' }}</strong> ({{ $order->shipping_address['city'] ?? '' }})</span>
                        </div>
                        <div class="flex items-center space-x-4">
                            <span class="text-xs text-gray-500">Order Total:</span>
                            <span class="font-serif font-bold text-xl text-brand-700">₹{{ number_format($order->total_amount, 2) }}</span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <!-- Empty State -->
        <div class="bg-white rounded-3xl p-12 text-center border border-gray-100 shadow-sm max-w-lg mx-auto my-12">
            <div class="w-20 h-20 rounded-full bg-brand-50 border border-brand-100 flex items-center justify-center text-brand-600 text-3xl mx-auto mb-5">
                <i class="fa-solid fa-box-open"></i>
            </div>
            <h3 class="font-serif text-2xl font-bold text-gray-900">No orders found</h3>
            <p class="text-xs text-gray-500 mt-2 leading-relaxed">
                @if($activeStatus === 'all')
                    You have not placed any orders yet. Explore our luxury collection of handcrafted candles and reed diffusers.
                @else
                    There are no orders matching the '{{ str_replace('_', ' ', $activeStatus) }}' filter right now.
                @endif
            </p>
            <a href="{{ route('shop.index') }}" class="inline-flex items-center space-x-2 mt-6 px-8 py-3.5 bg-gradient-to-r from-brand-600 to-brand-700 text-white font-bold text-xs rounded-2xl shadow-lg hover:shadow-brand-600/30 transition-all">
                <i class="fa-solid fa-sparkles"></i>
                <span>Explore Storefront</span>
            </a>
        </div>
    @endif

</div>
@endsection
