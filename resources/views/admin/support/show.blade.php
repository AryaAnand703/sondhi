@extends('layouts.admin')

@section('title', 'Ticket #' . $ticket->ticket_number)

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex justify-between items-center bg-white p-6 rounded-3xl shadow-sm border border-gray-100">
        <div>
            <a href="{{ route('admin.support.index') }}" class="text-xs font-bold text-gray-500 hover:text-gray-800">&larr; Back to Support Queue</a>
            <h2 class="font-serif text-xl font-bold text-gray-900 mt-1">Ticket #{{ $ticket->ticket_number }} - {{ $ticket->subject }}</h2>
        </div>
        <span class="px-3 py-1 text-xs font-bold rounded-full bg-amber-100 text-amber-800">
            {{ $ticket->status }}
        </span>
    </div>

    <!-- Customer Ticket Request Summary -->
    <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 space-y-3 text-xs">
        <div class="flex justify-between items-center text-gray-500 pb-2 border-b border-gray-100">
            <span>Customer: <strong>{{ $ticket->user ? $ticket->user->name : 'User' }}</strong> ({{ $ticket->user ? $ticket->user->email : '' }})</span>
            <span>Category: <strong>{{ $ticket->category }}</strong></span>
        </div>
        <div class="p-4 bg-gray-50 rounded-2xl text-gray-800 leading-relaxed">
            {{ $ticket->description }}
        </div>
    </div>

    <!-- Conversation Thread -->
    <div class="space-y-4">
        <h3 class="font-serif text-lg font-bold text-gray-900">Support Conversation Thread</h3>

        @foreach($ticket->replies as $reply)
            <div class="p-4 rounded-2xl border text-xs space-y-2 {{ $reply->is_admin ? 'bg-amber-50 border-amber-200' : 'bg-white border-gray-200' }}">
                <div class="flex justify-between items-center font-bold">
                    <span class="{{ $reply->is_admin ? 'text-amber-800' : 'text-gray-900' }}">
                        {{ $reply->is_admin ? '🛡️ Admin Support Desk' : ($reply->user ? $reply->user->name : 'Customer') }}
                    </span>
                    <span class="text-gray-400 text-[10px]">{{ $reply->created_at->format('M d, Y h:i A') }}</span>
                </div>
                <p class="text-gray-700 leading-relaxed">{{ $reply->message }}</p>
            </div>
        @endforeach
    </div>

    <!-- Admin Reply Form -->
    <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 space-y-4">
        <h4 class="font-bold text-sm text-gray-900"><i class="fa-solid fa-reply text-brand-600 mr-1"></i> Post Admin Reply & Update Ticket Status</h4>

        <form action="{{ route('admin.support.reply', $ticket->id) }}" method="POST" class="space-y-4">
            @csrf

            <div class="w-48">
                <label class="block text-xs font-bold uppercase text-gray-500 mb-1">Set Ticket Status</label>
                <select name="status" class="w-full px-3 py-2 rounded-xl bg-gray-50 border border-gray-200 text-xs font-bold">
                    <option value="Open" {{ $ticket->status === 'Open' ? 'selected' : '' }}>Open</option>
                    <option value="In Progress" {{ $ticket->status === 'In Progress' ? 'selected' : '' }}>In Progress</option>
                    <option value="Answered" {{ $ticket->status === 'Answered' ? 'selected' : '' }}>Answered</option>
                    <option value="Resolved" {{ $ticket->status === 'Resolved' ? 'selected' : '' }}>Resolved</option>
                    <option value="Closed" {{ $ticket->status === 'Closed' ? 'selected' : '' }}>Closed</option>
                </select>
            </div>

            <textarea name="message" rows="4" placeholder="Write reply message to customer..." required class="w-full px-4 py-3 rounded-xl bg-gray-50 border border-gray-200 text-xs focus:ring-2 focus:ring-amber-500"></textarea>

            <button type="submit" class="px-6 py-3 bg-brand-600 hover:bg-brand-700 text-white font-bold text-xs rounded-xl shadow">
                Post Reply & Send Email Notification
            </button>
        </form>
    </div>
</div>
@endsection
