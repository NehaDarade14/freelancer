<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js" lang="en">
<!--<![endif]-->

<head>
    @include('admin.stylesheet')
</head>

<body>
    @include('admin.navigation')

    <!-- Right Panel -->
    @if(Auth::user()->id == 1)
    <div id="right-panel" class="right-panel">
        @include('admin.header')
        @include('admin.warning')
        <div class="content mt-3">
            <div class="animated fadeIn">
                <div class="row">
                    <div class="col-md-3 ml-auto" align="right">
                    
                    </div>
                    <div class="col-md-12">
                     
                        <div class="card">
                            <div class="card-header">
                                <h4>{{ $job->title }}</h4>
                                <span class="badge bg-{{ $job->status === 'active' ? 'success' : ($job->status === 'closed' ? 'danger' : 'secondary') }}">
                                    {{ ucfirst($job->status) }}
                                </span>
                            </div>

                            <div class="card-body">
                                <div class="mb-4">
                                    <h5>Job Details</h5>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <p><strong>Job Type:</strong> {{ ucfirst($job->job_type) }}</p>
                                            <p><strong>Experience Level:</strong> {{ ucfirst($job->experience_level) }} Level</p>
                                        </div>
                                        <div class="col-md-6">
                                            <p><strong>Location:</strong> {{ $job->location }}</p>
                                            <p><strong>Salary:</strong> {{ $job->salary ? '$' . number_format($job->salary, 2) : 'Negotiable' }}</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <h5>Description</h5>
                                    <p>{{ $job->description }}</p>
                                </div>

                                <div class="mb-4">
                                    <h5>Required Skills</h5>
                                    <div class="d-flex flex-wrap gap-2">
                                        {{ json_decode($job->skills_required) }}
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <h5>Application Deadline</h5>
                                    <p>{{ $job->deadline->format('F j, Y g:i A') }}</p>
                                </div>

                                <div class="d-flex justify-content-between">
                                    <div>
                                        <a href="{{ route('admin.jobs.index') }}" class="btn btn-secondary">Back to Jobs</a>
                                    </div>
                                    <div>
                                        <a href="{{ route('admin.jobs.edit', $job->id) }}" class="btn btn-primary">Edit</a>
                                    
                                        <form action="{{ route('admin.jobs.destroy', $job->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this job?')">Delete</button>
                                        </form>
                                    
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @else
    @include('admin.denied')
    @endif 
    @include('admin.javascript')

</body>

</html>