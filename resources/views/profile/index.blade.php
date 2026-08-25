@extends('layouts.app')

@section('title', 'My Account Profile | Sondhi')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <!-- Profile Header Banner -->
    <div class="gradient-brand rounded-3xl p-8 text-white mb-10 shadow-xl flex flex-col md:flex-row justify-between items-start md:items-center">
        <div class="flex items-center space-x-4 mb-4 md:mb-0">
            <div class="w-16 h-16 rounded-2xl bg-amber-500/20 border border-amber-400/30 flex items-center justify-center text-amber-300 font-bold text-2xl">
                {{ strtoupper(substr($user->name, 0, 2)) }}
            </div>
            <div>
                <h1 class="font-serif text-2xl font-bold">{{ $user->name }}</h1>
                <p class="text-sm text-brand-200"><i class="fa-solid fa-envelope mr-1"></i> {{ $user->email }} | <i class="fa-solid fa-phone mr-1"></i> {{ $user->phone }}</p>
            </div>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('orders.index') }}" class="px-4 py-2 bg-white/10 hover:bg-white/20 text-white rounded-xl text-sm font-semibold transition-colors">
                <i class="fa-solid fa-box-open mr-2"></i> View Orders
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Left Column: Personal Information & Password -->
        <div class="space-y-8">
            <!-- Edit Profile Form -->
            <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100">
                <h3 class="font-serif text-lg font-bold text-gray-900 mb-4 pb-2 border-b border-gray-100">
                    <i class="fa-solid fa-user-gear text-brand-600 mr-2"></i> Edit Account Info
                </h3>
                <form action="{{ route('profile.update') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-xs font-bold uppercase text-gray-500 mb-1">Full Name</label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}" required class="w-full px-4 py-2.5 rounded-xl bg-gray-50 border border-gray-200 text-sm focus:ring-2 focus:ring-brand-500">
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase text-gray-500 mb-1">Email Address</label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}" required class="w-full px-4 py-2.5 rounded-xl bg-gray-50 border border-gray-200 text-sm focus:ring-2 focus:ring-brand-500">
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase text-gray-500 mb-1">Phone Number</label>
                        <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" required class="w-full px-4 py-2.5 rounded-xl bg-gray-50 border border-gray-200 text-sm focus:ring-2 focus:ring-brand-500">
                    </div>
                    <button type="submit" class="w-full py-2.5 px-4 bg-brand-600 hover:bg-brand-700 text-white font-bold text-sm rounded-xl transition-all">
                        Save Profile Changes
                    </button>
                </form>
            </div>
        </div>

        <!-- Right Column: Saved Delivery Addresses & Recent Order Activity -->
        <div class="lg:col-span-2 space-y-8">
            <!-- Saved Delivery Addresses Section -->
            <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100">
                <div class="flex justify-between items-center mb-6 pb-2 border-b border-gray-100">
                    <h3 class="font-serif text-lg font-bold text-gray-900">
                        <i class="fa-solid fa-location-dot text-brand-600 mr-2"></i> Saved Delivery Addresses
                    </h3>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6">
                    @forelse($addresses as $addr)
                        <div class="p-4 rounded-2xl border {{ $addr->is_default ? 'border-brand-500 bg-brand-50/30' : 'border-gray-200 bg-gray-50' }} relative group">
                            @if($addr->is_default)
                                <span class="absolute top-3 right-3 px-2 py-0.5 text-[10px] font-bold bg-brand-600 text-white rounded-full">DEFAULT</span>
                            @endif
                            <p class="font-bold text-sm text-gray-900">{{ $addr->recipient_name }}</p>
                            <p class="text-xs text-gray-500 mt-1"><i class="fa-solid fa-phone mr-1"></i> {{ $addr->phone }}</p>
                            <p class="text-xs text-gray-700 mt-2 leading-relaxed">
                                {{ $addr->address_line1 }}@if($addr->address_line2), {{ $addr->address_line2 }}@endif<br>
                                {{ $addr->city }}, {{ $addr->state }} - {{ $addr->postal_code }}
                            </p>

                            <div class="mt-4 pt-2 border-t border-gray-200 flex justify-end">
                                <form action="{{ route('profile.address.delete', $addr->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-xs font-semibold text-rose-600 hover:underline">
                                        <i class="fa-solid fa-trash-can mr-1"></i> Remove
                                    </button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div class="sm:col-span-2 text-center py-6 text-gray-400 text-xs">
                            No saved delivery addresses yet. Add your address below!
                        </div>
                    @endforelse
                </div>

                <!-- Add New Address Collapsible Form -->
                <div class="bg-gray-50 p-5 rounded-2xl border border-gray-200">
                    <h4 class="font-bold text-sm text-gray-800 mb-3"><i class="fa-solid fa-plus-circle mr-1 text-brand-600"></i> Add New Delivery Address</h4>
                    <form action="{{ route('profile.address.store') }}" method="POST" class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        @csrf
                        <div>
                            <input type="text" name="recipient_name" placeholder="Recipient Name" required class="w-full px-3 py-2 rounded-xl bg-white border border-gray-200 text-xs">
                        </div>
                        <div>
                            <input type="text" name="phone" placeholder="Phone Number" required class="w-full px-3 py-2 rounded-xl bg-white border border-gray-200 text-xs">
                        </div>
                        <div class="sm:col-span-2">
                            <input type="text" name="address_line1" placeholder="Flat, Street, Building Name" required class="w-full px-3 py-2 rounded-xl bg-white border border-gray-200 text-xs">
                        </div>
                        <div class="sm:col-span-2">
                            <input type="text" name="address_line2" placeholder="Landmark (Optional)" class="w-full px-3 py-2 rounded-xl bg-white border border-gray-200 text-xs">
                        </div>
                        <div>
                            <input type="text" name="city" placeholder="City" required class="w-full px-3 py-2 rounded-xl bg-white border border-gray-200 text-xs">
                        </div>
                        <div>
                            <input type="text" name="state" placeholder="State" required class="w-full px-3 py-2 rounded-xl bg-white border border-gray-200 text-xs">
                        </div>
                        <div>
                            <input type="text" name="postal_code" placeholder="Postal / PIN Code" required class="w-full px-3 py-2 rounded-xl bg-white border border-gray-200 text-xs">
                        </div>
                        <div class="flex items-center">
                            <label class="text-xs text-gray-700 font-medium flex items-center">
                                <input type="checkbox" name="is_default" value="1" class="rounded text-brand-600 mr-2"> Set as Default Address
                            </label>
                        </div>
                        <div class="sm:col-span-2 mt-2">
                            <button type="submit" class="w-full py-2.5 bg-brand-600 hover:bg-brand-700 text-white font-bold text-xs rounded-xl shadow">
                                Save Address
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Recent Orders Summary -->
            <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="font-serif text-lg font-bold text-gray-900">
                        <i class="fa-solid fa-clock-rotate-left text-brand-600 mr-2"></i> Recent Orders
                    </h3>
                    <a href="{{ route('orders.index') }}" class="text-xs font-bold text-brand-600 hover:underline">View All Orders &rarr;</a>
                </div>

                @if($recentOrders->count() > 0)
                    <div class="divide-y divide-gray-100">
                        @foreach($recentOrders as $ord)
                            <div class="py-4 flex items-center justify-between">
                                <div>
                                    <span class="font-bold text-sm text-gray-900">#{{ $ord->order_number }}</span>
                                    <span class="text-xs text-gray-500 block">{{ $ord->created_at->format('M d, Y') }}</span>
                                </div>
                                <div>
                                    <span class="px-3 py-1 text-xs font-bold rounded-full 
                                        {{ $ord->status === 'Delivered' ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-800' }}">
                                        {{ $ord->status }}
                                    </span>
                                </div>
                                <div class="text-right">
                                    <span class="font-bold text-sm text-gray-900">₹{{ number_format($ord->total_amount, 2) }}</span>
                                    <a href="{{ route('orders.show', $ord->id) }}" class="text-xs font-semibold text-brand-600 block hover:underline">Track &rarr;</a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-xs text-gray-400 text-center py-4">No recent orders yet.</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
