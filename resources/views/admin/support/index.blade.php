@extends('layouts.admin')

@section('title', 'Customer Support Desk')

@section('content')
<div class="space-y-6">
    <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h2 class="font-serif text-xl font-bold text-gray-900">Support Ticket Queue</h2>
            <p class="text-xs text-gray-500">Manage and reply to customer inquiries, delivery questions, and refund requests.</p>
        </div>

        <form action="{{ route('admin.support.index') }}" method="GET">
            <select name="status" onchange="this.form.submit()" class="px-4 py-2 rounded-xl bg-gray-50 border border-gray-200 text-xs focus:ring-2 focus:ring-amber-500 font-medium">
                <option value="">All Statuses</option>
                <option value="Open" {{ request('status') == 'Open' ? 'selected' : '' }}>Open</option>
                <option value="In Progress" {{ request('status') == 'In Progress' ? 'selected' : '' }}>In Progress</option>
                <option value="Resolved" {{ request('status') == 'Resolved' ? 'selected' : '' }}>Resolved</option>
                <option value="Closed" {{ request('status') == 'Closed' ? 'selected' : '' }}>Closed</option>
            </select>
        </form>
    </div>

    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
        <table class="w-full text-left text-xs">
            <thead class="bg-gray-50 border-b border-gray-100 uppercase tracking-wider text-gray-500 font-bold">
                <tr>
                    <th class="p-4">Ticket ID</th>
                    <th class="p-4">Customer</th>
                    <th class="p-4">Category</th>
                    <th class="p-4">Subject</th>
                    <th class="p-4">Priority</th>
                    <th class="p-4">Status</th>
                    <th class="p-4 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($tickets as $t)
                    <tr class="hover:bg-gray-50">
                        <td class="p-4 font-mono font-bold text-brand-600">#{{ $t->ticket_number }}</td>
                        <td class="p-4">
                            <p class="font-bold text-gray-900">{{ $t->user ? $t->user->name : 'Customer' }}</p>
                            <p class="text-[10px] text-gray-400">{{ $t->user ? $t->user->email : '' }}</p>
                        </td>
                        <td class="p-4 text-gray-700 font-medium">{{ $t->category }}</td>
                        <td class="p-4 font-bold text-gray-900 line-clamp-1 max-w-xs">{{ $t->subject }}</td>
                        <td class="p-4">
                            <span class="px-2 py-0.5 rounded text-[10px] font-bold {{ $t->priority === 'Urgent' ? 'bg-rose-100 text-rose-800' : 'bg-gray-100 text-gray-700' }}">
                                {{ $t->priority }}
                            </span>
                        </td>
                        <td class="p-4">
                            <span class="px-2.5 py-0.5 rounded-full font-bold text-[10px] {{ $t->status === 'Resolved' ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-800' }}">
                                {{ $t->status }}
                            </span>
                        </td>
                        <td class="p-4 text-right">
                            <a href="{{ route('admin.support.show', $t->id) }}" class="px-3 py-1.5 bg-brand-50 text-brand-700 hover:bg-brand-600 hover:text-white font-bold text-xs rounded-xl transition-colors">
                                Reply & Chat &rarr;
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $tickets->links() }}
    </div>
</div>
@endsection
