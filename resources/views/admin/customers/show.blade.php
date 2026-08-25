@extends('layouts.admin')

@section('title', 'Customer Profile - ' . $customer->name)

@section('content')
<div class="space-y-8">
    <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <a href="{{ route('admin.customers.index') }}" class="text-xs font-bold text-gray-500 hover:text-gray-800">&larr; Back to Customers Directory</a>
            <h2 class="font-serif text-2xl font-bold text-gray-900 mt-1">{{ $customer->name }}</h2>
            <p class="text-xs text-gray-500"><i class="fa-solid fa-envelope mr-1"></i> {{ $customer->email }} | <i class="fa-solid fa-phone mr-1"></i> {{ $customer->phone }}</p>
        </div>
        <div class="text-right">
            <span class="text-xs text-gray-400 block font-bold uppercase">Total Lifetime Spend</span>
            <span class="font-serif text-2xl font-bold text-brand-600">₹{{ number_format($customer->orders->sum('total_amount'), 2) }}</span>
        </div>
    </div>

    <!-- Orders & Addresses Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Customer Orders Table -->
        <div class="lg:col-span-2 bg-white rounded-3xl p-6 shadow-sm border border-gray-100 space-y-4">
            <h3 class="font-serif text-lg font-bold text-gray-900 pb-3 border-b border-gray-100">Order History ({{ $customer->orders->count() }})</h3>
            <div class="divide-y divide-gray-100">
                @forelse($customer->orders as $ord)
                    <div class="py-3 flex items-center justify-between text-xs">
                        <div>
                            <span class="font-bold text-gray-900">#{{ $ord->order_number }}</span>
                            <span class="text-gray-400 ml-2">{{ $ord->created_at->format('M d, Y') }}</span>
                        </div>
                        <span class="px-2.5 py-0.5 rounded-full font-bold text-[10px] bg-amber-100 text-amber-800">{{ $ord->status }}</span>
                        <span class="font-bold text-gray-900">₹{{ number_format($ord->total_amount, 2) }}</span>
                        <a href="{{ route('admin.orders.show', $ord->id) }}" class="text-brand-600 font-bold hover:underline">Inspect &rarr;</a>
                    </div>
                @empty
                    <p class="text-xs text-gray-400 py-4">No orders placed yet.</p>
                @endforelse
            </div>
        </div>

        <!-- Saved Addresses -->
        <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 space-y-4">
            <h3 class="font-serif text-lg font-bold text-gray-900 pb-3 border-b border-gray-100">Saved Addresses</h3>
            <div class="space-y-3">
                @forelse($customer->addresses as $addr)
                    <div class="p-3 bg-gray-50 rounded-2xl border border-gray-200 text-xs">
                        <p class="font-bold text-gray-900">{{ $addr->recipient_name }}</p>
                        <p class="text-gray-500">{{ $addr->phone }}</p>
                        <p class="text-gray-700 mt-1 leading-relaxed">{{ $addr->address_line1 }}, {{ $addr->city }}, {{ $addr->state }} - {{ $addr->postal_code }}</p>
                    </div>
                @empty
                    <p class="text-xs text-gray-400">No saved addresses on file.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
