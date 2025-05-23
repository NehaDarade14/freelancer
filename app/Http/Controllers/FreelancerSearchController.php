<?php

namespace Fickrr\Http\Controllers;

use Illuminate\Http\Request;
use Fickrr\User;
use Fickrr\Models\UserType;
use Fickrr\Models\Project;
use Auth;
use Illuminate\Support\Facades\DB;
class FreelancerSearchController extends Controller
{
    public function search(Request $request)
    {
        $query = User::query()
            ->whereHas('types', function($q) {
                $q->where('type', 'freelancer');
            });

        // Skills filter
        // Skills filter (match ANY of the skills)
        if ($request->filled('skills')) {
            $skills = array_map('trim', explode(',', $request->skills));
            $query->where(function ($q) use ($skills) {
                foreach ($skills as $skill) {
                    $q->orWhere('skills', 'LIKE', '%' . $skill . '%');
                }
            });
        }


       if ($request->filled('rating')) {
            $query->whereHas('ratings', function ($q) {
                $q->select(DB::raw('freelancer_id, AVG(rating) as avg_rating'))
                ->groupBy('freelancer_id');
            });

            $query->withAvg('ratings', 'rating')
                ->having('ratings_avg_rating', '>=', $request->rating);
        }

        // Availability filter
        if ($request->filled('available')) {
            $query->where('available', $request->available);
        }

        $freelancers = $query->paginate(10);
        return view('freelancers.search', compact('freelancers'));
    }

    public function searchat(Request $request)
    {
        $query = User::query()
            ->whereHas('types', function($q) {
                $q->where('type', 'freelancer');
            });

    
       // Skills filter (match ANY of the skills)
        if ($request->filled('skills')) {
            $skills = array_map('trim', explode(',', $request->skills));
            $query->where(function ($q) use ($skills) {
                foreach ($skills as $skill) {
                    $q->orWhere('skills', 'LIKE', '%' . $skill . '%');
                }
            });
        }


       if ($request->filled('rating')) {
            $query->whereHas('ratings', function ($q) {
                $q->select(DB::raw('freelancer_id, AVG(rating) as avg_rating'))
                ->groupBy('freelancer_id');
            });

            $query->withAvg('ratings', 'rating')
                ->having('ratings_avg_rating', '>=', $request->rating);
        }

        // Availability filter
        if ($request->filled('available')) {
            $query->where('available', $request->available);
        }

        $freelancers = $query->paginate(10);
        return view('freelancers.search', compact('freelancers'));
    }

    public function show($id)
    {
         $freelancer = User::whereHas('types', function($q) {
                $q->where('type', 'freelancer');
            })
            ->findOrFail($id);

    
            $hasActiveProject = false;
        if ($freelancer) {
            $hasActiveProject = Project::where(function($query) use ($id) {
                $query->where('client_id', Auth::id())
                      ->where('freelancer_id', $id)
                      ->whereIn('status', ['active', 'in_progress']);
            })->orWhere(function($query) use ($id) {
                $query->where('client_id', $id)
                      ->where('freelancer_id', Auth::id())
                      ->whereIn('status', ['active', 'in_progress']);
            })->exists();
        }

        return view('freelancers.show', compact('freelancer','hasActiveProject'));
    }
}
