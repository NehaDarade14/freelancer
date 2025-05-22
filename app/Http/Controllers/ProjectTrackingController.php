<?php

namespace Fickrr\Http\Controllers;

use Fickrr\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectTrackingController extends Controller
{
    public function index()
    {
        $projects = Auth::user()->projects()
            ->with(['client', 'freelancer'])
            ->latest()
            ->paginate(10);

        return view('projects.tracking', compact('projects'));
    }

    public function show(Project $project)
    {
        // $this->authorize('view', $project);

        return view('projects.tracking-show', compact('project'));
    }

    public function updateProgress(Request $request, Project $project)
    {
        // $this->authorize('update', $project);

        $request->validate([
            'progress' => 'required|integer|min:0|max:100'
        ]);

        $project->update([
            'progress' => $request->progress,
            'status' => $request->progress == 100 ? 'completed' : $project->status
        ]);

        return back()->with('success', 'Progress updated successfully');
    }

    public function updateStatus(Request $request, Project $project)
    {
        // $this->authorize('update', $project);

        $request->validate([
            'status' => 'required|in:pending,active,completed'
        ]);

        $project->update([
            'status' => $request->status,
            'completed_at' => $request->status == 'completed' ? now() : null
        ]);

        return back()->with('success', 'Status updated successfully');
    }
}