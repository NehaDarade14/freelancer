<!DOCTYPE HTML>
<html lang="en">
<head>
<title>{{ $allsettings->site_title }} - @if(Auth::user()->id != 1) Application for: {{ $application->job->title }} @else {{ __('404 Not Found') }} @endif</title>
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
                        <li class="breadcrumb-item text-nowrap active" aria-current="page">Application for: {{ $application->job->title }}</li>
                    </ol>
                    </nav>
                </div>
                <div class="order-lg-1 pr-lg-4 text-center text-lg-left">
                    <h1 class="h3 mb-0 text-white">Application for: {{ $application->job->title }}</h1>
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
                                    <div class="card-header d-flex justify-content-between align-items-center">
                                        <h2 class="mb-0">Application for: {{ $application->job->title }}</h2>
                                        <div class="badge badge-{{ $application->status === 'pending' ? 'warning' : ($application->status === 'accepted' ? 'success' : 'danger') }}">
                                            {{ ucfirst($application->status) }}
                                        </div>
                                    </div>

                                    <div class="card-body">
                                        <div class="row mb-4">
                                            <div class="col-md-6">
                                                <h5>Freelancer Details</h5>
                                                <div class="d-flex align-items-center mb-3">
                                                    <div class="mr-3">
                                                        <!-- <img src="{{ $application->freelancer?->profile_photo_url ?? asset('images/default-profile.png') }}" alt="Profile Photo"
                                                            class="rounded-circle" width="60" height="60"> -->

                                                            @if(!empty($application->freelancer->user_photo))
                                                            <img class="lazy rounded-circle" width="60" height="60" src="{{ url('/') }}/public/storage/users/{{ $application->freelancer->user_photo }}"  alt="{{ Auth::user()->name }}">
                                                            @else
                                                            <img class="lazy rounded-circle"  width="60" height="60" src="{{ url('/') }}/public/img/no-user.png"  alt="{{ $application->freelancer->name }}">
                                                            @endif
                                                    </div>
                                                    <div>
                                                        <h6 class="mb-0">{{ $application->freelancer?->name ?? 'Unknown User' }}</h6>
                                                        <small class="text-muted">{{ $application->freelancer?->email ?? '' }}</small>
                                                    </div>
                                                </div>
                                                <p><strong>Bid Amount:</strong> {{ config('app.currency_symbol') }}{{ number_format($application->bid_amount, 2) }}</p>
                                                <p><strong>Applied On:</strong> {{ $application->created_at->format('M d, Y h:i A') }}</p>
                                            </div>

                                            <div class="col-md-6">
                                                <h5>Job Details</h5>
                                                <p><strong>Budget:</strong> {{ config('app.currency_symbol') }}{{ number_format($application->job->budget, 2) }}</p>
                                                <p><strong>Posted On:</strong> {{ $application->job->created_at->format('M d, Y h:i A') }}</p>
                                                <p><strong>Deadline:</strong> {{ $application->job->deadline->format('M d, Y') }}</p>
                                                <p><strong>Status:</strong> {{ ucfirst($application->job->status) }}</p>
                                            </div>
                                        </div>

                                        <div class="mb-4">
                                            <h5>Proposal</h5>
                                            <div class="card">
                                                <div class="card-body">
                                                    {!! nl2br(e($application->proposal)) !!}
                                                </div>
                                            </div>
                                        </div>

                                        @if(!empty($application->attachments))
                                            <div class="mb-4">
                                                <h5>Attachments</h5>
                                                <div class="card">
                                                    <div class="card-body">
                                                        <div class="row">
                                                            @foreach($application->attachments_urls as $url)
                                                                <div class="col-md-4 mb-3">
                                                                    <div class="card">
                                                                        <div class="card-body text-center">
                                                                            <i class="fa fa-file-{{ str_replace(['jpg', 'jpeg', 'png'], 'image', strtolower(pathinfo($url, PATHINFO_EXTENSION))) }} fa-3x mb-2"></i>
                                                                            <h6 class="card-title">{{ Str::limit(basename($url), 15) }}</h6>
                                                                            <a href="{{ $url }}" target="_blank" class="btn btn-sm btn-primary">
                                                                                <i class="fa fa-download"></i> Download
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif

                                        <div class="d-flex justify-content-between">
                                            @if(auth()->user()->isClient())
                                                    <form action="{{ route('employer.jobs.applications.status', ['job' => $application->job, 'application' => $application]) }}" method="POST" class="mr-2">
                                                        @csrf
                                                        <div class="input-group">
                                                            <select name="status" class="form-control">
                                                                <option value="pending" {{ $application->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                                                <option value="in_progress" {{ $application->status === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                                                <option value="review" {{ $application->status === 'review' ? 'selected' : '' }}>Review</option>
                                                                <option value="completed" {{ $application->status === 'completed' ? 'selected' : '' }}>Completed</option>
                                                                <option value="rejected" {{ $application->status === 'rejected' ? 'selected' : '' }}>Rejected</option>
                                                                
                                                            </select>
                                                            <div class="input-group-append">
                                                                <button type="submit" class="btn btn-primary">
                                                                    <i class="fa fa-save"></i> Update Status
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                @else
                                                    <a href="{{ route('job-applications.edit', $application) }}" class="btn btn-primary">
                                                        <i class="fa fa-edit"></i> Edit Application
                                                    </a>
                                                @endif
                                           
                                                <form action="{{ route('job-applications.destroy', ['job' => $application->job, 'application' => $application]) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to withdraw this application?')">
                                                        <i class="fa fa-trash"></i> Withdraw Application
                                                    </button>
                                                </form>
                                            

                                            <a href="{{ route('jobs.show', $application->job) }}" class="btn btn-secondary">
                                                <i class="fa fa-arrow-left"></i> Back to Job
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