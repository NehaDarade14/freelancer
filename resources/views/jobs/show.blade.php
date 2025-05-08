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
                                <div class="d-grid gap-2">
                                        <a href="{{ route('admin.jobs.index') }}" class="btn btn-secondary">Cancel</a>
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