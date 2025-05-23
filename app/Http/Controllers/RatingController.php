<?php

namespace Fickrr\Http\Controllers;

use Fickrr\Models\Rating;
use Fickrr\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RatingController extends Controller
{
    public function __construct()
    {
        // $this->middleware(ProjectComplete::class);
    }

    public function store(Request $request, Project $project)
    {
         if(auth()->user()->user_type === 'client')
         {
            $validated = $request->validate([
                'work_rating' => 'required|integer|between:1,5'
            ]);

        }

        // Verify project completion status
        if ($project->status !== 'completed') {
            abort(403, 'Project must be completed before rating');
        }

        // Verify requesting user is the project client
        // if ($project->client_id !== Auth::id()) {
        //     abort(403, 'Unauthorized action');
        // }

        // Check for existing rating
        if (Rating::where('user_id', Auth::id())
            ->where('project_id', $project->id)
            ->exists()) {
            return back()->withErrors(['work_rating' => 'You have already rated this project']);
        }

        Rating::create([
            'user_id' => Auth::id(),
            'freelancer_id' => $project->freelancer_id,
            'project_id' => $project->id,
            'work_rating' => $$request->work_rating ?? 0,
            'communication_rating' => $request->communication_rating ?? 0  ,
            'payment_rating' => $request->payment_rating ?? 0,
            'review_text' => $request->review_text ?? null,

        ]);

        return back()->with('success', 'Thank you for rating this freelancer!');
    }
}