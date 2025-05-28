
@extends('layouts.main')

@section('content')
 <div class="row">
    <div class="col-md-12">
    <div class="card">
            <div class="card-header">Available Jobs</div>

            <div class="card-body">
                <form method="GET" action="{{ route('freelancer.jobs') }}" class="mb-4">
                    <div class="row">
                        <div class="col-md-4">
                            <input type="text" name="search" class="form-control" placeholder="Search jobs..." value="{{ request('search') }}">
                        </div>
                        <div class="col-md-3">
                            <select name="job_type" class="form-control">
                                <option value="">All Types</option>
                                @foreach(['full-time', 'part-time', 'contract', 'freelance', 'internship'] as $type)
                                    <option value="{{ $type }}" {{ request('job_type') == $type ? 'selected' : '' }}>{{ ucfirst($type) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select name="experience_level" class="form-control">
                                <option value="">All Levels</option>
                                @foreach(['entry', 'mid', 'senior', 'executive'] as $level)
                                    <option value="{{ $level }}" {{ request('experience_level') == $level ? 'selected' : '' }}>{{ ucfirst($level) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary w-100">Filter</button>
                        </div>
                    </div>
                </form>

                @forelse($jobs as $job)
                    <div class="job-card mb-3 p-3 border rounded">
                        <h4><a href="{{ route('jobs.show', $job) }}">{{ $job->title }}</a></h4>
                        <div class="text-muted mb-2">
                            <span class="mr-3"><i class="fa fa-briefcase"></i> {{ ucfirst($job->job_type) }}</span>
                            <span class="mr-3"><i class="fa fa-map-marker"></i> {{ $job->location }}</span>
                            <span><i class="fa fa-star"></i> {{ ucfirst($job->experience_level) }}</span>
                        </div>
                        <p>{{ Str::limit($job->description, 200) }}</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <small class="text-muted">Posted {{ $job->created_at->diffForHumans() }}</small>
                        </div>
                    
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <a href="{{ route('jobs.show', $job) }}" class="btn btn-outline-primary btn-sm">
                                <i class="fa fa-eye"></i> View Details
                            </a>

                            @if( auth()->user() && auth()->user()->user_type === 'freelancer')
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
                @empty
                    <div class="alert alert-info">No jobs found matching your criteria.</div>
                @endforelse

                {{ $jobs->links() }}
            </div>
        </div>
    </div>
</div>


@endsection
