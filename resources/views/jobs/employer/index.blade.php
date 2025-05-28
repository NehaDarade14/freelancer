@extends('layouts.main')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3>My Job Postings</h3>
                        <a href="{{ route('employer.jobs.create') }}" class="btn btn-primary">
                            <i class="fa fa-plus"></i> Post New Job
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    @if($jobs->isEmpty())
                        <div class="alert alert-info">
                            You haven't posted any jobs yet. 
                            <a href="{{ route('employer.jobs.create') }}">Create your first job posting</a>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Title</th>
                                        <th>Type</th>
                                        <th>Applications</th>
                                        <th>Status</th>
                                        <th>Posted</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($jobs as $job)
                                    <tr>
                                        <td>{{ $job->title }}</td>
                                        <td>{{ ucfirst($job->job_type) }}</td>
                                        <td>
                                            <a href="{{ route('employer.jobs.applications', $job) }}" class="badge badge-secondary">
                                                {{ $job->applications_count }} applications
                                            </a>
                                        </td>
                                        <td>
                                            <span class="badge 
                                                @if($job->status == 'draft') badge-secondary
                                                @elseif($job->status == 'active') badge-success
                                                @elseif($job->status == 'closed') badge-warning
                                                @elseif($job->status == 'archived') badge-dark
                                                @endif">
                                                {{ ucfirst($job->status) }}
                                            </span>
                                        </td>
                                        <td>{{ $job->created_at->format('M d, Y') }}</td>
                                        <td>
                                            <div class="btn-group btn-group-sm">
                                                <a href="{{ route('employer.jobs.edit', $job) }}" 
                                                class="btn btn-outline-primary">
                                                    Edit
                                                </a>
                                                <a href="{{ route('jobs.show', $job) }}" 
                                                class="btn btn-outline-info">
                                                    View
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        {{ $jobs->links() }}
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection 