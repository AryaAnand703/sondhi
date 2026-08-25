@extends('layouts.admin')

@section('title', 'Manage Orders Pipeline | Sondhi Admin')

@section('content')
<div class="space-y-8">

    <!-- Header Title & Overview -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <h1 class="font-serif text-2xl sm:text-3xl font-bold text-gray-900">Orders & Fulfillment Pipeline</h1>
            <p class="text-xs text-gray-500 mt-1">Manage luxury orders, track shipping status, and update fulfillment stages.</p>
        </div>
    </div>

    <!-- Analytics & KPI Metrics Row -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 flex items-center space-x-4">
            <div class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center text-xl font-bold">
                <i class="fa-solid fa-boxes-stacked"></i>
            </div>
            <div>
                <p class="text-[10px] uppercase font-bold tracking-wider text-gray-400">Total Orders</p>
                <h3 class="font-serif text-2xl font-bold text-gray-900 mt-0.5">{{ $stats['total'] }}</h3>
            </div>
        </div>

        <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 flex items-center space-x-4">
            <div class="w-12 h-12 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center text-xl font-bold">
                <i class="fa-solid fa-truck-fast"></i>
            </div>
            <div>
                <p class="text-[10px] uppercase font-bold tracking-wider text-gray-400">Pending Dispatch</p>
                <h3 class="font-serif text-2xl font-bold text-gray-900 mt-0.5">{{ $stats['pending'] }}</h3>
            </div>
        </div>

        <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 flex items-center space-x-4">
            <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-xl font-bold">
                <i class="fa-solid fa-circle-check"></i>
            </div>
            <div>
                <p class="text-[10px] uppercase font-bold tracking-wider text-gray-400">Delivered</p>
                <h3 class="font-serif text-2xl font-bold text-gray-900 mt-0.5">{{ $stats['delivered'] }}</h3>
            </div>
        </div>

        <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 flex items-center space-x-4">
            <div class="w-12 h-12 rounded-2xl bg-brand-50 text-brand-600 flex items-center justify-center text-xl font-bold">
                <i class="fa-solid fa-indian-rupee-sign"></i>
            </div>
            <div>
                <p class="text-[10px] uppercase font-bold tracking-wider text-gray-400">Paid Revenue</p>
                <h3 class="font-serif text-2xl font-bold text-gray-900 mt-0.5">₹{{ number_format($stats['revenue'], 2) }}</h3>
            </div>
        </div>
    </div>

    <!-- Search & Filter Bar -->
    <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <form action="{{ route('admin.orders.index') }}" method="GET" class="w-full flex flex-col md:flex-row items-center gap-3">
            <div class="relative w-full md:w-80">
                <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search Order # or Customer..." class="w-full pl-9 pr-4 py-2.5 rounded-2xl bg-gray-50 border border-gray-200 text-xs focus:ring-2 focus:ring-amber-500 focus:bg-white transition-all">
            </div>

            <div class="flex items-center space-x-3 w-full md:w-auto">
                <select name="status" onchange="this.form.submit()" class="px-4 py-2.5 rounded-2xl bg-gray-50 border border-gray-200 text-xs font-semibold text-gray-700 focus:ring-2 focus:ring-amber-500 focus:bg-white transition-all">
                    <option value="">All Statuses</option>
                    <option value="Order Placed" {{ request('status') == 'Order Placed' ? 'selected' : '' }}>Order Placed</option>
                    <option value="Payment Confirmed" {{ request('status') == 'Payment Confirmed' ? 'selected' : '' }}>Payment Confirmed</option>
                    <option value="Processing" {{ request('status') == 'Processing' ? 'selected' : '' }}>Processing</option>
                    <option value="Packed" {{ request('status') == 'Packed' ? 'selected' : '' }}>Packed</option>
                    <option value="Shipped" {{ request('status') == 'Shipped' ? 'selected' : '' }}>Shipped</option>
                    <option value="Delivered" {{ request('status') == 'Delivered' ? 'selected' : '' }}>Delivered</option>
                    <option value="Cancelled" {{ request('status') == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>

                <button type="submit" class="px-5 py-2.5 bg-gray-900 hover:bg-brand-600 text-white text-xs font-bold rounded-2xl shadow transition-all">
                    Filter
                </button>

                @if(request('search') || request('status'))
                    <a href="{{ route('admin.orders.index') }}" class="px-4 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-600 text-xs font-bold rounded-2xl transition-colors">
                        Clear
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Orders Management Table -->
    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-gray-50/80 border-b border-gray-100 uppercase tracking-wider text-gray-500 font-bold">
                    <tr>
                        <th class="p-4 pl-6">Order ID</th>
                        <th class="p-4">Customer</th>
                        <th class="p-4">Items</th>
                        <th class="p-4">Amount</th>
                        <th class="p-4">Payment</th>
                        <th class="p-4">Pipeline Status</th>
                        <th class="p-4">Date</th>
                        <th class="p-4 pr-6 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($orders as $ord)
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="p-4 pl-6 font-mono font-bold text-gray-900">
                                <a href="{{ route('admin.orders.show', $ord->id) }}" class="text-brand-700 hover:underline">
                                    #{{ $ord->order_number }}
                                </a>
                            </td>
                            <td class="p-4">
                                <div class="flex items-center space-x-2.5">
                                    <div class="w-8 h-8 rounded-full bg-brand-100 text-brand-700 flex items-center justify-center font-bold text-xs uppercase">
                                        {{ substr($ord->user ? $ord->user->name : 'G', 0, 1) }}
                                    </div>
                                    <div>
                                        <p class="font-bold text-gray-900">{{ $ord->user ? $ord->user->name : 'Guest' }}</p>
                                        <p class="text-[10px] text-gray-400">{{ $ord->user ? $ord->user->email : 'N/A' }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="p-4 font-bold text-gray-700">
                                <span class="bg-gray-100 px-2.5 py-1 rounded-lg text-gray-800">{{ $ord->items->count() }} item(s)</span>
                            </td>
                            <td class="p-4 font-bold text-gray-900">₹{{ number_format($ord->total_amount, 2) }}</td>
                            <td class="p-4">
                                <span class="px-2.5 py-1 rounded-lg font-bold text-[10px] {{ $ord->payment_status === 'Paid' ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-800' }}">
                                    {{ $ord->payment_method }} ({{ $ord->payment_status }})
                                </span>
                            </td>
                            <td class="p-4">
                                <span class="px-3.5 py-1 rounded-full font-bold text-[10px] inline-flex items-center space-x-1
                                    {{ $ord->status === 'Delivered' ? 'bg-emerald-100 text-emerald-800' : 
                                      ($ord->status === 'Cancelled' ? 'bg-rose-100 text-rose-800' : 'bg-amber-100 text-amber-800') }}">
                                    <i class="fa-solid {{ $ord->status === 'Delivered' ? 'fa-circle-check' : ($ord->status === 'Cancelled' ? 'fa-ban' : 'fa-truck-fast') }} text-[10px] mr-1"></i>
                                    <span>{{ $ord->status }}</span>
                                </span>
                            </td>
                            <td class="p-4 text-gray-500">{{ $ord->created_at->format('M d, Y') }}</td>
                            <td class="p-4 pr-6 text-right">
                                <a href="{{ route('admin.orders.show', $ord->id) }}" class="px-4 py-2 bg-brand-50 text-brand-700 hover:bg-brand-600 hover:text-white font-bold text-xs rounded-xl transition-all shadow-sm inline-flex items-center space-x-1">
                                    <span>Inspect</span>
                                    <i class="fa-solid fa-arrow-right text-[10px]"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="p-12 text-center text-gray-400">
                                <i class="fa-solid fa-box-open text-4xl mb-3 text-gray-200"></i>
                                <p class="font-bold text-sm text-gray-600">No orders found</p>
                                <p class="text-xs text-gray-400 mt-1">Try resetting search query or status filter.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-4">
        {{ $orders->links() }}
    </div>

</div>
@endsection
