@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h2 class="mb-0">My Job Applications</h2>
                    <div>
                        <a href="{{ route('jobs.index') }}" class="btn btn-sm btn-primary">
                            <i class="fa fa-search"></i> Browse Jobs
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    @if($applications->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Job Title</th>
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
                                            <td>
                                                {{ config('app.currency_symbol') }}{{ number_format($application->bid_amount, 2) }}
                                            </td>
                                            <td>
                                                <span class="badge badge-{{ $application->status === 'accepted' ? 'success' : ($application->status === 'rejected' ? 'danger' : 'warning') }}">
                                                    {{ ucfirst($application->status) }}
                                                </span>
                                            </td>
                                            <td>
                                                {{ $application->created_at->format('M d, Y') }}
                                            </td>
                                            <td>
                                                <a href="{{ route('job-applications.show', $application) }}" class="btn btn-sm btn-info" title="View Details">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                                @if($application->status === 'pending')
                                                    <a href="{{ route('job-applications.edit', $application) }}" class="btn btn-sm btn-primary" title="Edit">
                                                        <i class="fa fa-edit"></i>
                                                    </a>
                                                    <form action="{{ route('job-applications.destroy', $application) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger" title="Withdraw" onclick="return confirm('Are you sure you want to withdraw this application?')">
                                                            <i class="fa fa-trash"></i>
                                                        </button>
                                                    </form>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="d-flex justify-content-center mt-4">
                            {{ $applications->links() }}
                        </div>
                    @else
                        <div class="alert alert-info">
                            <i class="fa fa-info-circle"></i> You haven't applied to any jobs yet.
                            <a href="{{ route('jobs.index') }}" class="alert-link">Browse available jobs</a> to get started.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection