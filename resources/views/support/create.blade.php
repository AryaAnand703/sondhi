@extends('layouts.app')

@section('title', 'Submit Support Ticket | Sondhi')

@section('content')
<div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="bg-white p-8 rounded-3xl shadow-xl border border-gray-100 space-y-6">
        <div class="text-center border-b border-gray-100 pb-6">
            <div class="w-12 h-12 bg-brand-100 text-brand-600 rounded-2xl flex items-center justify-center mx-auto mb-3 shadow-inner">
                <i class="fa-solid fa-headset text-xl"></i>
            </div>
            <h1 class="font-serif text-2xl font-bold text-gray-900">Submit Support Ticket</h1>
            <p class="text-xs text-gray-500 mt-1">Our support specialists typically respond within 2-4 business hours.</p>
        </div>

        <form action="{{ route('support.store') }}" method="POST" class="space-y-5">
            @csrf

            <!-- Associated Order Select -->
            <div>
                <label for="order_id" class="block text-xs font-bold uppercase text-gray-600 mb-1">Related Order (Optional)</label>
                <select name="order_id" id="order_id" class="w-full px-4 py-3 rounded-xl bg-gray-50 border border-gray-200 text-sm focus:ring-2 focus:ring-brand-500">
                    <option value="">-- General Inquiry (Not Order Specific) --</option>
                    @foreach($userOrders as $ord)
                        <option value="{{ $ord->id }}" {{ request('order_id') == $ord->id ? 'selected' : '' }}>
                            Order #{{ $ord->order_number }} (Status: {{ $ord->status }} &bull; Total: ₹{{ number_format($ord->total_amount, 2) }})
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Issue Category -->
            <div>
                <label for="category" class="block text-xs font-bold uppercase text-gray-600 mb-1">Issue Category</label>
                <select name="category" id="category" required class="w-full px-4 py-3 rounded-xl bg-gray-50 border border-gray-200 text-sm focus:ring-2 focus:ring-brand-500">
                    <option value="Order Query">Order Status & Delivery Query</option>
                    <option value="Payment Problem">Payment / Billing Problem</option>
                    <option value="Cancellation/Return">Request Cancellation or Return</option>
                    <option value="General">General Inquiry / Feedback</option>
                </select>
            </div>

            <!-- Subject -->
            <div>
                <label for="subject" class="block text-xs font-bold uppercase text-gray-600 mb-1">Subject</label>
                <input type="text" name="subject" id="subject" placeholder="Brief summary of your question" required 
                       class="w-full px-4 py-3 rounded-xl bg-gray-50 border border-gray-200 text-sm focus:ring-2 focus:ring-brand-500">
            </div>

            <!-- Priority -->
            <div>
                <label for="priority" class="block text-xs font-bold uppercase text-gray-600 mb-1">Priority Level</label>
                <select name="priority" id="priority" class="w-full px-4 py-3 rounded-xl bg-gray-50 border border-gray-200 text-sm focus:ring-2 focus:ring-brand-500">
                    <option value="Normal" selected>Normal</option>
                    <option value="Low">Low</option>
                    <option value="High">High</option>
                    <option value="Urgent">Urgent</option>
                </select>
            </div>

            <!-- Detailed Description -->
            <div>
                <label for="description" class="block text-xs font-bold uppercase text-gray-600 mb-1">Detailed Description</label>
                <textarea name="description" id="description" rows="4" placeholder="Describe your question or issue in detail..." required 
                          class="w-full px-4 py-3 rounded-xl bg-gray-50 border border-gray-200 text-xs focus:ring-2 focus:ring-brand-500"></textarea>
            </div>

            <button type="submit" class="w-full py-3.5 px-4 bg-brand-600 hover:bg-brand-700 text-white font-bold text-sm rounded-xl shadow-lg shadow-brand-500/25 transition-all">
                Submit Support Ticket &rarr;
            </button>
        </form>
    </div>
</div>
@endsection
