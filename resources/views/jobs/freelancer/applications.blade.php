@extends('layouts.main')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3>My Job Applications</h3>
                </div>

                <div class="card-body">
                    @if($applications->isEmpty())
                        <div class="alert alert-info">You haven't applied to any jobs yet.</div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Job Title</th>
                                        <th>Employer</th>
                                        <th>Bid Amount</th>
                                        <th>Status</th>
                                        <th>Applied On</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($applications as $application)
                                    <tr>
                                        <td>
                                            <a href="{{ route('jobs.show', $application->job) }}">
                                                {{ $application->job->title }}
                                            </a>
                                        </td>
                                        <td>{{ $application->job->employer->name }}</td>
                                        <td>${{ number_format($application->bid_amount, 2) }}</td>
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
                                            <a href="{{ route('freelancer.jobs.applications.view', $application) }}" 
                                            class="btn btn-sm btn-outline-primary">
                                                View
                                            </a>
                                            <a href="{{ route('messages.index', ['user_id' =>$application->job->employer->id]) }}"
                                                        class="btn btn-sm btn-outline-info">
                                                            Message
                                                        </a>
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

@endsection 