@extends('layouts.app')

@section('title', 'Ticket #' . $ticket->ticket_number . ' | Sondhi Support')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="mb-6 flex justify-between items-center">
        <a href="{{ route('support.index') }}" class="text-xs font-bold text-brand-600 hover:underline">&larr; Back to Support Desk</a>
        <span class="px-3 py-1 text-xs font-bold rounded-full {{ $ticket->status === 'Resolved' ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-800' }}">
            Status: {{ $ticket->status }}
        </span>
    </div>

    <!-- Ticket Summary Card -->
    <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 mb-8 space-y-4">
        <div class="flex items-center justify-between pb-3 border-b border-gray-100">
            <div>
                <span class="text-xs font-mono font-bold text-brand-600">Ticket #{{ $ticket->ticket_number }}</span>
                <span class="text-xs text-gray-400 ml-2">&bull; Category: <strong>{{ $ticket->category }}</strong></span>
            </div>
            @if($ticket->order)
                <a href="{{ route('orders.show', $ticket->order->id) }}" class="text-xs font-bold text-brand-600 hover:underline">
                    Order #{{ $ticket->order->order_number }} &rarr;
                </a>
            @endif
        </div>

        <h1 class="font-serif text-2xl font-bold text-gray-900">{{ $ticket->subject }}</h1>

        <div class="bg-gray-50 p-4 rounded-2xl text-xs text-gray-700 leading-relaxed">
            <div class="flex justify-between items-center mb-2">
                <span class="font-bold text-gray-900">{{ Auth::user()->name }} (Customer)</span>
                <span class="text-gray-400">{{ $ticket->created_at->format('M d, Y \a\t h:i A') }}</span>
            </div>
            <p>{{ $ticket->description }}</p>
        </div>
    </div>

    <!-- Conversation Chat Thread -->
    <div class="space-y-6 mb-8">
        <h3 class="font-serif text-lg font-bold text-gray-900">Conversation History</h3>

        @forelse($ticket->replies as $reply)
            <div class="flex flex-col {{ $reply->is_admin ? 'items-start' : 'items-end' }}">
                <div class="max-w-xl rounded-3xl p-5 shadow-sm border text-xs space-y-2 
                    {{ $reply->is_admin ? 'bg-amber-500/10 border-amber-200 text-gray-900 rounded-tl-sm' : 'bg-brand-600 text-white border-brand-600 rounded-tr-sm' }}">
                    <div class="flex justify-between items-center space-x-4 border-b pb-1.5 {{ $reply->is_admin ? 'border-amber-200/50' : 'border-brand-500' }}">
                        <span class="font-bold flex items-center">
                            @if($reply->is_admin)
                                <i class="fa-solid fa-crown text-amber-600 mr-1"></i> Sondhi Support Team
                            @else
                                {{ $reply->user ? $reply->user->name : 'You' }}
                            @endif
                        </span>
                        <span class="{{ $reply->is_admin ? 'text-gray-500' : 'text-brand-100' }} text-[10px]">{{ $reply->created_at->format('M d, h:i A') }}</span>
                    </div>
                    <p class="leading-relaxed whitespace-pre-line">{{ $reply->message }}</p>
                </div>
            </div>
        @empty
            <p class="text-xs text-gray-400 text-center py-4">No replies yet. Our support team will get back to you shortly.</p>
        @endforelse
    </div>

    <!-- Reply Box -->
    <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100">
        <h4 class="font-bold text-sm text-gray-900 mb-3"><i class="fa-solid fa-reply text-brand-600 mr-1"></i> Post a Reply</h4>
        <form action="{{ route('support.reply', $ticket->id) }}" method="POST" class="space-y-4">
            @csrf
            <textarea name="message" rows="3" placeholder="Type your reply message..." required 
                      class="w-full px-4 py-3 rounded-xl bg-gray-50 border border-gray-200 text-xs focus:ring-2 focus:ring-brand-500"></textarea>
            <button type="submit" class="px-6 py-2.5 bg-brand-600 hover:bg-brand-700 text-white font-bold text-xs rounded-xl shadow">
                Send Reply
            </button>
        </form>
    </div>
</div>
@endsection
