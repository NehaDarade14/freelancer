<!DOCTYPE HTML>
<html lang="en">
<head>
<title>{{ $allsettings->site_title }} - @if(Auth::user()->id != 1) {{ __('Application') }} @else {{ __('404 Not Found') }} @endif</title>
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
                <li class="breadcrumb-item text-nowrap active" aria-current="page">{{ __('Application') }}</li>
            </ol>
            </nav>
        </div>
        <div class="order-lg-1 pr-lg-4 text-center text-lg-left">
            <h1 class="h3 mb-0 text-white">{{ __('Application') }}</h1>
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
                                <h3>Application for: {{ $application->job->title }}</h3>
                                <div class="text-muted">
                                    <span class="mr-3">Status: 
                                        <span class="badge 
                                            @if($application->status == 'submitted') badge-primary
                                            @elseif($application->status == 'under_review') badge-info
                                            @elseif($application->status == 'accepted') badge-success
                                            @elseif($application->status == 'rejected') badge-danger
                                            @endif">
                                            {{ ucfirst(str_replace('_', ' ', $application->status)) }}
                                        </span>
                                    </span>
                                    <span>Applied on: {{ $application->created_at->format('M d, Y') }}</span>
                                </div>
                            </div>

                            <div class="card-body">
                                <div class="mb-4">
                                    <h5>Your Proposal</h5>
                                    <div class="proposal-content p-3 bg-light rounded">
                                        {!! nl2br(e($application->proposal)) !!}
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <h5>Bid Details</h5>
                                        <ul class="list-unstyled">
                                            <li><strong>Bid Amount:</strong> ${{ number_format($application->bid_amount, 2) }}</li>
                                            <li><strong>Job Budget:</strong> {{ $application->job->salary ? '$'.number_format($application->job->salary) : 'Not specified' }}</li>
                                        </ul>
                                    </div>
                                    <div class="col-md-6">
                                        <h5>Attachments</h5>
                                        @if(!empty($application->attachments))
                                            <ul class="list-unstyled">
                                                @foreach($application->attachments_urls as $url)
                                                    <li>
                                                        <a href="{{ $url }}" target="_blank">
                                                            <i class="fas fa-file-alt"></i> {{ basename($url) }}
                                                        </a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @else
                                            <p class="text-muted">No attachments</p>
                                        @endif
                                    </div>
                                </div>

                                <div class="d-flex justify-content-between">
                                    <a href="{{ route('freelancer.jobs.applications') }}" class="btn btn-outline-secondary">
                                        Back to Applications
                                    </a>
                                    <a href="{{ route('jobs.show', $application->job) }}" class="btn btn-outline-primary">
                                        View Job Posting
                                    </a>
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