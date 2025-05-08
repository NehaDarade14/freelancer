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
    <!--  -->
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
                            <div class="card-header">Job Listings</div>

                            <div class="card-body">
                                <form method="GET" action="{{ route('admin.jobs.index') }}" class="mb-4">
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
                                        <h4><a href="{{ route('admin.jobs.show', $job) }}">{{ $job->title }}</a></h4>
                                        <div class="text-muted mb-2">
                                            <span class="mr-3"><i class="fa fa-briefcase"></i> {{ ucfirst($job->job_type) }}</span>
                                            <span class="mr-3"><i class="fa fa-map-marker"></i> {{ $job->location }}</span>
                                            <span><i class="fa fa-star"></i> {{ ucfirst($job->experience_level) }}</span>
                                        </div>
                                        <p>{{ Str::limit($job->description, 200) }}</p>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <small class="text-muted">Posted {{ $job->created_at->diffForHumans() }}</small>
                                            <a href="{{ route('admin.jobs.show', $job) }}" class="btn btn-sm btn-outline-primary">View Details</a>
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
            </div>
        </div>
    </div>
    <!--  -->
    @include('admin.javascript')

</body>

</html>