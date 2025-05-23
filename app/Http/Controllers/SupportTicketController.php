<?php

namespace Fickrr\Http\Controllers;

use Illuminate\Http\Request;
use Fickrr\Http\Controllers\Controller;
use Fickrr\Models\SupportTicket;
use Fickrr\Events\SupportTicketCreated;

class SupportTicketController extends Controller
{
    /**
     * Show support ticket form
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('pages.support-ticket');
    }

    /**
     * Store new support ticket
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
            'priority' => 'required|in:low,medium,high',
        ]);
        $ticket = SupportTicket::create([
            'user_id' => auth()->id(),
            'subject' => $validated['subject'],
            'message' => $validated['message'],
            'priority' => $validated['priority'],
            'status' => 'open'
        ]);

        // event(new SupportTicketCreated($ticket));

        return redirect()->route('support-ticket_create')
            ->with('success', 'Your support ticket has been submitted successfully!');
    }

    /**
     * Display user's support tickets
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $tickets = SupportTicket::where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('pages.my-support-tickets', compact('tickets'));
    }
}