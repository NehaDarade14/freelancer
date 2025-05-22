<?php

namespace Fickrr\Http\Controllers;

use Illuminate\Http\Request;
use Fickrr\User;
use Fickrr\Models\Project;
use Fickrr\Models\Job;

class ProjectsController extends Controller
{
    public function create($freelancerId)
    {
        $freelancer = User::findOrFail($freelancerId);
        
        return view('projects.create', [
            'freelancer' => $freelancer
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'scope' => 'required|string',
            'deliverables' => 'required|string',
            'requirements' => 'nullable|string',
            'communication' => 'required|in:email,chat,video,mixed',
            'budget' => 'required|numeric|min:1',
            'deadline' => 'required|date|after:today',
            'freelancer_id' => 'required|exists:users,id'
        ]);

        $project = Project::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'scope' => $validated['scope'],
            'deliverables' => $validated['deliverables'],
            'requirements' => $validated['requirements'],
            'communication_preference' => $validated['communication'],
            'budget' => $validated['budget'],
            'deadline' => $validated['deadline'],
            'client_id' => auth()->id(),
            'freelancer_id' => $validated['freelancer_id'],
            'status' => 'pending'
        ]);

        return redirect()->route('project-tracking')
            ->with('success', 'Project initiated successfully!');
    }
}