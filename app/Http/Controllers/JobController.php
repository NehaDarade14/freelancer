<?php

namespace Fickrr\Http\Controllers;

use Fickrr\Models\Job;
use Fickrr\Models\JobApplication;
use Fickrr\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JobController extends Controller
{
    // Public job listings
    public function index(Request $request)
    {
        $jobs = Job::with('employer')
            ->where('status',"active")
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

        
            $jobs = Job::latest()
            ->where("status","active")
            ->filter($request->only(['search', 'job_type', 'location', 'experience_level']))
            ->paginate(9);

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
        $jobs = \Fickrr\Models\Job::with(['applications'])
        ->withCount('applications')
        ->where('employer_id', auth()->id())
        ->latest()
        ->paginate(10);
          

        return view('jobs.employer.index', compact('jobs'));
    }

    public function jobApplications(Job $job)
    {
        // $this->authorize('view', $job);
        
        $applications = $job->applications()
            ->with('freelancer')
            ->latest()
            ->paginate(10);

        return view('jobs.employer.applications', compact('job', 'applications'));
    }

    public function viewEmployerApplication(Job $job, JobApplication $application)
    {
        // $this->authorize('view', $job);
        // $this->authorize('view', $application);
        
        $application->load('freelancer', 'job');
        return view('jobs.applications.show', compact('job', 'application'));
    }

    public function create()
    {
        return view('jobs.employer.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|min:100',
            'job_type' => 'required|in:full-time,part-time,contract,freelance',
            'salary' => 'required|numeric|min:1',
            'location' => 'required|string|max:255',
            'deadline' => 'required|date|after:today',
            'experience_level' => 'required|in:entry,mid,senior',
            'skills_required' => 'required|string|min:1',
            'skills_required.*' => 'string|max:255'
        ]);

        $job = new Job($validated);
        $job->employer_id = Auth::id();
        $job->status = 'active';
        $job->save();

        return redirect()->route('employer.jobs')
            ->with('success', 'Job created successfully!');
    }

    public function edit(Job $job)
    {
        // $this->authorize('update', $job);
        return view('jobs.employer.edit', compact('job'));
    }

    public function update(Request $request, Job $job)
    {
        // $this->authorize('update', $job);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|min:100',
            'job_type' => 'required|in:full-time,part-time,contract,freelance',
            'salary' => 'required|numeric|min:1',
            'location' => 'required|string|max:255',
            'deadline' => 'required|date|after:today',
            'experience_level' => 'required|in:entry,mid,senior',
            'skills_required' => 'required|string|min:1',
            'skills_required.*' => 'string|max:255',
            'status' => 'sometimes|in:active,closed'
        ]);

        $job->update($validated);

        return redirect()->route('employer.jobs')
            ->with('success', 'Job updated successfully!');
    }

    public function destroy(Job $job)
    {
        // $this->authorize('delete', $job);
        $job->delete();

        return redirect()->route('employer.jobs')
            ->with('success', 'Job deleted successfully!');
    }

    public function destroyApplication(Job $job, JobApplication $application)
    {
        // Only allow employer who owns the job or freelancer who submitted the application
        if (Auth::id() !== $job->employer_id && Auth::id() !== $application->freelancer_id) {
            abort(403);
        }

        $application->delete();

        return redirect()->back()
            ->with('success', 'Application withdrawn successfully!');
    }

    public function updateApplicationStatus(Request $request, Job $job, JobApplication $application)
    {
        // Only allow employer who owns the job
        if (Auth::id() !== $job->employer_id) {
            abort(403);
        }

        $validated = $request->validate([
            'status' => 'required|in:pending,accepted,rejected'
        ]);

        $application->update($validated);

        return redirect()->back()
            ->with('success', 'Application status updated successfully!');
    }

    public function view_project_tracking()
    {
        if (auth()->user()->user_type === 'client') {
            // Client view - show all their jobs with application statuses and counts
            $jobs = \Fickrr\Models\Job::with(['applications' => function($query) {
                    $query->where('freelancer_id', "!=", 0);
                }])
                ->where('employer_id', auth()->id())
                ->get()
                ->map(function($job) {
                    $steps = [
                        'pending' => $job->applications->where('status', 'pending')->count(),
                        'in_progress' => $job->applications->where('status', 'in_progress')->count(),
                        'review' => $job->applications->where('status', 'review')->count(),
                        'completed' => $job->applications->where('status', 'completed')->count()
                    ];
                    
                    $totalSteps = array_sum($steps);
                    $completedValue = $steps['completed'] * 100;
                    $inProgressValue = $steps['in_progress'] * 50;
                    $reviewValue = $steps['review'] * 75;
                    
                    $progress = $totalSteps > 0
                        ? round(($completedValue + $inProgressValue + $reviewValue) / ($totalSteps * 100) * 100)
                        : 0;

                    return (object) [
                        'id' => $job->id,
                        'name' => $job->title,
                        'client' => (object) ['name' => auth()->user()->name],
                        'progress' => $progress,
                        'deadline' => $job->deadline,
                        'job_status' => $job->status,
                        'job_status_color' => $this->getStatusColor($job->status),
                        'application_count' => $job->applications->count() ,
                        'application_status' => $job->applications->first() ? $job->applications->first()->status : "pending",
                        'application_status_color' => $this->getApplicationStatusColor($job->applications->first() ? $job->applications->first()->status : "pending"),
                        'steps' => $steps,
                        'can_update' => true,
                        'freelancer_id' =>$job->applications->first() ? $job->applications->first()->freelancer_id : 0
                    ];
                });
        } else {
            // Freelancer view - show their applications
            $jobs = \Fickrr\Models\Job::with(['employer', 'applications' => function($query) {
                $query->where('freelancer_id', auth()->id());
            }])
            ->get()
            ->map(function($job) {
                $steps = [
                    'pending' => $job->applications->where('status', 'pending')->count(),
                    'in_progress' => $job->applications->where('status', 'in_progress')->count(),
                    'review' => $job->applications->where('status', 'review')->count(),
                    'completed' => $job->applications->where('status', 'completed')->count()
                ];
                
                $totalSteps = array_sum($steps);
                $completedValue = $steps['completed'] * 100;
                $inProgressValue = $steps['in_progress'] * 50;
                $reviewValue = $steps['review'] * 75;
                
                $progress = $totalSteps > 0
                    ? round(($completedValue + $inProgressValue + $reviewValue) / ($totalSteps * 100) * 100)
                    : 0;

                return (object) [
                    'id' => $job->id,
                    'name' => $job->title,
                    'client' => (object) ['name' => $job->employer->name],
                    'progress' => $progress,
                    'deadline' => $job->deadline,
                    'job_status' => $job->status,
                    'job_status_color' => $this->getStatusColor($job->status),
                    'application_count' => $job->applications->count() ,
                    'application_status' => $job->applications->first() ? $job->applications->first()->status : "pending",
                    'application_status_color' => $this->getApplicationStatusColor($job->applications->first() ? $job->applications->first()->status : "pending"),
                    'steps' => $steps,
                    'can_update' => false,
                    'freelancer_id' => $job->applications->first() ?  $job->applications->first()->freelancer_id : 0
                ];
            });
        }
        return view('pages.project-tracking', [
            'projects' => $jobs
        ]);
    }

    public function update_project_status(Request $request, $jobId, $freelancerId)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,in_progress,review,completed,rejected'
        ]);

        $application = JobApplication::where('job_id', $jobId)
            ->where('freelancer_id', $freelancerId)
            ->first();

        if (!$application) {
            return response()->json(['success' => false, 'message' => 'Application not found'], 404);
        }

        if (auth()->user()->user_type !== 'client') {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        $application->update(['status' => $validated['status']]);

        return response()->json(['success' => true]);
    }


    private function getStatusColor($status)
    {
        switch(strtolower($status)) {
            case 'active': return 'success';
            case 'completed': return 'primary';
            case 'pending': return 'warning';
            default: return 'secondary';
        }
    }

    private function getApplicationStatusColor($status)
    {
        switch(strtolower($status)) {
            case 'completed': return 'success';
            case 'in_progress': return 'primary';
            case 'review': return 'info';
            case 'pending': return 'warning';
            case 'rejected': return 'danger';
            default: return 'secondary';
        }
    }

    public function updateStatus(Request $request, $id)
    {
        $job = Job::findOrFail($id);
        
        // Update job status if client makes changes
        if($request->has('job_status')) {
            $job->status = $request->job_status;
        }
        
        // Update application status
        // if($job->applications->count() > 0) {
        //     $application = $job->applications->first();
        //     $application->status = $request->status;
        //     $application->save();
        // }

        $job->save();

        return response()->json(['success' => true]);
    }
}