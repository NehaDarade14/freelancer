<!DOCTYPE HTML>
<html lang="en">
<head>
<title>{{ $allsettings->site_title }} - @if(Auth::user()->id != 1) {{ __('Available Jobs') }} @else {{ __('404 Not Found') }} @endif</title>
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
                <li class="breadcrumb-item text-nowrap active" aria-current="page">{{ __('Available Jobs') }}</li>
            </ol>
            </nav>
        </div>
        <div class="order-lg-1 pr-lg-4 text-center text-lg-left">
            <h1 class="h3 mb-0 text-white">{{ __('Available Jobs') }}</h1>
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
                                                    <a href="{{ route('employer.jobs.applications', $job) }}">
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
                                                        class="btn btn-outline-info" target="_blank">
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
                </section>
        </div>
    </div>

    @include('footer')
    @include('script')
    </body>
</html>