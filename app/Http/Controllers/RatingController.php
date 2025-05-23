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
        $validated = $request->validate(Rating::rules());


        if ($project->client_id !== Auth::id()) {
            abort(403, 'Unauthorized action');
        }

        // Check for existing rating
        if (Rating::where('user_id', Auth::id())
            ->where('project_id', $project->id)
            ->exists()) {
            return back()->withErrors(['rating' => 'You have already rated this project']);
        }

        Rating::create([
            'user_id' => Auth::id(),
            'freelancer_id' => $project->freelancer_id,
            'project_id' => $project->id,
            'rating' => $validated['rating']
        ]);

        return back()->with('success', 'Thank you for rating this freelancer!');
    }
}