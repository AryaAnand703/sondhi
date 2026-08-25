@extends('layouts.admin')

@section('title', 'Order #' . $order->order_number . ' Inspection | Sondhi Admin')

@section('content')
<style>
    @media print {
        header, sidebar, nav, .no-print {
            display: none !important;
        }
        body {
            background-color: white !important;
            color: black !important;
        }
    }
</style>

<div class="space-y-8">

    <!-- Top Navigation & Pipeline Status Quick Action Bar -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center bg-white p-6 rounded-3xl shadow-sm border border-gray-100 gap-4 no-print">
        <div>
            <a href="{{ route('admin.orders.index') }}" class="inline-flex items-center text-xs font-bold text-gray-500 hover:text-gray-900 transition-colors mb-1">
                <i class="fa-solid fa-arrow-left mr-1.5"></i> Back to Orders List
            </a>
            <div class="flex items-center space-x-3">
                <h1 class="font-serif text-2xl font-bold text-gray-900">Order #{{ $order->order_number }}</h1>
                <span class="px-3.5 py-1 text-xs font-bold rounded-full border shadow-sm
                    {{ $order->status === 'Delivered' ? 'bg-emerald-100 text-emerald-800 border-emerald-200' : 
                      ($order->status === 'Cancelled' ? 'bg-rose-100 text-rose-800 border-rose-200' : 'bg-amber-100 text-amber-800 border-amber-200') }}">
                    <i class="fa-solid {{ $order->status === 'Delivered' ? 'fa-circle-check' : ($order->status === 'Cancelled' ? 'fa-ban' : 'fa-truck-fast') }} mr-1"></i>
                    {{ $order->status }}
                </span>
            </div>
            <p class="text-xs text-gray-500 mt-1">Placed on {{ $order->created_at->format('F d, Y \a\t h:i A') }}</p>
        </div>

        <div class="flex flex-wrap items-center space-x-3 w-full md:w-auto justify-end">
            <!-- Print Packing Slip Button -->
            <button onclick="window.print()" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-800 font-bold text-xs rounded-2xl transition-all flex items-center space-x-2">
                <i class="fa-solid fa-print text-gray-500"></i>
                <span>Print Packing Slip</span>
            </button>

            <!-- Status Dropdown Form -->
            <form action="{{ route('admin.orders.update-status', $order->id) }}" method="POST" class="flex items-center space-x-2 bg-gray-50 p-1.5 rounded-2xl border border-gray-200">
                @csrf
                <select name="status" class="px-3 py-1.5 rounded-xl bg-white border border-gray-200 text-xs font-bold text-brand-700 focus:ring-2 focus:ring-amber-500">
                    @foreach($statuses as $st)
                        <option value="{{ $st }}" {{ $order->status === $st ? 'selected' : '' }}>{{ $st }}</option>
                    @endforeach
                </select>
                <button type="submit" class="px-4 py-1.5 bg-gray-900 hover:bg-brand-600 text-white font-bold text-xs rounded-xl shadow transition-colors">
                    Update
                </button>
            </form>
        </div>
    </div>

    <!-- 1-Click Pipeline Advance Highlight Callout Banner -->
    @if($nextStatus)
        <div class="bg-gradient-to-r from-brand-600 to-amber-600 rounded-3xl p-6 text-white shadow-lg flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 no-print">
            <div class="flex items-center space-x-4">
                <div class="w-12 h-12 rounded-2xl bg-white/20 backdrop-blur-md flex items-center justify-center text-xl text-amber-100">
                    <i class="fa-solid fa-circle-arrow-right"></i>
                </div>
                <div>
                    <h3 class="font-serif font-bold text-lg text-white">Next Pipeline Step Available</h3>
                    <p class="text-xs text-amber-100 mt-0.5">
                        Current stage is <strong>"{{ $order->status }}"</strong>. Advance order to <strong>"{{ $nextStatus }}"</strong> with one click.
                    </p>
                </div>
            </div>

            <form action="{{ route('admin.orders.update-status', $order->id) }}" method="POST">
                @csrf
                <input type="hidden" name="status" value="{{ $nextStatus }}">
                <button type="submit" class="px-6 py-3 bg-white text-gray-900 hover:bg-amber-50 font-bold text-xs rounded-2xl shadow-md transition-all flex items-center space-x-2">
                    <span>Advance to "{{ $nextStatus }}"</span>
                    <i class="fa-solid fa-arrow-right text-brand-600"></i>
                </button>
            </form>
        </div>
    @endif

    <!-- Printable Packing Slip Header (Print Only) -->
    <div class="hidden print:block mb-6 border-b pb-4">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="font-serif text-2xl font-bold">SONDHI WAREHOUSE PACKING SLIP</h1>
                <p class="text-xs text-gray-600">Fulfillment & Quality Inspection Document</p>
            </div>
            <div class="text-right text-xs">
                <p class="font-bold">Order #{{ $order->order_number }}</p>
                <p>Status: {{ $order->status }}</p>
            </div>
        </div>
    </div>

    <!-- Order Items & Customer Info Breakdown Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        <!-- Itemized Products -->
        <div class="lg:col-span-2 bg-white rounded-3xl p-6 sm:p-8 shadow-sm border border-gray-100 space-y-6">
            <h3 class="font-serif text-xl font-bold text-gray-900 pb-3 border-b border-gray-100">Itemized Products & Quantities</h3>

            <div class="divide-y divide-gray-100">
                @foreach($order->items as $item)
                    <div class="py-4 flex items-center justify-between gap-4">
                        <div class="flex items-center space-x-4">
                            <img src="{{ $item->product && $item->product->image_path ? $item->product->image_path : 'https://images.unsplash.com/photo-1603006905003-be475563bc59?auto=format&fit=crop&w=300&q=80' }}" class="w-14 h-14 object-cover rounded-2xl bg-gray-100 border border-gray-100 shadow-sm flex-shrink-0">
                            <div>
                                <h4 class="font-bold text-sm text-gray-900">{{ $item->product_name }}</h4>
                                <p class="text-xs text-gray-500 mt-0.5">Rate: ₹{{ number_format($item->price, 2) }} &bull; Quantity: <strong>{{ $item->quantity }}</strong></p>
                                @if($item->custom_options)
                                    <span class="text-[10px] text-amber-800 bg-amber-50 px-2 py-0.5 rounded mt-1.5 inline-block font-semibold border border-amber-200">
                                        <i class="fa-solid fa-pen-nib mr-1 text-amber-600"></i> {{ $item->custom_options }}
                                    </span>
                                @endif
                            </div>
                        </div>
                        <span class="font-mono font-bold text-sm text-gray-900">₹{{ number_format($item->subtotal, 2) }}</span>
                    </div>
                @endforeach
            </div>

            <!-- Financial Calculation -->
            <div class="pt-6 border-t border-gray-100 space-y-2.5 text-xs text-gray-600">
                <div class="flex justify-between">
                    <span>Subtotal</span>
                    <span class="font-bold text-gray-900">₹{{ number_format($order->subtotal, 2) }}</span>
                </div>
                <div class="flex justify-between">
                    <span>Shipping Fee</span>
                    <span class="font-bold text-emerald-700">₹{{ number_format($order->shipping_fee, 2) }}</span>
                </div>
                <div class="flex justify-between pt-3 border-t border-gray-100 text-sm">
                    <span class="font-bold text-gray-900">Total Billed</span>
                    <span class="font-serif font-bold text-brand-700 text-2xl">₹{{ number_format($order->total_amount, 2) }}</span>
                </div>
            </div>
        </div>

        <!-- Customer & Delivery Sidebar -->
        <div class="space-y-6">

            <!-- Customer Profile Details Card -->
            <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 space-y-4">
                <div class="flex justify-between items-center pb-3 border-b border-gray-100">
                    <h3 class="font-serif text-lg font-bold text-gray-900">Customer Details</h3>
                    @if($order->user)
                        <a href="{{ route('admin.customers.show', $order->user->id) }}" class="text-[10px] font-bold text-brand-700 hover:underline">
                            View Directory Profile &rarr;
                        </a>
                    @endif
                </div>

                <div class="text-xs space-y-2">
                    <p class="font-bold text-gray-900 text-sm flex items-center">
                        <i class="fa-solid fa-user text-gray-400 mr-2"></i>
                        {{ $order->user ? $order->user->name : 'Guest Customer' }}
                    </p>
                    <p class="text-gray-600 flex items-center">
                        <i class="fa-solid fa-envelope text-gray-400 mr-2"></i> 
                        {{ $order->user ? $order->user->email : 'N/A' }}
                    </p>
                    <p class="text-gray-600 flex items-center">
                        <i class="fa-solid fa-phone text-gray-400 mr-2"></i> 
                        {{ $order->user ? ($order->user->phone ?? 'Not provided') : 'N/A' }}
                    </p>
                </div>
            </div>

            <!-- Shipping Destination Card -->
            <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 space-y-4">
                <h3 class="font-serif text-lg font-bold text-gray-900 pb-3 border-b border-gray-100">Shipping Address</h3>
                <div class="text-xs text-gray-700 leading-relaxed space-y-1">
                    <p class="font-bold text-gray-900 text-sm">{{ $order->shipping_address['recipient_name'] ?? 'Recipient' }}</p>
                    <p class="text-gray-600"><i class="fa-solid fa-phone mr-1 text-gray-400"></i> {{ $order->shipping_address['phone'] ?? 'N/A' }}</p>
                    <p class="pt-2 border-t border-gray-50 text-gray-600">
                        {{ $order->shipping_address['address_line1'] ?? '' }}
                        @if(!empty($order->shipping_address['address_line2'])), {{ $order->shipping_address['address_line2'] }}@endif<br>
                        <strong>{{ $order->shipping_address['city'] ?? '' }}</strong>, {{ $order->shipping_address['state'] ?? '' }} - {{ $order->shipping_address['postal_code'] ?? '' }}
                    </p>
                </div>
            </div>

            <!-- Payment Information Card -->
            <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 space-y-3">
                <h3 class="font-serif text-lg font-bold text-gray-900 pb-3 border-b border-gray-100">Payment & Transaction</h3>
                <div class="text-xs space-y-2">
                    <div class="flex justify-between items-center">
                        <span class="text-gray-500">Method:</span>
                        <span class="font-bold text-gray-900 bg-gray-100 px-2 py-0.5 rounded">{{ $order->payment_method }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-500">Status:</span>
                        <span class="px-2.5 py-1 rounded-lg font-bold text-[10px] {{ $order->payment_status === 'Paid' ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-800' }}">
                            {{ $order->payment_status }}
                        </span>
                    </div>
                    @if($order->payment && $order->payment->transaction_id)
                        <div class="flex justify-between items-center pt-2 border-t border-gray-50">
                            <span class="text-gray-500">Transaction ID:</span>
                            <span class="font-mono text-gray-700 bg-gray-50 px-2 py-0.5 rounded border border-gray-100">{{ $order->payment->transaction_id }}</span>
                        </div>
                    @endif
                </div>
            </div>

        </div>

    </div>

</div>
@endsection
