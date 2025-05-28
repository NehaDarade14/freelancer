
@extends('layouts.main')

@section('content')

<!-- <div class="container"> -->
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3>{{ $job->title }}</h3>
                    <div class="text-muted">
                        <span class="mr-3"><i class="fa fa-building"></i> {{ $job->employer->name }}</span>
                        <span class="mr-3"><i class="fa fa-briefcase"></i> {{ ucfirst($job->job_type) }}</span>
                        <span class="mr-3"><i class="fa fa-map-marker"></i> {{ $job->location }}</span>
                    </div>
                </div>

                <div class="card-body">
                    <div class="mb-4">
                        <h5>Job Description</h5>
                        <p>{{ $job->description }}</p>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h5>Details</h5>
                            <ul class="list-unstyled">
                                <li><strong>Experience Level:</strong> {{ ucfirst($job->experience_level) }}</li>
                                <li><strong>Salary:</strong> {{ $job->salary ? '$'.number_format($job->salary) : 'Negotiable' }}</li>
                                <li><strong>Deadline:</strong> {{ $job->deadline->format('M d, Y') }}</li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <h5>Required Skills</h5>
                            <div class="skills">
                                @foreach(explode(',', $job->skills_required) as $skill)
                                    <span class="badge badge-primary">{{ trim($skill) }}</span>
                                @endforeach
                            </div>
                        </div>
                        
                    </div>
                    <div class="gap-2">
                        
                        <a href="{{ route('freelancer.jobs') }}" class="btn btn-secondary  btn-sm">Cancel</a>
                        @if(auth()->user()->user_type === 'freelancer')
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
        </div>
    </div>
@endsection
