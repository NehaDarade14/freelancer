<?php

namespace Fickrr\Http\Controllers\Admin;

use Fickrr\Http\Controllers\Controller;
use Fickrr\Models\SupportTicket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SupportTicketController extends Controller
{
    public function index()
    {
        $supportTickets = SupportTicket::latest()->paginate(10);
        return view('admin.support-tickets.index', compact('supportTickets'));
    }

    public function create()
    {
        return view('admin.support-tickets.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
            'priority' => 'required|in:low,medium,high'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        SupportTicket::create([
            'subject' => $request->subject,
            'message' => $request->message,
            'priority' => $request->priority,
            'status' => $request->status ?? "open",
            'user_id' => auth()->id()
        ]);

        return redirect()->route('support-tickets.index')
            ->with('success', 'Support ticket created successfully');
    }

    public function edit(SupportTicket $supportTicket)
    {
        return view('admin.support-tickets.edit', compact('supportTicket'));
    }

    public function update(Request $request, SupportTicket $supportTicket)
    {
        $validator = Validator::make($request->all(), [
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
            'priority' => 'required|in:low,medium,high',
            'status' => 'required|in:open,pending,resolved'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $supportTicket->update([
            'subject' => $request->subject,
            'message' => $request->message,
            'priority' => $request->priority,
            'status' => $request->status
        ]);

        return redirect()->route('support-tickets.index')
            ->with('success', 'Support ticket updated successfully');
    }

    public function destroy(SupportTicket $supportTicket)
    {
        $supportTicket->delete();
        return redirect()->route('support-tickets.index')
            ->with('success', 'Support ticket deleted successfully');
    }
}
