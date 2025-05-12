<!DOCTYPE HTML>
<html lang="en">
<head>
<title>{{ $allsettings->site_title }} - @if(Auth::user()->id != 1) Applications for: {{ $job->title }} @else {{ __('404 Not Found') }} @endif</title>
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
                        <li class="breadcrumb-item text-nowrap active" aria-current="page">Applications for: {{ $job->title }}</li>
                    </ol>
                    </nav>
                </div>
                <div class="order-lg-1 pr-lg-4 text-center text-lg-left">
                    <h1 class="h3 mb-0 text-white">Applications for: {{ $job->title }}</h1>
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
                                        <h2 class="mb-0">Applications for: {{ $job->title }}</h2>
                                        <a href="{{ route('employer.jobs.show', $job) }}" class="btn btn-sm btn-secondary">
                                            <i class="fa fa-arrow-left"></i> Back to Job
                                        </a>
                                    </div>

                                    <div class="card-body">
                                        @if($applications->count() > 0)
                                            <div class="table-responsive">
                                                <table class="table table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th>Freelancer</th>
                                                            <th>Bid Amount</th>
                                                            <th>Applied On</th>
                                                            <th>Status</th>
                                                            <th>Actions</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($applications as $application)
                                                            <tr>
                                                                <td>
                                                                    <div class="d-flex align-items-center">
                                                                        <img src="{{ $application->user->profile_photo_url }}" 
                                                                            class="rounded-circle mr-2" width="40" height="40">
                                                                        <div>
                                                                            <h6 class="mb-0">{{ $application->user->name }}</h6>
                                                                            <small class="text-muted">{{ $application->user->email }}</small>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td>{{ config('app.currency_symbol') }}{{ number_format($application->bid_amount, 2) }}</td>
                                                                <td>{{ $application->created_at->format('M d, Y') }}</td>
                                                                <td>
                                                                    <span class="badge badge-{{ $application->status === 'pending' ? 'warning' : ($application->status === 'accepted' ? 'success' : 'danger') }}">
                                                                        {{ ucfirst($application->status) }}
                                                                    </span>
                                                                </td>
                                                                <td>
                                                                    <a href="{{ route('employer.jobs.applications.show', ['job' => $job, 'application' => $application]) }}" 
                                                                    class="btn btn-sm btn-primary">
                                                                        <i class="fa fa-eye"></i> View
                                                                    </a>
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
                                                No applications received yet for this job.
                                            </div>
                                        @endif
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