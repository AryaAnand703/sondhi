@extends('layouts.app')

@section('title', 'Help & Support Center | Sondhi')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <!-- Header Banner -->
    <div class="gradient-brand text-white py-12 px-8 rounded-3xl mb-12 shadow-xl flex flex-col md:flex-row justify-between items-start md:items-center">
        <div>
            <h1 class="font-serif text-3xl font-bold">Help & Support Desk</h1>
            <p class="text-xs text-brand-100 mt-1">Frequently asked questions, order inquiries, and direct support tickets.</p>
        </div>
        <div class="mt-4 md:mt-0">
            @auth
                <a href="{{ route('support.create') }}" class="px-5 py-3 bg-amber-500 hover:bg-amber-600 text-white font-bold text-xs rounded-xl shadow-lg transition-colors">
                    <i class="fa-solid fa-ticket mr-1"></i> Submit Support Ticket
                </a>
            @else
                <a href="{{ route('login') }}" class="px-5 py-3 bg-amber-500 text-white font-bold text-xs rounded-xl shadow">
                    Login to Open Ticket
                </a>
            @endauth
        </div>
    </div>

    <!-- FAQ Accordions -->
    <div class="mb-14">
        <h2 class="font-serif text-2xl font-bold text-gray-900 mb-6 flex items-center">
            <i class="fa-solid fa-circle-question text-brand-600 mr-2"></i> Frequently Asked Questions
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @foreach($faqs as $faq)
                <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 space-y-2">
                    <h3 class="font-bold text-sm text-gray-900 flex items-start">
                        <span class="w-6 h-6 rounded-full bg-brand-100 text-brand-700 text-xs flex items-center justify-center font-bold mr-2 flex-shrink-0">Q</span>
                        {{ $faq['question'] }}
                    </h3>
                    <p class="text-xs text-gray-600 leading-relaxed pl-8">
                        {{ $faq['answer'] }}
                    </p>
                </div>
            @endforeach
        </div>
    </div>

    <!-- My Support Tickets (If Authenticated) -->
    @auth
        <div>
            <div class="flex justify-between items-center mb-6">
                <h2 class="font-serif text-2xl font-bold text-gray-900">My Support Tickets</h2>
                <a href="{{ route('support.create') }}" class="text-xs font-bold text-brand-600 hover:underline">+ Open Ticket</a>
            </div>

            @if($tickets->count() > 0)
                <div class="space-y-4">
                    @foreach($tickets as $tck)
                        <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                            <div>
                                <div class="flex items-center space-x-3">
                                    <span class="font-mono text-xs font-bold text-brand-600">#{{ $tck->ticket_number }}</span>
                                    <span class="px-2.5 py-0.5 text-[10px] font-bold bg-gray-100 text-gray-700 rounded-full">{{ $tck->category }}</span>
                                </div>
                                <h3 class="font-bold text-base text-gray-900 mt-1">
                                    <a href="{{ route('support.show', $tck->id) }}" class="hover:text-brand-600 transition-colors">{{ $tck->subject }}</a>
                                </h3>
                                <p class="text-xs text-gray-500 mt-0.5">Created on {{ $tck->created_at->format('M d, Y') }} &bull; {{ $tck->replies->count() }} Replies</p>
                            </div>

                            <div class="flex items-center space-x-3">
                                <span class="px-3 py-1 text-xs font-bold rounded-full 
                                    {{ $tck->status === 'Resolved' ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-800' }}">
                                    {{ $tck->status }}
                                </span>
                                <a href="{{ route('support.show', $tck->id) }}" class="px-4 py-2 bg-brand-50 text-brand-700 hover:bg-brand-600 hover:text-white font-bold text-xs rounded-xl transition-colors">
                                    View Chat &rarr;
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="bg-white p-8 rounded-3xl text-center border border-gray-100 shadow-sm text-xs text-gray-500">
                    No support tickets submitted yet. Have a issue with an order or payment? Submit a ticket above!
                </div>
            @endif
        </div>
    @endauth
</div>
@endsection
