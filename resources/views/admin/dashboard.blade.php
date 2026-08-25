@extends('layouts.admin')

@section('title', 'Executive Dashboard')

@section('content')
<div class="space-y-8">
    <!-- Top Metric Cards Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
        <!-- Revenue Card -->
        <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 flex items-center space-x-4">
            <div class="w-14 h-14 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-xl font-bold">
                <i class="fa-solid fa-indian-rupee-sign"></i>
            </div>
            <div>
                <p class="text-xs text-gray-400 font-bold uppercase tracking-wider">Total Revenue</p>
                <h3 class="font-serif text-2xl font-bold text-gray-900 mt-0.5">₹{{ number_format($totalRevenue, 2) }}</h3>
                <span class="text-[10px] text-emerald-700 font-bold"><i class="fa-solid fa-arrow-trend-up mr-1"></i> Paid Orders</span>
            </div>
        </div>

        <!-- Orders Card -->
        <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 flex items-center space-x-4">
            <div class="w-14 h-14 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center text-xl font-bold">
                <i class="fa-solid fa-receipt"></i>
            </div>
            <div>
                <p class="text-xs text-gray-400 font-bold uppercase tracking-wider">Total Orders</p>
                <h3 class="font-serif text-2xl font-bold text-gray-900 mt-0.5">{{ number_format($totalOrders) }}</h3>
                <span class="text-[10px] text-amber-700 font-bold">{{ $pendingOrdersCount }} Pending Fulfillment</span>
            </div>
        </div>

        <!-- Support Desk Card -->
        <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 flex items-center space-x-4">
            <div class="w-14 h-14 rounded-2xl bg-purple-50 text-purple-600 flex items-center justify-center text-xl font-bold">
                <i class="fa-solid fa-headset"></i>
            </div>
            <div>
                <p class="text-xs text-gray-400 font-bold uppercase tracking-wider">Open Tickets</p>
                <h3 class="font-serif text-2xl font-bold text-gray-900 mt-0.5">{{ number_format($openSupportTickets) }}</h3>
                <span class="text-[10px] text-purple-700 font-bold">Customer Desk</span>
            </div>
        </div>
    </div>

    <!-- Quick Action Navigation Banner -->
    <div class="bg-gradient-to-r from-slate-900 to-slate-800 p-6 rounded-3xl text-white flex flex-col md:flex-row justify-between items-center gap-4">
        <div>
            <h3 class="font-serif text-xl font-bold text-amber-400">Back-Office Command Center</h3>
            <p class="text-xs text-slate-300">Quickly add products, update order status, or manage customer support tickets.</p>
        </div>
        <div class="flex flex-wrap gap-3">
            <a href="{{ route('admin.products.create') }}" class="px-4 py-2.5 bg-brand-600 hover:bg-brand-700 text-white font-bold text-xs rounded-xl transition-all shadow">
                + Add New Product
            </a>
            <a href="{{ route('admin.orders.index') }}" class="px-4 py-2.5 bg-slate-700 hover:bg-slate-600 text-white font-bold text-xs rounded-xl transition-all">
                Process Orders
            </a>
        </div>
    </div>

    <!-- Recent Customer Orders Section -->
    <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 space-y-4">
        <div class="flex justify-between items-center pb-3 border-b border-gray-100">
            <h3 class="font-serif text-lg font-bold text-gray-900"><i class="fa-solid fa-clock-rotate-left text-brand-600 mr-2"></i> Recent Customer Orders</h3>
            <a href="{{ route('admin.orders.index') }}" class="text-xs font-bold text-brand-600 hover:underline">View All &rarr;</a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="text-gray-400 border-b border-gray-100 uppercase tracking-wider">
                        <th class="py-2">Order ID</th>
                        <th class="py-2">Customer</th>
                        <th class="py-2">Amount</th>
                        <th class="py-2">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($recentOrders as $ord)
                        <tr class="hover:bg-gray-50">
                            <td class="py-3 font-bold text-gray-900">
                                <a href="{{ route('admin.orders.show', $ord->id) }}" class="hover:text-brand-600">#{{ $ord->order_number }}</a>
                            </td>
                            <td class="py-3 text-gray-700">{{ $ord->user ? $ord->user->name : 'Guest' }}</td>
                            <td class="py-3 font-bold text-gray-900">₹{{ number_format($ord->total_amount, 2) }}</td>
                            <td class="py-3">
                                <span class="px-2 py-0.5 text-[10px] font-bold rounded-full bg-amber-100 text-amber-800">
                                    {{ $ord->status }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
