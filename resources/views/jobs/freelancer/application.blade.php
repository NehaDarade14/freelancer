@extends('layouts.main')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3>Application for: {{ $application->job->title }}</h3>
                    <div class="text-muted">
                        <span class="mr-3">Status: 
                            <span class="badge 
                                @if($application->status == 'submitted') badge-primary
                                @elseif($application->status == 'under_review') badge-info
                                @elseif($application->status == 'accepted') badge-success
                                @elseif($application->status == 'rejected') badge-danger
                                @endif">
                                {{ ucfirst(str_replace('_', ' ', $application->status)) }}
                            </span>
                        </span>
                        <span>Applied on: {{ $application->created_at->format('M d, Y') }}</span>
                    </div>
                </div>

                <div class="card-body">
                    <div class="mb-4">
                        <h5>Your Proposal</h5>
                        <div class="proposal-content p-3 bg-light rounded">
                            {!! nl2br(e($application->proposal)) !!}
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h5>Bid Details</h5>
                            <ul class="list-unstyled">
                                <li><strong>Bid Amount:</strong> ${{ number_format($application->bid_amount, 2) }}</li>
                                <li><strong>Job Budget:</strong> {{ $application->job->salary ? '$'.number_format($application->job->salary) : 'Not specified' }}</li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <h5>Attachments</h5>
                            @if(!empty($application->attachments))
                                <ul class="list-unstyled">
                                    @foreach($application->attachments_urls as $url)
                                        <li>
                                            <a href="{{ $url }}" target="_blank">
                                                <i class="fas fa-file-alt"></i> {{ basename($url) }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <p class="text-muted">No attachments</p>
                            @endif
                        </div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('freelancer.jobs.applications') }}" class="btn btn-outline-secondary">
                            Back to Applications
                        </a>
                        <a href="{{ route('jobs.show', $application->job) }}" class="btn btn-outline-primary">
                            View Job Posting
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection 