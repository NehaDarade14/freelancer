<!DOCTYPE HTML>
<html lang="en">
<head>
<title>{{ $allsettings->site_title }} - @if(Auth::user()->id != 1) Application for - {{ $job->title }} @else {{ __('404 Not Found') }} @endif</title>
@include('meta')
@include('style')
</head>
<body>
@include('header')

<div class="page-title-overlap pt-4" style="background-image: url('{{ url('/') }}/public/storage/settings/{{ $allsettings->site_banner }}');">
    <div class="container d-lg-flex justify-content-between py-2 py-lg-3">
        <div class="order-lg-2 mb-3 mb-lg-0 pt-lg-2">
            <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-light flex-lg-nowrap justify-content-center justify-content-lg-star">
                <li class="breadcrumb-item"><a class="text-nowrap" href="{{ URL::to('/') }}"><i class="dwg-home"></i>{{ __('Home') }}</a></li>
                <li class="breadcrumb-item text-nowrap active" aria-current="page">Applicatoin for - {{ $job->title }}</li>
            </ol>
            </nav>
        </div>
        <div class="order-lg-1 pr-lg-4 text-center text-lg-left">
            <h1 class="h3 mb-0 text-white">Applicatoin for - {{ $job->title }}</h1>
        </div>
    </div>
</div>
<div class="container pb-5 mb-2 mb-md-3">
    <div class="row">
        <!-- Sidebar-->
        <aside class="col-lg-4 pt-5 mt-3">
            <div class="d-block d-lg-none p-4">
            <a class="btn btn-outline-accent d-block" href="#account-menu" data-toggle="collapse"><i class="dwg-menu mr-2"></i>{{ __('Account menu') }}</a></div>
            @include('dashboard-menu')
        </aside>    
        <!-- Content  -->
        <section class="col-lg-8">

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
                                <div class="d-grid gap-2">
                                    
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
            </section>
    </div>
</div>

@include('footer')
@include('script')
</body>
</html>