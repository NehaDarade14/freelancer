<?php

namespace Fickrr\Http\Controllers;

use Fickrr\Models\Project;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ProjectTrackingController extends Controller
{
    public function dashboard()
    {
        $projects = auth()->user()->projects()
            ->with(['client', 'freelancer', 'team'])
            ->latest()
            ->get();

        $stats = [
            'total' => $projects->count(),
            'active' => $projects->where('status', 'active')->count(),
            'completed' => $projects->where('status', 'completed')->count(),
            'pending' => $projects->where('status', 'pending')->count(),
            'overdue' => $projects->filter(fn($p) => $p->isOverdue())->count(),
            'avg_progress' => round($projects->avg('progress'), 1)
        ];

        $upcomingDeadlines = $projects
            ->filter(fn($p) => $p->status === 'active')
            ->sortBy('deadline')
            ->take(5);

        return view('projects.dashboard', compact('projects', 'stats', 'upcomingDeadlines'));
    }

    public function kanban()
    {
       
        $projects = auth()->user()->projects()
            ->with(['team', 'milestones'])
            ->get()
            ->groupBy('status');

        return view('projects.kanban', compact('projects'));
    }

    public function gantt()
    {
        $projects = auth()->user()->projects()
            ->with(['milestones'])
            ->get()
            ->map(function($project) {
                return [
                    'id' => $project->id,
                    'name' => $project->title,
                    'start' => $project->created_at->format('Y-m-d'),
                    'end' => $project->deadline->format('Y-m-d'),
                    'progress' => $project->progress / 100,
                    'dependencies' => $project->milestones->pluck('id')->implode(','),
                    'custom_class' => 'bg-' . ($project->isOverdue() ? 'danger' : 'success')
                ];
            });
        return view('projects.gantt', compact('projects'));
    }

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

    public function updateKanbanStatus(Request $request, Project $project)
    {
        // $this->authorize('update', $project);

        $request->validate([
            'status' => 'required|in:pending,active,completed,review'
        ]);

        $project->update([
            'status' => $request->status,
            'completed_at' => $request->status == 'completed' ? now() : null
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Status updated successfully'
        ]);
    }
}