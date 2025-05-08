@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3>Applications for: {{ $job->title }}</h3>
                        <a href="{{ route('employer.jobs') }}" class="btn btn-outline-secondary">
                            Back to Jobs
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    @if($applications->isEmpty())
                        <div class="alert alert-info">No applications received yet for this job.</div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Freelancer</th>
                                        <th>Bid Amount</th>
                                        <th>Proposal</th>
                                        <th>Status</th>
                                        <th>Applied On</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($applications as $application)
                                    <tr>
                                        <td>
                                            <a href="{{ route('profile.show', $application->freelancer) }}">
                                                {{ $application->freelancer->name }}
                                            </a>
                                        </td>
                                        <td>${{ number_format($application->bid_amount, 2) }}</td>
                                        <td>{{ Str::limit($application->proposal, 100) }}</td>
                                        <td>
                                            <span class="badge 
                                                @if($application->status == 'submitted') badge-primary
                                                @elseif($application->status == 'under_review') badge-info
                                                @elseif($application->status == 'accepted') badge-success
                                                @elseif($application->status == 'rejected') badge-danger
                                                @endif">
                                                {{ ucfirst(str_replace('_', ' ', $application->status)) }}
                                            </span>
                                        </td>
                                        <td>{{ $application->created_at->format('M d, Y') }}</td>
                                        <td>
                                            <div class="btn-group btn-group-sm">
                                                <a href="{{ route('employer.jobs.applications.view', $application) }}" 
                                                   class="btn btn-outline-primary">
                                                    View
                                                </a>
                                                <a href="{{ route('messages.create', ['recipient' => $application->freelancer_id, 'job' => $job->id]) }}"
                                                   class="btn btn-outline-info">
                                                    Message
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        {{ $applications->links() }}
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection