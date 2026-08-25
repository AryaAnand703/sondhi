<?php

namespace App\Http\Controllers;

use App\Models\SupportTicket;
use App\Models\TicketReply;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SupportTicketController extends Controller
{
    public function index()
    {
        $faqs = [
            [
                'question' => 'How long do orders take to ship?',
                'answer' => 'Standard orders ship within 2-3 business days. Delivery typically takes 3-5 business days across India.',
            ],
            [
                'question' => 'What payment methods do you support?',
                'answer' => 'We accept all major Online Payment methods (Razorpay: UPI, Credit/Debit cards, NetBanking) as well as Cash on Delivery (COD).',
            ],
            [
                'question' => 'Can I request custom notes or gift packaging?',
                'answer' => 'Yes! You can add custom packaging notes directly on the product detail page before adding items to your cart.',
            ],
        ];

        $tickets = Auth::check() ? Auth::user()->supportTickets()->with(['order', 'replies'])->latest()->get() : collect();

        return view('support.index', compact('faqs', 'tickets'));
    }

    public function create()
    {
        $userOrders = Auth::user()->orders()->latest()->get();
        return view('support.create', compact('userOrders'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'order_id' => 'nullable|exists:orders,id',
            'category' => 'required|string',
            'subject' => 'required|string|max:255',
            'description' => 'required|string|max:2000',
            'priority' => 'required|in:Low,Normal,High,Urgent',
        ]);

        $ticket = SupportTicket::create([
            'ticket_number' => 'TCK-' . rand(1000, 9999),
            'user_id' => Auth::id(),
            'order_id' => $request->order_id,
            'category' => $request->category,
            'subject' => $request->subject,
            'description' => $request->description,
            'priority' => $request->priority,
            'status' => 'Open',
        ]);

        return redirect()->route('support.show', $ticket->id)->with('success', "Support Ticket #{$ticket->ticket_number} created successfully.");
    }

    public function show($id)
    {
        $ticket = SupportTicket::where('id', $id)->where('user_id', Auth::id())->with(['order', 'replies.user'])->firstOrFail();

        return view('support.show', compact('ticket'));
    }

    public function reply(Request $request, $id)
    {
        $ticket = SupportTicket::where('id', $id)->where('user_id', Auth::id())->firstOrFail();

        $request->validate([
            'message' => 'required|string|max:2000',
        ]);

        TicketReply::create([
            'ticket_id' => $ticket->id,
            'user_id' => Auth::id(),
            'message' => $request->message,
            'is_admin' => false,
        ]);

        $ticket->update(['status' => 'Open']);

        return back()->with('success', 'Reply sent.');
    }
}
