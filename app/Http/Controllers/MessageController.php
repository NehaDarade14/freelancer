<?php

namespace Fickrr\Http\Controllers;

use Illuminate\Http\Request;
use Fickrr\Models\JobApplication;
use Fickrr\Models\Message;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    /**
     * Display messages for a job application
     */
    public function index(JobApplication $application)
    {
        // Verify the authenticated user is either the freelancer or client for this application
        if (Auth::id() != $application->freelancer_id && Auth::id() != $application->job->employer_id) {
            abort(403);
        }

        // Mark all messages from other user as read
        Message::where('job_application_id', $application->id)
            ->where('user_id', '!=', Auth::id())
            ->where('is_read', false)
            ->update([
                'is_read' => true,
                'read_at' => now()
            ]);

        $messages = Message::where('job_application_id', $application->id)
            ->orderBy('created_at', 'asc')
            ->get();
            
        return view('jobs.applications.messages', [
            'application' => $application,
            'messages' => $messages
        ]);
    }

    /**
     * Store a new message
     */
    public function store(Request $request)
    {
        $request->validate([
            'job_application_id' => 'required|exists:job_applications,id',
            'content' => 'required|string|max:2000'
        ]);

        $application = JobApplication::findOrFail($request->job_application_id);

        // Verify the authenticated user is either the freelancer or client
        if (Auth::id() != $application->freelancer_id && Auth::id() != $application->job->employer_id) {
            abort(403);
        }

        $message = Message::create([
            'job_application_id' => $application->id,
            'user_id' => Auth::id(),
            'content' => $request->content,
            'is_read' => false,
            'notification_sent' => false
        ]);

        // Send notification to the other user
        $recipientId = Auth::id() == $application->freelancer_id
            ? $application->job->employer_id
            : $application->freelancer_id;

        // Create notification
        $notification = new \Fickrr\Models\Notification();
        $notification->user_id = $recipientId;
        $notification->message_id = $message->id;
        $notification->save();

        // Update unread count in session
        $unreadCount = \Fickrr\Models\Notification::where('user_id', $recipientId)
            ->where('is_read', false)
            ->count();
        session()->put('unread_notifications.' . $recipientId, $unreadCount);

        return redirect()->back()
            ->with('success', 'Message sent successfully');
    }

    /**
     * Show messages for a job application (employer/freelancer view)
     */
    public function showMessages(JobApplication $application)
    {
        // Verify the authenticated user is either the freelancer or client for this application
        if (Auth::id() != $application->freelancer_id && Auth::id() != $application->job->employer_id) {
            abort(403);
        }

        // Mark all messages from other user as read
        Message::where('job_application_id', $application->id)
            ->where('user_id', '!=', Auth::id())
            ->where('is_read', false)
            ->update([
                'is_read' => true,
                'read_at' => now()
            ]);

        $messages = Message::where('job_application_id', $application->id)
            ->orderBy('created_at', 'asc')
            ->get();

        return view('jobs.applications.messages', [
            'application' => $application,
            'messages' => $messages
        ]);
    }

    /**
     * Get messages via AJAX
     */
    public function getMessages(JobApplication $application)
    {
        // Verify the authenticated user is either the freelancer or client for this application
        if (Auth::id() != $application->freelancer_id && Auth::id() != $application->job->employer_id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $messages = Message::with('user')
            ->where('job_application_id', $application->id)
            ->orderBy('created_at', 'asc')
            ->get();

        return response()->json([
            'messages' => $messages,
            'current_user_id' => Auth::id()
        ]);
        
    }

    /**
     * Mark messages as read via AJAX
     */
    public function markAsRead(Request $request, JobApplication $application)
    {
        // Verify the authenticated user is either the freelancer or client for this application
        if (Auth::id() != $application->freelancer_id && Auth::id() != $application->job->employer_id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $updated = Message::where('job_application_id', $application->id)
            ->where('user_id', '!=', Auth::id())
            ->where('is_read', false)
            ->update([
                'is_read' => true,
                'read_at' => now()
            ]);

        return response()->json([
            'success' => $updated > 0,
            'count' => $updated
        ]);
    }
}
