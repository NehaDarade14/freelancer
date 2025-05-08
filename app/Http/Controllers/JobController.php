<?php

namespace Fickrr\Http\Controllers;

use Fickrr\Models\Job;
use Fickrr\Models\JobApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JobController extends Controller
{
    // Public job listings
    public function index(Request $request)
    {
        $jobs = Job::with('employer')
            ->latest()
            ->filter($request->only(['search', 'job_type', 'location', 'experience_level']))
            ->paginate(10);

        return view('jobs.index', compact('jobs')); 
    }

    public function show(Job $job)
    {
        return view('jobs.freelancer.show', compact('job'));
    }

    // Job application process
    public function apply(Job $job)
    {
        if (Auth::user()->applications()->where('job_id', $job->id)->exists()) {
            return redirect()->route('jobs.show', $job)
                ->with('warning', 'You have already applied to this job');
        }

        return view('jobs.apply', compact('job'));
    }

    public function submitApplication(Request $request, Job $job)
    {
        $validated = $request->validate([
            'proposal' => 'required|string|min:100|max:5000',
            'bid_amount' => 'required|numeric|min:1',
            'attachments.*' => 'nullable|file|mimes:pdf,doc,docx|max:2048'
        ]);

        $application = new JobApplication($validated);
        $application->job_id = $job->id;
        $application->freelancer_id = Auth::id();
        $application->save();

        if ($request->hasFile('attachments')) {
            $attachments = [];
            foreach ($request->file('attachments') as $file) {
                $path = $file->store('job_applications/attachments');
                $attachments[] = $path;
            }
            $application->attachments = $attachments;
            $application->save();
        }

        return redirect()->route('jobs.show', $job)
            ->with('success', 'Application submitted successfully!');
    }

    // Freelancer job management
    public function freelancerJobs(Request $request)
    {
        // $query = Job::where('status', 'active')
        //     ->where('deadline', '>=', now())
        //     ->withCount('applications')
        //     ->orderBy('created_at', 'desc');

        // if ($request->has('search')) {
        //     $query->where(function($q) use ($request) {
        //         $q->where('title', 'like', '%'.$request->search.'%')
        //           ->orWhere('description', 'like', '%'.$request->search.'%')
        //           ->orWhere('skills_required', 'like', '%'.$request->search.'%');
        //     });
        // }

        // $jobs = $query->paginate(10);

        // return view('jobs.freelancer.index', [
        //     'jobs' => $jobs,
        //     'search' => $request->search ?? ''
        // ]);

        $jobs = Job::with('employer')
            ->latest()
            ->filter($request->only(['search', 'job_type', 'location', 'experience_level']))
            ->paginate(10);

        return view('jobs.freelancer.index', compact('jobs'));
    }

    public function myApplications(Request $request)
    {
        $applications = JobApplication::with(['job.employer'])
        ->where('freelancer_id', Auth::id())
        ->latest()
        ->when($request->status && $request->status !== 'all', function($query) use ($request) {
            $query->where('status', $request->status);
        })
        ->paginate(10);

        return view('jobs.freelancer.applications', [
            'applications' => $applications,
            'statusFilter' => $request->status ?? 'all'
        ]);
    }

    public function viewApplication(JobApplication $application)
    {
        // $this->authorize('view', $application);
        
        return view('jobs.freelancer.application', compact('application'));
    }

    // Employer job management
    public function employerJobs()
    {
        $jobs = Auth::user()->jobs()
            ->latest()
            ->paginate(10);

        return view('jobs.employer.index', compact('jobs'));
    }

    public function jobApplications(Job $job)
    {
        $this->authorize('view', $job);
        
        $applications = $job->applications()
            ->with('freelancer')
            ->latest()
            ->paginate(10);

        return view('jobs.employer.applications', compact('job', 'applications'));
    }
}