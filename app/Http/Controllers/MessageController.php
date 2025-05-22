<?php

namespace Fickrr\Http\Controllers;

use Fickrr\Events\MessageSent;
use Fickrr\Models\Message;
use Fickrr\Models\MessageNotification;
use Fickrr\User;
use Fickrr\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function index(Request $request)
    {
        $user = null;
        $messages = collect();
        $conversations = [];
        
        if ($request->has('user_id')) {
            $user = User::findOrFail($request->user_id);
            $messages = Message::betweenUsers(Auth::id(), $user->id)
                ->with(['sender', 'receiver', 'notifications'])
                ->oldest()
                ->get();

            // Mark messages as read
            MessageNotification::where('user_id', Auth::id())
                ->whereIn('message_id', $messages->pluck('id'))
                ->update(['is_read' => true]);
        }

        // Get all conversations for the sidebar
        $conversations = Message::getConversations(Auth::id());
     
        return view('messages.index', compact('messages', 'conversations', 'user'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'content' => 'required|string|max:1000',
            'messageable_id' => 'nullable',
            'messageable_type' => 'nullable'
        ]);

        $message = Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $validated['receiver_id'],
            'content' => $validated['content'],
            'messageable_id' => $validated['messageable_id'] ?? null,
            'messageable_type' => $validated['messageable_type'] ?? null
        ]);

        // Create notification for receiver
        MessageNotification::create([
            'message_id' => $message->id,
            'user_id' => $validated['receiver_id'],
            'is_read' => false
        ]);
        

        // Broadcast event
        broadcast(new MessageSent($message))->toOthers();

        return response()->json(['success' => true]);
    }

    public function markAsRead(Message $message)
    {
        $this->authorize('update', $message);
        
        $updated = $message->notifications()
            ->where('user_id', Auth::id())
            ->update(['is_read' => true]);

        return response()->json([
            'success' => (bool) $updated,
            'message' => $updated ? 'Message marked as read' : 'No unread messages'
        ]);
    }

    public function markAllRead(User $user)
    {
        MessageNotification::where('user_id', Auth::id())
            ->whereHas('message', function($query) use ($user) {
                $query->where('sender_id', $user->id);
            })
            ->update(['is_read' => true]);

        return response()->json(['success' => true]);
    }

    public function getContactInfo($userId)
    {
        $user = User::findOrFail($userId);
        $hasActiveProject = Project::where(function($query) use ($user) {
            $query->where('client_id', Auth::id())
                  ->where('freelancer_id', $user->id)
                  ->whereIn('status', ['active', 'in_progress']);
        })->orWhere(function($query) use ($user) {
            $query->where('client_id', $user->id)
                  ->where('freelancer_id', Auth::id())
                  ->whereIn('status', ['active', 'in_progress']);
        })->exists();

        if (!$hasActiveProject) {
            return response()->json([
                'error' => 'Contact information is only available after project initiation'
            ], 403);
        }

        return response()->json([
            'email' => $user->email,
            'phone' => $user->phone,
            'name' => $user->name
        ]);
    }

    public function destroy(Message $message)
    {
        $this->authorize('delete', $message);
        
        $message->notifications()->delete();
        $message->delete();

        return response()->json(['success' => true]);
    }

    public function getUnreadCount()
    {
        $count = MessageNotification::where('user_id', Auth::id())
            ->where('is_read', false)
            ->count();

        return response()->json(['count' => $count]);
    }

    public function markBatchAsRead(Request $request)
    {
        $validated = $request->validate([
            'message_ids' => 'required|array',
            'message_ids.*' => 'exists:messages,id'
        ]);

        $updated = MessageNotification::where('user_id', Auth::id())
            ->whereIn('message_id', $validated['message_ids'])
            ->update(['is_read' => true]);

        return response()->json([
            'success' => (bool) $updated,
            'count' => $updated
        ]);
    }

    public function deleteConversation($conversationId)
    {
        $messages = Message::where(function($query) use ($conversationId) {
            $query->where('sender_id', Auth::id())
                  ->where('receiver_id', $conversationId);
        })->orWhere(function($query) use ($conversationId) {
            $query->where('sender_id', $conversationId)
                  ->where('receiver_id', Auth::id());
        })->get();

        foreach ($messages as $message) {
            $message->notifications()->delete();
            $message->delete();
        }

        return response()->json(['success' => true]);
    }

    public function getProjectContactInfo(Project $project)
    {
        $this->authorize('view', $project);

        $user = Auth::id() === $project->client_id
            ? $project->freelancer
            : $project->client;

        return response()->json([
            'email' => $user->email,
            'phone' => $user->phone,
            'name' => $user->name
        ]);
    }
}
