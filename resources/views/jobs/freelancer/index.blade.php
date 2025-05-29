@extends('layouts.main')

@section('content')
<section class="page-content pt-100 pb-100">
    <div class="container-jobs">
        <div class="row">
            <!-- Sidebar Filters -->
            <div class="col-lg-3">
                <div class="sidebar-widget">
                    <h4 class="widget-title">Filter Jobs</h4>
                    <form method="GET" action="{{ route('freelancer.jobs') }}">
                        <div class="form-group mb-3">
                            <input type="text" name="search" class="form-control" placeholder="Search jobs..." value="{{ request('search') }}">
                        </div>

                        <div class="form-group mb-3">
                            <select name="job_type" class="form-control">
                                <option value="">All Types</option>
                                @foreach(['full-time', 'part-time', 'contract', 'freelance', 'internship'] as $type)
                                    <option value="{{ $type }}" {{ request('job_type') == $type ? 'selected' : '' }}>
                                        {{ ucfirst($type) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group mb-3">
                            <select name="experience_level" class="form-control">
                                <option value="">All Levels</option>
                                @foreach(['entry', 'mid', 'senior', 'executive'] as $level)
                                    <option value="{{ $level }}" {{ request('experience_level') == $level ? 'selected' : '' }}>
                                        {{ ucfirst($level) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">Apply Filters</button>
                    </form>
                </div>
            </div>

            <!-- Job Listings -->
            <div class="col-lg-9">
                <div class="row">
                    @forelse($jobs as $job)
                        @if(Auth::check())
                            <div class="col-md-6 mb-4">
                        @else
                            <div class="col-md-4 mb-4">
                        @endif
                            <div class="job-card style-1 p-4 rounded-jobs shadow-sm">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <h4 class="mb-0">
                                        <a href="{{ route('jobs.show', $job) }}">{{ $job->title }}</a>
                                    </h4>
                                    <small class="text-muted">{{ $job->created_at->diffForHumans() }}</small>
                                </div>

                                <div class="text-muted mb-3">
                                    <span class="mr-3"><i class="fa fa-briefcase"></i> {{ ucfirst($job->job_type) }}</span>
                                    <span class="mr-3"><i class="fa fa-map-marker"></i> {{ $job->location }}</span>
                                    <span><i class="fa fa-star"></i> {{ ucfirst($job->experience_level) }}</span>
                                </div>

                                <p>{{ Str::limit($job->description, 75) }}</p>

                                <div class="skills mb-2">
                                @foreach(explode(',', $job->skills_required) as $skill)
                                    <span class="badge badge-primary">{{ trim($skill) }}</span>
                                @endforeach
                                </div>

                                <strong>Rate:</strong> {{ $job->salary ? '$'.number_format($job->salary) : 'Negotiable' }}


                                <div class="d-flex justify-content-between align-items-center mt-3">
                                    <a href="{{ route('jobs.show', $job) }}" class="btn btn-outline-primary btn-sm">
                                        <i class="fa fa-eye"></i> View Details
                                    </a>

                                    @if(auth()->user() && auth()->user()->user_type === 'freelancer')
                                        @php
                                            $application = Auth::user()->applications()->where('job_id', $job->id)->first();
                                        @endphp

                                        @if(!$application)
                                            <a href="{{ route('jobs.apply', $job) }}" class="btn btn-primary btn-sm">
                                                <i class="fa fa-paper-plane"></i> Apply Now
                                            </a>
                                        @else
                                            <a href="{{ route('freelancer.jobs.applications.view', $application->id) }}" class="btn btn-info btn-sm">
                                                <i class="fa fa-file"></i> View Application
                                            </a>
                                        @endif
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-md-12">
                            <div class="alert alert-info">No jobs found matching your criteria.</div>
                        </div>
                    @endforelse
                </div>

                <div class="mt-4">
                    {{ $jobs->links() }}
                </div>
            </div>
        </div>
    </div>
</section>
<style>
    .container-jobs{
        margin:50px;

    }
</style>
@endsection
