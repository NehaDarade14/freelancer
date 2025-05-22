<?php

namespace Fickrr\Http\Controllers;

use Fickrr\Models\Project;
use Illuminate\Http\Request;

class ProjectTrackingController extends Controller
{
    public function index()
    {
        $projects = Project::where('client_id', auth()->id())
            ->orWhere('freelancer_id', auth()->id())
            ->with(['client', 'freelancer'])
            ->get();

        return view('projects.tracking', compact('projects'));
    }

    public function show(Project $project)
    {
        
        return view('projects.tracking-show', compact('project'));
    }
}