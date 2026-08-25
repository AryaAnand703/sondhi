@extends('layouts.app')

@section('title', 'Order #' . $order->order_number . ' Tracking & Details | Sondhi')

@section('content')
<style>
    @media print {
        header, footer, .no-print {
            display: none !important;
        }
        body {
            background-color: white !important;
            color: black !important;
        }
        .print-only-shadow {
            box-shadow: none !important;
            border: 1px solid #ddd !important;
        }
    }
</style>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    <!-- Header Navigation & Action Bar -->
    <div class="mb-8 flex flex-col md:flex-row justify-between items-start md:items-center gap-4 no-print">
        <div>
            <a href="{{ route('orders.index') }}" class="inline-flex items-center text-xs font-bold text-brand-600 hover:text-brand-700 transition-colors mb-2">
                <i class="fa-solid fa-arrow-left mr-1.5"></i> Back to My Orders
            </a>
            <div class="flex items-center space-x-3">
                <h1 class="font-serif text-3xl sm:text-4xl font-bold text-gray-900">Order #{{ $order->order_number }}</h1>
                <span class="px-3.5 py-1 text-xs font-bold rounded-full border shadow-sm
                    {{ $order->status === 'Delivered' ? 'bg-emerald-100 text-emerald-800 border-emerald-200' : 
                      ($order->status === 'Cancelled' ? 'bg-rose-100 text-rose-800 border-rose-200' : 'bg-amber-100 text-amber-800 border-amber-200') }}">
                    <i class="fa-solid {{ $order->status === 'Delivered' ? 'fa-circle-check' : ($order->status === 'Cancelled' ? 'fa-ban' : 'fa-truck-fast') }} mr-1"></i>
                    {{ $order->status }}
                </span>
            </div>
            <p class="text-xs text-gray-500 mt-1">
                Placed on <strong>{{ $order->created_at->format('F d, Y \a\t h:i A') }}</strong>
            </p>
        </div>

        <!-- Header Actions -->
        <div class="flex items-center space-x-3 w-full md:w-auto justify-end">
            <button onclick="window.print()" class="px-4 py-2.5 bg-white border border-gray-200 hover:bg-gray-50 text-gray-700 font-bold text-xs rounded-2xl shadow-sm transition-all flex items-center space-x-2">
                <i class="fa-solid fa-print text-gray-500"></i>
                <span>Print Invoice</span>
            </button>
            <a href="{{ route('support.create', ['order_id' => $order->id]) }}" class="px-5 py-2.5 bg-gray-900 hover:bg-brand-600 text-white font-bold text-xs rounded-2xl shadow transition-all flex items-center space-x-2">
                <i class="fa-solid fa-headset text-amber-400"></i>
                <span>Need Order Help?</span>
            </a>
        </div>
    </div>

    <!-- Printable Header Banner (Only visible during print) -->
    <div class="hidden print:block mb-6 border-b pb-4">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="font-serif text-2xl font-bold">SONDHI LUXURY FRAGRANCES</h1>
                <p class="text-xs text-gray-600">Official Order Invoice & Delivery Receipt</p>
            </div>
            <div class="text-right text-xs">
                <p class="font-bold">Order #{{ $order->order_number }}</p>
                <p>Date: {{ $order->created_at->format('d M Y') }}</p>
            </div>
        </div>
    </div>

    <!-- Live Status Pipeline Step Tracker -->
    <div class="bg-white rounded-3xl p-6 sm:p-8 shadow-sm border border-gray-100 mb-10 no-print">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-2">
            <div>
                <h3 class="font-serif text-xl font-bold text-gray-900">Real-Time Delivery Pipeline</h3>
                <p class="text-xs text-gray-500">Follow the journey of your order from artisan dispatch to doorstep delivery.</p>
            </div>
            <span class="text-xs font-semibold text-gray-400 bg-gray-50 px-3 py-1 rounded-full border border-gray-100">
                Current Step: <strong class="text-brand-600">{{ $order->status }}</strong>
            </span>
        </div>

        @if($order->status === 'Cancelled')
            <div class="p-6 bg-rose-50 border border-rose-200 rounded-2xl text-center text-rose-800 text-sm font-bold flex flex-col items-center">
                <i class="fa-solid fa-circle-xmark text-4xl text-rose-500 mb-2"></i>
                <p>This order was Cancelled on {{ $order->updated_at->format('M d, Y') }}.</p>
                <p class="text-xs font-normal text-rose-600 mt-1">If you have any questions or need a refund verification, please reach out to customer support.</p>
            </div>
        @else
            <!-- Responsive Step Tracker Pipeline Container -->
            <div class="relative pt-4 pb-2">
                <!-- Background Line (Desktop) -->
                <div class="hidden md:block absolute left-8 right-8 top-10 h-1.5 bg-gray-100 z-0 rounded-full"></div>
                <!-- Progress Line (Desktop) -->
                <div class="hidden md:block absolute left-8 top-10 h-1.5 bg-gradient-to-r from-brand-500 to-emerald-500 z-0 transition-all duration-700 rounded-full" 
                     style="width: calc({{ count($allSteps) > 1 ? ($currentStepIndex / (count($allSteps) - 1)) * 100 : 0 }}% - 4rem)"></div>

                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-6 gap-6 relative z-10">
                    @foreach($allSteps as $index => $step)
                        @php
                            $isPassed = $index <= $currentStepIndex;
                            $isCurrent = $index === $currentStepIndex;
                        @endphp
                        <div class="flex flex-col items-center text-center group">
                            <!-- Step Badge -->
                            <div class="w-12 h-12 rounded-2xl flex items-center justify-center font-bold text-sm shadow-md transition-all duration-300 mb-3
                                {{ $isCurrent ? 'bg-brand-600 text-white ring-4 ring-brand-100 scale-110 shadow-brand-500/30' : 
                                  ($isPassed ? 'bg-emerald-600 text-white' : 'bg-gray-100 text-gray-400') }}">
                                @if($isPassed && !$isCurrent)
                                    <i class="fa-solid fa-check text-base"></i>
                                @else
                                    <i class="fa-solid {{ $step['icon'] ?? 'fa-circle' }} text-sm"></i>
                                @endif
                            </div>

                            <!-- Step Title & Description -->
                            <span class="text-xs font-bold transition-colors {{ $isCurrent ? 'text-brand-700' : ($isPassed ? 'text-gray-900' : 'text-gray-400') }}">
                                {{ $step['title'] }}
                            </span>
                            <span class="text-[10px] text-gray-400 mt-1 leading-snug hidden sm:block max-w-[130px]">
                                {{ $step['description'] }}
                            </span>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>

    <!-- Order Items & Shipping Address Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        <!-- Order Items Column -->
        <div class="lg:col-span-2 bg-white rounded-3xl p-6 sm:p-8 shadow-sm border border-gray-100 space-y-6 print-only-shadow">
            <div class="flex justify-between items-center pb-4 border-b border-gray-100">
                <h3 class="font-serif text-xl font-bold text-gray-900">Ordered Items ({{ $order->items->count() }})</h3>
                <span class="text-xs font-semibold text-gray-500">Invoice ID: #{{ $order->order_number }}</span>
            </div>

            <div class="divide-y divide-gray-100">
                @foreach($order->items as $item)
                    <div class="py-4 flex items-center justify-between gap-4">
                        <div class="flex items-center space-x-4">
                            <img src="{{ $item->product && $item->product->image_path ? $item->product->image_path : 'https://images.unsplash.com/photo-1603006905003-be475563bc59?auto=format&fit=crop&w=400&q=80' }}" alt="{{ $item->product_name }}" class="w-16 h-16 object-cover rounded-2xl bg-gray-100 border border-gray-100 shadow-sm flex-shrink-0">
                            <div>
                                <h4 class="font-bold text-sm text-gray-900">{{ $item->product_name }}</h4>
                                <p class="text-xs text-gray-500 mt-0.5">Rate: ₹{{ number_format($item->price, 2) }} &bull; Quantity: <strong>{{ $item->quantity }}</strong></p>
                                @if($item->custom_options)
                                    <span class="text-[10px] text-amber-800 bg-amber-50 px-2 py-0.5 rounded-md mt-1.5 inline-block border border-amber-200 font-medium">
                                        <i class="fa-solid fa-pen-nib mr-1 text-amber-600"></i> {{ $item->custom_options }}
                                    </span>
                                @endif
                            </div>
                        </div>
                        <span class="font-mono font-bold text-sm text-gray-900">₹{{ number_format($item->subtotal, 2) }}</span>
                    </div>
                @endforeach
            </div>

            <!-- Financial Calculation Summary -->
            <div class="pt-6 border-t border-gray-100 space-y-2.5 text-xs text-gray-600">
                <div class="flex justify-between">
                    <span>Subtotal</span>
                    <span class="font-bold text-gray-900">₹{{ number_format($order->subtotal, 2) }}</span>
                </div>
                <div class="flex justify-between">
                    <span>Shipping & Handling</span>
                    <span class="font-bold text-emerald-700">
                        {{ $order->shipping_fee == 0 ? 'FREE Standard Shipping' : '₹' . number_format($order->shipping_fee, 2) }}
                    </span>
                </div>
                <div class="flex justify-between pt-3 border-t border-gray-100 text-sm">
                    <span class="font-bold text-gray-900">Total Billed Amount</span>
                    <span class="font-serif font-bold text-brand-700 text-2xl">₹{{ number_format($order->total_amount, 2) }}</span>
                </div>
            </div>
        </div>

        <!-- Sidebar: Shipping & Payment Details -->
        <div class="space-y-6">

            <!-- Delivery Address Card -->
            <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 space-y-4 print-only-shadow">
                <div class="flex items-center space-x-2 pb-3 border-b border-gray-100 text-gray-900">
                    <i class="fa-solid fa-truck-ramp-box text-brand-600 text-base"></i>
                    <h3 class="font-serif text-lg font-bold">Delivery Address</h3>
                </div>

                <div class="text-xs space-y-2 text-gray-700 leading-relaxed">
                    <p class="font-bold text-gray-900 text-sm flex items-center">
                        <i class="fa-solid fa-user text-gray-400 mr-2 text-xs"></i>
                        {{ $order->shipping_address['recipient_name'] ?? 'Recipient' }}
                    </p>
                    <p class="flex items-center text-gray-600">
                        <i class="fa-solid fa-phone text-gray-400 mr-2 text-xs"></i> 
                        {{ $order->shipping_address['phone'] ?? 'N/A' }}
                    </p>
                    <div class="pt-2 border-t border-gray-50 flex items-start">
                        <i class="fa-solid fa-location-dot text-gray-400 mr-2 text-xs mt-0.5"></i>
                        <span>
                            {{ $order->shipping_address['address_line1'] ?? '' }}
                            @if(!empty($order->shipping_address['address_line2'])), {{ $order->shipping_address['address_line2'] }}@endif<br>
                            <strong>{{ $order->shipping_address['city'] ?? '' }}</strong>, {{ $order->shipping_address['state'] ?? '' }} - {{ $order->shipping_address['postal_code'] ?? '' }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Payment Details Card -->
            <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 space-y-4 print-only-shadow">
                <div class="flex items-center space-x-2 pb-3 border-b border-gray-100 text-gray-900">
                    <i class="fa-solid fa-credit-card text-brand-600 text-base"></i>
                    <h3 class="font-serif text-lg font-bold">Payment Information</h3>
                </div>

                <div class="text-xs space-y-3">
                    <div class="flex justify-between items-center">
                        <span class="text-gray-500">Method:</span>
                        <span class="font-bold text-gray-900 bg-gray-100 px-2.5 py-1 rounded-lg">{{ $order->payment_method }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-500">Payment Status:</span>
                        <span class="px-2.5 py-1 rounded-lg font-bold text-[10px] {{ $order->payment_status === 'Paid' ? 'bg-emerald-100 text-emerald-800 border border-emerald-200' : 'bg-amber-100 text-amber-800 border border-amber-200' }}">
                            <i class="fa-solid {{ $order->payment_status === 'Paid' ? 'fa-circle-check' : 'fa-clock' }} mr-1"></i>
                            {{ $order->payment_status }}
                        </span>
                    </div>
                    @if($order->payment && $order->payment->transaction_id)
                        <div class="flex justify-between items-center pt-2 border-t border-gray-50">
                            <span class="text-gray-500">Transaction Ref:</span>
                            <span class="font-mono text-gray-700 bg-gray-50 px-2 py-0.5 rounded border border-gray-100">{{ $order->payment->transaction_id }}</span>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Support Banner Card -->
            <div class="bg-gradient-to-br from-brand-50 to-brand-100/50 rounded-3xl p-6 border border-brand-200/50 text-center space-y-3 no-print">
                <i class="fa-solid fa-shield-heart text-2xl text-brand-600"></i>
                <h4 class="font-serif font-bold text-sm text-gray-900">Sondhi Satisfaction Guarantee</h4>
                <p class="text-[11px] text-gray-600 leading-relaxed">
                    If your luxury candle arrives damaged or with any quality issue, our customer team will replace it immediately.
                </p>
                <a href="{{ route('support.create', ['order_id' => $order->id]) }}" class="inline-block text-xs font-bold text-brand-700 hover:text-brand-800 underline">
                    Open Support Ticket &rarr;
                </a>
            </div>

        </div>

    </div>

</div>
@endsection
