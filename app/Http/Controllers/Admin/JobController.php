<?php

namespace Fickrr\Http\Controllers\Admin;

use Fickrr\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Fickrr\Http\Controllers\Controller;

class JobController extends Controller
{
    public function index(Request $request)
    {
        $jobs = Job::with('employer')
            ->latest()
            ->filter($request->only(['search', 'job_type', 'location', 'experience_level']))
            ->paginate(10);

        return view('jobs.index', compact('jobs'));
    }


    public function create()
    {
        
        return view('jobs.create');
    }

    public function store(Request $request)
    {
        
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'job_type' => 'required|in:full-time,part-time,contract,freelance,internship',
            'salary' => 'nullable|numeric',
            'location' => 'required|string|max:255',
            'deadline' => 'required|date|after:today',
            'experience_level' => 'required|in:entry,mid,senior,executive',
            'skills_required' => 'required|array',
            'skills_required.*' => 'string|max:255'
        ]);

        $validated['employer_id'] = Auth::id();
        $validated['skills_required'] = json_encode($validated['skills_required']);

        Job::create($validated);

        return redirect()->route('admin.jobs.index')->with('success', 'Job posted successfully!');
    }

    public function show(Job $job)
    {
        return view('jobs.show', compact('job'));
    }

    public function edit(Job $job)
    {
        
        return view('jobs.edit', compact('job'));
    }

    public function update(Request $request, Job $job)
    {
        
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'job_type' => 'required|in:full-time,part-time,contract,freelance,internship',
            'salary' => 'nullable|numeric',
            'location' => 'required|string|max:255',
            'deadline' => 'required|date|after:today',
            'experience_level' => 'required|in:entry,mid,senior,executive',
            'skills_required' => 'required',
            'skills_required.*' => 'string|max:255',
            'status' => 'sometimes|in:draft,active,closed,archived'
        ]);

        $validated['skills_required'] = json_encode($validated['skills_required']);

        $job->update($validated);

        return redirect()->route('admin.jobs.show', $job)->with('success', 'Job updated successfully!');
    }

    public function destroy(Job $job)
    {
        
        $job->delete();
        return redirect()->route('admin.jobs.index')->with('success', 'Job deleted successfully!');
    }
}