<?php

namespace Fickrr\Http\Controllers;

use Illuminate\Http\Request;
use Fickrr\User;
use Fickrr\Models\UserType;

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


        // Rating filter
        if ($request->filled('rating')) {
            $query->where('rating', '>=', $request->rating);
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


        // Rating filter
        if ($request->filled('rating')) {
            $query->where('rating', '>=', $request->rating);
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

        return view('freelancers.show', compact('freelancer'));
    }
}
