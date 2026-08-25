@extends('layouts.admin')

@section('title', 'Registered Customers Directory')

@section('content')
<div class="space-y-6">
    <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 flex justify-between items-center">
        <div>
            <h2 class="font-serif text-xl font-bold text-gray-900">Registered Customer Accounts</h2>
            <p class="text-xs text-gray-500">View customer activity, order frequencies, and lifetime spending.</p>
        </div>
    </div>

    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
        <table class="w-full text-left text-xs">
            <thead class="bg-gray-50 border-b border-gray-100 uppercase tracking-wider text-gray-500 font-bold">
                <tr>
                    <th class="p-4">Customer Name</th>
                    <th class="p-4">Email Address</th>
                    <th class="p-4">Phone Number</th>
                    <th class="p-4">Total Orders</th>
                    <th class="p-4">Lifetime Spend</th>
                    <th class="p-4">Joined Date</th>
                    <th class="p-4 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($customers as $c)
                    <tr class="hover:bg-gray-50">
                        <td class="p-4 font-bold text-gray-900 flex items-center space-x-3">
                            <div class="w-8 h-8 rounded-full bg-brand-100 text-brand-700 font-bold flex items-center justify-center text-xs">
                                {{ strtoupper(substr($c->name, 0, 2)) }}
                            </div>
                            <span>{{ $c->name }}</span>
                        </td>
                        <td class="p-4 text-gray-600">{{ $c->email }}</td>
                        <td class="p-4 text-gray-600">{{ $c->phone }}</td>
                        <td class="p-4 font-bold text-brand-600">{{ $c->orders_count }} orders</td>
                        <td class="p-4 font-bold text-gray-900">₹{{ number_format($c->total_spent ?? 0, 2) }}</td>
                        <td class="p-4 text-gray-400">{{ $c->created_at->format('M d, Y') }}</td>
                        <td class="p-4 text-right">
                            <a href="{{ route('admin.customers.show', $c->id) }}" class="px-3 py-1.5 bg-gray-100 text-gray-700 hover:bg-brand-600 hover:text-white font-bold text-xs rounded-xl transition-colors">
                                View Profile &rarr;
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $customers->links() }}
    </div>
</div>
@endsection
