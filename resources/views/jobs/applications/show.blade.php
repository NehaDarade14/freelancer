@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h2 class="mb-0">Application for: {{ $application->job->title }}</h2>
                    <div class="badge badge-{{ $application->status === 'pending' ? 'warning' : ($application->status === 'accepted' ? 'success' : 'danger') }}">
                        {{ ucfirst($application->status) }}
                    </div>
                </div>

                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h5>Freelancer Details</h5>
                            <div class="d-flex align-items-center mb-3">
                                <div class="mr-3">
                                    <img src="{{ $application->user->profile_photo_url }}" alt="Profile Photo" 
                                         class="rounded-circle" width="60" height="60">
                                </div>
                                <div>
                                    <h6 class="mb-0">{{ $application->user->name }}</h6>
                                    <small class="text-muted">{{ $application->user->email }}</small>
                                </div>
                            </div>
                            <p><strong>Bid Amount:</strong> {{ config('app.currency_symbol') }}{{ number_format($application->bid_amount, 2) }}</p>
                            <p><strong>Applied On:</strong> {{ $application->created_at->format('M d, Y h:i A') }}</p>
                        </div>

                        <div class="col-md-6">
                            <h5>Job Details</h5>
                            <p><strong>Budget:</strong> {{ config('app.currency_symbol') }}{{ number_format($application->job->budget, 2) }}</p>
                            <p><strong>Posted On:</strong> {{ $application->job->created_at->format('M d, Y h:i A') }}</p>
                            <p><strong>Deadline:</strong> {{ $application->job->deadline->format('M d, Y') }}</p>
                            <p><strong>Status:</strong> {{ ucfirst($application->job->status) }}</p>
                        </div>
                    </div>

                    <div class="mb-4">
                        <h5>Proposal</h5>
                        <div class="card">
                            <div class="card-body">
                                {!! nl2br(e($application->proposal)) !!}
                            </div>
                        </div>
                    </div>

                    @if($application->attachments->count() > 0)
                        <div class="mb-4">
                            <h5>Attachments</h5>
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        @foreach($application->attachments as $attachment)
                                            <div class="col-md-4 mb-3">
                                                <div class="card">
                                                    <div class="card-body text-center">
                                                        <i class="fa fa-file-{{ str_replace(['jpg', 'jpeg', 'png'], 'image', strtolower(pathinfo($attachment->name, PATHINFO_EXTENSION))) }} fa-3x mb-2"></i>
                                                        <h6 class="card-title">{{ Str::limit($attachment->name, 15) }}</h6>
                                                        <a href="{{ Storage::url($attachment->path) }}" target="_blank" class="btn btn-sm btn-primary">
                                                            <i class="fa fa-download"></i> Download
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="d-flex justify-content-between">
                        @can('update', $application)
                            <a href="{{ route('job-applications.edit', $application) }}" class="btn btn-primary">
                                <i class="fa fa-edit"></i> Edit Application
                            </a>
                        @endcan

                        @can('delete', $application)
                            <form action="{{ route('job-applications.destroy', $application) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to withdraw this application?')">
                                    <i class="fa fa-trash"></i> Withdraw Application
                                </button>
                            </form>
                        @endcan

                        <a href="{{ route('jobs.show', $application->job) }}" class="btn btn-secondary">
                            <i class="fa fa-arrow-left"></i> Back to Job
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection